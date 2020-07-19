<template>
    <v-dialog v-model="addWarehouseDialog" persistent max-width="750">
        <v-card>
            <v-card-title dark>
                <span class="headLine">{{$t('warehouses.add_warehouse')}}</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-on:submit.prevenr>
                    <v-container row>
                        <v-flex xs12 px-2>
                            <v-text-field v-model="form.name"
                                          :label="$t('warehouses.name')+'*'"
                                          :rules="rules.required"
                                          required>
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 px-2>
                            <v-text-field v-model="form.address"
                                          :label="$t('warehouses.address')+'*'"
                                          :rules="rules.required">
                            </v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 px-2>
                            <v-combobox
                                    :rules="rules.required"
                                    required
                                    :items="cities"
                                    v-model="form.city"
                                    item-text="name"
                                    :label="$t('warehouses.city')+'*'">
                            </v-combobox>
                        </v-flex>
                    </v-container>
                </v-form>
                <small>{{$t('required_fields')}}</small>
            </v-card-text>
            <v-card-actions>
                <div class="flex-grow-1"></div>
                <v-btn color="blue darken-1" text @click="closeDialog">{{$t('close')}}</v-btn>
                <v-btn color="blue darken-1" type="submit" text :loading="addWarehouseLoader" @click="addWarehouse">
                    {{$t('add')}}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "AddWarehouse",
        props: {
            addWarehouseDialog: false,
            dataForModal: {}
        },
        components: {},
        data() {
            return {
                snackbar: {
                    color: 'error',
                    show: false,
                    text: this.$t('snackbar_required'),
                    timeout: 3000,
                },
                addWarehouseLoader: false,
                cities: [],
                form: {
                    name: '',
                    addres: '',
                    city: null,
                },
                rules: {
                    required: [(v) => !!v || this.$t('validation.field')],
                },
                formError: {},
            }
        },
        methods: {
            addWarehouse() {
                if (this.$refs.form.validate()) {
                    this.addWarehouseLoader = true;
                    let data = {
                        name: this.form.name,
                        address: this.form.address,
                        city_id: this.form.city.id,
                    };
                    axios({
                        url: 'api/warehouse',
                        method: 'POST',
                        data: data,
                        addWarehouseLoader: false,
                    }).then((response) => {
                        this.closeDialog(),
                        this.addWarehouseLoader = false,
                        this.$emit('addWarehouse', response.data)
                    }).catch(error => {
                        this.closeDialog(),
                            this.addWarehouseLoader = false,
                            this.$wal.fire({
                                type: 'error',
                                title: 'Error',
                                text: error,
                            })
                })
                }else {
                    this.snackbar.text = this.$t('snackbar_required');
                    this.snackbar.show = true;
                }
            },
            readCities() {
                axios({
                    url: '/api/city',
                    method: 'GET'
                }).then((response) => {
                    this.cities = response.data;
                }).catch(error => {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: error,
                    })
                })
            },
            getEmptyForm() {
                return {
                    name: '',
                    address: '',
                    city: null
                }
            },
            closeDialog() {
                this.showFields = false;
                document.getElementsByClassName('v-dialog--active')[0].scrollTop = 0
                this.formError = {}
                this.form = this.getEmptyForm();
                this.$refs.form.resetValidation()
                this.$emit('closeAddDialog', false)
            },
        },
        created() {
            this.readCities();
        }
    }
</script>

<style scoped/>
