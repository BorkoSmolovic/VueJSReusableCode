<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-container>

        <v-toolbar color="White">
            <v-toolbar-title>{{$t('warehouses.warehouses')}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="mr-4" color="primary" dark @click="openAddWarehouseDialog">
                {{$t('warehouses.add_warehouse')}}
            </v-btn>
            <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning" @click="refresh(false)">
                <v-icon>mdi-refresh</v-icon>
            </v-btn>
        </v-toolbar>
        <v-spacer></v-spacer>
        <v-spacer></v-spacer>

        <v-data-table
                :headers="headers"
                :items="warehouses"
                :loading="tableDataLoading"
                :items-per-page="itemsPerPage"
                :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                loading-text="Data is currently being loaded, please wait..."
        >
            <template v-slot:item.isActive="{ item }">
                <v-chip small
                        :class="{'error inactive-row white--text':(!item.isActive) , 'white black--text':(item.isActive)}">
                    {{ item.isActive ? $t('active') : $t('not_active') }}
                </v-chip>
            </template>

            <!-----------------------------------  DETAILS EDIT DELETE  ----------------------------------->
            <template v-slot:item.actions="{ item }">
                <v-layout align-center justify-center>
                    <v-btn icon @click.stop="openEditWarehouseDialog(item)">
                        <v-icon>mdi-pencil-outline</v-icon>
                    </v-btn>
                    <v-btn icon :loading="deleteLoadingId == item.id" @click="onDelete(item)">
                        <v-icon v-if="item.isActive">mdi-trash-can-outline</v-icon>
                        <v-icon v-else>mdi-autorenew</v-icon>
                    </v-btn>
                </v-layout>
            </template>
            <!----------------------------------- ## FILTERS ## ----------------------------------->
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
                                      style="padding: 0; font-size: inherit; text-align: right !important;">
                        </v-text-field>
                        <v-layout v-else align-center justify-center>
                            <v-btn depressed small :disabled="!enabledSearch" color="success"
                                   @click="search">
                                <v-icon>mdi-search-web</v-icon>
                            </v-btn>
                            <v-btn depressed class="ml-1" small :disabled="!enabledSearch" color="error"
                                   @click="refresh(true)">
                                <v-icon>mdi-close-circle</v-icon>
                            </v-btn>
                        </v-layout>
                    </th>
                </tr>
            </template>


        </v-data-table>
        <template>
            <add-warehouse
                    :addWarehouseDialog="addWarehouseDialog"
                    :dataForModal="dataForModal"
                    @closeAddDialog="addWarehouseDialog=false"
                    @addWarehouse="addWarehouse"/>
            <edit-warehouse
                    v-if="dialogEdit"
                    :dialogEdit="dialogEdit"
                    :editData="editData"
                    @closeEditDialog="dialogEdit=false"
                    @editWarehouse="editWarehouse"/>
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
        </template>
    </v-container>
</template>

<script>
    import axios from 'axios'
    import AddWarehouse from "../../components/warehouses/AddWarehouse";
    import EditWarehouse from "../../components/warehouses/EditWarehouse";

    export default {
        name: "Warehouse",
        components: {
            AddWarehouse,
            'edit-warehouse': EditWarehouse,
        },
        comments: {

        },
        data: function () {
            return {
                cities: null,
                editData: null,
                tableDataLoading: false,
                enabledSearch: false,
                warehouses: [],
                warehouse_data: null,
                deleteLoadingId: -1,
                snackbar: {
                    color: 'success',
                    show: false,
                    text: this.$t('warehouses.add_warehouse_msg'),
                    timeout: 3000,
                },
                filteredWarehouses: [],
                addWarehouseDialog: false,
                dialogEdit: false,
                dataForModal: {},
                itemsPerPage: 10,
                rowPerPageItems: [10, 15, 30, 50],
                filters: {
                    name: '',
                    address: '',
                    city: '',
                    isActive: "",
                }
            }
        },
        computed: {
            headers() {
                return [
                    {text: this.$t("warehouses.name"), name: 'name', align: 'left', sortable: true, value: 'name'},
                    {text: this.$t("warehouses.address"), name: 'address', align: 'left', sortable: true, value: 'address'},
                    {text: this.$t("warehouses.city"), name: 'city', align: 'left', sortable: true, value: 'city.name'},
                    {text: this.$t("warehouses.active"), name: 'active', align: 'left', sortable: true, value: 'isActive'},
                    {text: this.$t("actions"), name: 'actions', align: 'center', value: 'actions'},
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
        methods: {
            getWarehouseIndexById(id) {
                for (let i = 0; i < this.warehouses.length; i++) {
                    if (this.warehouses[i].id == id) {
                        return i;
                    }
                }
                return -1;
            },
            readWarehouses() {
                this.warehouses = [];
                this.tableDataLoading = true;
                axios.get('/api/warehouse').then(({data}) => {
                    this.warehouses = data;
                    if (data.length == 0) {
                        this.tableDataLoading = false;
                        this.errorMessage = this.$t("no_data");
                        this.showErrorMessage = true;
                    } else {
                        this.enabledSearch = true;
                        this.tableDataLoading = false;
                    }
                }).catch(error => {
                    console.error("READ WAREHOUSES", error);
                    this.tableDataLoading = false;
                    if (error.response == undefined) {
                        this.errorMessage = this.$t("error_loading_data_timeout");
                    } else {
                        this.errorMessage = this.$t("error_loading_data");
                    }
                    this.showErrorMessage = true;
                })
            },
            editWarehouse(warehouse) {
                this.warehouses.splice(this.getWarehouseIndexById(warehouse.id), 1, warehouse);
                this.snackbar.text = this.$t('edit_success')
                this.snackbar.show = true;
            },
            onDelete: function (item) {
                this.deleteLoadingId = item.id
                let message = this.$t('warehouses.deactivate_warehouse')
                if (!item.isActive) {
                    message = this.$t('warehouses.reactivate_warehouse')
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
                        confirmButtonText: this.$t('confirm')
                    })
                    .then(result => {
                        if (result.value) {
                            axios.delete("api/warehouse/" + item.id).then(({data}) => {
                                item.isActive = data.isActive ? 1 : 0;
                                item = data;
                                this.notification = 'delete';
                                this.snackbar.text = this.$t('edit_success');
                                this.snackbar.show = true;
                                this.deleteLoadingId = -1;
                            });
                        } else {
                            this.deleteLoadingId = -1;
                        }
                    });
            },
            openAddWarehouseDialog() {
                this.addWarehouseDialog = true;
                this.dataForModal = {
                    cities: this.cities,
                };
            },
            search() {
                if (this.filteredWarehouses.length == 0) {
                    this.filteredWarehouses = this.warehouses
                }
                this.warehouses = this.filteredWarehouses
                for (let i = 0; i < Object.keys(this.filters).length; i++) {
                    let val = Object.keys(this.filters)[i];
                    if (this.filters[val] == "") {
                        continue;
                    }
                    this.warehouses = this.warehouses.filter(item => {
                        if (item != undefined) {
                            //kreiraj varijablu koja sadrzi item
                            let value = item;
                            //ukoliko val koji predstavlja kljuc iz fitlera sadrzi tacku,
                            //to znaci da treba uci u objekat, pa se to mora raditi preko []
                            if (val.indexOf(".") != -1) {
                                //dobijamo svaki kljuc
                                let keys = val.split(".")
                                //prolazimo kroz svaki kljuc i ulazimo u value kroz loop i value dobija vrijednost od kljuca
                                keys.forEach(part => {
                                    value = value[part];
                                })
                            } else {
                                //ako nema tacke onda samo postaje kao sto pise
                                value = item[val];
                            }
                            return (value + "").toLowerCase().indexOf((this.filters[val] + "").toLowerCase()) > -1
                        }
                    })
                }
            },
            openEditWarehouseDialog(item) {
                this.dialogEdit = true;
                this.editData = {
                    warehouse_data: item,
                    cities: this.cities,
                };
            },
            readCities(){
              axios.get('/api/city').then(response => {
                  this.cities = response.data;
              }).catch(error => {
              })
            },
            addWarehouse(warehouse) {
                this.warehouses.push(warehouse)
                this.snackbar.text = this.$t('add_success');
                this.snackbar.show = true;
            },
            refresh(isReset) {
                if (this.filteredWarehouses.length == 0) {
                    this.filteredWarehouses = this.warehouses
                }
                Object.keys(this.filters).forEach(f => {
                    this.filters[f] = ''
                });
                if (isReset) {
                    this.warehouses = this.filteredWarehouses;
                } else {
                    this.readWarehouses();
                }
            }
        },
        created() {
            this.readCities();
            this.readWarehouses();
        }
    }
</script>

<style scoped/>
