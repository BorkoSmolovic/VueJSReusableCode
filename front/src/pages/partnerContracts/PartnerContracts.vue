<template>
  <v-container fluid grid-list-sm>
    <v-toolbar color="White">
      <v-toolbar-title class="headline">{{$t('drawer.'+translation)}}</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning"
             @click="readTableDataById(api,partnerId)">
        <v-icon>mdi-refresh</v-icon>
      </v-btn>
    </v-toolbar>
    <v-spacer></v-spacer>
    <v-data-table
      :mobile-breakpoint="breakpoint"
      :headers="headers"
      :items="tableData"
      :items-per-page="itemsPerPage"
      :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
      :dense="true"
      :loading-text="$t('loading_data')"
      class="elevation-1"
      sort-by="name"
      :loading="tableDataLoading"
    >
      <!--<template v-slot:item.name="{ item }">-->
      <!--<v-chip :color="getColor(item.calories)" dark>{{ item.name }}</v-chip>-->
      <!--</template>-->
      <template v-slot:item.isActive="{ item }">
        <v-chip small
                        :class="{'error inactive-row white--text':(!item.isActive) , 'white black--text':(item.isActive)}">
                    {{ item.isActive ? $t('active') : $t('not_active') }}
                </v-chip>
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
            <v-text-field v-else-if="header.name != 'actions'"
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
        findById,
        addEmit,
        editEmit,
        onDelete,
        readTableDataById,
        refresh,
        search
    } from "../../statics/DataTableFunctions";
    import AddContract from "../../components/contracts/AddContract";
    import EditContract from "../../components/contracts/EditContract";


    export default {
        name: "PartnerContracts",
        data() {
            return {
                partnerId: localStorage.getItem('partner_id'),
                breakpoint: 500,
                translation: 'contracts',
                api: 'contract',
                dataForModal: {},
                addItemDialog: false,
                editItemDialog: false,
                tableDataLoading: false,
                tableData: [],
                filteredTableData: [],
                filters: {
                    isActive: '',
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
            search,
            findById,
            refresh,
            onDelete,
            readTableDataById,
            addEmit,
            editEmit,
            openEditDialog(item) {
                this.editItemDialog = true;
                this.dataForModal = item;
            },
        },
        computed: {
            headers() {
                return [
                    {text: this.$t(this.translation+'.id'), name: 'id', align: 'left', sortable: true, value: 'id'},
                    {text: this.$t(this.translation+'.contract_name'), name: 'contract_name', align: 'left', sortable: true, value: 'contract_name'},
                    {text: this.$t(this.translation+'.dateFrom'), name: 'dateFrom', align: 'left', sortable: true, value: 'dateFrom'},
                    {text: this.$t(this.translation+'.dateTo'), name: 'dateTo', align: 'left', sortable: true, value: 'dateTo'},
                    {text: this.$t(this.translation+'.no'), name: 'no', align: 'left', sortable: true, value: 'number_of_recordings'},
                    {text: this.$t(this.translation+'.remaining'), name: 'recordings_remaining', align: 'left', sortable: true, value: 'recordings_remaining'},
                    {text: this.$t(this.translation+'.active'), name: 'active', align: 'left', sortable: true, value: 'isActive'},
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
        },
        created() {
            this.readTableDataById(this.api,this.partnerId)
        }
    }
</script>

<style scoped/>
