<template>
  <b-card no-body>
    <b-card-header>
      <b-card-title>This Year Consumption per month (KW)</b-card-title>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <b-overlay
          :show="showOverlay"
          rounded="sm"
          spinner-variant="primary"
      >
        <chartjs-component-bar-chart
          v-if="chartLoaded"
          :height="400"
          :data="this.monthlyConsumption.data"
          :options="this.monthlyConsumption.options"
        />
      </b-overlay>
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BCardTitle, BOverlay
} from 'bootstrap-vue'
import ChartjsComponentBarChart from './../dashboard/charts-components/ChartjsComponentBarChart.vue'
import router from '@/router'

export default {
  components: {
    BCard,
    BCardHeader,
    BCardBody,
    BCardTitle,
    ChartjsComponentBarChart,
    BOverlay
  },
  data() {
    return {
      showOverlay: true,
      chartLoaded: false,
      monthlyConsumption: {
        data: {
          labels: [],
          datasets: [
            {
              data: [],
              backgroundColor: '#28dac6',
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          responsiveAnimationDuration: 500,
          legend: {
            display: false,
          },
        },
      }
    }
  },
  async mounted() {
    this.chartLoaded = false
    await this.$http.get('/dashboard/consumption-per-month?appliance_id=' + router.currentRoute.params.id)
        .then(result => {
          this.monthlyConsumption.data.datasets[0].data = result.data.data;
          this.monthlyConsumption.data.labels = result.data.labels;
          this.showOverlay = false;
          this.chartLoaded = true
        })
  },
}
</script>