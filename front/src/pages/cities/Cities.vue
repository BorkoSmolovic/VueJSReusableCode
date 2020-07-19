<template>
    <v-container fluid grid-list-sm>
        <v-toolbar color="White">
            <v-toolbar-title class="headline">{{$t('drawer.'+translation)}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="mr-4" color="primary" dark @click="addItemDialog=true">
                {{$t(translation+'.add')}}
            </v-btn>
            <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning"
                   @click="readTableData(api)">
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
            <!-------------------------------------  DETAILS EDIT DELETE  ----------------------------------------------->
            <template v-slot:item.actions="{ item }">
                <v-layout align-center justify-center>
                    <v-btn icon @click.stop="openEditDialog(item)">
                        <v-icon>mdi-pencil-outline</v-icon>
                    </v-btn>
                    <v-btn icon :loading="deleteLoadingId == item.id" @click="onDelete(api,item)">
                        <v-icon v-if="item.isActive">mdi-trash-can-outline</v-icon>
                        <v-icon v-else>mdi-autorenew</v-icon>
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
        <!---------------------------------- Add item Dialog  ----------------------------------------->
        <add-item
                :addItemDialog="addItemDialog"
                @close="addItemDialog=false"
                @addEmit="addEmit"/>
        <!---------------------------------- Edit item Dialog  ----------------------------------------->
        <edit-item
                :editItemDialog="editItemDialog"
                :dataForModal="dataForModal"
                @close="editItemDialog=false"
                @editEmit="editEmit"/>

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
        readTableData,
        refresh,
        search
    } from "../../statics/DataTableFunctions";
    import AddCity from "../../components/cities/AddCity";
    import EditCity from "../../components/cities/EditCity";


    export default {
        name: "Cities",
        components: {
            'add-item': AddCity,
            'edit-item': EditCity,
        },
        data() {
            return {
                breakpoint: 500,
                translation: 'cities',
                api: 'city',
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
            readTableData,
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
                    {text: this.$t(this.translation+'.name'), name: 'name', align: 'left', value: 'name'},
                    {text: this.$t(this.translation+'.post_code'), name: 'post_code', align: 'left', value: 'post_code'},
                    {text: this.$t(this.translation+'.country'), name: 'country', align: 'left', value: 'country.name'},
                    {text: this.$t(this.translation+'.active'), name: 'active', align: 'left', value: 'isActive'},
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
            this.readTableData(this.api)
        }
    }
</script>

<style scoped>
</style>

