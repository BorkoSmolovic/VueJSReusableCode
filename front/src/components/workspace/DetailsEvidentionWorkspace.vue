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
            <v-container class="pt-9" row justify-space-around>
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
                  <v-tab @click="test()">
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
                  <v-tab :disabled="status.id < 5 ">
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
  import {findById, readCountries, readStatuses, readServicesActive, readNotifications} from "../../statics/DataTableFunctions";
  import EvidentionWorkersWorkspace from "./EvidentionWorkersWorkspace";
  import EvidentionItemsWorkspace from "./EvidentionItemsWorkspace";
  import EvidentionMessagesWorkspace from "./EvidentionMessagesWorkspace";
  import EvidentionInvoiceWorkspace from "./EvidentionInvoiceWorkspace";
  import EvidentionServicesWorkspace from "./EvidentionServicesWorkspace";


  export default {
    name: "DetailsPartnerWorkspace",
    props: {
      dataForModal: null,
      detailsItemDialog: false,
    },
    components: {
      'evidention-workers': EvidentionWorkersWorkspace,
      'evidention-items': EvidentionItemsWorkspace,
      'evidention-messages': EvidentionMessagesWorkspace,
      'evidention-invoice': EvidentionInvoiceWorkspace,
      'evidention-services': EvidentionServicesWorkspace,
    },

    data() {
      return {
        notifications: null,
        translation: 'evidentions',
        api: 'evidention',
        countries: [],
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
      test() {
        this.notificationRead()
      },
      notificationRead() {
        let data = {
          evidention_id: this.dataForModal.id
        }
        axios.post('api/seen', data)
          .then((response) => {
            this.readNotifications();
          })
      },
      readNotifications,
      readServicesActive,
      readStatuses,
      readCountries,
      findById,
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
          this.statusId = this.dataForModal.status.status_id;
          this.status = this.statuses[this.findById(this.statusId, this.statuses)];
          this.savedStatus = this.statuses[this.findById(this.statusId, this.statuses)];

          this.city = this.dataForModal.city;
          let countryIndex = this.findById(this.city.country_id, this.countries);
          if (countryIndex != -1) {
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
