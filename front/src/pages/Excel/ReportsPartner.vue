<template>
  <v-container>
    <v-row class="center" justify="center">
      <v-col cols="12">
        <!--  ===============================================TABOVI ===============================================-->
        <!----------------- IZVJESTAJ O KLIJENTIMA ------------------>
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="3">
                <v-text-field
                  readonly
                  v-model="partner.name"
                  text="name"
                  :label="$t('drawer.client')" required
                  autocomplete="off"
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
      </v-col>
    </v-row>
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
    },
    data() {
      return {
        downloadingEvidentionReport: false,
        menuFromClients: false,
        menuToClients: false,
        dateFrom: new Date().getFullYear() + '-' + (new Date().getMonth() <= 9 ? '0' + (new Date().getMonth() + 1) : new Date().getMonth() + 1) + '-' + '01',
        dateTo: new Date().getFullYear() + '-' + (new Date().getMonth() <= 9 ? '0' + (new Date().getMonth() + 1) : new Date().getMonth() + 1) + '-' + new Date().getDate(),
        downloadingClientsReport: false,
        chosenCities: null,
        cities: [],
        chosenCountry: null,
        countries: [],
        chosenServices: null,
        services: [],
        partner: {},
      }
    },
    created() {
      this.partner = JSON.parse(localStorage.getItem('partner'))
      this.readCountriesActive()
      this.readServicesActive()
    },
    methods: {
      changeCountry() {
        this.chosenCities = null
        this.cities = this.chosenCountry.city
      },
      readServicesActive,
      readCountriesActive,
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
