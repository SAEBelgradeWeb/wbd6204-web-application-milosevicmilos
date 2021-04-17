<template>
  <b-modal
      id="create-building-form"
      cancel-variant="outline-secondary"
      ok-title="Create"
      cancel-title="Cancel"
      centered
      title="Create Building"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
  >
    <form
        ref="form"
        @submit.stop.prevent="submitForm"
    >
      <validation-observer ref="buildingFormObserver">
        <b-form-group
            label="Select User"
            label-for="userSelect"
            v-if="this.userRole === 'ADMIN'"
        >
          <validation-provider
              #default="{ errors }"
              name="Select User"
              rules="required"
          >
            <v-select
                id="userSelect"
                name="user"
                v-model="selectedUser"
                :options="allUsers"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group>
          <label for="name">Name:</label>
          <validation-provider
              #default="{ errors }"
              name="Name"
              rules="required|min:3"
          >
            <b-form-input
                id="name"
                name="name"
                type="text"
                v-model="nameValue"
                :state="errors.length > 0 ? false:null"
                placeholder="Name"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group>
          <label for="address">Address:</label>
          <validation-provider
              #default="{ errors }"
              name="address"
              rules="required|min:3"
          >
            <b-form-input
                id="address"
                name="address"
                type="text"
                v-model="addressValue"
                :state="errors.length > 0 ? false:null"
                placeholder="Address"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
      </validation-observer>
    </form>
  </b-modal>
</template>

<script>
import {
  BButton, BDropdown, BDropdownItem, BForm, BFormGroup, BFormInput, BFormSelect, BModal, VBModal
} from 'bootstrap-vue'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import {ValidationObserver, ValidationProvider} from 'vee-validate'
import {
  required, min
} from '@validations'
import vSelect from "vue-select";

export default {
  components: {
    ToastificationContent,
    BModal,
    BForm,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    BButton,
    vSelect,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      selectedUser: '',
      allUsers: [],
      nameValue: '',
      addressValue: '',
      userRole: '',
      required,
      min,
    }
  },
  directives: {
    'b-modal': VBModal,
  },
  created() {
    this.userRole = localStorage.getItem('userRole');

    if (this.userRole === 'ADMIN') {
      this.$http.get('/users')
          .then(result => {
            this.allUsers = result.data.users
          })
    }
  },
  methods: {
    resetModal() {
      this.selectedUser = '';
      this.nameValue = '';
      this.addressValue = '';
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.submitForm();
    },
    submitForm() {
      this.$refs.buildingFormObserver.validate().then(success => {
        if (success) {
          let data = {
            'name': this.nameValue,
            'address': this.addressValue,
          };
          if (this.userRole === 'ADMIN') {
            data.user_id = this.selectedUser.id
          }
          this.$http.post('/buildings', data)
            .then(result => {
              this.$parent.$options.parent.rows.push(result.data.building);
              this.$bvModal.hide('create-building-form');

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Success',
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `Building "${result.data.building.name}" has been created`
                },
              })

            })
            .catch(error => {
              console.log('Error ' + error);
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Error',
                  icon: 'XIcon',
                  variant: 'danger',
                  text: 'Something went wrong when trying to create a building'
                },
              })
            })
        }
      })
    },
  }
}
</script>

<style lang="scss" >
@import '@core/scss/vue/libs/vue-select.scss';
</style>