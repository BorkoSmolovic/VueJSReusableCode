<template>
  <v-container fluid grid-list-sm>
    <v-toolbar color="White">
      <v-toolbar-title class="headline">{{$t('drawer.'+translation)}}</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-spacer></v-spacer>
      <v-btn class="primary" @click="downloadEvidentionReport" :loading="downloadingEvidentionReport">Preuzmi
        izvještaj
      </v-btn>
      &nbsp&nbsp&nbsp
      <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning"
             @click="readTableDataByDate(api,dateFrom,dateTo)">
        <v-icon>mdi-refresh</v-icon>
      </v-btn>
    </v-toolbar>
    <v-spacer></v-spacer>
    <v-data-table
      calculate-widths
      :mobile-breakpoint="breakpoint"
      :headers="headers"
      :items="tableData"
      :items-per-page="itemsPerPage"
      :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
      :dense="true"
      :loading-text="$t('loading_data')"
      class="elevation-1"
      sort-by="date"
      :sort-desc="true"
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
            <v-icon>mdi-account-card-details-outline</v-icon>
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
  import axios from 'axios'
  import {
    download,
    findById,
    readTableDataByDate,
    refresh,
    search
  } from "../../statics/DataTableFunctions";
  import DetailsEvidentionWorkspace from "../../components/workspace/DetailsEvidentionWorkspace";


  export default {
    name: "EvidentionReports",
    components: {
      'details-item': DetailsEvidentionWorkspace,
    },
    data() {
      let startDate = new Date();
      return {
        breakpoint: 500,
        translation: 'evidentions',
        api: 'evidentionsBetweenDates',
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
        let data = {
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
        return
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
          /* {
               text: this.$t(this.translation + '.id'),
               name: 'id',
               align: 'left',
               sortable: true,
               value: 'id'
           },*/
          /*  {
                text: this.$t(this.translation + '.date'),
                name: 'date',
                align: 'left',
                sortable: true,
                value: 'date'
            },*/
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
          {value: true, text: this.$t('yes')},
          {value: false, text: this.$t('no')},
        ]
      },
    },
    created() {
      this.readTableDataByDate(this.api, '2019-01-01', '2020-01-01')
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
