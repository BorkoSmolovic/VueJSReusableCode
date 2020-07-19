<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-container fluid grid-list-sm>
        <v-toolbar color="White">
            <v-toolbar-title>{{$t('tax.vat')}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <!--  &lt;!&ndash; DIALOG - ADD PArtner &ndash;&gt;-->
            <!--  <add-partner @close="closeDialog"/>-->
            <!--  &lt;!&ndash; DIALOG - ADD PArtner &ndash;&gt;-->

            <add-vat :vats="vats" @pushVat="pushVat"/>
            <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning" @click="refresh(false)">
                <v-icon>mdi-refresh</v-icon>
            </v-btn>
        </v-toolbar>
        <v-data-table
                :headers="headers"
                :items="vats"
                :items-per-page="itemsPerPage"
                :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                :dense="true"
                class="elevation-1 "
                sort-by="name"
                :loading="tableDataLoading"
                loading-text="'Data is currently being loaded, please wait...'">

            <template v-slot:item.isActive="{ item }">
                <v-chip small
                        v-bind:class="{'error inactive-row white--text':(item.isActive == 0) , 'white black--text':(item.isActive === 1)}">
                    {{ item.isActive == 1 ? $t('active') : $t('not_active') }}
                </v-chip>
            </template>


            <template v-slot:item.actions="{ item }">
                <v-layout align-center justify-center>
                    <v-btn icon @click="editVat(item)">
                        <v-icon>mdi-pencil-outline</v-icon>
                    </v-btn>
                    <v-btn icon :loading="deleteLoadingId == item.id" @click="onDelete(item)">
                        <v-icon v-if="item.isActive">mdi-trash-can-outline</v-icon>
                        <v-icon v-else>mdi-autorenew</v-icon>
                    </v-btn>
                </v-layout>
            </template>

            <!--FILTERS-->

            <template v-slot:body.prepend>
                <tr class="grey lighten-2">
                    <th v-for="header in headers"
                        :key="header.name"
                        class="py-2">
                        <v-select v-if="header.name == 'active'"
                                  class="justify-center n5"
                                  v-model="filters[header.value]"
                                  @change="search"
                                  :items="activeObjects"
                                  item-value="value"
                                  item-text="text"
                                  style="padding: 0; font-size: inherit; text-align: right !important;"
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
                                <v-btn :disabled="!enabledSearch" color="success" @click="search">
                                    <v-icon>mdi-search-web</v-icon>
                                </v-btn>
                                <v-btn :disabled="!enabledSearch" color="error" @click="refresh(true)">
                                    <v-icon>mdi-close-circle</v-icon>
                                </v-btn>
                        </v-layout>
                    </th>
                </tr>
            </template>

            <!-- ## NO DATA ## -->
            <template v-slot:no-data>
                <div class="text-xs-center">
                    <v-alert :value="showErrorMessage" color="error" icon="mdi-alert-circle-outline">
                        {{errorMessage}}
                    </v-alert>
                </div>
            </template>
        </v-data-table>

        <edit-vat v-if="dialog" :dialogEdit.sync="dialog" :vat="vatData" @update="updateVat"/>

        <v-snackbar
                v-model="snackbar.show"
                :bottom=true
                :right=true
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
    import AddVat from "../../components/vats/AddVat";
    import EditVat from "../../components/vats/EditVat";

    axios.defaults.timeout = 15000;
    export default {
        name: "Test",
        components: {
            'add-vat': AddVat,
            'edit-vat': EditVat,
        },
        data: function () {
            return {
                snackbar: {
                    color: 'success',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                dialog: false,
                vatData: {},
                itemsPerPage: 10,
                rowsPerPageItems: [10, 15, 30, 50],
                tableDataLoading: true,
                deleteLoadingId: -1,
                enabledSearch: true,
                showErrorMessage: false,
                errorMessage: '',
                /* headers: [
                     {text: 'Stopa', name: 'rate', align: 'left', value: 'rate'},
                     {text: 'Aktivnost', name: 'iactive', align: 'left', value: 'isActive'},
                     {text: 'Operacije', name: 'actions', align: 'center', sortable: false, value: 'actions'},
                 ],*/
                filters: {
                    name: '',
                    isActive: '',
                },
                vats: [],
                filteredVats: []
            }
        },
        computed: {
            activeObjects() {
                return [
                    {value: "", text: this.$t('all')},
                    {value: 'true', text: this.$t('active')},
                    {value: 'false', text: this.$t('not_active')},
                ]
            },
            headers() {
                return [
                    {text: this.$t('tax.rate'), name: 'rate', align: 'left', value: 'rate'},
                    {text: this.$t('tax.active'), name: 'active', align: 'left', value: 'isActive'},
                    {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
                ]
            }
        },
        methods: {
            getVatIndexById(id) {
                for (let i = 0; i < this.vats.length; i++) {
                    if (this.vats[i].id == id) {
                        return i;
                    }
                }
                return -1;
            },
            editVat(vat) {
                this.vatData = vat;
                this.dialog = true;
            },
            updateVat(vat) {
                this.vats.splice(this.getVatIndexById(vat.id), 1, vat);
                this.snackbar.text = this.$t('edit_success');
                this.snackbar.show = true;
            },
            pushVat(vat) {
                this.vats.push(vat);
                this.snackbar.text = this.$t('add_success');
                this.snackbar.show = true;
            },
            onDelete: function (item) {
                this.deleteLoadingId = item.id
                let message = this.$t('tax.deactivate_vat')
                if (!item.isActive) {
                    message = this.$t('tax.reactivate_vat')
                }
                this.$swal
                    .fire({
                        title: message,
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#ff5252",
                        reverseButtons: false,
                        cancelButtonText: this.$t('deny'),
                        confirmButtonText:  this.$t('confirm'),
                    })
                    .then(result => {
                        if (result.value) {
                            axios.delete("api/vat/" + item.id).then(({data}) => {
                                item.name = data.name;
                                item.isActive = data.isActive ? 1 : 0;
                                this.notification = 'delete';
                                // this.snackbar = true;
                                this.deleteLoadingId = -1;
                            });
                        } else {
                            this.deleteLoadingId = -1;
                        }
                    });
            },
            readVats() {
                this.vats = [];
                this.tableDataLoading = true;
                axios.get('/api/vat').then(({data}) => {
                    this.vats = data;
                    this.filteredVats = this.vats;
                    if (data.length == 0) {
                        this.tableDataLoading = false;
                        this.errorMessage = this.$t('no_data');
                        this.showErrorMessage = true;
                    } else {
                        this.tableDataLoading = false;
                        this.enabledSearch = true;
                    }
                }).catch(error => {
                    console.error("READ VATS", error);
                    this.tableDataLoading = false
                    if (error.response == undefined) {
                        this.errorMessage = 'Timeout'
                    } else {
                        this.errorMessage = this.$t('error_data')
                    }
                    // this.showLoading = false
                    this.showErrorMessage = true
                    // this.enabledRefresh = true;
                })
            },
            search() {
                if (this.filteredVats.length == 0) {
                    this.filteredVats = this.vats
                }
                this.vats = this.filteredVats
                Object.keys(this.filters).forEach(val => {
                    if (this.filters[val] == "") {
                        return;
                    }

                    this.vats = this.vats.filter(item => {
                        if (item != undefined) {
                            //svi ostali filteri
                            return (item[val] + "").toLowerCase().indexOf((this.filters[val] + "").toLowerCase()) > -1
                        }
                    })
                })
            },
            refresh(isReset) {
                if (this.filteredVats.length == 0) {
                    this.filteredVats = this.vats
                }
                Object.keys(this.filters).forEach(f => {
                    this.filters[f] = ''
                });
                if (isReset) {
                    this.vats = this.filteredVats
                } else {
                    this.readVats();
                }
            }
        },
        created() {
            this.readVats();
        }
    }
</script>
