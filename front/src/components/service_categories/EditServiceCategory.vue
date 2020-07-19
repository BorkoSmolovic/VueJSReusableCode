<template>
    <v-row
            class="mr-0"
            justify="end"
    >
        <v-dialog
                max-width="600px"
                persistent
                v-if="editServiceCategoryDialog"
                v-model="editServiceCategoryDialog"
        >
            <v-card>
                <v-card-title>
                    <span v-if="editData.isItem==0" class="headline">{{$t('service_categories_edit')}}</span>
                    <span v-else class="headline">{{$t('service_categories_service_edit')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form v-if="editData.isItem==0"
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
                                            v-model="editData.name"
                                    />
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-form v-else-if="editData.isItem==1"
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
                                            v-model="editData.name"
                                    />
                                    <v-combobox
                                            :items="comboboxData"
                                            item-value="id"
                                            item-text="rate"
                                            v-model="editData.vat"
                                            :label="$t('service.service_tax')+'*'"
                                            :rules="rules.required"
                                            required
                                    >

                                    </v-combobox>
                                    <v-text-field
                                            :rules="rules.required"
                                            autocomplete="off"
                                            :label="$t('service.price')+'*'"
                                            required
                                            v-model="editData.price"
                                    />
                                    <v-combobox
                                            :items="paymentTypes"
                                            item-value="id"
                                            item-text="name"
                                            :label="$t('service.payment_type')+'*'"
                                            v-model="editData.payment_type"
                                            :rules="rules.required"
                                            required
                                    >
                                    </v-combobox>
                                    <v-switch
                                            v-model="editData.has_serial_number"
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
                            @click="editCategory"
                            color="blue darken-1"
                            text
                    >
                        {{ $t('edit') }}
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
            paymentTypes:null,
            editServiceCategoryDialog: false,
            editData: {},
            comboboxData: {},
        },
        name: 'EditServiceCategory',
        data() {
            return {
                form: {
                    name: this.editData.name,
                    isItem: this.editData.isItem,
                    vat_id: this.editData.vat_id,
                    service_category_id: this.editData.service_category_id,
                    price: this.editData.price,
                    payment_type: this.editData.payment_type,
                    hasSerialNumber: this.editData.has_serial_number,
                },
                rules: {
                    required: [v => !!v || this.$t('validation.field')],
                    cleanStart: [
                        v => !!v || this.$t('validation.field'),
                        v => !/^\d/.test(v) ||  this.$t('validation.cleanStart')
                    ],
                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {
            editCategory() {
                this.formError = {};
                if (!this.$refs.form.validate()) {
                    this.alert = true;
                    return
                }
                this.loading = true;
                let data = {
                    name: this.editData.name,
                    isItem: this.editData.isItem,
                    vat_id: this.editData.vat == null ? null : this.editData.vat.id,
                    service_category_id: this.editData.service_category_id,
                    price: this.editData.price,
                    payment_type_id: this.editData.payment_type == null ? null : this.editData.payment_type.id,
                    has_serial_number: this.editData.has_serial_number == null ? null : this.editData.has_serial_number,
                };
                axios.put('/api/serviceCategory/' + this.editData.id, data).then((response) => {
                    this.alert = false;
                    this.loading = false;
                    let data = {
                        oldItem: this.editData.item,
                        newItem: response.data,
                    }
                    this.$emit('editCategory', data);
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
                this.$refs.form.resetValidation();
                this.$emit('closeEditServiceDialog', false);
            },
        },
    }
</script>

<style scoped/>
