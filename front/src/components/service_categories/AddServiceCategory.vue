<template>
    <v-row
            class="mr-0"
            justify="end"
    >
        <v-dialog
                max-width="600px"
                persistent
                v-if="addServiceCategoryDialog"
                v-model="addServiceCategoryDialog"
        >
            <v-card>
                <v-card-title>
                    <span v-if="this.radioGroup === '1'" class="headline">{{$t('add_category')}}</span>
                    <span v-else class="headline">{{$t('add_service')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-radio-group @change="show=!show" v-if="addData!=null" v-model="radioGroup" :mandatory="true">
                        <v-radio
                                :label="$t('service.service_category')"
                                value="1"
                        ></v-radio>
                        <v-radio
                                :label="$t('service.service_item')"
                                value="0"
                        ></v-radio>

                    </v-radio-group>
                    <v-container>
                        <v-form v-if="show"
                                @submit.prevent
                                ref="form"
                        >
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            :rules="rules.cleanStart"
                                            autocomplete="off"
                                            :label="$t('service.category_name')+'*'"
                                            required
                                            v-model="form.service_category"
                                    />
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-form v-else-if="!show"
                                @submit.prevent
                                ref="form"
                        >
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            :rules="rules.cleanStart"
                                            autocomplete="off"
                                            :label="$t('service.service_name')+'*'"
                                            required
                                            v-model="form.service_category"
                                    />
                                    <v-combobox
                                            :items="comboboxData"
                                            item-value="id"
                                            item-text="rate"
                                            :label="$t('service.service_tax')+'*'"
                                            v-model="form.vat"
                                            :rules="rules.required"
                                            required
                                    >
                                    </v-combobox>
                                    <v-text-field
                                            :rules="rules.required"
                                            autocomplete="off"
                                            :label="$t('service.price')+'*'"
                                            required
                                            v-model="form.price"
                                    />
                                    <v-combobox
                                            :items="paymentTypes"
                                            item-value="id"
                                            item-text="name"
                                            :label="$t('service.payment_type')+'*'"
                                            v-model="form.payment_type_id"
                                            :rules="rules.required"
                                            required
                                    >
                                    </v-combobox>
                                    <v-switch
                                            v-model="form.hasSerialNumber"
                                            :label="$t('service.hasSerial')"
                                    ></v-switch>
                                </v-col>
                            </v-row>
                        </v-form>

                    </v-container>
                    <small>{{ $t('required_fields') }}</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"/>
                    <v-btn
                            @click="closeDialog"
                            color="blue darken-1"
                            text
                    >
                        {{ $t('close') }}
                    </v-btn>
                    <v-btn
                            :loading="loading"
                            @click="addCategory"
                            color="blue darken-1"
                            text
                    >
                        {{$t('add')}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
    import axios from 'axios'


    export default {
        props: {
            paymentTypes: null,
            addServiceCategoryDialog: false,
            addData: {},
            comboboxData: {},
        },
        name: 'AddCategory',
        data() {
            return {
                vat: [],
                show: true,
                radioGroup: '1',
                form: {
                    vat: null,
                    isItem: null,
                    service_category: '',
                    price: null,
                    payment_type_id: null,
                    hasSerialNumber: false,

                },
                rules: {
                    required: [v => !!v || this.$t('validation.field')],
                    cleanStart: [
                        v => !!v || this.$t('validation.field'),
                        v => !/^\d/.test(v) || this.$t('validation.cleanStart')
                    ],

                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {
            addCategory() {
                let data
                this.formError = {};
                if (!this.$refs.form.validate()) {
                    this.alert = true;
                    return
                }
                this.loading = true;
                if (this.addData === null) {
                    data = {
                        name: this.form.service_category,
                        isItem: 0,
                        vat_id: null,
                        service_category_id: null,
                        price: null,
                        payment_type_id: null,
                        has_serial_number: null,
                    };
                } else {
                    if (this.radioGroup === '1') {
                        data = {
                            name: this.form.service_category,
                            isItem: 0,
                            vat_id: null,
                            service_category_id: this.addData.service_category_id,
                            price: null,
                            payment_type_id: null,
                            has_serial_number: null,
                        };
                    } else {
                        data = {
                            name: this.form.service_category,
                            isItem: 1,
                            vat_id: this.form.vat.id,
                            service_category_id: this.addData.service_category_id,
                            price: this.form.price,
                            payment_type_id: this.form.payment_type_id.id,
                            has_serial_number: this.form.hasSerialNumber == undefined ? false : this.form.hasSerialNumber,
                        };
                    }
                }
                axios.post('/api/serviceCategory', data).then((response) => {
                    this.alert = false;
                    this.loading = false;
                    if (this.addData === null) {
                        this.$emit('pushCategory', null, response.data);
                    } else {
                        this.$emit('pushCategory', this.addData.item, response.data);
                    }
                    this.closeDialog()
                }).catch(error => {
                    this.loading = false;
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: error,
                    })
                })
            },
            closeDialog() {
                this.formError = {};
                this.form = {
                    vat: null,
                    isItem: null,
                    service_category: '',
                    price: null,
                    duration: null,
                };
                this.show = true
                this.radioGroup = '1'
                this.$refs.form.resetValidation();
                this.$emit('closeAddServiceDialog', false);
            },
        },
        created() {
        }
    }
</script>

<style scoped/>
