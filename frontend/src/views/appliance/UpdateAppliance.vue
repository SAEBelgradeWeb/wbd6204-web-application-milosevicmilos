<template>
  <b-modal
      id="update-appliance-form"
      cancel-variant="outline-secondary"
      ok-title="Update"
      cancel-title="Cancel"
      centered
      title="Update Appliance"
      @show="getAppliance"
      @hidden="resetModal"
      @ok="handleOk"
  >
    <form
        @submit.stop.prevent="submitForm"
    >
      <validation-observer ref="formObserver">
        <b-form-group
            label="Filter User Buildings"
            label-for="userSelect"
            v-if="this.userRole === 'ADMIN'"
        >
          <validation-provider
              #default="{ errors }"
              name="Filter User Buildings"
          >
            <v-select
                id="userSelect"
                v-model="selectedUser"
                :options="allUsers"
                @input="filterBuildings"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
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
                v-model="selectedFloor"
                :options="allFloors"
                :disabled="floors_disabled === true"
                @input="getRooms"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group
            label="Select Room"
            label-for="roomSelect"
        >
          <validation-provider
              #default="{ errors }"
              name="Select Room"
              rules="required"
          >
            <v-select
                id="roomSelect"
                name="room"
                v-model="selectedRoom"
                :disabled="rooms_disabled === true"
                :options="allRooms"
            />
            <small class="text-danger">{{ errors[0] }}</small>
          </validation-provider>
        </b-form-group>
        <b-form-group
            label="Select Type"
            label-for="typeSelect"
        >
          <validation-provider
              #default="{ errors }"
              name="Select Type"
              rules="required"
          >
            <v-select
                id="typeSelect"
                name="type"
                v-model="selectedType"
                :options="allTypes"
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
  props: ['appliance'],
  data() {
    return {
      selectedUser: '',
      allUsers: [],
      selectedBuilding: '',
      allBuildings: [],
      selectedFloor: '',
      allFloors: [],
      selectedRoom: '',
      allRooms: [],
      floors_disabled: false,
      rooms_disabled: false,
      nameValue: '',
      selectedType: '',
      allTypes: [],
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

    this.$http.get('/users')
        .then(result => {
          this.allUsers = result.data.users
        })

    this.$http.get('/buildings')
        .then(result => {
          this.allBuildings = result.data.buildings
        })

    this.$http.get('/appliance-types')
        .then(result => {
          this.allTypes = result.data.appliance_types
        })
  },
  methods: {
    getAppliance() {
      this.$http.get('/buildings/' + this.appliance.room.floor.building.id + '/floors')
          .then(result => {
            this.allFloors = result.data.floors
          })

      this.$http.get('/buildings/' + this.appliance.room.floor.building.id + '/floors/' + this.appliance.room.floor.id + '/rooms')
          .then(result => {
            this.allRooms = result.data.rooms
          })

      this.$http.get( '/appliances/' + this.appliance.id)
          .then(result => {
            this.selectedBuilding = result.data.appliance.room.floor.building
            this.selectedFloor = result.data.appliance.room.floor
            this.selectedRoom = result.data.appliance.room
            this.nameValue = result.data.appliance.name
            this.selectedType = result.data.appliance.appliance_type
          })
    },
    filterBuildings() {

    },
    getFloors() {
      this.selectedFloor = '';
      this.allFloors = [];
      this.floors_disabled = false;

      this.selectedRoom = '';
      this.allRooms = [];
      this.rooms_disabled = true;

      this.$http.get('/buildings/' + this.selectedBuilding.id + '/floors')
          .then(result => {
            this.allFloors = result.data.floors
          })
    },
    getRooms() {
      this.selectedRoom = '';
      this.allRooms = [];
      this.rooms_disabled = false;

      this.$http.get('/buildings/' + this.selectedBuilding.id + '/floors/' + this.selectedFloor.id + '/rooms')
          .then(result => {
            this.allRooms = result.data.rooms
          })
    },
    resetModal() {
      this.selectedUser = '';
      this.selectedBuilding = '';
      this.selectedFloor = '';
      this.selectedRoom = '';
      this.nameValue = '';
      this.selectedType = '';

      this.floors_disabled = false;
      this.rooms_disabled = false;
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
          this.$http.patch('/appliances/' + this.appliance.id, {
            'room_id': this.selectedRoom.id,
            'name': this.nameValue,
            'appliance_type_id': this.selectedType.id,
          })
            .then(result => {
              this.$parent.$options.parent.rows[this.appliance.originalIndex].name = result.data.appliance.name;
              this.$parent.$options.parent.rows[this.appliance.originalIndex].appliance_type.name = result.data.appliance.appliance_type.name;
              this.$parent.$options.parent.rows[this.appliance.originalIndex].room.name = result.data.appliance.room.name;
              this.$bvModal.hide('update-appliance-form');

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: 'Success',
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `Appliance "${result.data.appliance.name}" has been updated`
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
                  text: 'Something went wrong when trying to update an appliance'
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