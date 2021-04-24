<template>
  <b-row class="match-height">
    <b-col md="3">
      <b-row class="match-height">
        <b-col
            xl="12"
        >
          <b-overlay
              :show="showOverlay"
              rounded="sm"
              spinner-variant="primary"
          >
            <statistic-card-vertical
                icon="EyeIcon"
                :statistic="this.totalConsumption + ' KW'"
                statistic-title="Total Consumption"
                color="info"
            />
          </b-overlay>
        </b-col>
      </b-row>
      <b-row class="match-height">
        <b-col
            xl="12"
        >
          <b-overlay
              :show="showOverlay"
              rounded="sm"
              spinner-variant="primary"
          >
            <statistic-card-vertical
                color="danger"
                icon="ShoppingBagIcon"
                :statistic="this.averageConsumptionPerYear + ' KW'"
                statistic-title="Average Consumption Per Year"
            />
          </b-overlay>
        </b-col>
      </b-row>
      <b-row class="match-height">
        <b-col
            xl="12"
        >
          <b-overlay
              :show="showOverlay"
              rounded="sm"
              spinner-variant="primary"
          >
            <statistic-card-vertical
                color="success"
                icon="AwardIcon"
                :statistic="this.averageConsumptionPerMonth + ' KW'"
                statistic-title="Average Consumption Per Month"
            />
          </b-overlay>
        </b-col>
      </b-row>
    </b-col>
    <b-col md="9">
      <weekly-consumption-chart />
    </b-col>
    <b-col md="6">
      <monthly-consumption-chart />
    </b-col>
    <b-col cols="6">
      <buildings-consumption-chart />
    </b-col>
  </b-row>
</template>

<script>
import {BRow, BCol, BLink, BOverlay} from 'bootstrap-vue'

import MonthlyConsumptionChart from './MonthlyConsumptionChart.vue'
import BuildingsConsumptionChart from './BuildingsConsumptionChart.vue'
import ApplianceTypesCountChart from './ApplianceTypesCountChart.vue'
import WeeklyConsumptionChart from './WeeklyConsumptionChart.vue'
import StatisticCardVertical from "@core/components/statistics-cards/StatisticCardVertical";

export default {
  components: {
    BRow,
    BCol,
    BLink,
    StatisticCardVertical,
    MonthlyConsumptionChart,
    BuildingsConsumptionChart,
    ApplianceTypesCountChart,
    WeeklyConsumptionChart,
    BOverlay
  },
  data() {
    return {
      showOverlay: true,
      totalConsumption: 0,
      averageConsumptionPerYear: 0,
      averageConsumptionPerMonth: 0,
    }
  },
  async mounted() {
    await this.$http.get('/dashboard/consumption-statistics')
        .then(result => {
          this.totalConsumption = result.data.totalConsumption;
          this.averageConsumptionPerYear = result.data.averageConsumptionPerYear;
          this.averageConsumptionPerMonth = result.data.averageConsumptionPerMonth;
          this.showOverlay = false;
        })
  },
}

</script>
