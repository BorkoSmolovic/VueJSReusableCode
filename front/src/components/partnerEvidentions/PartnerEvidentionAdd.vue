<template>
  <v-row justify="end" class="mr-0">
    <v-dialog persistent v-model="addItemDialog" max-width="800px">
      <v-card>
        <v-card-title>
          <span class="headline">{{$t(translation+'.add')}}</span>
        </v-card-title>
        <v-card-text class="pa-8">
          <v-form ref="form" v-on:submit.prevent>
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
                  v-model="contract.contract_name"
                  text="id"
                  @click="dialogChooseItemContract=true"
                  :label="'Broj ugovora'+'*'" required
                  :rules="rules.required"
                  autocomplete="off"/>
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
                                 @input="date = false" :min="minDate"
                                 locale="sr-Latn-CS"></v-date-picker>
                </v-menu>
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

            </v-row>
            <v-row class="px-5">
              <small>{{$t('required_fields')}}</small>
              <div class="flex-grow-1"/>
              <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">
                {{$t('close')}}
              </v-btn>
              <v-btn
                color="primary"
                @click="add(api)"
              >
                {{$t('add')}}
              </v-btn>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <!---------------------------------- Add Contract Dialog  ----------------------------------------->
    <dialog-choose-item
      :id="partner_id"
      :singleSelect="singleSelectContract"
      :api="ChooseItemApiContract"
      :translation="ChooseItemTranslationContract"
      :headers="itemHeadersContract"
      :dialogChooseItem="dialogChooseItemContract"
      @close="dialogChooseItemContract=false"
      @addSuperior="choosenContract"
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
  import {add, readCountries, readItems, readWorkers, readWorkerTypes} from "../../statics/DataTableFunctions";
  import ChooseItemDialog from "../licencePartners/ChooseItemDialog";

  export default {
    components: {
      'dialog-choose-item': ChooseItemDialog,
    },
    props: {
      addItemDialog: false,
    },
    name: "PartnerAddEvidention",
    data() {
      return {
        partner_id: localStorage.getItem('partner_id'),
        singleSelectContract: true,
        ChooseItemApiContract: 'contract',
        ChooseItemTranslationContract: 'contracts',
        dialogChooseItemContract: false,
        contracts: null,
        contract: {},
        country: null,
        countries: null,
        city: null,
        cities: null,
        e1: 0,
        minDate: '',
        breakpoint: 500,
        itemsPerPage: 10,
        date: false,
        singleSelect: true,
        translation: 'evidentions',
        api: 'evidention',
        loading: false,
        form: {
          event_name: "",
          contract_id: "",
          description: "",
          date: "",
          city_id: '',
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
            v => v === '' || v.length > 1 || this.$t(this.translation + '.validation')
          ],
          choose: [
            v => v === 1 || v === 0 || this.$t('validation.field'),
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
    },
    created() {
      this.setMinDate();
      this.readCountries();
    },
    methods: {
      setMinDate() {
        let date = new Date();
        this.minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 1).toISOString();
      },
      getWorkersByType(item) {
        item.worker_type_id = item.workerType.id;
        item.filteredWorkers = [];
        for (let i = 0; i < this.workers.length; i++) {
          for (let j = 0; j < this.workers[i].worker_type_worker.length; j++) {
            if (this.workers[i].worker_type_worker[j].worker_type_id === item.workerType.id) {
              item.filteredWorkers.push(this.workers[i])
            }
          }
        }
      },
      readCountries,
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

