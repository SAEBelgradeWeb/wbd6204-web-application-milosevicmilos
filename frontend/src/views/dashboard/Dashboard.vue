<template>
  <b-row class="match-height">
    <b-col md="6">
      <weekly-consumption-chart />
    </b-col>
    <b-col md="6">
      <monthly-consumption-chart />
    </b-col>
    <b-col cols="6">
      <buildings-consumption-chart />
    </b-col>
    <b-col md="6">
      <appliance-types-count-chart />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol, BLink } from 'bootstrap-vue'

import MonthlyConsumptionChart from './MonthlyConsumptionChart.vue'
import BuildingsConsumptionChart from './BuildingsConsumptionChart.vue'
import ApplianceTypesCountChart from './ApplianceTypesCountChart.vue'
import WeeklyConsumptionChart from './WeeklyConsumptionChart.vue'

export default {
  components: {
    BRow,
    BCol,
    BLink,

    MonthlyConsumptionChart,
    BuildingsConsumptionChart,
    ApplianceTypesCountChart,
    WeeklyConsumptionChart,
  },
}
</script>
