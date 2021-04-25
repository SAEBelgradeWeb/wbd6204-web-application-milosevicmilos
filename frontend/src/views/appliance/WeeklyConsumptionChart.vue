<template>
  <b-card no-body>
    <b-card-header>
      <b-card-title>This Week Consumption per day (KW)</b-card-title>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <b-overlay
          :show="showOverlay"
          rounded="sm"
          spinner-variant="primary"
      >
        <chartjs-component-horizontal-bar-chart
          v-if="chartLoaded"
          :height="400"
          :data="weeklyConsumption.data"
          :options="weeklyConsumption.options"
        />
      </b-overlay>
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardBody, BCardHeader, BCardTitle, BCardSubTitle, BOverlay,
} from 'bootstrap-vue'
import ChartjsComponentHorizontalBarChart from './../dashboard/charts-components/ChartjsComponentHorizontalBarChart.vue'
import { $themeColors } from '@themeConfig'
import router from '@/router'

export default {
  components: {
    BCard,
    BCardBody,
    BCardHeader,
    BCardTitle,
    BCardSubTitle,
    ChartjsComponentHorizontalBarChart,
    BOverlay
  },
  data() {
    return {
      showOverlay: true,
      chartLoaded: false,
      weeklyConsumption: {
        options: {
          responsive: true,
          maintainAspectRatio: false,
          responsiveAnimationDuration: 500,
          legend: {
            display: false,
          },
        },
        data: {
          labels: [],
          datasets: [
            {
              data: [],
              backgroundColor: $themeColors.info,
              borderColor: 'transparent',
              barThickness: 15,
            },
          ],
        },
      }
    }
  },
  async mounted() {
    this.chartLoaded = false
    await this.$http.get('/dashboard/consumption-per-week?appliance_id=' + router.currentRoute.params.id)
        .then(result => {
          this.weeklyConsumption.data.datasets[0].data = result.data.data;
          this.weeklyConsumption.data.labels = result.data.labels;
          this.showOverlay = false;
          this.chartLoaded = true
        })
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
