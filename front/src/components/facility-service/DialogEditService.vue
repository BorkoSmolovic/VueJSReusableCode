<template>
    <v-dialog v-model="DialogEditService" persistent width="800" transition="dialog-bottom-transition">
        <v-container fluid grid-list-sm>
            <v-toolbar color="White">
                <v-toolbar-title>{{$t('navigation_service_categories')}}</v-toolbar-title>
                <v-spacer/>
            </v-toolbar>
            <v-spacer></v-spacer>
            <v-spacer></v-spacer>
            <v-card>
                <v-form ref="form" v-on:submit.prevent>
                    <v-row v-if="DialogEditService" class="mx-4 px-4">
                        <v-col cols="12" align-center justify-center>
                            <v-text-field readonly v-model="form.name" :label="$t('service.service_name')"
                                          class="text-xs-right"></v-text-field>
                        </v-col>
                        <v-col cols="6" align-center justify-center>
                            <v-combobox
                                    :label="$t('service.service_tax')+'*'"
                                    :items="vats"
                                    item-value="id"
                                    item-text="rate"
                                    v-model="form.vat"
                                    :rules="rules.required"
                                    style="padding: 0;padding-top: 3%; font-size: inherit; text-align: right !important;"
                            >
                            </v-combobox>
                        </v-col>
                        <v-col cols="6" align-center justify-center>
                            <v-layout align-center justify-center>
                                <v-text-field :rules="rules.required" v-model="form.price" :label="$t('service.price')+'*'"
                                              class="text-xs-right"></v-text-field>
                            </v-layout>
                        </v-col>
                        <v-col cols="6" align-center justify-center>
                            <v-layout align-center justify-center>
                                <v-text-field :rules="rules.required" v-model="form.quantity" :label="$t('service.quantity')+'*'"
                                              class="text-xs-right"></v-text-field>
                            </v-layout>
                        </v-col>
                        <v-col cols="6" align-center justify-center>
                            <v-layout align-center justify-center>
                                <v-text-field v-model="form.note" :label="$t('service.note')"
                                              class="text-xs-right"></v-text-field>
                            </v-layout>
                        </v-col>
                        <v-col cols="6" align-center justify-center>
                            <v-combobox
                                    :items="payment_types"
                                    item-value="id"
                                    item-text="name"
                                    :rules="rules.required"
                                    @change="changePayment(form)"
                                    v-model="form.payment_type"
                                    style="padding: 0;padding-top: 3%; font-size: inherit; text-align: right !important;"
                            >
                            </v-combobox>
                        </v-col>
                        <v-col cols="6" align-center justify-center>
                            <v-layout align-center justify-center>
                                <v-text-field :rules="form.payment_type.id != 2 ? [] : rules.required " :disabled="form.payment_type.id != 2" :label="$t('service.duration')"
                                              v-model="form.duration"
                                              class="text-xs-right"></v-text-field>
                            </v-layout>
                        </v-col>
                    </v-row>
                </v-form>

            </v-card>
            <v-card>
                <v-card-actions class="white" align="right">
                    <div class="flex-grow-1"></div>
                    <v-btn class="mr-4" text color="primary" dark @click="editService()">
                        {{$t('edit')}}
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
            service: {},
            DialogEditService: false,
        },
        name: "DialogEditService",
        data: function () {
            return {
                form: {
                    id: null,
                    name: null,
                    vat: null,
                    price: null,
                    quantity: null,
                    note: null,
                    payment_type_id: null,
                    duration: null,
                    service_category_id: null,
                    vat_id: null,
                    payment_type: null,
                },
                rules: {
                    required: [(v) => !!v || this.$t('validation.field')],
                },
                payment_type: 0,
                snackbar: {
                    color: 'error',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                itemsPerPage: 10,
                tableDataLoading: false,
                showLoading: true,
                showErrorMessage: false,
                errorMessage: 'Add services below',
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
                    {
                        text: this.$t('service.payment_type'),
                        name: 'paymentType',
                        align: 'left',
                        value: 'payment_type_id'
                    },
                    {text: this.$t('service.duration'), name: 'duration', align: 'left', value: 'duration'},
                    {text: this.$t('actions'), name: 'actions', align: 'center', value: 'actions'},
                ]
            },
        },
        watch: {
            'close': function (value) {
            },
            'form.partnerType': function (val) {
                if (val == null) return;
                if (val.id === 2) {
                    this.showFields = true
                } else {
                    this.showFields = false
                }
            },
            DialogEditService: function (val) {
                if (val) {
                    this.form = {
                        id: this.service.service_category === undefined ? '' : this.service.id,
                        name: this.service.service_category === undefined ? '' : this.service.service_category.name,
                        vat: this.service.service_category === undefined ? '' : this.service.vat,
                        price: this.service.service_category === undefined ? '' : this.service.price,
                        quantity: this.service.service_category === undefined ? '' : this.service.quantity,
                        note: this.service.service_category === undefined ? '' : this.service.note,
                        payment_type_id: this.service.service_category === undefined ? '' : this.service.payment_type.id,
                        duration: this.service.service_category === undefined ? '' : this.service.duration,
                        service_category_id: this.service.service_category === undefined ? '' : this.service.service_category_id,
                        vat_id: this.service.service_category === undefined ? '' : this.service.vat.id,
                        payment_type: this.service.service_category === undefined ? '' : this.service.payment_type,
                    }
                }
            },
        },
        methods: {
            changePayment(item) {
                item.duration = null
            },
            editService() {
                if (!this.$refs.form.validate()) {
                    this.alert = true;
                    return;
                }
                let data = {
                    price: this.form.price,
                    vat_id: this.form.vat.id,
                    payment_type: this.form.payment_type.id,
                    duration: this.form.duration,
                    quantity: this.form.quantity,
                    note: this.form.note
                }
                axios.put('/api/facilityServiceCategory/' + this.service.id, data)
                    .then((response) => {
                        this.$emit('editService', response.data[0])
                    })
                    .catch(function (error) {
                    });
                this.close()
            },
            getItemIndexById(id) {
                for (let i = 0; i < this.tree.length; i++) {
                    if (this.tree[i].service_category_id == id) {
                        return i;
                    }
                }
                return -1;
            },
            close() {
                this.$emit('close', false)
            },
        },
    }
</script>

<style scoped/>
