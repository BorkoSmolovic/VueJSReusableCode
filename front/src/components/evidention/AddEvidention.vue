<template>
  <v-row justify="end" class="mr-0">
    <v-dialog persistent v-model="addItemDialog" max-width="800px">
      <v-card>
        <v-card-title>
          <span class="headline">{{$t(translation+'.add')}}</span>
        </v-card-title>
        <v-card-text>
          <v-form ref="form" v-on:submit.prevent>
            <v-stepper
              v-model="e1">
              <v-stepper-header>
                <v-stepper-step
                  :editable="true"
                  :complete="e1 > 1"
                  step="1">Detalji
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                  :editable="true"
                  :complete="e1 > 2"
                  step="2">Radnici
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step
                  :editable="true"
                  step="3">Troškovi
                </v-stepper-step>
              </v-stepper-header>
              <v-stepper-items>
                <v-stepper-content step="1">
                  <v-row>
                    <v-col cols="12">
                      <v-text-field
                        v-model="form.event_name"
                        :label="$t(translation+'.name')+'*'" required
                        :rules="rules.required"
                        autocomplete="off"
                      />
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        readonly
                        v-model="partner.name"
                        text="name"
                        @change="contract.id=''"
                        @click="dialogChooseItem=true"
                        :label="$t(translation+'.partner')+'*'" required
                        :rules="rules.required"
                        autocomplete="off"/>
                    </v-col>
                    <v-col cols="6">
                      <v-text-field
                        readonly
                        v-model="contract.contract_name"
                        text="id"
                        :disabled="partner.name == undefined"
                        @click="dialogChooseItemContract=true"
                        :label="'Broj ugovora'+'*'" required
                        :rules="rules.required"
                        autocomplete="off"/>
                    </v-col>
                    <v-col cols="6">
                      <v-combobox
                        v-model="country"
                        :items="countries"
                        @change="city=null"
                        :rules="rules.required"
                        :label="'Država'+'*'"
                        item-text="name"
                        autocomplete="off"
                      />
                    </v-col>
                    <v-col cols="6">
                      <v-combobox
                        v-model="city"
                        :disabled="country == null || country.city == undefined"
                        :items="country != null && country.city != undefined ? country.city : []"
                        @change="form.city_id = city.id"
                        :rules="rules.required"
                        :label="'Grad'+'*'"
                        item-text="name"
                        autocomplete="off"
                      />
                    </v-col>
                    <v-col cols="12">
                      <v-autocomplete
                        v-model="form.services"
                        :items="services"
                        dense
                        chips
                        small-chips
                        label="Tip usluge"
                        return-object
                        item-text="name"
                        multiple
                        solo
                      ></v-autocomplete>
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                        class=""
                        auto-grow
                        dense
                        rows="1"
                        v-model="form.description"
                        :label="$t(translation+'.description')"
                        single-line
                        :rows="2"
                        outlined
                        autocomplete="off"
                      ></v-textarea>
                    </v-col>
                    <v-col cols="6">
                      <v-menu
                        v-model="date"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="form.date"
                            :label="$t(translation+'.date')"
                            readonly
                            :rules="rules.required"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="form.date"
                                       @input="date = false"></v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col cols="6">
                      <v-select autocomplete="off"
                                class="justify-center"
                                v-model="form.is_commercial"
                                :items="commercialObjects"
                                item-value="value"
                                item-text="text"
                                style="padding: 0; margin-top: 1em !important; margin-bottom: -1em !important;  font-size: inherit; text-align: right !important;"
                                :rules="rules.choose"
                                :label="$t(translation+'.commercial')+'*'">
                      </v-select>
                    </v-col>
                  </v-row>
                  <v-row class="px-5">
                    <small>{{$t('required_fields')}}</small>
                    <div class="flex-grow-1"/>
                    <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">
                      {{$t('close')}}
                    </v-btn>
                    <v-btn
                      color="primary"
                      @click="e1 = 2"
                    >
                      Nastavi
                    </v-btn>
                  </v-row>
                </v-stepper-content>
                <v-stepper-content step="2">
                  <v-row class="px-5">
                    <div class="flex-grow-1"/>
                    <v-btn
                      color="primary"
                      @click="addWorker"
                    >
                      Dodaj radnika
                    </v-btn>
                  </v-row>
                  <v-data-table
                    :mobile-breakpoint="breakpoint"
                    :headers="headersWorkers"
                    :items="form.workers"
                    :items-per-page="itemsPerPage"
                    :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                    :dense="true"
                    :loading-text="$t('loading_data')"
                    sort-by="name"
                    :loading="tableWorkerLoading"
                  >
                    <template v-slot:item.type="{ item }">
                      <v-combobox
                        v-model="item.workerType"
                        :items="workerTypes"
                        @change="getWorkersByType(item)"
                        :rules="rules.required"
                        :label="'Tip radnika'+'*'"
                        item-text="name"
                        autocomplete="off"
                      />
                    </template>
                    <template v-slot:item.name="{ item }">
                      <v-combobox
                        v-model="item.worker"
                        :items="item.filteredWorkers"
                        :disabled="item.filteredWorkers == null"
                        @change="item.worker == null? '' :item.worker_id = item.worker.id"
                        :rules="rules.required"
                        :label="'Ime radnika'+'*'"
                        item-text="fullName"
                        autocomplete="off"
                      />
                    </template>
                    <template v-slot:item.salary="{ item }">
                      <v-text-field
                        :label="'Dnevnica'+'*'"
                        v-model="item.salary"
                        :rules="rules.positive_number"
                        autocomplete="off"
                      />
                    </template>
                    <template v-slot:item.actions="{ item }">
                      <v-layout align-center justify-center>
                        <v-icon :disabled="form.workers.length <= 1"
                                @click="removeWorker(item)">mdi-trash-can-outline
                        </v-icon>
                      </v-layout>
                    </template>
                  </v-data-table>
                  <v-row class="px-5">
                    <small>{{$t('required_fields')}}</small>
                    <div class="flex-grow-1"/>
                    <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">
                      {{$t('close')}}
                    </v-btn>
                    <v-btn
                      color="primary"
                      @click="e1 = 3"
                    >
                      Nastavi
                    </v-btn>
                  </v-row>
                </v-stepper-content>
                <v-stepper-content step="3">
                  <v-row class="px-5">
                    <div class="flex-grow-1"/>
                    <v-btn
                      color="primary"
                      @click="addItem"
                    >
                      Dodaj stavku
                    </v-btn>
                  </v-row>
                  <v-data-table
                    :mobile-breakpoint="breakpoint"
                    :headers="headersItems"
                    :items="form.items"
                    :items-per-page="itemsPerPage"
                    :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                    :dense="true"
                    :loading-text="$t('loading_data')"
                    sort-by="name"
                    :loading="tableItemLoading"
                  >
                    <template v-slot:item.name="{ item }">
                      <v-combobox
                        v-model="item.item"
                        :items="items"
                        @change="checkVehicle(item)"
                        :rules="rules.required"
                        :label="'Naziv'+'*'"
                        item-text="name"
                        autocomplete="off"
                      />
                      <div v-if="item.vehicle!=null">{{'('+item.vehicle.type+', '+item.vehicle.plates+')'}}</div>
                    </template>
                    <template v-slot:item.value="{ item }">
                      <v-text-field
                        :label="'Cijena'+'*'"
                        v-model="item.value"
                        :rules="rules.positive_number"
                        autocomplete="off"
                      />
                      <div v-if="item.vehicle!=null" class="white--text ">&nbsp</div>
                    </template>
                    <template v-slot:item.actions="{ item }">
                      <v-layout align-center justify-center>
                        <v-icon :disabled="form.items.length <= 1" @click="removeItem(item)">
                          mdi-trash-can-outline
                        </v-icon>
                      </v-layout>
                    </template>
                  </v-data-table>
                  <v-row class="px-5">
                    <small>{{$t('required_fields')}}</small>
                    <div class="flex-grow-1"/>
                    <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">
                      {{$t('close')}}
                    </v-btn>
                    <v-btn
                      color="primary"
                      @click="check()"
                    >
                      Dodaj
                    </v-btn>
                  </v-row>
                </v-stepper-content>
              </v-stepper-items>
            </v-stepper>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <!---------------------------------- Add Partner Dialog  ----------------------------------------->
    <dialog-choose-item
      :singleSelect="singleSelect"
      :id="-1"
      :api="ChooseItemApi"
      :translation="ChooseItemTranslation"
      :headers="itemHeaders"
      :dialogChooseItem="dialogChooseItem"
      @close="dialogChooseItem=false"
      @addSuperior="choosenPartner"
    />
    <!---------------------------------- Add Contract Dialog  ----------------------------------------->
    <dialog-choose-item
      v-if="partner != null"
      :id="partner == null ? '-1' : partner.id"
      :singleSelect="singleSelectContract"
      :api="ChooseItemApiContract"
      :translation="ChooseItemTranslationContract"
      :headers="itemHeadersContract"
      :dialogChooseItem="dialogChooseItemContract"
      @close="dialogChooseItemContract=false"
      @addSuperior="choosenContract"
    />
    <!---------------------------------- Add Vehicle Dialog  ----------------------------------------->
    <dialog-choose-item
      v-if="partner != null"
      :id="'-1'"
      :singleSelect="singleSelectVehicle"
      :api="ChooseItemApiVehicle"
      :translation="ChooseItemTranslationVehicle"
      :headers="itemHeadersVehicle"
      :dialogChooseItem="dialogChooseItemVehicle"
      @close="closeVehicles"
      @addSuperior="choosenVehicle"
    />
    <!---------------------------------- Snackbar  ----------------------------------------->
    <v-snackbar
      v-model="snackbar.show"
      :bottom=true
      :color="snackbar.color"
      :timeout="snackbar.timeout">
      {{ snackbar.text }}
      <v-btn dark text @click="snackbar.show = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-snackbar>
  </v-row>
</template>

<script>
  import {
    add,
    readCountriesActive,
    readItemsActive,
    readWorkersActive,
    readWorkerTypesActive,
    readServicesActive
  } from "../../statics/DataTableFunctions";
  import ChooseItemDialog from "../licencePartners/ChooseItemDialog";

  export default {
    components: {
      'dialog-choose-item': ChooseItemDialog,
    },
    props: {
      addItemDialog: false,
    },
    name: "AddEvidention",
    data() {
      return {
        singleSelectVehicle: true,
        ChooseItemApiVehicle: 'vehicle',
        ChooseItemTranslationVehicle: 'vehicles',
        dialogChooseItemVehicle: false,
        currentItem: null,
        singleSelectContract: true,
        ChooseItemApiContract: 'contractActive',
        ChooseItemTranslationContract: 'contracts',
        dialogChooseItemContract: false,
        workerTypes: null,
        contracts: null,
        services: [],
        contract: {},
        partner: {},
        country: null,
        countries: null,
        city: null,
        cities: null,
        items: null,
        workers: null,
        e1: 1,
        breakpoint: 500,
        itemsPerPage: 10,
        tableItemLoading: false,
        tableWorkerLoading: false,
        ChooseItemApi: 'partnersActive',
        ChooseItemTranslation: 'partners',
        date: false,
        dialogChooseItem: false,
        singleSelect: true,
        translation: 'evidentions',
        api: 'evidention',
        loading: false,
        form: {
          event_name: "",
          contract_id: "",
          description: "",
          date: "",
          is_commercial: "",
          city_id: '',
          workers: [
            {
              filteredWorkers: null,
              workerType: '',
              worker_type_id: '',
              worker: '',
              worker_id: '',
              salary: ''
            }
          ],
          items: [
            {
              vehicle_id: null,
              vehicle: null,
              item: '',
              item_id: '',
              value: ''
            }
          ],
          services: []
        },
        rules: {
          required: [
            v => !!v || this.$t('validation.field'),
          ],
          required_date: [
            v => !!v || this.$t('validation.field'),
          ],
          required_length: [
            v => !!v || this.$t('validation.field'),
            v => v == '' || v.length > 1 || this.$t(this.translation + '.validation')
          ],
          choose: [
            v => v !== "" || this.$t('validation.field'),
          ],
          positive_number: [
            v => /^\d{1,}[.]\d{1,}$/.test(v) && v > 0 || /^\d{1,}$/.test(v) && v > 0 || "Morate unijeti pozitivan broj"
          ],
        },
        snackbar: {
          color: 'success',
          show: false,
          text: '',
          timeout: 3000,
        },
      }
    },
    computed: {
      itemHeadersVehicle() {
        return [
          {text: 'Tip', name: 'type', align: 'left', sortable: true, value: 'type'},
          {text: 'Tablice', name: 'plates', align: 'left', sortable: true, value: 'plates'},
          {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
        ]
      },
      headersWorkers() {
        return [
          {text: 'Tip', name: 'type', align: 'left', sortable: true, value: 'type'},
          {text: 'Ime', name: 'name', align: 'left', sortable: true, value: 'name'},
          {text: 'Dnevnica', name: 'salary', align: 'left', sortable: false, value: 'salary'},
          {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
        ]
      },
      headersItems() {
        return [
          {text: 'Naziv', name: 'name', align: 'left', sortable: true, value: 'name'},
          {text: 'Cijena', name: 'value', align: 'left', sortable: false, value: 'value'},
          {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
        ]
      },
      itemHeaders() {
        return [
          {
            text: this.$t(this.ChooseItemTranslation + '.name'),
            name: 'name',
            align: 'left',
            sortable: true,
            value: 'name'
          },
          {
            text: this.$t(this.ChooseItemTranslation + '.address'),
            name: 'address',
            align: 'left',
            value: 'address'
          },
          {
            text: this.$t(this.ChooseItemTranslation + '.pib'),
            name: 'pib',
            align: 'left',
            value: 'pib'
          },
          {
            text: this.$t(this.ChooseItemTranslation + '.pdv'),
            name: 'pdv',
            align: 'left',
            value: 'pdv'
          },
          {
            text: this.$t(this.ChooseItemTranslation + '.active'),
            name: 'active',
            align: 'left',
            value: 'isActive'
          },
          {
            text: this.$t(this.ChooseItemTranslation + '.type'),
            name: 'type',
            align: 'left',
            value: 'partner_type.name'
          },
          {text: this.$t('actions'), name: 'actions', align: 'center', value: 'actions'},
        ]
      },
      itemHeadersContract() {
        return [
          {
            text: this.$t(this.ChooseItemTranslationContract + '.id'),
            name: 'id',
            align: 'left',
            sortable: true,
            value: 'id'
          },
          {
            text: this.$t(this.ChooseItemTranslationContract + '.contract_name'),
            name: 'contract_name',
            align: 'left',
            sortable: true,
            value: 'contract_name'
          },
          {
            text: this.$t(this.ChooseItemTranslationContract + '.dateFrom'),
            name: 'dateFrom',
            align: 'left',
            sortable: true,
            value: 'dateFrom'
          },
          {
            text: this.$t(this.ChooseItemTranslationContract + '.dateTo'),
            name: 'dateTo',
            align: 'left',
            sortable: true,
            value: 'dateTo'
          },
          {
            text: this.$t(this.ChooseItemTranslationContract + '.no'),
            name: 'no',
            align: 'left',
            sortable: true,
            value: 'number_of_recordings'
          },
          {
            text: this.$t(this.ChooseItemTranslationContract + '.remaining'),
            name: 'recordings_remaining',
            align: 'left',
            sortable: true,
            value: 'recordings_remaining'
          },
          {
            text: this.$t(this.ChooseItemTranslationContract + '.active'),
            name: 'active',
            align: 'left',
            sortable: true,
            value: 'isActive'
          },
          {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
        ]
      },
      commercialObjects() {
        return [
          {value: "", text: this.$t('choose')},
          {value: true, text: this.$t('yes')},
          {value: false, text: this.$t('no')},
        ]
      },
    },
    created() {
      this.readWorkerTypesActive();
      this.readItemsActive();
      this.readWorkersActive();
      this.readCountriesActive();
      this.readServicesActive();
    },
    methods: {
      readServicesActive,
      checkWorkers() {
        let check = true;
        for (let i = 0; i < this.form.workers.length; i++) {
          if (!this.form.workers[i].worker_id || !this.form.workers[i].salary) {
            check = false;
          }
        }
        return check;
      },
      check() {
        if (this.form.event_name === "" || this.form.contract_id === "" || this.form.is_commercial === "" || this.form.city_id === "" || this.form.city_id === null) {
          this.e1 = 1;
        } else if (!this.checkWorkers()) {
          this.e1 = 2
        } else {
          this.e1 = 3;
        }
        this.add(this.api)
      },
      closeVehicles(number) {
        this.dialogChooseItemVehicle = false
        if (number == -1) {
          this.currentItem.item = '';
          this.currentItem.value = '';
          this.currentItem.item_id = '';
          this.currentItem.vehicle_id = null;
          this.currentItem.vehicle = null;
        }
      },
      checkVehicle(item) {
        item.vehicle_id = null;
        item.vehicle = null;
        this.currentItem = item;
        item.item_id = item.item.id;
        if (item.item.hasVehicles) {
          this.dialogChooseItemVehicle = true;
        }
      },
      containsWorkerRole(workerTypeID, workerID) {
        for (let m = 0; m < this.form.workers.length; m++) {
          if (this.form.workers[m].worker_type_id == workerTypeID && this.form.workers[m].worker_id == workerID) {
            return true
          }
        }
        return false
      },
      getWorkersByType(item) {
        this.containsWorkerRole()
        item.worker_type_id = item.workerType.id;
        item.filteredWorkers = [];
        for (let i = 0; i < this.workers.length; i++) {
          for (let j = 0; j < this.workers[i].worker_type_worker.length; j++) {
            if (this.workers[i].worker_type_worker[j].worker_type_id == item.workerType.id && !this.containsWorkerRole(item.worker_type_id, this.workers[i].id)) {
              item.filteredWorkers.push(this.workers[i])
            }
          }
        }
      },
      readCountriesActive,
      add,
      clearContract() {
        this.contract = {};
        this.form.contract_id = "";
      },
      choosenContract(item) {
        this.clearContract();
        this.contract = item;
        this.form.contract_id = item.id
      },
      choosenPartner(item) {
        this.partner = item;
        this.form.partner_id = item.id;
      },
      choosenVehicle(item) {
        this.currentItem.vehicle = item;
        this.currentItem.vehicle_id = item.id;
      },
      addWorker() {
        this.form.workers.push({
          filteredWorkers: null,
          workerType: '',
          worker_type_id: '',
          worker: '',
          worker_id: '',
          salary: ''
        })
      },
      removeWorker(item) {
        this.form.workers.splice(this.form.workers.indexOf(item), 1)
      },
      readWorkerTypesActive,
      readWorkersActive,
      addItem() {
        this.form.items.push({
          vehicle_id: null,
          vehicle: null,
          item: '',
          item_id: '',
          value: ''
        })
      },
      removeItem(item) {
        this.form.items.splice(this.form.items.indexOf(item), 1)
      },
      readItemsActive,
      closeDialog() {
        this.e1 = 1;
        this.country = null;
        this.city = null;
        this.partner = {},
          this.contract = {},
          this.form = {
            event_name: "",
            contract_id: "",
            description: "",
            date: "",
            is_commercial: "",
            city_id: '',
            workers: [
              {
                filteredWorkers: null,
                workerType: '',
                worker_type_id: '',
                worker: '',
                worker_id: '',
                salary: ''
              }
            ],
            items: [
              {
                vehicle_id: null,
                vehicle: null,
                item: '',
                item_id: '',
                value: ''
              }
            ],
          }
        this.$refs.form.resetValidation()
        this.$emit('close')
      },
    }
  }
</script>

<style scoped/>

