<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-row justify="end" class="mr-0">
    <v-dialog v-model="detailsItemDialog" fullscreen persistent transition="dialog-bottom-transition">
      <v-toolbar dark color="primary">
        <v-toolbar-title class="headline"> {{$t(translation+'.details')}}</v-toolbar-title>
        <div class="flex-grow-1"></div>
        <v-toolbar-items>
          <v-btn icon dark @click="closeDialog">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card v-if="detailsItemDialog">
        <v-card-text>
          <v-form ref="form" v-on:submit.prevent>
            <v-container style="max-width: 100% !important;" class="pt-9" row justify-space-around>
              <v-col cols="4" mt-5>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal == undefined ? '' : dataForModal.event_name"
                                :label="$t(translation+'.name')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal == undefined || dataForModal.user == undefined ? '' : dataForModal.user.name"
                                :label="$t(translation+'.user')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal == undefined || dataForModal.user == undefined ? '' : dataForModal.contract.partner.name"
                                :label="$t(translation+'.partner')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal == undefined ? '' : dataForModal.contract.contract_name"
                                :label="$t(translation+'.contractNumber')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly v-model="dataForModal == undefined ? '' : dataForModal.date"
                                :label="$t(translation+'.date')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="country.name"
                                :label="$t(translation+'.country')" type="text"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal.city == undefined ? '' : dataForModal.city.name"
                                :label="$t(translation+'.city')"
                                type="text"/>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal == undefined ? '' : dataForModal.description"
                                :label="$t(translation+'.description')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly
                                v-model="dataForModal == undefined ? '' : dataForModal.is_commercial==1? $t('yes'):$t('no')"
                                :label="$t(translation+'.commercial')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-combobox
                    v-model="status"
                    :items="filteredStatuses"
                    @change="changeStatus(status)"
                    :disabled="status.id === 6 || status.id === 3"
                    :label="'Status evidencije'"
                    item-text="name"
                    autocomplete="off"
                  />
                </v-row>
              </v-col>
              <v-col cols="7">
                <!--  ===============================================TABOVI ===============================================-->
                <v-tabs
                  background-color="white"
                  class="elevation-2 primary--text"
                >
                  <v-tabs-slider color="primary"></v-tabs-slider>
                  <!--  =============================================== Radnici ===============================================-->
                  <v-tab>
                    <v-icon>mdi-account-tie</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.workers')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <evidention-workers
                      :dataForModal="dataForModal"
                      :detailsItemDialog="detailsItemDialog"
                    />
                  </v-tab-item>
                  <!--      =============================================== Stavke ===============================================-->
                  <v-tab>
                    <v-icon>mdi-currency-eur</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.items')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <evidention-items
                      :dataForModal="dataForModal"
                      :detailsItemDialog="detailsItemDialog"
                    />
                  </v-tab-item>
                  <!--      =============================================== Tipovi usluga ===============================================-->
                  <v-tab>
                    <v-icon>mdi-alpha-u-box</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.serviceTypes')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <evidention-services
                      :dataForModal="dataForModal"
                      :detailsItemDialog="detailsItemDialog"
                    />
                  </v-tab-item>
                  <!--      =============================================== Poruke/Komentari ===============================================-->
                  <v-tab>
                    <v-icon>mdi-message-text-outline</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.comments')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <evidention-messages
                      :dataForModal="dataForModal"
                      :detailsItemDialog="detailsItemDialog"
                    />
                  </v-tab-item>
                  <!--      =============================================== Fakture ===============================================-->
                  <v-tab>
                    <v-icon>mdi-file-document-outline</v-icon>
                    <v-card-text class="text-uppercase">
                      Faktura
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <evidention-invoice
                      :dataForModal="dataForModal"
                      :detailsItemDialog="detailsItemDialog"
                    />
                  </v-tab-item>
                </v-tabs>
              </v-col>
            </v-container>
          </v-form>
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
        </v-card-text>
      </v-card>

    </v-dialog>
  </v-row>
</template>


<script>
  import axios from 'axios'
  import {
    findById,
    readCountries,
    readStatuses,
    readNotifications,
    readServicesActive
  } from "../../statics/DataTableFunctions";
  import EvidentionWorkers from "./EvidentionWorkers";
  import EvidentionItems from "./EvidentionItems";
  import EvidentionMessages from "./EvidentionMessages";
  import EvidentionInvoice from "./EvidentionInvoice";
  import EvidentionServices from "../evidentionServices/EvidentionServices";

  export default {
    name: "DetailsPartner",
    props: {
      dataForModal: null,
      detailsItemDialog: false,
    },
    components: {
      'evidention-workers': EvidentionWorkers,
      'evidention-items': EvidentionItems,
      'evidention-messages': EvidentionMessages,
      'evidention-invoice': EvidentionInvoice,
      'evidention-services': EvidentionServices
    },

    data() {
      return {
        notifications: null,
        translation: 'evidentions',
        api: 'evidention',
        countries: [],
        services: [],
        country: {
          name: '',
        },
        savedStatus: null,
        statusId: -1,
        statuses: null,
        filteredStatuses: [],
        status: {
          name: '',
        },
        snackbar: {
          color: 'success',
          show: false,
          text: '',
          timeout: 3000,
        },
      }
    },
    methods: {
      readServicesActive,
      readStatuses,
      readCountries,
      findById,
      readNotifications,
      seen() {
        let data = {
          evidention_id: this.dataForModal.id
        }
        axios.post('api/seen', data)
          .then((response) => {
            this.readNotifications();
          })
        /*         .catch(error => {
                 if (error.response.status == 401) {
                     this.loading = false
                     this.$swal.fire({
                         type: 'info',
                         title: "Info",
                         text: this.$t('validation.session'),
                     })
                     this.$router.push('/login')
                 } else {
                     this.loading = false
                     this.$swal.fire({
                         type: 'error',
                         title: this.$t('validation.error'),
                         text: this.$t('validation.error'),
                     })
                 }
             })*/
      },
      changeStatus(status) {
        this.$swal
          .fire({
            title: "Da li ste sigurni da želite da promijenite status?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#4caf50",
            cancelButtonColor: "#ff5252",
            reverseButtons: false,
            cancelButtonText: this.$t('deny'),
            confirmButtonText: this.$t('confirm')
          })
          .then(result => {
            if (result.value) {
              this.statusId = status.id;
              this.savedStatus = this.status
              this.filterStatuses(this.findById(this.statusId, this.statuses));
              let data = {
                evidention_id: this.dataForModal.id,
                status_id: this.statusId,
              }
              axios.post('api/evidentionStatus', data).then(({data}) => {
                if (data.status_id === 6) {
                  let snackbar = {color: 'success', text: 'Radna zona uspješno kompletirana'};
                  this.$emit('closeAndRefresh', snackbar)
                } else {
                  this.snackbar.color = 'success'
                  this.snackbar.text = this.$t('edit_success');
                  this.$emit('refreshEvidentions', data);
                }
              });
            } else {
              this.status = this.savedStatus
            }
          });
      },
      filterStatuses(index) {
        this.filteredStatuses = [];
        if (index === 0) {
          for (let i = index + 1; i < 3; i++) {
            this.filteredStatuses.push(this.statuses[i]);
          }
        } else {
          if (index + 1 <= this.statuses.length) {

            if (index === 1) {
              this.filteredStatuses.push(this.statuses[index + 2]);
            } else {
              this.filteredStatuses.push(this.statuses[index + 1]);
            }

          }
        }
      },
      closeDialog() {
        this.country = {
          name: '',
        }
        this.status = {
          name: '',
        }
        document.getElementsByClassName('v-dialog--active')[0].scrollTop = 0
        this.$emit('close', false)
      },
    },
    created() {
      this.readServicesActive();
    },
    watch: {
      detailsItemDialog: function (val) {
        if (val) {
          this.readCountries();
          this.readStatuses();
        }
      },
      statuses: function (val) {
        if (val != null) {
          this.seen();
          this.statusId = this.dataForModal.status.status_id;
          this.status = this.statuses[this.findById(this.statusId, this.statuses)];
          this.savedStatus = this.statuses[this.findById(this.statusId, this.statuses)];
          this.filterStatuses(this.findById(this.statusId, this.statuses));

          this.city = this.dataForModal.city;
          let countryIndex = this.findById(this.city.country_id, this.countries);
          if (countryIndex !== -1) {
            this.country = this.countries[countryIndex];
          }
          this.contract = this.dataForModal.contract
          this.partner = this.dataForModal.contract.partner

          this.form = {
            status_id: null,
            event_name: this.dataForModal.event_name,
            contract_id: this.dataForModal.contract_id,
            description: this.dataForModal.description,
            date: this.dataForModal.date,
            is_commercial: this.dataForModal.is_commercial,
            city_id: this.dataForModal.city_id,
            workers: [],
            items: [],
          }
        }
      }
    },
  }
</script>


<style scoped>

</style>
