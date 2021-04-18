<template>
  <b-modal
      id="update-level-form"
      cancel-variant="outline-secondary"
      ok-title="Update"
      cancel-title="Cancel"
      centered
      title="Update Floor"
      @show="getFloor"
      @hidden="resetModal"
      @ok="handleOk"
  >
    <form
        @submit.stop.prevent="submitForm"
    >
      <validation-observer ref="formObserver">
        <b-form-group
            label="Select Building"
            label-for="buildingSelect"
        >
          <validation-provider
              #default="{ errors }"
              name="Select Building"
              rules="required"
          >
            <v-select
                id="buildingSelect"
                name="building"
                disabled
                v-model="selectedBuilding"
                :options="allBuildings"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group>
          <label for="name">Name:</label>
          <validation-provider
              #default="{ errors }"
              name="name"
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
          <label for="level">Level:</label>
          <validation-provider
              #default="{ errors }"
              name="Level"
              rules="required|integer"
          >
            <b-form-input
                id="level"
                name="level"
                type="number"
                v-model="levelValue"
                :state="errors.length > 0 ? false:null"
                placeholder="Level"
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
  required, min, integer
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
  props: ['id', 'index'],
  data() {
    return {
      selectedBuilding: '',
      allBuildings: [],
      nameValue: '',
      levelValue: '',
      required,
      min,
      integer,
    }
  },
  directives: {
    'b-modal': VBModal,
  },
  created() {
    this.$http.get('/buildings')
        .then(result => {
          this.allBuildings = result.data.buildings
        })
  },
  methods: {
    getFloor() {
      this.$http.get('/floors/' + this.id)
          .then(result => {
            this.selectedBuilding = result.data.floor.building
            this.nameValue = result.data.floor.name
            this.levelValue = result.data.floor.level
          })
    },
    resetModal() {
      this.selectedBuilding = '';
      this.nameValue = '';
      this.levelValue = '';
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.submitForm();
    },
    submitForm() {
      this.$refs.formObserver.validate().then(success => {
        if (success) {
          let url = '/buildings/' + this.selectedBuilding.id + '/floors/' + this.id;
          this.$http.patch(url, {
              'name': this.nameValue,
              'level': this.levelValue,
          })
            .then(result => {
              this.$parent.$options.parent.rows[this.index].name = result.data.floor.name;
              this.$parent.$options.parent.rows[this.index].level = result.data.floor.level;
              this.$bvModal.hide('update-level-form');

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Success',
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `Floor "${result.data.floor.name}" has been created`
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
                  text: 'Something went wrong when trying to update a floor'
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