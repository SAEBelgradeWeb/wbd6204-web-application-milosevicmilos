<template>
  <b-card no-body>
    <b-card-header>
      <b-card-title>Appliance Types Count</b-card-title>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <chartjs-component-polar-area-chart
        :height="350"
        :data="polarChart.data"
        :options="polarChart.options"
      />
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardTitle, BCardBody, BCardHeader,
} from 'bootstrap-vue'
import ChartjsComponentPolarAreaChart from './charts-components/ChartjsComponentPolarAreaChart.vue'
import { $themeColors } from '@themeConfig'
// colors
const chartColors = {
  primaryColorShade: '#836AF9',
  yellowColor: '#ffe800',
  successColorShade: '#28dac6',
  warningColorShade: '#ffe802',
  warningLightColor: '#FDAC34',
  infoColorShade: '#299AFF',
  greyColor: '#4F5D70',
  blueColor: '#2c9aff',
  blueLightColor: '#84D0FF',
  greyLightColor: '#EDF1F4',
  lineChartPrimary: '#666ee8',
  lineChartDanger: '#ff4961',
  labelColor: '#6e6b7b',
}

export default {
  components: {
    ChartjsComponentPolarAreaChart,
    BCard,
    BCardTitle,
    BCardBody,
    BCardHeader,
  },
  data() {
    return {
      polarChart: {
        options: {
          responsive: true,
          maintainAspectRatio: false,
          responsiveAnimationDuration: 500,
          legend: {
            position: 'right',
            labels: {
              usePointStyle: true,
              padding: 25,
              boxWidth: 10,
              fontColor: chartColors.labelColor,
            },
          },
          scale: {
            scaleShowLine: true,
            scaleLineWidth: 1,
            ticks: {
              display: false,
              fontColor: chartColors.labelColor,
            },
            reverse: false,
            gridLines: {
              display: false,
            },
          },
          animation: {
            animateRotate: false,
          },
        },
        data: {
          labels: ['Africa', 'Asia', 'Europe', 'America', 'Antarctica', 'Australia', 'Africa1', 'Asia1', 'Europe1', 'America1', 'Antarctica1', 'Australia1'],
          datasets: [
            {
              backgroundColor: [
                chartColors.primaryColorShade,
                chartColors.warningColorShade,
                $themeColors.primary,
                chartColors.infoColorShade,
                chartColors.greyColor,
                chartColors.successColorShade,
                chartColors.primaryColorShade,
                chartColors.warningColorShade,
                $themeColors.primary,
                chartColors.infoColorShade,
                chartColors.greyColor,
                chartColors.successColorShade,
              ],
              data: [19, 17.5, 15, 13.5, 11, 9, 19, 17.5, 15, 13.5, 11, 9],
              borderWidth: 0,
            },
          ],
        },
      }
    }
  },
}
</script>
