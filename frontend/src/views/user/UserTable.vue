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
                  v-b-modal.create-user-form
              >
                Create User
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
          :rtl="direction"
          :search-options="{
            enabled: true,
            externalQuery: searchTerm }"
          :sort-options="{
            enabled: true,
            multipleColumns: true,
            initialSortBy: [
              {field: 'first_name', type: 'asc'},
              {field: 'last_name', type: 'asc'}
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

            <!-- Column: Status -->
            <span v-if="props.column.field === 'status'">
              <b-badge :variant="statusVariant(props.row.status)">
                {{ props.row.status }}
              </b-badge>
            </span>

            <!-- Column: Action -->
            <span v-else-if="props.column.field === 'action'">
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
                  <b-dropdown-item v-b-modal.update-user-form @click="updateUser(props.row)">
                    <feather-icon
                      icon="Edit2Icon"
                      class="mr-50"
                    />
                    <span>Edit</span>
                  </b-dropdown-item>
                  <b-dropdown-item @click="deleteUser(props.row)">
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
        <create-user></create-user>
        <update-user v-bind:id="this.id" v-bind:index="this.index"></update-user>
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
import CreateUser from './CreateUser.vue'
import UpdateUser from './UpdateUser.vue'

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
    CreateUser,
    UpdateUser,
  },
  data() {
    return {
      pageLength: 5,
      dir: false,
      columns: [
        {
          label: 'ID',
          field: 'id',
          sortable: false,
        },
        {
          label: 'First Name',
          field: 'first_name',
        },
        {
          label: 'Last Name',
          field: 'last_name',
        },
        {
          label: 'Email',
          field: 'email',
        },
        {
          label: 'Role',
          field: 'role_name',
        },
        {
          label: 'Status',
          field: 'status',
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
      ],
      rows: [],
      id: 0,
      index: 0,
      searchTerm: '',
      status: [{
        1: 'Active',
        2: 'Deleted',
        3: 'Inactive',
      },
      {
        1: 'light-success',
        2: 'light-danger',
        3: 'light-warning',
      }],
    }
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        Active: 'light-success',
        Deleted: 'light-danger',
        Inactive: 'light-warning',
        /* eslint-enable key-spacing */
      }

      return status => statusColor[status]
    },
    direction() {
      if (store.state.appConfig.isRTL) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.dir = true
        return this.dir
      }
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.dir = false
      return this.dir
    },
  },
  created() {
    this.$http.get('/users')
      .then(result => {
        this.rows = result.data.users
      })
  },
  methods: {
    updateUser(row) {
      this.id = row.id;
      this.index = row.originalIndex;
    },
    deleteUser(row) {
      // TODO: Add confirm box!
      this.$http.delete('/users/' + row.id)
        .then(res => {
          this.rows.splice(row.originalIndex, 1);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Success',
              icon: 'CheckIcon',
              variant: 'success',
              text: `User "${row.first_name} ${row.last_name}" has been deleted`
            },
          })
        })
        .catch(error => {
          console.log(error);
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Error',
              icon: 'XIcon',
              variant: 'danger',
              text: 'Something went wrong when trying to delete a user'
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