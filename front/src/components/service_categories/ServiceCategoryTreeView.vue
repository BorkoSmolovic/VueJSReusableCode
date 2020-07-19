<template lang="html">
    <v-container>
        <!-- ==================== TOOLBAR - ServiceCategories ===================== -->
        <div>
            <v-toolbar color="White">
                <v-toolbar-title>{{$t('navigation_service_categories')}}</v-toolbar-title>
                <v-spacer/>
                <v-btn
                        @click="openAddCategoryDialog(null)"
                        class="mr-4"
                        color="primary"
                        dark
                >
                    {{$t('add_category')}}
                </v-btn>
            </v-toolbar>
            <v-divider/>


            <add-category-dialog
                    :paymentTypes="paymentTypes"
                    :comboboxData="comboboxData"
                    :addServiceCategoryDialog="addServiceCategoryDialog"
                    @closeAddServiceDialog="addServiceCategoryDialog=false"
                    :addData="addData"
                    @pushCategory="pushCategory"
            />
            <edit-category-dialog
                    :paymentTypes="paymentTypes"
                    :comboboxData="comboboxData"
                    :editServiceCategoryDialog="editServiceCategoryDialog"
                    :editData="editData"
                    @closeEditServiceDialog="editServiceCategoryDialog=false"
                    @editCategory="editCategory"
            />
        </div>
        <br> <!-- BR -->
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
                            <!-- <v-icon v-if="item.isItem == 0">folder_open</v-icon> -->
                            <v-icon v-if="item.isItem == 1">
                                mdi-information
                            </v-icon>
                            <span v-if="item.service_category != undefined">
                              <v-icon v-if=" item.isItem == 0 && item.service_category.length > 0">
                               mdi-folder-multiple-outline
                            </v-icon>
                            <v-icon v-if=" item.isItem == 0 && item.service_category.length == 0">
                               mdi-folder-outline
                            </v-icon>
                            </span>

                        </template>
                        <template
                                slot="label"
                                slot-scope="{ item, active }"
                        >
                            <div>
                                <v-row @click="selectedItemId = item.id">
                                    <div
                                            class="pt-1 pr-2"
                                            style="margin-left: 20px; max-width: 70%; word-break:break-all; word-wrap:break-word; display:inline-block;"
                                    >
                                        <v-chip
                                                v-bind:class="{'error inactive-row white--text':(item.isActive == 0) , 'white black--text':(item.isActive == 1)}">
                                            {{ item.name }}
                                        </v-chip>

                                    </div>
                                    <span v-if="selectedItemId == item.id && active"
                                          class="pt-1 pr-2"
                                          style="margin-left: 20px; max-width: 70%; word-break:break-all; word-wrap:break-word; display:inline-block;"
                                    >
                                        <v-btn icon v-if="item.isItem == 0"
                                               @click.stop="openAddCategoryDialog(item)">
                                          &nbsp&nbsp<v-icon>mdi-plus-outline</v-icon>
                                        </v-btn>
                                       <v-btn icon v-if="selectedItemId == item.id  && active"
                                              @click.stop="openEditCategoryDialog(item)">
                                           &nbsp&nbsp<v-icon>mdi-pencil-outline</v-icon>
                                       </v-btn>
                                        <v-btn icon text
                                               v-if="item.isActive == 1"
                                               @click.stop="openMoveCategoryDialog(item)">
                                            &nbsp&nbsp<v-icon>mdi-folder-move</v-icon>
                                        </v-btn>
                                        <v-btn icon text
                                               :loading="item.id == deleteLoadingId" v-if="item.isActive == 1"
                                               @click.stop="deleteCategory(item)">
                                            &nbsp&nbsp<v-icon>mdi-trash-can-outline</v-icon>
                                        </v-btn>
                                        <v-btn icon text v-if="item.isActive == 0"
                                               :loading="item.id == deleteLoadingId"
                                               @click.stop="deleteCategory(item)">
                                            &nbsp&nbsp<v-icon>mdi-autorenew</v-icon>
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
        </v-card>
        <move-service-dialog
                :moveData="moveData"
                :dialogMoveServiceCategory="dialogMoveServiceCategory"
                @close="dialogMoveServiceCategory=false"
                @moveCategory="moveServiceEmit"
        />
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
    import moment from 'moment'
    import axios from 'axios'
    import AddServiceCategory from "./AddServiceCategory";
    import EditServiceCategory from "./EditServiceCategory";
    import DialogServiceCategoryMove from "./DialogServiceCategoryMove";

    export default {
        components: {
            'move-service-dialog': DialogServiceCategoryMove,
            'add-category-dialog': AddServiceCategory,
            'edit-category-dialog': EditServiceCategory
        },
        props: {
            closeDialog: {
                default: true,
            },
            newServices: Array,
        },
        data: function () {
            return {
                paymentTypes: [],
                selectedItemId: null,
                moveData: null,
                dialogMoveServiceCategory: false,
                deleteLoadingId: -1,
                snackbar: {
                    color: 'error',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                comboboxData: [],
                addData: {},
                editData: {},
                editServiceCategoryDialog: false,
                addServiceCategoryDialog: false,
                items: [],
                search: '',
                open: [],
                tree: [],

                showLoading: true,
                showErrorMessage: false,
                errorMessage: 'test',
            }
        },
        computed: {
            selections() {
                const selections = [];
                var i = 0;
                for (var categories of this.tree) {
                    if (categories.isItem == 0) continue;
                    categories['due_date'] = moment(moment(), 'YYYY-MM-DD').add(categories.complete_within_days, 'd').format('YYYY-MM-DD');
                    categories['comment'] = '';
                    categories['quantity'] = 1;
                    // categories['tax']= 0
                    categories['place'] = '';
                    if (categories.desabledCheck == undefined) {
                        categories['desabledCheck'] = categories.accreditation
                    }
                    if (categories.accreditation == 2) {
                        categories.accreditation = 0
                    }
                    selections.push(categories);
                    i++
                }
                this.$emit('chosenService', selections);
                return selections
            },
            filter() {
                if (this.search == '') {
                    this.open = []
                }
                return (item, search, textKey) => {
                    // this.open = [];
                    if (item[textKey].toLowerCase().includes(search.toLowerCase())) {
                        // if (item['isItem'] == 1) {
                        var scId = item['id'];
                        if (item['isItem'] == 0) {
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
                if (value == false) {
                    this.tree = []
                }
            },
        },
        created() {
            this.readPaymentTypes();
            this.readServiceCategories()
            this.readVats()
        },
        methods: {
            readPaymentTypes() {
                axios.get('/api/paymentType')
                    .then(responce => {
                        this.paymentTypes = responce.data
                    }).catch(error => {
                })

            },
            computedIcon(item) {
                if (item.isItem == 1) {
                    return 'mdi-information'
                } else if (item.service_category != undefined) {
                    return 'mdi-folder-multiple-outline'
                } else if (item.isItem == 0 && item.service_category.length == 0) {
                    return 'mdi-folder-outline'
                }
                return 'mdi-plus'
            },
            moveServiceEmit() {
                this.readServiceCategories()
            },
            deleteCategory(item) {
                this.deleteLoadingId = item.id
                let message = item.isItem == 0 ? this.$t('service.deactivate_category_msg') : this.$t('service.deactivate_service_msg')
                if (!item.isActive) {
                    message = item.isItem == 0 ? this.$t('service.reacivate_category_msg') : this.$t('service.reacivate_service_msg')
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
                            axios.delete('/api/serviceCategory/' + item.id)
                                .then(response => {
                                    item.isActive = item.isActive == 1 ? 0 : 1
                                    this.snackbar.text = this.$t('edit_success');
                                    this.snackbar.color = 'success'
                                    this.snackbar.show = true;
                                    this.deleteLoadingId = -1;
                                })
                                .catch(function (error) {

                                });
                        } else {
                            this.deleteLoadingId = -1;
                        }
                    });
            },
            readVats() {
                axios.get('/api/vat')
                    .then(response => {
                        this.comboboxData = response.data
                    })
                    .catch(function (error) {
                    });
            },
            openAddCategoryDialog(item) {
                this.addServiceCategoryDialog = true
                if (item != null) {
                    this.addData = {
                        item: item,
                        service_category_id: item.id,
                    }
                } else {
                    this.addData = null
                }
            },
            openEditCategoryDialog(item) {
                this.editServiceCategoryDialog = true,
                    this.editData = {
                        item: item,
                        id: item.id,
                        isActive: item.isActive,
                        isItem: item.isItem,
                        name: item.name,
                        service_category: item.service_category,
                        service_category_id: item.service_category_id,
                        user_id: item.user_id,
                        vat: item.vat,
                        vat_id: item.vat_id,
                        duration: item.duration,
                        price: item.price,
                        payment_type: item.payment_type,
                        has_serial_number: item.has_serial_number == 1 ? true : false
                    }
            },
            openMoveCategoryDialog(item) {
                this.dialogMoveServiceCategory = true
                this.moveData = item
            },
            editCategory(data) {
                data.oldItem.duration = data.newItem.duration;
                data.oldItem.id = data.newItem.id;
                data.oldItem.isActive = data.newItem.isActive;
                data.oldItem.isItem = data.newItem.isItem;
                data.oldItem.name = data.newItem.name;
                data.oldItem.price = data.newItem.price;
                data.oldItem.service_category = data.newItem.service_category;
                data.oldItem.service_category_id = data.newItem.service_category_id;
                data.oldItem.user_id = data.newItem.user_id;
                data.oldItem.vat = data.newItem.vat;
                data.oldItem.vat_id = data.newItem.vat_id;
                data.oldItem.payment_type = data.newItem.payment_type;
                data.oldItem.has_serial_number = data.newItem.has_serial_number;
                this.snackbar.text = data.newItem.isItem == 0 ? this.$t('category_snackbar_edit') : this.$t('service_snackbar_edit');
                this.snackbar.color = 'success';
                this.snackbar.show = true;
            },
            pushCategory(item, newItem) {
                if (item == null) {
                    this.items.push(newItem);
                    // this.items.sort((a, b) => a.name.localeCompare(b.name));
                    this.items.sort((a, b) => a.name.localeCompare(b.name, undefined, {
                        numeric: true,
                        sensitivity: 'base'
                    }));
                } else {
                    item.service_category.push(newItem);
                    item.service_category.sort((a, b) => a.name.localeCompare(b.name, undefined, {
                        numeric: true,
                        sensitivity: 'base'
                    }));
                    item.service_category.sort(function (a, b) {
                        return b.isItem > a.isItem ? -1 : 1;
                    })
                }
                this.snackbar.text = newItem.isItem == 0 ? this.$t('category_snackbar_add') : this.$t('service_snackbar_add'),
                    this.snackbar.color = 'success',
                    this.snackbar.show = true
            },
            filterData() {
                this.search = this.$refs.searchData.lazyValue;
            },
            selectItem(item) {
                this.tree.push({
                    index: this.tree.length + 1,
                    menu: false,
                    id: item.id,
                    name: item.name,
                    tax: item.vat.rate,
                    supplement: item.supplement,
                })
            },
            remove(item) {
                this.$emit('removeItem', item);
                this.tree.splice(this.tree.indexOf(item), 1);
            },
            readServiceCategories() {
                axios.get('/api/serviceCategory').then(({data}) => {
                    this.items = data;
                    if (data.length == 0) {
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
                    if (item.id == id) {
                        return item
                    }
                    if (item.service_category) {
                        return this.findItem(id, item.service_category)
                    }
                    return acc
                }, null)
            },
            openParentItem(id, item) {
                if (item == null) {
                    for (let i = 0; i < this.items.length; i++) {
                        this.openParentItem(id, this.items[i])
                    }
                    // this.items.forEach(temp => {
                    //     this.openParentItem(id, temp)
                    // })
                } else {
                    if (item.service_category == undefined) {
                        return
                    }
                    for (let i = 0; i < item.service_category.length; i++) {
                        let child = item.service_category[i];
                        if (child.id == id) {
                            if (!this.open.includes(child.service_category_id)) {
                                this.open.push(child.service_category_id);
                                this.openParentItem(child.service_category_id, null)
                            }
                        } else {
                            this.openParentItem(id, child)
                        }
                    }
                    // item.service_category.forEach(child => {
                    //     if (child.id == id) {
                    //         if (!this.open.includes(child.service_category_id)) {
                    //             this.open.push(child.service_category_id);
                    //             this.openParentItem(child.service_category_id, null)
                    //         }
                    //     } else {
                    //         this.openParentItem(id, child)
                    //     }
                    // })
                }
            },
        },
    }
</script>

<style lang="css" scoped>
</style>
