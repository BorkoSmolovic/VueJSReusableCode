<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-dialog v-model="dialogChooseItems" persistent transition="dialog-bottom-transition">
        <v-container fluid grid-list-sm>
            <v-toolbar color="White">
                <v-toolbar-title class="headline">{{$t('navigation_partners')}}</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning" @click="refresh(false)">
                    <v-icon>mdi-refresh</v-icon>
                </v-btn>
            </v-toolbar>
            <v-spacer></v-spacer>
            <v-card class="my-1" :elevation="2">
                <v-data-table
                        :headers="headers"
                        :items="partners"
                        :items-per-page="itemsPerPage"
                        :footer-props="{itemsPerPageOptions: [10,20,30,50]}"
                        :dense="true"
                        class="elevation-1"
                        sort-by="name"
                        :loading="tableDataLoading"
                        loading-text="'Data is currently being loaded, please wait...'">
                    <!--<template v-slot:item.name="{ item }">-->
                    <!--<v-chip :color="getColor(item.calories)" dark>{{ item.name }}</v-chip>-->
                    <!--</template>-->

                    <template v-slot:item.actions="{ item }">
                        <v-layout v-if="singleSelect" align-center justify-center>
                            <v-checkbox v-model="item.id==selectedId" @change="select(item)"/>
                        </v-layout>
                        <v-layout v-else align-center justify-center >
                            <v-checkbox v-model="item.id==selectedId" @change="updateSelected(item)"/>
                        </v-layout>
                    </template>

                    <template v-slot:item.isActive="{ item }">
                        <v-chip small
                                v-bind:class="{'error inactive-row white--text':(item.isActive == 0) , 'white black--text':(item.isActive === 1)}">
                            {{ item.isActive == 1 ? $t('active') : $t('not_active') }}
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

                    <!-------------------------------- ## NO DATA ## ----------------------------------->
                    <template v-slot:no-data>
                        <div class="text-xs-center">
                            <v-alert :value="showErrorMessage" color="error" icon="mdi-alert-circle-outline">
                                {{errorMessage}}
                            </v-alert>
                        </div>
                    </template>
                </v-data-table>
                <v-card-actions class="white" align="right">
                    <div class="flex-grow-1"></div>
                        <v-btn class="mr-4" text color="primary" dark @click="addSuperior()">
                            {{$t('add')}}
                        </v-btn>
                        <v-btn class="mr-4" text color="primary" dark @click="closeDialog()">
                            {{$t('close')}}
                        </v-btn>
                </v-card-actions>
            </v-card>
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
    import axios from 'axios'

    export default {
        props: {
            singleSelect:true,
            dialogChooseItems: '',
        },
        name: "ChoosePartners",
        data: function () {
            return {
                selectedId:-1,
                selected: [],
                addedPartners: [],
                defaultActive: '',
                deleteLoadingId: -1,
                snackbar: {
                    color: 'success',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                itemsPerPage: 10,
                rowsPerPageItems: [10, 15, 30, 50],
                tableDataLoading: true,
                enabledSearch: true,
                showErrorMessage: false,
                errorMessage: '',
                filters: {
                    name: '',
                    address: '',
                    pib: '',
                    pdv: '',
                    isActive: '',
                },
                selectedLetter: null,
                letters: [],
                partners: [],
                filteredPartners: [],
            }
        },
        methods: {
            search() {
                if (this.filteredPartners.length == 0) {
                    this.filteredPartners = this.partners
                }
                this.partners = this.filteredPartners
                Object.keys(this.filters).forEach(val => {
                    if (this.filters[val] == "") {
                        return;
                    }
                    this.partners = this.partners.filter(item => {
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
                })
            },
            updateSelected(item){
                let id = this.findPartnerById(item.id);
                if(id==-1){
                    this.selected.push(item)
                    return;
                }else{
                    this.selected.splice(id,1)
                    return;
                }
            },
            findPartnerById(id){
                if(this.selected.length>0){
                    for (let i = 0; i < this.selected.length; i++) {
                    if (this.selected[i].id == id) {
                        return i;
                    }
                }
                return -1;
                }else{
                    return -1;
                }
            },
            select(item) {
                this.selected = item
                this.selectedId=item.id
            },
            readPartners() {
                this.partners = [];
                this.tableDataLoading = true;
                // this.showLoading = true
                axios.get('/api/partners').then(({data}) => {
                    this.partners = data;
                    this.filteredPartners = this.partners;

                    if (data.length == 0) {
                        this.tableDataLoading = false;
                        this.errorMessage = 'No data';
                        this.showErrorMessage = true;
                    } else {
                        this.tableDataLoading = false;
                        this.enabledSearch = true;
                    }
                    // this.enabledRefresh = true;
                    // this.showLoading = false
                }).catch(error => {
                    console.error("READ PARTNERS", error);
                    this.tableDataLoading = false
                    if (error.response == undefined) {
                        this.errorMessage = 'Timeout'
                    } else {
                        this.errorMessage = 'Error loading data'
                    }
                    // this.showLoading = false
                    this.showErrorMessage = true
                    // this.enabledRefresh = true;
                })
            }
            ,
            refresh(isReset) {
                if (this.filteredPartners.length == 0) {
                    this.filteredPartners = this.partners
                }
                Object.keys(this.filters).forEach(f => {
                    this.filters[f] = ''
                });
                if (isReset) {
                    this.partners = this.filteredPartners
                } else {
                    this.readPartners();
                }
            }
            ,
            addSuperior() {
                this.$emit('addSuperior', this.selected)
                this.closeDialog()
                this.selectedId=-1
                this.selected=[]
            }
            ,
            closeDialog() {
                this.readPartners();
                this.$emit('closeDialogChoosePartners', false)
            }
            ,
        },
        created() {
            this.readPartners();
        },
        computed: {
            headers() {
                return [
                    {
                        text: this.$t('partners.name'),
                        name: 'name',
                        align: 'left',
                        sortable: true,
                        value: 'name'
                    },
                    {text: this.$t('partners.address'), name: 'address', align: 'left', value: 'address'},
                    {text: this.$t('partners.pib'), name: 'pib', align: 'left', value: 'pib'},
                    {text: this.$t('partners.pdv'), name: 'pdv', align: 'left', value: 'pdv'},
                    {text: this.$t('partners.active'), name: 'active', align: 'left', value: 'isActive'},
                    {text: this.$t('partners.type'), name: 'type', align: 'left', value: 'partner_type.name'},
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
    }
</script>

<style scoped/>
