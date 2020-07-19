<template>
    <v-row justify="end">
        <v-dialog persistent v-if="dialogEdit" v-model="dialogEdit" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{$t('warehouses.edit_warehouse')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container v-if="dialogEdit">
                        <v-form ref="form" v-on:submit.prevent>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.name"
                                            :label="$t('warehouses.name')+'*'" required
                                            :rules="rules.required_length"
                                            autocomplete="off"
                                    />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.address"
                                            :label="$t('warehouses.address')+'*'" required
                                            :rules="rules.required_length"
                                            autocomplete="off"
                                    />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <v-combobox
                                            v-model="form.city"
                                            :items="editData.cities"
                                            :rules="rules.required"
                                            :label="$t('warehouses.city')+'*'"
                                            item-text="name"
                                    />
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                    <small>{{$t('required_fields')}}</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="blue darken-1" text @click="closeDialog">{{$t('close')}}</v-btn>
                    <v-btn color="blue darken-1" text :loading="loading" @click="editWarehouse">{{$t('edit')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-row>
</template>

<script>
    import VueSweetalert2 from 'vue-sweetalert2';
    import axios from 'axios';

    export default {
        name: "Edit-warehouse",
        props: {
            editData: null,
            dialogEdit: false
        },
        data() {
            return {
                color: '',
                mode: '',
                snackbar: false,
                text: 'Hello, I\'m a snackbar',
                timeout: 6000,
                x: null,
                y: 'top',
                dialog: this.dialogEdit,
                rules: {
                    required: [v => !!v || this.$t('validation.field')],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v == '' || v.length > 1 || this.$t('cities.validation')
                    ],

                },
                form : {
                    name: this.editData.warehouse_data.name,
                    address: this.editData.warehouse_data.address,
                    city: this.editData.warehouse_data.city
                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {
            editWarehouse() {
                this.formError = {}
                if (!this.$refs.form.validate()) {
                    this.alert = true
                    return;
                }
                this.loading = true;

                let data = {
                    name: this.form.name,
                    address: this.form.address,
                    city_id: this.form.city.id
                };

                axios.put('/api/warehouse/' + this.editData.warehouse_data.id, data).then((response) => {
                    this.alert = false
                    this.loading = false;
                    this.$emit('editWarehouse', response.data)
                    this.closeDialog();
                }).catch(error => {
                    this.loading = false
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: error,
                    })
                })
            },
            closeDialog() {
                this.formError = {}
                this.$refs.form.resetValidation()
                this.$refs.form.reset()
                this.$emit('closeEditDialog', false)
            }
            ,
        },

    }
</script>

<style scoped/>
