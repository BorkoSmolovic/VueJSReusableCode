<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-row justify="end" class="mr-0">
        <v-dialog v-if="detailsFacilityDialog" v-model="detailsFacilityDialog" fullscreen
                  transition="dialog-bottom-transition">
            <v-toolbar dark color="primary">
                <v-toolbar-title class="headline"> {{$t('facilities.facility_details')}}: {{form.name}},
                    {{form.address}}
                </v-toolbar-title>
                <div class="flex-grow-1"></div>
                <v-toolbar-items>
                    <v-btn icon dark @click="closeDialog">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card v-if="detailsFacilityDialog">
                <v-card-text>

                    <div class="pt-9 row">


                        <!--  ===============================================TABOVI ===============================================-->
                        <v-tabs
                                background-color="white"
                                class="elevation-2 primary--text"
                        >
                            <v-tabs-slider color="primary"></v-tabs-slider>
                            <!--  =============================================== LICENCE ===============================================-->
                            <!--<v-tab @click="resetFilters">
                                <v-icon>mdi-account-tie</v-icon>
                                <v-card-text class="text-uppercase">{{$t('licenses.license')}}</v-card-text>
                            </v-tab>
                            <v-tab-item>
                                <v-toolbar color="White">
                                    <v-toolbar-title class="headline">{{$t('licenses.license')}}
                                    </v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn class="mr-4" color="primary" dark @click="dialogAddLicense=true">
                                        {{$t('licenses.add_license')}}
                                    </v-btn>
                                    <v-btn :loading="tableDataLoading"
                                           :disabled="tableDataLoading"
                                           color="warning"
                                           @click="$emit('refreshData', false)">
                                        <v-icon>mdi-refresh</v-icon>
                                    </v-btn>
                                </v-toolbar>
                                <v-spacer></v-spacer>

                                <v-data-table
                                        :headers="headersLicenses"
                                        :items="itemForFacility.licences"
                                        :items-per-page="itemsPerPage"
                                        :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                                        :dense="true"
                                        class="elevation-1"
                                        sort-by="name"
                                        :loading="tableDataLoading"
                                        loading-text="'Data is currently being loaded, please wait...'">
                                    &lt;!&ndash;=============================================== Details edit delete  ===============================================&ndash;&gt;
                                    <template v-slot:item.actions="{ item }">
                                        <v-layout align-center justify-center>
                                            <v-btn icon @click.stop="openEditLicenseDialog(item)">
                                                <v-icon>mdi-pencil-outline</v-icon>
                                            </v-btn>
                                            <v-btn icon :loading="deleteLoadingId === item.id"
                                                   @click="onLicenseDelete(item)">
                                                <v-icon v-if="item.isActive===0">mdi-autorenew</v-icon>
                                                <v-icon v-else>mdi-trash-can-outline</v-icon>
                                            </v-btn>
                                        </v-layout>
                                    </template>
                                    <template v-slot:item.isActive="{ item }">
                                        <v-chip small
                                                v-bind:class="{'error inactive-row white&#45;&#45;text':(item.isActive === 0) , 'white black&#45;&#45;text':(item.isActive != 0)}">
                                            {{ item.isActive === 0 ? $t('not_active') : $t('active') }}
                                        </v-chip>
                                    </template>
                                    &lt;!&ndash;=============================================== Filteri  ===============================================&ndash;&gt;
                                    <template v-slot:body.prepend>
                                        <tr class="grey lighten-2">
                                            <th v-for="header in headersLicenses"
                                                :key="header.name">
                                                <v-select v-if="header.name === 'isActive'"
                                                          class="justify-center"
                                                          v-model="filtersLicenses[header.value]"
                                                          @change="searchLicenses"
                                                          :items="activeObjects"
                                                          item-value="value"
                                                          item-text="text"
                                                          style="padding: 0; font-size: inherit; text-align: right !important;"
                                                          label="Filter">
                                                </v-select>
                                                <v-text-field
                                                        v-else-if="header.name != 'actions'"
                                                        v-model="filtersLicenses[header.value]"
                                                        @keyup.enter.native="searchLicenses"
                                                        label="Filter"
                                                        :placeholder="header.text"
                                                        hide-details
                                                        style="font-size: inherit;"
                                                />
                                                <v-layout v-else class="justify-center">
                                                    <v-btn depressed small :disabled="!enabledSearch"
                                                           color="success"
                                                           @click="searchLicenses">
                                                        <v-icon>mdi-search-web</v-icon>
                                                    </v-btn>
                                                    <v-btn depressed class="ml-1" small
                                                           :disabled="!enabledSearch"
                                                           color="error"
                                                           @click="refreshLicenses(true)">
                                                        <v-icon>mdi-close-circle</v-icon>
                                                    </v-btn>
                                                </v-layout>
                                            </th>
                                        </tr>
                                    </template>

                                    &lt;!&ndash;=============================================== No Data ===============================================&ndash;&gt;
                                    <template v-slot:no-data>
                                        <div class="text-xs-center">
                                            <v-alert
                                                    :value="itemForFacility.licences.length === 0"
                                                    color="error"
                                                    icon="mdi-alert-circle-outline">
                                                {{errorMessage}}
                                            </v-alert>
                                        </div>
                                    </template>
                                </v-data-table>

                            </v-tab-item>-->

                            <!--      =============================================== SERVICES ===============================================-->
                            <v-tab @click="resetFilters">
                                <v-icon>mdi-city-variant-outline</v-icon>
                                <v-card-text class="text-uppercase">
                                    {{$t('service.services')}}
                                </v-card-text>
                            </v-tab>
                            <v-tab-item>
                                <v-toolbar color="White">
                                    <v-toolbar-title class="headline">{{$t('service.services')}}
                                    </v-toolbar-title>
                                    <v-spacer></v-spacer>
                                    <v-btn class="mr-4" color="primary" dark @click="DialogServiceCategoryTree=true">
                                        {{$t('service.service_add')}}
                                    </v-btn>
                                    <v-btn :loading="tableDataLoading"
                                           :disabled="tableDataLoading"
                                           color="warning"
                                           @click="readServices()">
                                        <v-icon>mdi-refresh</v-icon>
                                    </v-btn>
                                </v-toolbar>
                                <v-spacer></v-spacer>

                                <v-data-table
                                        :headers="headersServices"
                                        :items="itemForFacility.services"
                                        :items-per-page="itemsPerPage"
                                        :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                                        :dense="true"
                                        v-bind:key="itemForFacility.id"
                                        class="elevation-1"
                                        sort-by="name"
                                        :loading="tableDataLoading"
                                        loading-text="'Data is currently being loaded, please wait...'">
                                    <!--=============================================== Details edit delete  ===============================================-->
                                    <template v-slot:item.actions="{ item,index } ">
                                        <v-layout align-center justify-center>
                                            <v-btn icon @click.stop="openEditServiceDialog(item)">
                                                <v-icon>mdi-pencil-outline</v-icon>
                                            </v-btn>
                                            <v-btn icon :loading="deleteLoadingId === item.id"
                                                   @click="onServiceDelete(item)">
                                                <v-icon v-if="item.isActive===0">mdi-autorenew</v-icon>
                                                <v-icon v-else>mdi-trash-can-outline</v-icon>
                                            </v-btn>
                                        </v-layout>
                                    </template>
                                    <template v-slot:item.isActive="{ item }">
                                        <v-chip small
                                                v-bind:class="{'error inactive-row white--text':(item.isActive === 0) , 'white black--text':(item.isActive != 0)}">
                                            {{ item.isActive === 0 ? $t('not_active') : $t('active') }}
                                        </v-chip>
                                    </template>
                                    <!--=============================================== Filteri  ===============================================-->
                                    <template v-slot:body.prepend>
                                        <tr class="grey lighten-2 align-bottom">
                                            <th v-for="header in headersServices"
                                                :key="header.name"
                                                class="py-2">
                                                <v-select v-if="header.name === 'active'"
                                                          class="justify-center pa-0 ma-0"
                                                          v-model="filtersServices[header.value]"
                                                          @change="searchServices"
                                                          :items="activeObjects"
                                                          item-value="value"
                                                          item-text="text"
                                                          style="padding: 0; font-size: inherit; text-align: right !important;"
                                                          label="Filter"/>
                                                <v-text-field v-else-if="header.name != 'actions'"
                                                              v-model="filtersServices[header.value]"
                                                              @keyup.enter.native="searchServices"
                                                              label="Filter"
                                                              :placeholder="header.text"
                                                              filled
                                                              hide-details
                                                              style="padding: 0; font-size: inherit; text-align: right !important;"/>
                                                <v-layout v-else class="justify-center">
                                                    <v-btn depressed small :disabled="!enabledSearch"
                                                           color="success"
                                                           @click="searchServices">
                                                        <v-icon>mdi-search-web</v-icon>
                                                    </v-btn>
                                                    <v-btn depressed class="ml-1" small
                                                           :disabled="!enabledSearch"
                                                           color="error"
                                                           @click="refreshServices(true)">
                                                        <v-icon>mdi-close-circle</v-icon>
                                                    </v-btn>
                                                </v-layout>
                                            </th>
                                        </tr>
                                    </template>

                                    <!--=============================================== No Data ===============================================-->
                                    <template v-slot:no-data>
                                        <div class="text-xs-center">
                                            <v-alert :value="itemForFacility.services.length === 0"
                                                     color="error"
                                                     icon="mdi-alert-circle-outline">
                                                {{errorMessage}}
                                            </v-alert>
                                        </div>
                                    </template>
                                </v-data-table>
                            </v-tab-item>
                        </v-tabs>
                    </div>
                </v-card-text>
            </v-card>
            <!--=============================================== Dialogs ===============================================-->
            <add-service-dialog
                    :payment_types="payment_types"
                    :vats="vats"
                    :facilityData="itemForFacility"
                    :DialogServiceCategoryTree="DialogServiceCategoryTree"
                    @close="DialogServiceCategoryTree=false"
                    @addService="addServiceEmit"
            />
            <edit-service-dialog
                    :payment_types="payment_types"
                    :vats="vats"
                    :service="service"
                    :DialogEditService="DialogEditService"
                    @close="DialogEditService=false"
                    @editService="editServiceEmit"
            />
            <!--=============================================== Snackbar ===============================================-->
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
        </v-dialog>
    </v-row>
</template>

<script>
    import DialogServiceCategoryTree from "../facility-service/DialogServiceCategoryTree";
    import axios from 'axios'
    import DialogEditService from "../facility-service/DialogEditService";

    axios.defaults.timeout = 15000;
    export default {
        created() {
            this.readVats();
            this.readPaymentTypes();
        },
        name: "FacilityDetails",
        props: {
            itemForFacility: {},
            detailsFacilityDialog: false,
            tableDataLoading: false,
        },
        components: {
            'add-service-dialog': DialogServiceCategoryTree,
            'edit-service-dialog': DialogEditService,
        },
        data: function () {
            return {
                snackbar: {
                    color: 'error',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                payment_types: [],
                vats: [],
                service: {},
                DialogEditService: false,
                DialogServiceCategoryTree: false,
                addServiceDialog: false,
                dialogEditLicense: false,
                dialogAddLicense: false,
                deleteLoadingId: -1,
                filteredLicenses: [],
                filteredServices: [],
                itemsPerPage: 10,
                rowsPerPageItems: [10, 15, 30, 50],
                enabledSearch: true,
                showErrorMessage: false,
                errorMessage: this.$t('no_data'),
                filtersLicenses: {
                    name: '',
                    isActive: '',
                },
                filtersServices: {
                    name: '',
                    isActive: '',
                },
                form: null,
                rules: {
                    required: [(v) => !!v || this.$t('validation.field')],
                },
                formError: {},
                tableDataLoading:false,
                loading: false,
                alert: false,
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
            headersServices() {
                return [
                    {
                        text: this.$t('service.service_name'),
                        name: 'name',
                        align: 'left',
                        sortable: true,
                        value: 'service_category.name'
                    },
                    {
                        text: this.$t('service.service_tax'),
                        name: 'tax',
                        align: 'left',
                        value: 'vat.rate'
                    },
                    {text: this.$t('service.price'), name: 'price', align: 'left', value: 'price'},
                    {text: this.$t('service.quantity'), name: 'quantity', align: 'left', value: 'quantity'},
                    {text: this.$t('service.note'), name: 'note', align: 'left', value: 'note'},
                    {
                        text: this.$t('service.payment_type'),
                        name: 'paymentType',
                        align: 'left',
                        value: 'payment_type.name'
                    },
                    {text: this.$t('service.duration'), name: 'duration', align: 'left', value: 'duration'},
                    {text: this.$t('service.active'), name: 'active', align: 'left', value: 'isActive'},
                    {text: this.$t('actions'), name: 'actions', align: 'center', value: 'actions'},
                ]
            },
            headersLicenses() {
                return [
                    {text: this.$t('partner_info.name'), name: 'name', align: 'left', sortable: true, value: 'name'},
                    {text: this.$t('partner_info.active'), name: 'active', align: 'left', value: 'isActive'},
                    {text: this.$t('actions'), name: 'actions', align: 'center', value: 'actions'},
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

            readServices(){
                this.tableDataLoading=true
                let id = this.itemForFacility.id
                axios.get('/api/facilityById/' + id,).then(responce => {

                    this.tableDataLoading=true
                }).catch(error => {

                    this.tableDataLoading=true
                })
            },

            editServiceEmit(item) {
                this.itemForFacility.services.splice(this.findServiceIndex(item), 1, item)
            },
            findServiceIndex(item) {
                for (let i = 0; i < this.itemForFacility.services.length; i++) {
                    if (this.itemForFacility.services[i].id === item.id) {
                        return i;
                    }
                }
                return -1;
            },
            onServiceDelete(item) {
                this.deleteLoadingId = item.id
                let message = this.$t('service.deactivate_msg')
                if (!item.isActive) {
                    message = this.$t('service.reactivate_msg')
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
                            axios.delete("api/serviceCategory/" + item.id).then(({data}) => {
                                item.isActive = data.isActive ? 1 : 0;
                                item = data;
                                this.notification = 'delete';
                                this.snackbar.color = 'success'
                                this.snackbar.text = this.$t('edit_success');
                                this.snackbar.show = true;
                                this.deleteLoadingId = -1;
                            });
                        } else {
                            this.deleteLoadingId = -1;
                        }
                    });
            },
            addServiceEmit(servicesArray) {
                let oldLenght = this.itemForFacility.services.length
                let newLenght = servicesArray.length
                for (let i = oldLenght; i < newLenght; i++) {
                    this.itemForFacility.services.push(servicesArray[i])
                }
            },
            openEditServiceDialog(item) {
                this.service = item;
                this.DialogEditService = true;
            },
            searchServices() {
                if (this.filteredServices.length === 0) {
                    this.filteredServices = this.itemForFacility.services
                }

                this.itemForFacility.services = this.filteredServices
                Object.keys(this.filtersServices).forEach(val => {
                    if (this.filtersServices[val] === "") {
                        return;
                    }
                    this.itemForFacility.services = this.itemForFacility.services.filter(item => {
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
                            return (value + "").toLowerCase().indexOf((this.filtersServices[val] + "").toLowerCase()) > -1
                        }
                    })
                })
            },
            refreshServices(isReset) {
                if (this.filteredServices.length === 0) {
                    this.filteredServices = this.itemForFacility.services
                }
                Object.keys(this.filtersServices).forEach(f => {
                    this.filtersServices[f] = ''
                });
                if (isReset) {
                    this.itemForFacility.services = this.filteredServices
                } else {
                    // this.readPartners();
                }
            },


            onLicenseDelete(item) {
                this.deleteLoadingId = item.id
                let message = this.$t('licenses.deactivate_license')
                if (!item.isActive) {
                    message = this.$t('licenses.reactivate_license')
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
                            axios.delete("api/licences/" + item.id).then(({data}) => {

                                item.isActive = data.isActive ? 1 : 0;
                                item = data;
                                this.notification = 'delete';
                                this.snackbar.color = 'success'
                                this.snackbar.text = this.$t('edit_success');
                                this.snackbar.show = true;
                                this.deleteLoadingId = -1;
                            });
                        } else {
                            this.deleteLoadingId = -1;
                        }
                    });
            },
            openEditLicenseDialog(item) {
                this.dialogEditLicense = true
                this.itemForFacility = null
            },
            editLicense(data) {
                let tempData = {
                    name: data.name,
                    license_number: data.license_number,
                    id: data.id,
                    isActive: data.isActive,
                    partner_id: data.partner_id,
                }
                this.itemForFacility.licences.splice(this.getAccIndexById(data.id), 1, tempData);
                this.snackbar.text = this.$t('edit_success')
                this.snackbar.color = "success"
                this.snackbar.show = true;
            },
            getLicenseIndexById(id) {
                for (let i = 0; i < this.itemForFacility.licences.length; i++) {
                    if (this.itemForFacility.licences[i].id === id) {
                        return i;
                    }
                }
                return -1;
            },
            pushLicense(data) {
                let tempData = {
                    name: item.name,
                    license_number: item.license_number,
                    id: item.id,
                    isActive: item.isActive,
                    partner_id: item.partner_id,
                }
                this.dataForModal.partner_data.bank_accounts.push(tempData)
                this.snackbar.text = this.$t('add_success')
                this.snackbar.color = "success"
                this.snackbar.show = true;
            },
            searchLicenses() {
                if (this.filteredLicenses.length === 0) {
                    this.filteredLicenses = this.itemForFacility.licences
                }

                this.itemForFacility.licences = this.filteredLicenses
                Object.keys(this.filtersLicense).forEach(val => {
                    if (this.filtersLicense[val] === "") {
                        return;
                    }
                    this.itemForFacility.licences = this.itemForFacility.licences.filter(item => {
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
                            return (value + "").toLowerCase().indexOf((this.filtersLicenses[val] + "").toLowerCase()) > -1
                        }
                    })
                })
            },
            refreshLicenses(isReset) {
                if (this.filteredLicenses.length === 0) {
                    this.filteredLicenses = this.itemForFacility.licences
                }
                Object.keys(this.filtersLicense).forEach(f => {
                    this.filtersLicense[f] = ''
                });
                if (isReset) {
                    this.itemForFacility.licences = this.filteredLicenses
                } else {
                    // this.readPartners();
                }
            },
            resetFilters() {
                this.refreshLicenses(true)
            },
            getEmptyForm() {
                return {
                    name: '',
                    address: '',
                }
            },
            readPaymentTypes() {
                axios.get('/api/paymentType').then(({data}) => {
                    this.payment_types = data;
                }).catch(error => {
                    console.error("Payment types", error);
                })
            },
            readVats() {
                axios.get('/api/vat').then(({data}) => {
                    this.vats = data;
                }).catch(error => {
                    console.error("READ VATS", error);
                })
            },
            closeDialog() {
                document.getElementsByClassName('v-dialog--active')[0].scrollTop = 0
                this.saveLoading = false
                this.$emit('close', false)
            },
        },
        watch: {
            detailsFacilityDialog: function (val) {
                if (val) {
                    this.form = {
                        name: this.itemForFacility.name,
                        address: this.itemForFacility.address,
                    }
                }
            },
        }
    }
</script>

<style scoped/>
