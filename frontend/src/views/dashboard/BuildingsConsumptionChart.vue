<template>
  <b-card no-body>
    <b-card-header>
      <div>
        <b-card-title>
          Total Buildings Consumption for the past year (KW)
        </b-card-title>
      </div>
    </b-card-header>

    <!-- chart -->
    <b-card-body>
      <b-overlay
          :show="showOverlay"
          rounded="sm"
          spinner-variant="primary"
      >
        <chartjs-component-line-chart
          v-if="chartLoaded"
          :height="400"
          :data="buildingsConsumption.data"
          :options="buildingsConsumption.options"
          :plugins="plugins"
        />
      </b-overlay>
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BCardSubTitle, BCardTitle, BOverlay,
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
    BOverlay
  },
  data() {
    return {
      showOverlay: true,
      chartLoaded: false,
      buildingsConsumption: {
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
          labels: [],
          datasets: [],
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
  async mounted() {
    await this.$http.get('/dashboard/consumption-per-building')
        .then(result => {
          this.buildingsConsumption.data.labels = result.data.labels;
          Object.entries(result.data.building).forEach(entry => {
            const [key, value] = entry;
            this.buildingsConsumption.data.datasets.push({
              data: value,
              label: key,
              borderColor: chartColors.successColorShade,
              backgroundColor: chartColors.successColorShade,
              fill: false,
            });
          });
          this.showOverlay = false;
          this.chartLoaded = true
        });
  },
}
</script>
