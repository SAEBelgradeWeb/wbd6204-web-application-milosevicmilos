<template>
  <b-modal
      id="create-room-form"
      cancel-variant="outline-secondary"
      ok-title="Create"
      cancel-title="Cancel"
      centered
      title="Create Room"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
  >
    <form
        ref="form"
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
                v-model="selectedBuilding"
                :options="allBuildings"
                @input="getFloors"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group
            label="Select Floor"
            label-for="floorSelect"
        >
          <validation-provider
              #default="{ errors }"
              name="Select Floor"
              rules="required"
          >
            <v-select
                id="floorSelect"
                name="floor"
                v-model="selectedFloor"
                :disabled="floors_disabled === true"
                :options="allFloors"
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
          <label for="size">Size:</label>
          <validation-provider
              #default="{ errors }"
              name="Size"
              rules="required|integer"
          >
            <b-form-input
                id="size"
                name="size"
                type="number"
                v-model="sizeValue"
                :state="errors.length > 0 ? false:null"
                placeholder="Size"
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
  data() {
    return {
      selectedBuilding: '',
      allBuildings: [],
      selectedFloor: '',
      allFloors: [],
      floors_disabled: true,
      nameValue: '',
      sizeValue: '',
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
    getFloors() {
      this.selectedFloor = '';
      this.allFloors = [];
      this.floors_disabled = false;

      this.$http.get('/buildings/' + this.selectedBuilding.id + '/floors')
          .then(result => {
            this.allFloors = result.data.floors
          })
    },
    resetModal() {
      this.selectedBuilding = '';
      this.selectedFloor = '';
      this.nameValue = '';
      this.sizeValue = '';
      this.selectedFloor = '';
      this.allFloors = [];
      this.floors_disabled = true;
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
          let url = '/buildings/' + this.selectedBuilding.id + '/floors/' + this.selectedFloor.id + '/rooms';

          this.$http.post(url, {
            'floor_id': this.selectedFloor.id,
            'name': this.nameValue,
            'size': this.sizeValue,
          })
            .then(result => {
              this.$parent.$options.parent.rows.push(result.data.room);
              this.$bvModal.hide('create-room-form');

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Success',
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `Room "${result.data.room.name}" has been created`
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
                  text: 'Something went wrong when trying to create a room'
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