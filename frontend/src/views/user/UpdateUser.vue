<template>
  <b-modal
      id="update-user-form"
      cancel-variant="outline-secondary"
      ok-title="Update"
      cancel-title="Cancel"
      centered
      title="Update User"
      @show="getUser"
      @hidden="resetUserModal"
      @ok="handleOk"
  >
    <form
        @submit.stop.prevent="submitUserForm"
    >
      <validation-observer ref="userFormObserver">
        <b-form-group>
          <label for="first_name">First Name:</label>
          <validation-provider
              #default="{ errors }"
              name="First Name"
              rules="required|min:3"
          >
            <b-form-input
                id="first_name"
                name="first_name"
                type="text"
                v-model="firstNameValue"
                :state="errors.length > 0 ? false:null"
                placeholder="First Name"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group>
          <label for="last_name">Last Name:</label>
          <validation-provider
              #default="{ errors }"
              name="Last Name"
              rules="required|min:3"
          >
            <b-form-input
                id="last_name"
                name="last_name"
                type="text"
                v-model="lastNameValue"
                :state="errors.length > 0 ? false:null"
                placeholder="Last Name"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group>
          <label for="last_name">Email:</label>
          <validation-provider
              #default="{ errors }"
              name="Email"
              rules="required|email"
          >
            <b-form-input
                id="email"
                name="email"
                type="text"
                v-model="emailValue"
                :state="errors.length > 0 ? false:null"
                placeholder="Email"
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
  required, min, email
} from '@validations'

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
    ValidationProvider,
    ValidationObserver,
  },
  props: ['id', 'index'],
  data() {
    return {
      firstNameValue: '',
      lastNameValue: '',
      emailValue: '',
      required,
      min,
      email,
    }
  },
  directives: {
    'b-modal': VBModal,
  },
  methods: {
    getUser() {
      this.$http.get('/users/' + this.id)
          .then(result => {
            this.firstNameValue = result.data.user.first_name
            this.lastNameValue = result.data.user.last_name
            this.emailValue = result.data.user.email
          })
    },
    resetUserModal() {
      this.firstNameValue = '';
      this.lastNameValue = '';
      this.emailValue = '';
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.submitUserForm();
    },
    submitUserForm() {
      this.$refs.userFormObserver.validate().then(success => {
        if (success) {
          this.$http.patch('/users/' + this.id, {
              'first_name': this.firstNameValue,
              'last_name': this.lastNameValue,
              'email': this.emailValue,
          })
            .then(result => {
              this.$parent.$options.parent.rows[this.index].first_name = result.data.user.first_name;
              this.$parent.$options.parent.rows[this.index].last_name = result.data.user.last_name;
              this.$parent.$options.parent.rows[this.index].email = result.data.user.email;
              this.$bvModal.hide('update-user-form');

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Success',
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `User "${result.data.user.first_name} ${result.data.user.last_name}" has been created`
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
                  text: 'Something went wrong when trying to update a user'
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