<template>
  <b-card no-body>
    <b-card-header>
      <b-card-title>Monthly Consumption</b-card-title>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <chartjs-component-bar-chart
        :height="400"
        :data="this.latestBarChart.data"
        :options="this.latestBarChart.options"
      />
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BCardTitle,
} from 'bootstrap-vue'
import ChartjsComponentBarChart from './charts-components/ChartjsComponentBarChart.vue'

export default {
  components: {
    BCard,
    BCardHeader,
    BCardBody,
    BCardTitle,
    ChartjsComponentBarChart,
  },
  data() {
    return {
      latestBarChart: {
        data: {
          labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'],
          datasets: [
            {
              data: [199, 275, 90, 190, 205, 125, 85, 55, 87, 127, 150, 230, 280, 190],
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
}
</script>