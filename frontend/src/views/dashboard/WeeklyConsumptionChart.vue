<template>
  <b-card no-body>
    <b-card-header>
      <b-card-title>Weekly Consumption</b-card-title>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <chartjs-component-horizontal-bar-chart
        :height="400"
        :data="horizontalBarChart.data"
        :options="horizontalBarChart.options"
      />
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardBody, BCardHeader, BCardTitle, BCardSubTitle,
} from 'bootstrap-vue'
import ChartjsComponentHorizontalBarChart from './charts-components/ChartjsComponentHorizontalBarChart.vue'
import { $themeColors } from '@themeConfig'

export default {
  components: {
    BCard,
    BCardBody,
    BCardHeader,
    BCardTitle,
    BCardSubTitle,
    ChartjsComponentHorizontalBarChart,
  },
  data() {
    return {
      horizontalBarChart: {
        options: {
          responsive: true,
          maintainAspectRatio: false,
          responsiveAnimationDuration: 500,
          legend: {
            display: false,
          },
        },
        data: {
          labels: ['MON', 'TUE', 'WED ', 'THU', 'FRI', 'SAT', 'SUN'],
          datasets: [
            {
              data: [710, 350, 470, 580, 230, 460, 120],
              backgroundColor: $themeColors.info,
              borderColor: 'transparent',
              barThickness: 15,
            },
          ],
        },
      }
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
