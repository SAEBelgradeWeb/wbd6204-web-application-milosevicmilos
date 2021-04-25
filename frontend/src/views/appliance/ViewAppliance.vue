<template>
  <b-row class="match-height">
    <b-col md="12">
      <weekly-consumption-chart />
    </b-col>
    <b-col md="12">
      <monthly-consumption-chart />
    </b-col>
  </b-row>
</template>

<script>
import {BRow, BCol, BLink} from 'bootstrap-vue'
import MonthlyConsumptionChart from './MonthlyConsumptionChart.vue'
import WeeklyConsumptionChart from './WeeklyConsumptionChart.vue'

export default {
  components: {
    BRow,
    BCol,
    BLink,
    MonthlyConsumptionChart,
    WeeklyConsumptionChart,
  },
  data() {
    return {
    }
  },
}

</script>
