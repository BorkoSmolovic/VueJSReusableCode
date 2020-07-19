<template>
  <v-container>
    <v-row class="center" justify="center">
      <v-col cols="12">
        <!--  ===============================================TABOVI ===============================================-->
        <v-tabs
          background-color="white"
          class="elevation-2 primary--text"
        >
          <v-tabs-slider color="primary"></v-tabs-slider>
          <!--      =============================================== Radnici ===============================================-->
          <v-tab>
            <v-icon>mdi-account-hard-hat</v-icon>
            <v-card-text class="text-uppercase">
              {{$t('drawer.workers')}}
            </v-card-text>
          </v-tab>
          <v-tab>
            <v-icon>mdi-ballot-outline</v-icon>
            <v-card-text class="text-uppercase">
              {{$t('drawer.items')}}
            </v-card-text>
          </v-tab>
          <v-tab>
            <v-icon>mdi-account</v-icon>
            <v-card-text class="text-uppercase">
              {{$t('drawer.clients')}}
            </v-card-text>
          </v-tab>
          <!----------------- IZVJESTAJ O RADNICIMA ------------------>
          <v-tab-item>
            <v-card>
              <v-card-text>
                <v-row>
                  <v-col cols="3">
                    <v-combobox
                      multiple
                      v-model="workerType"
                      :items="workerTypes"
                      :label="'Tip radnika'"
                      item-text="name"
                      autocomplete="off"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-combobox
                      multiple
                      v-model="worker"
                      :items="workers"
                      :label="'Ime radnika'"
                      item-text="fullName"
                      autocomplete="off"
                    />
                  </v-col>
                  <v-col cols="2">
                    <v-menu
                      v-model="menuFrom"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFrom"
                          label="Datum od"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker v-model="dateFrom"
                                     :max="dateTo"
                                     @input="menuFrom = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="2">
                    <v-menu
                      v-model="menuTo"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateTo"
                          label="Datum do"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker v-model="dateTo"
                                     :min="dateFrom"
                                     @input="menuTo = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col>
                    <v-layout align-center justify-center>
                      <v-btn class="primary" @click="downloadWorkerReport" :loading="downloadingWorkerReport">
                        <v-icon>
                          mdi-download
                        </v-icon>
                        &nbsp Preuzmi
                        izvještaj
                      </v-btn>
                    </v-layout>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-tab-item>
          <!----------------- IZVJESTAJ O TROŠKOVIMA ------------------>
          <v-tab-item>
            <v-card>
              <v-card-text>
                <v-row>
                  <v-col cols="3">
                    <v-combobox
                      multiple
                      v-model="chosenItems"
                      :items="items"
                      :label="$t('drawer.items')"
                      item-text="name"
                      autocomplete="off"
                    />
                  </v-col>
                  <v-col cols="2">
                    <v-menu
                      v-model="menuFromCosts"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFrom"
                          label="Datum od"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFrom"
                        :max="dateTo"
                        @input="menuFromCosts = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="2">
                    <v-menu
                      v-model="menuToCosts"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateTo"
                          label="Datum do"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateTo"
                        :min="dateFrom"
                        @input="menuToCosts = false">
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col>
                    <v-layout align-center justify-center>
                      <v-btn class="primary" @click="downloadItemsReport" :loading="downloadingItemsReport">
                        <v-icon>
                          mdi-download
                        </v-icon>
                        &nbsp {{$t('download_report')}}
                      </v-btn>
                    </v-layout>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-tab-item>
          <!----------------- IZVJESTAJ O KLIJENTIMA ------------------>
          <v-tab-item>
            <v-card>
              <v-card-text>
                <v-row>
                  <v-col cols="3">
                    <v-text-field
                      readonly
                      v-model="partner.name"
                      text="name"
                      @click="dialogChooseItem=true"
                      :label="$t('drawer.client')" required
                      autocomplete="off"
                      append-outer-icon="mdi-close"
                      @click:append-outer="partner = {}"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-combobox
                      multiple
                      v-model="chosenServices"
                      :items="services"
                      :label="$t('evidentions.serviceTypes')"
                      item-text="name"
                      autocomplete="off"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-menu
                      v-model="menuFromClients"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateFrom"
                          label="Datum od"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateFrom"
                        :max="dateTo"
                        @input="menuFromClients = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="3"/>
                  <v-col cols="3">
                    <v-select
                      v-model="chosenCountry"
                      :items="countries"
                      :label="$t('state')"
                      item-text="name"
                      autocomplete="off"
                      return-object
                      @change="changeCountry()"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-combobox
                      multiple
                      v-model="chosenCities"
                      :items="cities"
                      :label="$t('city')"
                      item-text="name"
                      autocomplete="off"
                      :disabled="cities.length === 0"
                    />
                  </v-col>
                  <v-col cols="3">
                    <v-menu
                      v-model="menuToClients"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateTo"
                          label="Datum do"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="dateTo"
                        :min="dateFrom"
                        @input="menuToClients = false">
                      </v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col>
                    <v-layout align-center justify-center>
                      <v-btn class="primary" @click="downloadClientsReport" :loading="downloadingClientsReport">
                        <v-icon>
                          mdi-download
                        </v-icon>
                        &nbsp {{$t('download_report')}}
                      </v-btn>
                    </v-layout>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
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
  </v-container>
</template>

<script>
  import axios from 'axios'
  import {
    readWorkers,
    readWorkerTypes,
    readItems,
    readCountriesActive,
    readServicesActive,
  } from "../../statics/DataTableFunctions";
  import EvidentionReports from "../../components/reports/EvidentionReports";
  import ChooseItemDialog from "../../components/licencePartners/ChooseItemDialog";

  export default {
    name: "Excel",
    components: {
      'evidentions': EvidentionReports,
      'dialog-choose-item': ChooseItemDialog
    },
    data() {
      return {
        singleSelect: true,
        ChooseItemApi: 'partnersActive',
        ChooseItemTranslation: 'partners',
        dialogChooseItem: false,
        downloadingEvidentionReport: false,
        menuFrom: false,
        menuTo: false,
        menuFromCosts: false,
        menuToCosts: false,
        menuFromClients: false,
        menuToClients: false,
        dateFrom: new Date().getFullYear() + '-' + (new Date().getMonth() <= 9 ? '0' + (new Date().getMonth() + 1) : new Date().getMonth() + 1) + '-' + '01',
        dateTo: new Date().getFullYear() + '-' + (new Date().getMonth() <= 9 ? '0' + (new Date().getMonth() + 1) : new Date().getMonth() + 1) + '-' + new Date().getDate(),
        downloadingWorkerReport: false,
        downloadingItemsReport: false,
        downloadingClientsReport: false,
        worker: [],
        workers: null,
        workerType: [],
        workerTypes: null,
        chosenItems: null,
        items: [],
        chosenCities: null,
        cities: [],
        chosenCountry: null,
        countries: [],
        chosenServices: null,
        services: [],
        partner: {}
      }
    },
    created() {
      this.readCountriesActive()
      this.readServicesActive()
      this.readWorkerTypes()
      this.readWorkers()
      this.readItems()
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
    },
    methods: {
      readItems,
      readWorkers,
      changeCountry() {
        this.chosenCities = null
        this.cities = this.chosenCountry.city
      },
      readWorkerTypes,
      choosenPartner(item) {
        this.partner = item;
      },
      readServicesActive,
      readCountriesActive,
      downloadItemsReport() {
        // Dodati snackbar
        this.downloadingItemsReport = true
        const FileDownload = require('js-file-download');
        axios({
          url: 'api/downloadReportItems',
          method: "POST",
          data: {
            items: this.chosenItems,
            dateFrom: this.dateFrom,
            dateTo: this.dateTo
          },
          responseType: "blob" // important
        }).then(response => {
          this.downloadingItemsReport = false
          FileDownload(response.data, 'Troškovi.xlsx');
        }).catch(error => {
          this.downloadingItemsReport = false
          this.$swal.fire({
            type: "error",
            title: "Error",
            text: error
          });
        });
      },
      downloadWorkerReport() {
        if ((this.worker === null || this.worker === []) && (this.workerType === null || this.workerType === [])) {
          return
        }
        this.downloadingWorkerReport = true
        const FileDownload = require('js-file-download');
        axios({
          url: 'api/downloadReportExcel',
          method: "POST",
          data: {
            workers: this.worker,
            worker_types: this.workerType,
            dateFrom: this.dateFrom,
            dateTo: this.dateTo
          },
          responseType: "blob" // important
        }).then(response => {
          this.downloadingWorkerReport = false
          FileDownload(response.data, 'Radnici.xlsx');
        }).catch(error => {
          this.downloadingWorkerReport = false
          this.$swal.fire({
            type: "error",
            title: "Error",
            text: error
          });
        });
      },
      downloadClientsReport() {
        this.downloadingClientsReport = true
        const FileDownload = require('js-file-download');
        // Dodati snackbar
        axios({
          url: 'api/downloadReportClients',
          method: "POST",
          data: {
            client: this.partner,
            services: this.chosenServices,
            country: this.chosenCountry,
            cities: this.chosenCities,
            dateFrom: this.dateFrom,
            dateTo: this.dateTo
          },
          responseType: "blob" // important
        }).then(response => {
          this.downloadingClientsReport = false
          FileDownload(response.data, 'Klijenti.xlsx');
        }).catch(error => {
          this.downloadingClientsReport = false
          this.$swal.fire({
            type: "error",
            title: "Error",
            text: error
          });
        });
      }
    }
  }
</script>

<style scoped>

</style>
