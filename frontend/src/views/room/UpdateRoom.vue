<template>
  <b-modal
      id="update-room-form"
      cancel-variant="outline-secondary"
      ok-title="Update"
      cancel-title="Cancel"
      centered
      title="Update Room"
      @show="getRoom"
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
                disabled=""
                v-model="selectedFloor"
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
  props: ['room'],
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
    getRoom() {
      this.$http.get( '/buildings/' + this.room.floor.building.id + '/floors/' + this.room.floor.id + '/rooms/' + this.room.id)
          .then(result => {
            this.selectedBuilding = result.data.room.floor.building
            this.selectedFloor = result.data.room.floor
            this.nameValue = result.data.room.name
            this.sizeValue = result.data.room.size
          })
    },
    resetModal() {
      this.selectedBuilding = '';
      this.allFloors = [];
      this.selectedFloor = '';
      this.nameValue = '';
      this.sizeValue = '';
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
          let url = '/buildings/' + this.selectedBuilding.id + '/floors/' + this.selectedFloor.id + '/rooms/' + this.room.id;
          this.$http.patch(url, {
              'name': this.nameValue,
              'size': this.sizeValue,
          })
            .then(result => {
              this.$parent.$options.parent.rows[this.room.originalIndex].name = result.data.room.name;
              this.$parent.$options.parent.rows[this.room.originalIndex].size = result.data.room.size;
              this.$bvModal.hide('update-room-form');

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Success',
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `Room "${result.data.room.name}" has been updated`
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