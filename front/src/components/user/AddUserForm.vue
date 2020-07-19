<template>
    <!-- ============= DIALOG ADD =============== -->
    <v-dialog v-model="dialogAdd" persistent max-width="900px">
        <template>
            <v-btn color="success" dark v-on="on">DODAJ KORISNIKA</v-btn>
        </template>
        <v-card>
            <!-- ========== Input FORM ============= -->
            <v-form ref="form" v-on:submit.prevent>
                <v-layout row wrap>
                    <v-flex xs12 sm12 md6>
                        <v-card-title class="ma-2">
                            <span class="headline">{{$t('partner_add')}}</span>
                        </v-card-title>
                        <v-card-text class="pa-0">
                            <v-container class="pt-0" grid-list-md>
                                <v-layout wrap>
                                    <!-- ## Country ## -->
                                    <v-flex xs12>
                                        <v-combobox
                                                v-model="form.country"
                                                item-text="name"
                                                item-value="id"

                                                :items="countries"
                                                :label="$t('partner_info.country')"
                                        ></v-combobox>
                                    </v-flex>
                                    <!-- ## City ## -->
                                    <v-flex xs12>
                                        <v-combobox
                                                v-model="form.city"
                                                item-text="name"
                                                item-value="id"
                                                :disabled="disabledCity"

                                                :items="cities"
                                                :label="$t('partner_info.city')"
                                        ></v-combobox>
                                    </v-flex>
                                    <!-- ## Partner name ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.name" :error-messages="formError.name" :label="$t('partner_info.name')+'*'" :rules="rules.required" required></v-text-field>
                                    </v-flex>
                                    <!-- ## address ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.address"  :label="$t('partner_info.address')" ></v-text-field>
                                    </v-flex>
                                    <!-- ## Contact person ##  -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.contact_person" :label="$t('partner_info.contact_person')"></v-text-field>
                                    </v-flex>
                                    <!-- ## Phone ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.phone" :label="$t('partner_info.phone')"></v-text-field>
                                    </v-flex>
                                    <!-- ## EMAIL ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.email"  :label="$t('partner_info.email')"  type="email"></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-flex>
                    <v-flex xs12 sm12 md6>
                        <v-card-title class="ma-4">
                            <span class="headline"></span>
                        </v-card-title>
                        <v-card-text class="pa-0">
                            <v-container class="pt-0" grid-list-md>
                                <v-layout row wrap>
                                    <!-- ## Account number ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.account_no"  :label="$t('partner_info.account_no')" ></v-text-field>
                                    </v-flex>
                                    <!-- ## Pib ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.pib" :error-messages="formError.pib" :label="$t('partner_info.pib')+'*'" :rules="rules.required" required></v-text-field>
                                    </v-flex>
                                    <!-- ## PDV ## -->
                                    <v-flex xs12>
                                        <v-text-field v-model="form.pdv" :label="$t('partner_info.pdv')"></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-flex>
                </v-layout>
                <!-- ======= TEXT-> required ====== -->
                <small class="pl-4">{{$t('required_fields')}}</small>
                <!-- ## ALERT ## -->
                <v-alert  v-model="alert" dismissible type="error"> {{ $t('validation.error_form') }}</v-alert>
                <!-- Actions -->
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" :disabled="loading" @click="closeDialog()" flat>{{$t('close')}}</v-btn>
                    <v-btn color="blue darken-1" :disabled="loading" flat @click="addPartner()">{{$t('save')}}</v-btn>
                    <v-progress-circular v-if="loading" indeterminate color="primary"></v-progress-circular>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script>
    import axios from 'axios/index'

    export default {
        data: function () {
            return {
                // -> FORM
                form: {
                    sifdob: '',
                    name: '',
                    address: '',
                    city: null,
                    country: null,
                    contact_person: '',
                    phone: '',
                    email: '',
                    account_no: '',
                    pib: '',
                    pdv: ''
                },
                // -> Validation
                rules: {
                    required: [(v) => !!v || this.$t('validation.field')],
                    email: [(v) => !!v || this.$t('validation.field'), (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || this.$t('validation.email')
                    ]
                },
                formError: {},
                loading: false,
                alert: false,
                // -> DIALOG
                dialogAdd: false,
                // -> City, Country
                disabledCity: true,
                countries: [],
                cities: []
            }
        },
        methods: {
            async addPartner() {
                this.formError = {}
                if (this.$refs.form.validate()) {
                    try {
                        this.loading = true;
                        const {data} = await axios.post('/api/partners', this.form)
                        this.loading = false;
                        this.alert = false
                        this.$emit('close')
                        this.closeDialog();
                    } catch (error) {
                        console.error("PARTNER ADD", error);
                        if (error.response.status === 422) {
                            for (var key in error.response.data.errors) {
                                this.formError[key] = error.response.data.errors[key][0]
                            }
                            this.alert = true
                        }
                        this.loading = false;
                    }
                } else {
                    this.alert = true
                }
            },
            // ====== CLose DIALOG ========
            closeDialog() {
                this.formError = {}
                this.$refs.form.reset()
                this.$refs.form.resetValidation()
                this.dialogAdd = false
            },
            // ======= READ COUNTRY ========
            readCountries() {
                axios.get('/api/countries').then(({data}) => {
                    data.forEach(country => {
                        this.countries.push({id: country.id, name: country.name})
                    })
                })
            },
            // ======= READ CITY ========
            readCities(id) {
                this.cities = []
                axios.get('/api/city').then(({data}) => {
                    data.forEach(city => {
                        if (id === city.country_id) {
                            this.cities.push({id: city.id, name: city.name, post_code: city.post_code, country_id: city.country_id})
                        }
                    })
                    if (this.cities.length === 0) this.disabledCity = true
                })
            }
        },
        watch: {
            'form.country': function (val) {
                if (val != null) {
                    this.disabledCity = false
                    this.form.city = null
                    this.readCities(val.id);
                }
            }
        },
        created() {
            this.readCountries()
        }
    }
</script>

<style lang="css" scoped>
</style>
