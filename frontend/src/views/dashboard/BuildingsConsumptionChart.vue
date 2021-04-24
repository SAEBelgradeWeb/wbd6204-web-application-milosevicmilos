<template>
  <b-card no-body>
    <b-card-header>
      <div>
        <b-card-title>
          Buildings Consumption
        </b-card-title>
      </div>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <chartjs-component-line-chart
        :height="400"
        :data="lineChart.data"
        :options="lineChart.options"
        :plugins="plugins"
      />
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BCardSubTitle, BCardTitle,
} from 'bootstrap-vue'
import ChartjsComponentLineChart from './charts-components/ChartjsComponentLineChart.vue'

// colors
const chartColors = {
  primaryColorShade: '#836AF9',
  successColorShade: '#28dac6',
  warningColorShade: '#ffe802',
}

export default {
  components: {
    BCard,
    BCardHeader,
    BCardBody,
    BCardSubTitle,
    BCardTitle,
    ChartjsComponentLineChart,
  },
  data() {
    return {
      lineChart: {
        options: {
          responsive: true,
          maintainAspectRatio: false,
          backgroundColor: false,
          layout: {
            padding: {
              top: -15,
              bottom: -25,
              left: -15,
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                scaleLabel: {
                  display: true,
                },
                gridLines: {
                  display: true,
                  color: 'rgba(200, 200, 200, 0.2)',
                  zeroLineColor: 'rgba(200, 200, 200, 0.2)',
                },
                ticks: {
                  fontColor: '#6e6b7b',
                },
              },
            ],
            yAxes: [
              {
                display: true,
                scaleLabel: {
                  display: true,
                },
                ticks: {
                  stepSize: 100,
                  min: 0,
                  max: 400,
                  fontColor: '#6e6b7b',
                },
                gridLines: {
                  display: true,
                  color: 'rgba(200, 200, 200, 0.2)',
                  zeroLineColor: 'rgba(200, 200, 200, 0.2)',
                },
              },
            ],
          },
          legend: {
            position: 'top',
            align: 'start',
            labels: {
              usePointStyle: true,
              padding: 25,
              boxWidth: 9,
            },
          },
        },
        data: {
          labels: [0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140],
          datasets: [
            {
              data: [80, 99, 82, 90, 115, 115, 74, 75, 130, 155, 125, 90, 140, 130, 180],
              label: 'Africa',
              borderColor: chartColors.primaryColorShade,
              backgroundColor: chartColors.primaryColorShade,
              fill: false,
            },
          ],
        },
      },
      plugins: [
        // to add spacing between legends and chart
        {
          beforeInit(chart) {
            /* eslint-disable func-names, no-param-reassign */
            chart.legend.afterFit = function () {
              this.height += 20
            }
            /* eslint-enable */
          },
        },
      ],
    }
  },
}
</script>
