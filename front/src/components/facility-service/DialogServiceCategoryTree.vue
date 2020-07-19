<template>
    <v-dialog v-model="DialogServiceCategoryTree" persistent transition="dialog-bottom-transition">
        <v-container fluid grid-list-sm>
            <v-toolbar color="White">
                <v-toolbar-title>{{$t('navigation_service_categories')}}</v-toolbar-title>
                <v-spacer/>
                <div class="flex-grow-1"></div>
                <v-btn :loading="addBtnLoading" class="mr-4" text color="primary" dark @click="addService()">
                    {{$t('add')}}
                </v-btn>
                <v-btn class="mr-4" text color="primary" dark @click="close">
                    {{$t('close')}}
                </v-btn>
            </v-toolbar>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-flex xs12 sm12>
                <v-card-text class="white pt-1 pl-1">
                    <v-form ref="form" v-on:submit.prevent>
                        <v-data-table
                                :headers="headers"
                                :items="selections"
                                :items-per-page="itemsPerPage"
                                :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                                :dense="true"
                                class="elevation-1"
                                sort-by="name"
                                :loading="tableDataLoading"
                                loading-text="'Data is currently being loaded, please wait...'">
                            <template v-slot:item.tax="{ item }">
                                <v-combobox
                                        :rules="rules.required"
                                        :items="vats"
                                        item-value="id"
                                        item-text="rate"
                                        v-model="item.tax"
                                        style="padding: 0;padding-top: 3%; font-size: inherit; text-align: right !important;"
                                >
                                </v-combobox>
                            </template>

                            <template v-slot:item.price="{ item }">
                                <v-layout align-center justify-center>
                                    <v-text-field :rules="rules.required" v-model="item.price"
                                                  class="text-xs-right"></v-text-field>
                                </v-layout>
                            </template>
                            <template v-slot:item.quantity="{ item }">
                                <v-layout align-center justify-center>
                                    <v-text-field :rules="rules.required" v-model="item.quantity"
                                                  class="text-xs-right"></v-text-field>
                                </v-layout>
                            </template>
                            <template v-slot:item.note="{ item }">
                                <v-layout align-center justify-center>
                                    <v-text-field  v-model="item.note"
                                                  class="text-xs-right"></v-text-field>
                                </v-layout>
                            </template>
                            <template v-slot:item.payment_type="{ item }">

                                <v-combobox
                                        :items="payment_types"
                                        item-value="id"
                                        item-text="name"
                                        @change="changePayment(item)"
                                        v-model="item.payment_type"
                                        style="padding: 0;padding-top: 3%; font-size: inherit; text-align: right !important;"
                                >
                                </v-combobox>
                            </template>
                            <template v-slot:item.duration="{ item }">
                                <v-layout align-center justify-center>
                                    <v-text-field :rules="item.payment_type.id != 2 ? [] : rules.required " :disabled="item.payment_type.id != 2"
                                                  v-model="item.duration"
                                                  class="text-xs-right"></v-text-field>
                                </v-layout>
                            </template>
                            <template v-slot:item.serial="{ item }">
                              <v-layout align-center justify-center>
                                    <v-text-field :disabled="item.has_serial_number != 1"
                                                  class="text-xs-right"></v-text-field>
                                </v-layout>
                            </template>
                            <!-------------------------------------  DETAILS EDIT DELETE  ----------------------------------------------->
                            <template v-slot:item.actions="{ item }">
                                <v-layout align-center justify-center>
                                    <v-icon @click="remove(item)">mdi-trash-can-outline</v-icon>
                                </v-layout>
                            </template>
                            <!-------------------------------- ## NO DATA ## ----------------------------------->
                            <template v-slot:no-data>
                                <div class="text-xs-center">
                                    <v-alert :value="selections.length === 0"
                                             color="error"
                                             icon="mdi-alert-circle-outline">
                                        {{errorMessage}}
                                    </v-alert>
                                </div>
                            </template>
                        </v-data-table>
                    </v-form>

                </v-card-text>
            </v-flex>
            <!-- ==================== TREE VIEW ====================== -->
            <v-card>
                <v-row>
                    <v-col
                            cols="12"
                            sm="12"
                    >
                        <!-- Search -->
                        <v-text-field
                                @keyup.enter.native="filterData"
                                clearable
                                hide-details
                                :placeholder="$t('search')"
                                ref="searchData"
                                solo-inverted
                                v-if="!showErrorMessage"
                        />
                        <v-treeview
                                :filter="filter"
                                :items="items"
                                :open="open"
                                :search="search"
                                hoverable
                                activatable
                                active-class=" grey lighten-4"
                                item-children="service_category"
                        >
                            <template v-slot:prepend="{ item, active }">
                                <!-- <v-icon v-if="item.isItem === 0">folder_open</v-icon> -->
                                <v-icon v-if="item.isItem === 1">
                                    mdi-information
                                </v-icon>
                                <span v-if="item.service_category != undefined">
                              <v-icon v-if=" item.isItem === 0 && item.service_category.length > 0">
                               mdi-folder-multiple-outline
                            </v-icon>
                            <v-icon v-if=" item.isItem === 0 && item.service_category.length === 0">
                               mdi-folder-outline
                            </v-icon>
                            </span>

                            </template>
                            <template
                                    slot="label"
                                    slot-scope="{ item, active }"
                            >
                                <div>
                                    <v-row>
                                        <div
                                                class="pt-1 pr-2"
                                                style="margin-left: 20px; max-width: 70%; word-break:break-all; word-wrap:break-word; display:inline-block;"
                                        >
                                            <v-chip
                                                    v-bind:class="{'error inactive-row white--text':(item.isActive === 0) , 'white black--text':(item.isActive === 1)}">
                                                {{ item.name }}
                                            </v-chip>

                                        </div>
                                        <span v-if="active"
                                              class="pt-1 pr-2"
                                              style="margin-left: 20px; max-width: 70%; word-break:break-all; word-wrap:break-word; display:inline-block;"
                                        >
                                       <v-btn icon v-if="active && item.isItem === 1"
                                              @click.stop="selectItem(item)">
                                           &nbsp&nbsp<v-icon>mdi-plus-outline</v-icon>
                                       </v-btn>
                                    </span>
                                        <div class="">
                                            <!-- <v-text-field v-if="item.isItem != 0" class="pa-0" type="number" style="max-width: 20%; display:inline-block;" ></v-text-field> -->

                                        </div>
                                    </v-row>
                                </div>
                            </template>
                        </v-treeview>
                    </v-col>
                </v-row>
                <v-card-actions class="white" align="right">
                    <div class="flex-grow-1"></div>
                    <v-btn :loading="addBtnLoading" class="mr-4" text color="primary" dark @click="addService()">
                        {{$t('add')}}
                    </v-btn>
                    <v-btn class="mr-4" text color="primary" dark @click="close">
                        {{$t('close')}}
                    </v-btn>
                </v-card-actions>
            </v-card>
            <v-spacer></v-spacer>
            <template>
                <!---------------------------------- Snackbar  ----------------------------------------->
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
    </v-dialog>
</template>

<script>
    import axios from 'axios/index'

    export default {
        props: {
            payment_types: null,
            vats: null,
            facilityData: {},
            DialogServiceCategoryTree: '',
        },
        name: "DialogServiceCategoryTree",
        data: function () {

            return {
                addBtnLoading: false,
                payment_type: 0,
                duration: null,
                activeItem: -1,
                deleteLoadingId: -1,
                snackbar: {
                    color: 'error',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                itemsPerPage: 10,
                tableDataLoading: false,
                comboboxData: [],
                items: [],
                search: '',
                open: [],
                tree: [],
                rules: {
                    required: [(v) => !!v || this.$t('validation.field')],
                },
                showLoading: true,
                showErrorMessage: false,
                errorMessage: this.$t('service.empty'),
            }
        },
        computed: {
            paymentType() {
                return [
                    {value: 1, text: this.$t('payment_type.one_time')},
                    {value: 2, text: this.$t('payment_type.monthly_limited')},
                    {value: 3, text: this.$t('payment_type.monthly_unlimited')},
                ]
            },
            headers() {
                return [
                    {text: this.$t('service.service_name'), name: 'name', align: 'left', sortable: true, value: 'name'},
                    {text: this.$t('service.service_tax'), name: 'tax', align: 'left', value: 'tax'},
                    {text: this.$t('service.price'), name: 'price', align: 'left', value: 'price'},
                    {text: this.$t('service.quantity'), name: 'quantity', align: 'left', value: 'quantity'},
                    {text: this.$t('service.note'), name: 'note', align: 'left', value: 'note'},
                    {text: this.$t('service.payment_type'), name: 'paymentType', align: 'left', value: 'payment_type'},
                    {text: this.$t('service.duration'), name: 'duration', align: 'left', value: 'duration'},
                    {text: this.$t('service.serial'), name: 'serial', align: 'left', value: 'serial'},
                    {text: this.$t('actions'), name: 'actions', align: 'center', value: 'actions'},
                ]
            },
            selections() {
                const selections = [];
                var i = 0;
                for (var categories of this.tree) {
                    if (categories.isItem === 0) continue;
                    categories['comment'] = '';
                    selections.push(categories);
                    i++
                }
                return selections
            },
            filter() {
                if (this.search === '') {
                    this.open = []
                }
                return (item, search, textKey) => {
                    // this.open = [];
                    if (item[textKey].toLowerCase().includes(search.toLowerCase())) {
                        // if (item['isItem'] === 1) {
                        var scId = item['id'];
                        if (item['isItem'] === 0) {
                            this.open.push(scId)
                        }
                        this.openParentItem(scId, null);
                        return true
                        // }
                    }
                    return false
                }
            },
        },
        watch: {

            'close': function (value) {
                if (value === false) {
                    this.tree = []
                    this.search = ''
                    this.open = []
                    this.readServiceCategories()
                } else {
                    this.tree = []
                    this.open = []
                    this.search = ''
                    this.readServiceCategories()
                }

            },
        },
        created() {
            this.readServiceCategories()
        },
        methods: {
            changePayment(item) {
                item.duration = null
            },
            addService() {
                if (!this.$refs.form.validate()) {
                    this.alert = true;
                    return;
                }
                this.addBtnLoading = true
                if (this.selections.length == 0) {
                    this.$swal
                        .fire({
                            title: this.$t('service.choose_service'),
                            icon: "info",
                            showCancelButton: false,
                            confirmButtonColor: "#4caf50",
                            cancelButtonColor: "#ff5252",
                            confirmButtonText: "OK"
                        })
                    this.addBtnLoading = false
                    return
                }

                for (let category of this.selections) {
                    category.payment_type_id = category.payment_type.id;
                    category.vat_id = category.tax.id;
                }
                let data = {
                    facility_id: this.facilityData.id,
                    services: this.selections
                }
                axios.post('/api/facilityServiceCategory', data)
                    .then((response) => {
                        this.$emit('addService', response.data[0].services)
                    })
                    .catch(function (error) {
                    });
                this.addBtnLoading = false
                this.close()
            },
            filterData() {
                this.search = this.$refs.searchData.lazyValue;
            },
            selectItem(item) {
                /*  var itemIndex = this.getItemIndexById(item.id)
                  if (itemIndex != -1) {
                      var tempItem = this.tree[itemIndex]
                      const quantity = tempItem.quantity
                      const index = tempItem.index
                      const id = tempItem.service_category_id
                      const name = tempItem.name
                      const tax = tempItem.tax
                      const price = tempItem.price
                      const note = tempItem.note
                      const duration = tempItem.duration
                      const payment_type = tempItem.payment_type
                      const payment_type_id = tempItem.payment_type.id
                      const vat_id = tempItem.tax.id
                      this.tree.splice(this.getItemIndexById(item.id), 1)
                      this.tree.push({
                          index: index,
                          service_category_id: id,
                          name: name,
                          tax: tax,
                          price: price,
                          quantity: (parseInt(quantity) + 1),
                          note: note,
                          duration: duration,
                          payment_type: payment_type,
                          payment_type_id: payment_type_id,
                          vat_id: vat_id
                      })
                  } else {*//*}*/

                this.tree.push({
                    index: this.tree.length + 1,
                    service_category_id: item.id,
                    name: item.name,
                    tax: item.vat,
                    price: item.price,
                    quantity: 1,
                    payment_type_id: item.payment_type_id,
                    payment_type: item.payment_type,
                    note: '',
                    duration: null,
                    vat_id: item.vat_id,
                    has_serial_number: item.has_serial_number
                })
            },
            /*  getItemIndexById(id) {
                  for (let i = 0; i < this.tree.length; i++) {
                      if (this.tree[i].service_category_id === id) {
                          return i;
                      }
                  }
                  return -1;
              },*/
            remove(item) {

                this.tree.splice(this.tree.indexOf(item), 1);
            },
            readServiceCategories() {
                axios.get('/api/serviceCategory').then(({data}) => {
                    this.items = data;
                    if (data.length === 0) {
                        this.errorMessage = 'Nema podataka';
                        this.showErrorMessage = true
                    }
                    this.showLoading = false
                }).catch(error => {
                    this.errorMessage = 'Greska pri ucitavanju podataka';
                    this.showLoading = false;
                    this.showErrorMessage = true
                })
            },
            findItem(id, items = null) {
                if (!items) {
                    items = this.items
                }
                return items.reduce((acc, item) => {
                    if (acc) {
                        return acc
                    }
                    if (item.id === id) {
                        return item
                    }
                    if (item.service_category) {
                        return this.findItem(id, item.service_category)
                    }
                    return acc
                }, null)
            },
            close() {
                document.getElementsByClassName('v-dialog--active')[0].scrollTop = 0
                this.tree = []
                this.$refs.searchData.lazyValue = '',
                    this.open = []
                this.search = ''
                this.readServiceCategories()
                this.$emit('close', false)
            },
            openParentItem(id, item) {
                if (item == null) {
                    this.items.forEach(temp => {
                        this.openParentItem(id, temp)
                    })
                } else {
                    if (item.service_category === undefined) {
                        return
                    }
                    item.service_category.forEach(child => {
                        if (child.id === id) {
                            if (!this.open.includes(child.service_category_id)) {
                                this.open.push(child.service_category_id);
                                this.openParentItem(child.service_category_id, null)
                            }
                        } else {
                            this.openParentItem(id, child)
                        }
                    })
                }
            },
        },
    }
</script>

<style scoped/>
