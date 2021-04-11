<template>
  <b-modal
      id="create-user-form"
      cancel-variant="outline-secondary"
      ok-title="Create"
      cancel-title="Cancel"
      centered
      title="Create User"
      @show="resetUserModal"
      @hidden="resetUserModal"
      @ok="handleOk"
  >
    <form
        ref="form"
        @submit.stop.prevent="submitUserForm"
    >
      <validation-observer ref="userFormObserver">
        <b-form-group
            label="Select Role"
            label-for="roleSelect"
        >
          <validation-provider
              #default="{ errors }"
              name="Select Role"
              rules="required"
          >
            <v-select
                id="roleSelect"
                name="role"
                v-model="selectedRole"
                :options="allRoles"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
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
          <label for="email">Email:</label>
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
        <b-form-group>
          <label for="password">Password:</label>
          <validation-provider
              #default="{ errors }"
              rules="required|password"
              name="password"
              vid="password"
          >
            <b-form-input
                id="password"
                name="password"
                v-model="passwordValue"
                type="password"
                :state="errors.length > 0 ? false:null"
                placeholder="Password"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group>
          <label for="password_confirmation">Confirmation:</label>
          <validation-provider
              #default="{ errors }"
              rules="required|confirmed:password"
              name="Confirm Password"
          >
            <b-form-input
                id="password_confirmation"
                name="password_confirmation"
                v-model="passwordConfirmationValue"
                type="password"
                :state="errors.length > 0 ? false:null"
                placeholder="Repeat Password"
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
  required, min, email, confirmed, password,
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
      selectedRole: 'REGULAR',
      allRoles: ['REGULAR', 'ADMIN'],
      firstNameValue: '',
      lastNameValue: '',
      emailValue: '',
      passwordValue: '',
      passwordConfirmationValue: '',
      required,
      min,
      password,
      email,
      confirmed,
    }
  },
  directives: {
    'b-modal': VBModal,
  },
  methods: {
    resetUserModal() {
      this.selectedRole = 'REGULAR';
      this.firstNameValue = '';
      this.lastNameValue = '';
      this.emailValue = '';
      this.passwordValue = '';
      this.passwordConfirmationValue = '';
    },
    handleOk(bvModalEvt) {
      console.log(this.id);
      console.log(this.props.id);
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.submitUserForm();
    },
    submitUserForm() {
      this.$refs.userFormObserver.validate().then(success => {
        if (success) {
          this.$http.post('/users', {
              'first_name': this.firstNameValue,
              'last_name': this.lastNameValue,
              'email': this.emailValue,
              'password': this.passwordValue,
              'password_confirmation': this.passwordConfirmationValue,
              'role': this.selectedRole,
          })
            .then(result => {
              this.$parent.$options.parent.rows.push(result.data.user);
              this.$bvModal.hide('create-user-form');

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
                  text: 'Something went wrong when trying to create a user'
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