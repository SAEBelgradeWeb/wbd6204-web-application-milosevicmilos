<template>
  <b-row>
    <b-col cols="12">
      <b-card-code>

        <!-- search input -->
        <div class="custom-search">
          <b-row>
            <b-col md="4">
              <b-button
                  variant="primary"
                  v-b-modal.create-room-form
              >
                Create Room
              </b-button>

            </b-col>
            <b-col md="4" offset-md="4">
              <b-form-group>
                <div class="d-flex align-items-center">
                  <b-form-input
                    v-model="searchTerm"
                    placeholder="Search"
                    type="text"
                    class="d-inline-block"
                  />
                </div>
              </b-form-group>
            </b-col>
          </b-row>
        </div>

        <!-- table -->
        <vue-good-table
          :columns="columns"
          :rows="rows"
          :search-options="{
            enabled: true,
            externalQuery: searchTerm }"
          :sort-options="{
            enabled: true,
            initialSortBy: [
              {field: 'name', type: 'asc'},
            ],
          }"
          :pagination-options="{
            enabled: true,
            perPage:pageLength
          }"
        >
          <template
            slot="table-row"
            slot-scope="props"
          >

            <!-- Column: Action -->
            <span v-if="props.column.field === 'action'">
              <span>
                <b-dropdown
                  variant="link"
                  toggle-class="text-decoration-none"
                  no-caret
                >
                  <template v-slot:button-content>
                    <feather-icon
                      icon="MoreVerticalIcon"
                      size="16"
                      class="text-body align-middle mr-25"
                    />
                  </template>
                  <b-dropdown-item v-b-modal.update-room-form @click="update(props.row)">
                    <feather-icon
                      icon="Edit2Icon"
                      class="mr-50"
                    />
                    <span>Edit</span>
                  </b-dropdown-item>
                  <b-dropdown-item @click="deleteRoom(props.row)">
                    <feather-icon
                      icon="TrashIcon"
                      class="mr-50"
                    />
                    <a>Delete</a>
                  </b-dropdown-item>
                </b-dropdown>
              </span>
            </span>

            <!-- Column: Common -->
            <span v-else>
              {{ props.formattedRow[props.column.field] }}
            </span>
          </template>

          <!-- pagination -->
          <template
            slot="pagination-bottom"
            slot-scope="props"
          >
            <div class="d-flex justify-content-between flex-wrap">
              <div class="d-flex align-items-center mb-0 mt-1">
                <span class="text-nowrap ">
                  Showing 1 to
                </span>
                <b-form-select
                  v-model="pageLength"
                  :options="['5','10', '25']"
                  class="mx-1"
                  @input="(value)=>props.perPageChanged({currentPerPage:value})"
                />
                <span class="text-nowrap"> of {{ props.total }} entries </span>
              </div>
              <div>
                <b-pagination
                  :value="1"
                  :total-rows="props.total"
                  :per-page="pageLength"
                  first-number
                  last-number
                  align="right"
                  prev-class="prev-item"
                  next-class="next-item"
                  class="mt-1 mb-0"
                  @input="(value)=>props.pageChanged({currentPage:value})"
                >
                  <template #prev-text>
                    <feather-icon
                      icon="ChevronLeftIcon"
                      size="18"
                    />
                  </template>
                  <template #next-text>
                    <feather-icon
                      icon="ChevronRightIcon"
                      size="18"
                    />
                  </template>
                </b-pagination>
              </div>
            </div>
          </template>
        </vue-good-table>
        <create-room></create-room>
        <update-room v-bind:room="this.room"></update-room>
      </b-card-code>
    </b-col>
  </b-row>
</template>

<script>
import BCardCode from '@core/components/b-card-code/BCardCode.vue'
import {
  BRow, BCol, BBadge, BPagination, BForm, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton
} from 'bootstrap-vue'
import { VueGoodTable } from 'vue-good-table'
import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import CreateRoom from './CreateRoom.vue'
import UpdateRoom from './UpdateRoom.vue'

export default {
  components: {
    BRow,
    BCol,
    BCardCode,
    VueGoodTable,
    BBadge,
    BPagination,
    BForm,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    ToastificationContent,
    BButton,
    CreateRoom,
    UpdateRoom,
  },
  data() {
    return {
      pageLength: 5,
      columns: this.columns,
      rows: [],
      room: null,
      searchTerm: '',
    }
  },
  created() {
    this.columns = [
      {
        label: 'ID',
        field: 'id',
        sortable: false,
      },
      {
        label: 'Building Name',
        field: 'floor.building.name',
      },
      {
        label: 'Floor Name',
        field: 'floor.name',
      },
      {
        label: 'Name',
        field: 'name',
      },
      {
        label: 'Appliances Count',
        field: 'appliances_count',
      },
      {
        label: 'Size',
        field: 'size',
      },
      {
        label: 'Action',
        field: 'action',
        sortable: false,
      },
    ];

    this.$http.get('/rooms')
      .then(result => {
        this.rows = result.data.rooms
      })
  },
  methods: {
    update(row) {
      this.room = row;
    },
    deleteRoom(row) {
      // TODO: Add confirm box!
      this.$http.delete('/buildings/' + row.floor.building.id + '/floors/' + row.floor.id + '/rooms/' + row.id)
        .then(res => {
          this.rows.splice(row.originalIndex, 1);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Success',
              icon: 'CheckIcon',
              variant: 'success',
              text: `Room "${row.name}" has been deleted`
            },
          })
        })
        .catch(error => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Error',
              icon: 'XIcon',
              variant: 'danger',
              text: 'Something went wrong when trying to delete a room'
            },
          })
        })
    },
  }
}
</script>

<style lang="scss" >
@import '@core/scss/vue/libs/vue-good-table.scss';
</style>