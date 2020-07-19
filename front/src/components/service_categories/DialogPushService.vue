<template>
    <v-row justify="end" class="mr-0">
        <v-dialog v-model="pushServiceDialog" persistent max-width="750">
            <v-card>
                <v-card-title dark>
                    <span class="headline">{{$t('service.service_add')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" v-on:submit.prevent>
                        <v-container row>
                            <v-flex xs12 px-2>
                                <v-text-field v-model="form.name"
                                              :label="$t('services.service_name')+'*'"
                                              :rules="rules.required"
                                              required/>
                            </v-flex>
                            <v-flex xs12 sm6 px-2>
                                <v-text-field v-model="form.quantity"
                                              :label="$t('services.service_quantity')"/>
                            </v-flex>
                            <v-flex v-if="showFields" xs12 sm6 px-2>
                                <v-text-field v-model="form.price"
                                              :label="$t('services.price')+'*'"
                                              :rules="rules.required"
                                              required
                                />
                            </v-flex>
                            <v-flex xs12 sm6 px-2>
                                <v-text-field v-model="form.tax"
                                              :label="$t('services.service_tax')+'*'"
                                              type="text"
                                              :rules="rules.required"
                                              required/>
                            </v-flex>
                        </v-container>
                    </v-form>
                    <small>{{$t('required_fields')}}</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="blue darken-1" text @click="closeDialog">{{$t('close')}}</v-btn>
                    <v-btn color="blue darken-1" type="submit" text :loading="addPartnerLoader" @click="addService">
                        {{$t('add')}}
                    </v-btn>
                </v-card-actions>
            </v-card>
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
    import axios from 'axios'

    export default {
        name: "Add-partner",
        props: {
            pushServiceDialog: false,
            serviceData: {}
        },
        data() {
            return {
                singleSelect:true,
                dialogAddLicensePartners:false,
                showFields: false,
                snackbar: {
                    color: 'error',
                    show: false,
                    text: this.$t('snackbar_required'),
                    timeout: 3000,
                },
                addPartnerLoader: false,
                addingPartner: false,
                contactTypes: [
                    /*  {contact_type_id: 1, name: 'Phone', icon: 'mdi-phone-outline'},
                      {contact_type_id: 2, name: 'Email', icon: 'mdi-email-outline'},*/
                ],
                contacts: [],
                form: {
                    index: serviceData.index,
                    id: serviceData.id,
                    price: serviceData.price,
                    quantity: 1,
                    name: serviceData.name,
                    tax: serviceData.tax,
                },
                rules: {
                    required: [(v) => !!v || this.$t('validation.field')],
                    emailRules: [
                        v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || this.$t('validation.email')
                    ]

                },
                formError: {},
                loading: false,
                alert: false,
                bank_accounts: [],
                contactIcons: [
                    {id: 1, icon: 'mdi-email-outline'},
                    {id: 2, icon: 'mdi-phone-outline'},

                ]
                // {id: '123', name: 'asdfasdfasdffsdaf'}
            }
        },
        methods: {
            getEmptyForm() {
                return {
                    index: '',
                    id: '',
                    price: '',
                    quantity: 1,
                    name: '',
                    tax: '',
                }
            },
            addService() {
                if (this.$refs.form.validate()) {
                    this.addPartnerLoader = true;
                    let data = {
                        id: this.form.phone === "" || this.form.partnerType.id === 1 ? null : this.form.phone,
                        index: this.form.partnerCode === "" ? null : this.form.partnerCode,
                        name: this.form.name,
                        tax: this.form.address,
                        price: this.form.pib,
                        pdv: this.form.pdv,
                    }
                } else {
                    this.snackbar.text = this.$t('snackbar_required');
                    this.snackbar.show = true;
                }
            },
            closeDialog() {
                document.getElementsByClassName('v-dialog--active')[0].scrollTop = 0
                this.formError = {}
                this.form = this.getEmptyForm();
                this.$refs.form.resetValidation()
                this.$emit('close', false)
            },
        }
    }
</script>

<style scoped/>
