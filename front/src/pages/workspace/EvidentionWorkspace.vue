<template>
  <v-container fluid grid-list-sm>
    <v-toolbar color="White">
      <v-toolbar-title class="headline">{{$t('drawer.'+translation)}}</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-col cols="7" sm="4" md="3">
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
              class="pt-6"
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
      <v-col cols="8" sm="4" md="3">
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
              class="pt-6"
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
      &nbsp&nbsp&nbsp
      <v-btn class="primary" @click="readTableDataByDate(api,dateFrom,dateTo)" :loading="downloadingEvidentionReport">
        <v-icon>
          mdi-search-web
        </v-icon>
      </v-btn>
      &nbsp&nbsp&nbsp
      <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning"
             @click="readTableDataByDate(api,dateFrom,dateTo)">
        <v-icon>mdi-refresh</v-icon>
      </v-btn>
    </v-toolbar>
    <v-spacer></v-spacer>
    <v-data-table
      @update:sort-by="sort_by = $event"
      @update:sort-desc="sort_order = $event"
      calculate-widths
      :mobile-breakpoint="breakpoint"
      :headers="headers"
      :items="tableData"
      :items-per-page="itemsPerPage"
      :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
      :dense="true"
      :loading-text="$t('loading_data')"
      class="elevation-1"
      :sort-by="sort_by"
      :sort-desc="sort_order"
      :loading="tableDataLoading"
    >
      <template v-slot:item.is_commercial="{ item }">
        {{ item.is_commercial == 1 ? $t('yes') : $t('no') }}
      </template>
      <template v-slot:item.isActive="{ item }">
        <v-chip small
                :class="{'error inactive-row white--text':(!item.isActive) , 'white black--text':(item.isActive)}">
          {{ item.isActive ? $t('active') : $t('not_active') }}
        </v-chip>
      </template>
      <!-------------------------------------  DETAILS EDIT DELETE  ----------------------------------------------->
      <template v-slot:item.actions="{ item }">
        <v-layout align-center justify-center>
          <v-btn icon @click="openDetailsDialog(item)" :loading="detailsItemDialog">
            <v-icon>mdi-account</v-icon>
          </v-btn>
        </v-layout>
      </template>
      <!----------------------------------- ## FILTERS ## ------------------------------------>
      <template v-slot:body.prepend>
        <tr class="grey lighten-2">
          <th v-for="header in headers"
              :key="header.name"
              class="py-2">
            <v-select v-if="header.name == 'active'"
                      class="justify-center"
                      v-model="filters[header.value]"
                      @change="search"
                      :items="activeObjects"
                      item-value="value"
                      item-text="text"
                      style="padding: 0; margin-top: 2em !important; margin-bottom: -1em !important;  font-size: inherit; text-align: right !important;"
                      label="Filter">
            </v-select>
            <v-select v-else-if="header.name == 'is_commercial'"
                      class="justify-center"
                      v-model="filters[header.value]"
                      @change="search"
                      :items="commercialObjects"
                      item-value="value"
                      item-text="text"
                      style="padding: 0; margin-top: 2em !important; margin-bottom: -1em !important;  font-size: inherit; text-align: right !important;"
                      label="Filter">
            </v-select>
            <v-text-field v-else-if="header.name != 'actions' && header.name != 'is_commercial'"
                          v-model="filters[header.value]"
                          @keyup.enter.native="search"
                          label="Filter"
                          :placeholder="header.text"
                          filled
                          hide-details
                          style="padding: 0; font-size: inherit; text-align: right !important;"
            ></v-text-field>
            <v-layout v-else class="justify-center">
              <v-btn depressed small :disabled="tableDataLoading" color="success"
                     @click="search">
                <v-icon>mdi-search-web</v-icon>
              </v-btn>
              <v-btn depressed class="ml-1" small :disabled="tableDataLoading" color="error"
                     @click="refresh(true)">
                <v-icon>mdi-close-circle</v-icon>
              </v-btn>
            </v-layout>
          </th>
        </tr>
      </template>
      <!-------------------------------- ## NO DATA ## ----------------------------------->
      <template v-slot:no-data>
        <div class="text-xs-center">
          <v-alert color="error" icon="mdi-alert-circle-outline">
            {{errorMessage}}
          </v-alert>
        </div>
      </template>
    </v-data-table>
    <div class="py-4 px-4">
      &nbsp&nbsp&nbsp
      <v-btn class="primary " @click="downloadEvidentionReport" :loading="downloadingEvidentionReport">
        <v-icon>
          mdi-download
        </v-icon>
        Preuzmite izvještaj
      </v-btn>
    </div>

    <!---------------------------------- Details item Dialog  ----------------------------------------->
    <details-item
      :detailsItemDialog="detailsItemDialog"
      :dataForModal="dataForModal"
      @close="detailsItemDialog=false"/>

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
  </v-container>
</template>

<script>
    import {
        download,
        findById,
        readTableDataByDate,
        refresh,
        search
    } from "../../statics/DataTableFunctions";
    import DetailsEvidentionWorkspace from "../../components/workspace/DetailsEvidentionWorkspace";
    import axios from "axios";


    export default {
        name: "EvidentionWorkspace",
        components: {
            'details-item': DetailsEvidentionWorkspace,
        },
        data() {
            return {
                sort_by: ['date'],
                sort_order: [true],
                downloadingEvidentionReport: false,
                menuFrom: false,
                menuTo: false,
                dateFrom: new Date().getFullYear() + '-' + (new Date().getMonth() <= 9 ? '0' + (new Date().getMonth() + 1) : new Date().getMonth() + 1) + '-' + '01',
                dateTo: new Date().getFullYear() + '-' + (new Date().getMonth() <= 9 ? '0' + (new Date().getMonth() + 1) : new Date().getMonth() + 1) + '-' + new Date().getDate(),
                reportDownloading: false,
                breakpoint: 500,
                translation: 'evidentions',
                api: 'evidentionFinishedDenied',
                dataForModal: {},
                addItemDialog: false,
                editItemDialog: false,
                detailsItemDialog: false,
                tableDataLoading: false,
                tableData: [],
                filteredTableData: [],
                filters: {
                    isActive: '',
                    is_commercial: '',

                },
                itemsPerPage: 10,
                deleteLoadingId: -1,
                errorMessage: this.$t('no_data'),
                snackbar: {
                    color: 'success',
                    show: false,
                    text: '',
                    timeout: 3000,
                },

            }
        },
        methods: {
            downloadEvidentionReport() {
                if(this.sort_by[0] === undefined){
                    this.sort_by[0] = null
                }
                if(this.sort_order[0] === undefined){
                    this.sort_order[0] = null
                }
                let data = {
                    sort_by: this.sort_by[0],
                    sort_order: this.sort_order[0],
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo,
                    isActive: this.filters.isActive === undefined ? null : this.filters.isActive,
                    is_commercial: this.filters.is_commercial === undefined ? null : this.filters.is_commercial,
                    event_name: this.filters.event_name === undefined ? null : this.filters.event_name,
                    user: this.filters["user.name"] === undefined ? null : this.filters["user.name"],
                    partner: this.filters["contract.partner.name"] === undefined ? null : this.filters["contract.partner.name"],
                    contract: this.filters.contract_id === undefined ? null : this.filters.contract_id,
                    city: this.filters["city.name"] === undefined ? null : this.filters["city.name"],
                    status: this.filters["status.status.name"] === undefined ? null : this.filters["status.status.name"],
                }
                this.downloadingEvidentionReport = true
                const FileDownload = require('js-file-download');
                axios({
                    url: 'api/excel1',
                    method: "POST",
                    // data: {
                    //     date: "2019-12",
                    //     event_name: 'D',
                    //     city: 'K',
                    //     is_commercial: true,
                    // partner: null,
                    // user: null,
                    // status: null,
                    // isActive: null
                    // },
                    data: data,
                    responseType: "blob" // important
                }).then(response => {
                    this.downloadingEvidentionReport = false
                    FileDownload(response.data, 'IzvještajEvidencija.xlsx');
                }).catch(error => {
                    this.downloadingEvidentionReport = false
                    this.$swal.fire({
                        type: "error",
                        title: "Error",
                        text: error
                    });
                });
            },
            search,
            findById,
            refresh,
            readTableDataByDate,
            download,
            openEditDialog(item) {
                this.dataForModal = item;
                this.editItemDialog = true;
            },
            openDetailsDialog(item) {
                this.dataForModal = item;
                this.detailsItemDialog = true;
            },

        },
        computed: {
            headers() {
                return [
                    {
                        text: this.$t(this.translation + '.id'),
                        name: 'id',
                        align: 'left',
                        sortable: true,
                        value: 'id'
                    },
                    {
                        text: this.$t(this.translation + '.date'),
                        name: 'date',
                        align: 'left',
                        sortable: true,
                        value: 'date'
                    },
                    {
                        text: this.$t(this.translation + '.name'),
                        name: 'event_name',
                        align: 'left',
                        sortable: true,
                        value: 'event_name'
                    },
                    {
                        text: this.$t(this.translation + '.user'),
                        name: 'user.name',
                        align: 'left',
                        sortable: true,
                        value: 'user.name'
                    },
                    {
                        text: this.$t(this.translation + '.partner'),
                        name: 'contract.partner.name',
                        align: 'left',
                        sortable: true,
                        value: 'contract.partner.name'
                    },
                    {
                        text: this.$t(this.translation + '.contractNumber'),
                        name: 'contract_id',
                        align: 'left',
                        sortable: true,
                        value: 'contract_id'
                    },
                    {
                        text: this.$t(this.translation + '.city'),
                        name: 'city.name',
                        align: 'left',
                        sortable: true,
                        value: 'city.name'
                    },
                    {
                        text: this.$t(this.translation + '.status'),
                        name: 'status.status.name',
                        align: 'left',
                        sortable: true,
                        value: 'status.status.name'
                    },
                    {
                        text: this.$t(this.translation + '.commercial'),
                        name: 'is_commercial',
                        align: 'left',
                        sortable: true,
                        value: 'is_commercial'
                    },
                    {
                        text: this.$t(this.translation + '.active'),
                        name: 'active',
                        align: 'left',
                        sortable: true,
                        value: 'isActive'
                    },
                    {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
                ]
            },
            activeObjects() {
                return [
                    {value: "", text: this.$t('all')},
                    {value: 'true', text: this.$t('active')},
                    {value: 'false', text: this.$t('not_active')},
                ]
            },
            commercialObjects() {
                return [
                    {value: "", text: this.$t('all')},
                    {value: "true", text: this.$t('yes')},
                    {value: "false", text: this.$t('no')},
                ]
            },
        },
        created() {
            this.readTableDataByDate(this.api, this.dateFrom, this.dateTo)
        },
        watch: {
            editItemDialog: function (val) {
                if (val) {
                }
            }
        }
    }
</script>

<style scoped/>
