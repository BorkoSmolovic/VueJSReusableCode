<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-row justify="end" class="mr-0">
    <v-dialog v-model="detailsItemDialog" fullscreen persistent transition="dialog-bottom-transition">
      <v-toolbar dark color="primary">
        <v-toolbar-title class="headline"> {{$t('partner_details')}}</v-toolbar-title>
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
            <v-container class="pt-9" style="max-width: 100% !important;" row justify-space-around>
              <v-col cols="4" mt-5>
                <v-row xs12 px-2>
                  <v-text-field readonly v-model="dataForModal == undefined ? '' : dataForModal.name"
                                :label="$t('partners.name')"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field
                    readonly
                    v-model="dataForModal.partner_type == undefined ? '' : dataForModal.partner_type.name"
                    :label="$t('partners.type')"
                    type="text"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly v-model="dataForModal.pib" :label="$t('partners.pib')"
                                type="text"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field
                    v-if="dataForModal.partner_type == undefined ? false : dataForModal.partner_type.id == 1" readonly
                    v-model="dataForModal.pdv" :label="$t('partners.pdv')"
                    type="text"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly v-model="countries[findById(dataForModal.city.country_id,countries)].name"
                                :label="$t('partners.country')" type="text"
                  ></v-text-field>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly v-model="dataForModal.city == undefined ? '' : dataForModal.city.name"
                                :label="$t('partners.city')"
                                type="text"/>
                </v-row>
                <v-row xs12 px-2>
                  <v-text-field readonly v-model="dataForModal.address"
                                :label="$t('partners.address')"></v-text-field>
                </v-row>
              </v-col>
              <v-col cols="7">
                <!--  ===============================================TABOVI ===============================================-->
                <v-tabs
                  background-color="white"
                  class="elevation-2 primary--text"
                >
                  <v-tabs-slider color="primary"></v-tabs-slider>
                  <!--  =============================================== BANKOVNI RACUNI ===============================================-->
                  <v-tab>
                    <v-icon>mdi-account-tie</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.banks')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <partner-bank-accounts
                      :partnerId="dataForModal.id"
                    />
                  </v-tab-item>
                  <!--      =============================================== KONTAKTI ===============================================-->
                  <v-tab>
                    <v-icon>mdi-contact-phone-outline</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.contacts')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <partner-contacts
                      :partnerId="dataForModal.id"
                    />
                  </v-tab-item>
                  <!--      =============================================== UGOVORI ===============================================-->
                  <v-tab>
                    <v-icon>mdi-file-account-outline</v-icon>
                    <v-card-text class="text-uppercase">
                      {{$t('drawer.contracts')}}
                    </v-card-text>
                  </v-tab>
                  <v-tab-item>
                    <partner-contracts
                      :partnerId="dataForModal.id"
                    />
                  </v-tab-item>
                </v-tabs>
              </v-col>
            </v-container>
          </v-form>
        </v-card-text>
      </v-card>

    </v-dialog>
  </v-row>
</template>


<script>
  import {readCountries, findById} from "../../statics/DataTableFunctions";
  import partnerDetailsContacts from "../partnersDetails/partnerDetailsContacts";
  import partnerDetailsBankAccounts from "../partnersDetails/partnerDetailsBankAccounts";
  import Contract from "../../pages/contracts/Contract";

  export default {
    name: "DetailsPartner",
    props: {
      dataForModal: {},
      detailsItemDialog: false,
    },
    components: {
      'partner-bank-accounts': partnerDetailsBankAccounts,
      'partner-contacts': partnerDetailsContacts,
      'partner-contracts': Contract,
    },

    data() {
      return {
        countries: [],
      }
    },
    methods: {
      readCountries,
      findById,
      closeDialog() {
        document.getElementsByClassName('v-dialog--active')[0].scrollTop = 0
        this.$emit('close', false)
      },
    },
    created() {
      this.readCountries();
    }
  }
</script>


<style scoped>

</style>
