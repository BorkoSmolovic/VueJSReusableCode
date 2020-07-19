<template>
    <v-dialog v-if="dialogMoveServiceCategory" v-model="dialogMoveServiceCategory" persistent
              transition="dialog-bottom-transition">
        <v-container fluid grid-list-sm>
            <v-toolbar color="White">
                <v-toolbar-title>{{$t('navigation_service_categories')}}</v-toolbar-title>
                <v-spacer/>
            </v-toolbar>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-flex xs12 sm12>
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

                            <template slot="prepend" slot-scope="{ item, active }">
                                <div>
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
                                </div>
                            </template>
                            <template
                                    slot="label"
                                    slot-scope="{ item, active }"
                            >
                                <div>
                                    <v-row @click="!active ? newId=item.id : newId=-1">
                                        <div
                                                class="pt-1 pr-2"
                                                style="margin-left: 20px; max-width: 70%; word-break:break-all; word-wrap:break-word; display:inline-block;"
                                        >
                                            <v-chip
                                                    v-bind:class="{'success white--text':active}">
                                                {{ item.name }}
                                            </v-chip>

                                        </div>
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
                    <v-btn class="mr-4" text color="primary" dark @click="moveService(-2)">
                        makni
                    </v-btn>
                    <v-btn class="mr-4" text color="primary" dark @click="moveService(newId)">
                        {{$t('move')}}
                    </v-btn>
                    <v-btn class="mr-4" text color="primary" dark @click="close">
                        {{$t('close')}}
                    </v-btn>
                </v-card-actions>
            </v-card><v-snackbar
                v-model="snackbar.show"
                :bottom=true
                :color="snackbar.color"
                :timeout="snackbar.timeout">
            {{ snackbar.text }}
            <v-btn dark text @click="snackbar.show = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-snackbar>
            <v-spacer></v-spacer>
                <!---------------------------------- Snackbar  ----------------------------------------->
        </v-container>

    </v-dialog>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            moveData: '',
            dialogMoveServiceCategory: '',
        },
        name: "DialogServiceCategoryTree",
        data: function () {

            return {
                newId: -1,
                activeItem: -1,
                snackbar: {
                    color: 'error',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                items: [],
                search: '',
                open: [],
                tree: [],
                showLoading: true,
                showErrorMessage: false,
            }
        },
        computed: {
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
            moveService(id) {
                if (this.newId === -1 || this.newId === this.moveData.id) {
                    this.snackbar.color = 'error';
                    this.snackbar.text = 'Morate izabrati mjesto premjestanja';
                    this.snackbar.show = true;
                    return;

                }
                let data
                if (id === -2) {
                    data = {
                        service_category_id: this.moveData.id,
                        parent_service_category_id: null,
                    };
                } else {
                    data = {
                        service_category_id: this.moveData.id,
                        parent_service_category_id: id != -1 ? id : this.moveData.service_category_id,
                    };
                }
                axios.post('/api/serviceCategoryMove', data).then((response) => {
                    this.alert = false;
                    this.loading = false;
                    let data = {
                        oldItem: this.moveData.item,
                        newItem: response.data,
                    }
                    this.$emit('moveCategory', data);
                    this.close()
                }).catch(error => {
                    this.loading = false;
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: error,
                    })
                })
            },
            filterData() {
                this.search = this.$refs.searchData.lazyValue;
            },
            readServiceCategories() {
                axios.get('/api/serviceCategoryGetFolders').then(({data}) => {

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
