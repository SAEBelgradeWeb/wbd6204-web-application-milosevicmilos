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
                  v-b-modal.create-appliance-form
              >
                Create Appliance
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

        <b-overlay
            :show="showOverlay"
            rounded="sm"
            spinner-variant="primary"
        >
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
                <feather-icon
                    icon="EyeIcon"
                    size="16"
                    class="mx-1"
                    @click="$router.push({ name: 'appliance-view', params: { id: props.row.id }})"
                />
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
                  <b-dropdown-item v-b-modal.update-appliance-form @click="update(props.row)">
                    <feather-icon
                      icon="Edit2Icon"
                      class="mr-50"
                    />
                    <span>Edit</span>
                  </b-dropdown-item>
                  <b-dropdown-item @click="deleteAppliance(props.row)">
                    <feather-icon
                      icon="TrashIcon"
                      class="mr-50"
                    />
                    <a>Delete</a>
                  </b-dropdown-item>
                </b-dropdown>
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
        </b-overlay>
        <create-appliance></create-appliance>
        <update-appliance v-bind:appliance="this.appliance"></update-appliance>
      </b-card-code>
    </b-col>
  </b-row>
</template>

<script>
import BCardCode from '@core/components/b-card-code/BCardCode.vue'
import {
  BRow, BCol, BBadge, BPagination, BForm, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BButton, BOverlay
} from 'bootstrap-vue'
import { VueGoodTable } from 'vue-good-table'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import CreateAppliance from './CreateAppliance.vue'
import UpdateAppliance from './UpdateAppliance.vue'

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
    CreateAppliance,
    UpdateAppliance,
    BOverlay,
  },
  data() {
    return {
      showOverlay: true,
      pageLength: 5,
      columns: this.columns,
      rows: [],
      appliance: null,
      searchTerm: '',
    }
  },
  created() {
    let columns = [
      {
        label: 'ID',
        field: 'id',
        sortable: false,
      },
      {
        label: 'Name',
        field: 'name',
      },
      {
        label: 'Type',
        field: 'appliance_type.name',
      },
      {
        label: 'Room',
        field: 'room.name',
      },
      {
        label: 'Created',
        field: 'created_at',
      },
      {
        label: 'Action',
        field: 'action',
        sortable: false,
      },
    ];

    if (localStorage.getItem('userRole') === 'ADMIN') {
      columns.splice(1, 0, {
        label: 'User',
        field: 'room.floor.building.user_name',
      });
    }

    this.columns = columns;

    this.$http.get('/appliances')
      .then(result => {
        this.rows = result.data.appliances
        this.showOverlay = false;
      })

  },
  methods: {
    update(row) {
      this.appliance = row;
    },
    viewAppliance(row) {

    },
    deleteAppliance(row) {
      // TODO: Add confirm box!
      this.$http.delete('/appliances/' + row.id)
        .then(res => {
          this.rows.splice(row.originalIndex, 1);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Success',
              icon: 'CheckIcon',
              variant: 'success',
              text: `Appliance "${row.name}" has been deleted`
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
              text: 'Something went wrong when trying to delete an appliance'
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