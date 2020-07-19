<template>
    <v-dialog v-if="dialogChooseItem" v-model="dialogChooseItem" persistent transition="dialog-bottom-transition">
        <v-container fluid grid-list-sm>
            <v-toolbar color="White">
                <v-toolbar-title class="headline">{{$t('drawer.'+translation)}}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn :loading="tableDataLoading" :disabled="tableDataLoading" color="warning"
                       @click="id == -1 ? readTableData(api) : readTableDataById(api,id)">
                    <v-icon>mdi-refresh</v-icon>
                </v-btn>
            </v-toolbar>
            <v-spacer></v-spacer>
            <v-data-table
                    :mobile-breakpoint="breakpoint"
                    :headers="headers"
                    :items="tableData"
                    :items-per-page="itemsPerPage"
                    :footer-props="{itemsPerPageOptions: [8,10,20,30,50]}"
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
                    <v-layout v-if="singleSelect" align-center justify-center>
                        <v-checkbox v-model="item.id==selectedId" @change="select(item)"/>
                    </v-layout>
                    <v-layout v-else align-center justify-center>
                        <v-checkbox v-model="item.id==selectedId" @change="updateSelected(item)"/>
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

            <v-card-actions class="white" align="right">
                <div class="flex-grow-1"></div>
                <v-btn class="mr-4" text color="primary" dark @click="addSuperior()">
                    {{$t('add')}}
                </v-btn>
                <v-btn class="mr-4" text color="primary" dark @click="closeDialog(-1)">
                    {{$t('close')}}
                </v-btn>
            </v-card-actions>
        </v-container>
    </v-dialog>
</template>

<script>
    import {
        addEmit,
        editEmit,
        findById,
        onDelete,
        readTableData,
        readTableDataById,
        refresh,
        search
    } from "../../statics/DataTableFunctions";

    export default {
        props: {
            id: '',
            translation: null,
            api: null,
            headers: null,
            singleSelect: '',
            dialogChooseItem: ''
        },
        name: "ChooseItemDialog",
        data() {
            return {
                selectedId: -1,
                selected: [],
                addedPartners: [],
                defaultActive: '',
                deleteLoadingId: -1,
                breakpoint: 500,
                dataForModal: {},
                addItemDialog: false,
                editItemDialog: false,
                tableDataLoading: false,
                tableData: [],
                filteredTableData: [],
                filters: {
                    isActive: '',
                },
                itemsPerPage: 8,
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
            readTableDataById,
            addEmit,
            editEmit,
            updateSelected(item) {
                let id = this.findPartnerById(item.id);
                if (id == -1) {
                    this.selected.push(item)
                    return;
                } else {
                    this.selected.splice(id, 1)
                    return;
                }
            },
            select(item) {
                if (this.selected == item ||
                    this.selectedId == item.id) {
                    this.selectedId = -1;
                    this.selected = [];
                    return;
                }
                this.selected = item
                this.selectedId = item.id
            },
            addSuperior() {
                if (this.selected == [] || this.selectedId == -1) {
                    this.$swal.fire({
                        type: 'info',
                        title: 'Info',
                        text: "Morate odabrati stavku",
                    })
                    return
                }
                this.$emit('addSuperior', this.selected)
                this.closeDialog()
                this.selectedId = -1
                this.selected = []
            },
            openEditDialog(item) {
                this.editItemDialog = true;
                this.dataForModal = item;
            },
            closeDialog(num) {
                this.$emit('close', num)
            },
        },
        watch: {
            dialogChooseItem: function (val) {
                if (val) {
                    if(this.id == -1){
                        this.readTableData(this.api)
                    } else{
                        this.readTableDataById(this.api,this.id)
                    }

                }
            },
        },
        computed: {
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
