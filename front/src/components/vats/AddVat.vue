<template>
    <v-row justify="end" class="mr-0">
        <v-dialog persistent v-model="dialog" max-width="600px">
            <template v-slot:activator="{ on }">
                <v-btn class="mr-4" color="primary" dark v-on="on" @click="dialog=true">{{$t('tax.add_vat')}}</v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline text-uppercase">{{$t('tax.add_vat')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-on:submit.prevent>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.rate"
                                            :label="$t('tax.rate')+'*'" required
                                            :rules="rules.required"
                                            autocomplete="off"
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
                    <v-btn color="blue darken-1" text :loading="loading" @click="addVat">{{$t('add')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
    import VueSweetalert2 from 'vue-sweetalert2';
    import axios from 'axios';

    export default {
        name: "Add-vat",
        props: {
            vats: null
        },
        data() {
            return {
                dialog: false,
                form: {
                    rate: ''
                },
                rules: {
                    required: [v => !!v || this.$t('validation.field')]

                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {
            addVat() {
                this.formError = {}
                if (!this.$refs.form.validate()) {
                    this.alert = true;
                    return;
                }
                this.loading = true;

                let data = {
                    rate: this.form.rate
                };

                axios.post('/api/vat', data).then((response) => {
                    this.alert = false
                    this.loading = false;
                    this.$emit('pushVat', response.data)
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
                this.form = {
                    rate: ''
                }
                this.$refs.form.resetValidation()
                this.dialog = false
            },
        }
    }
</script>

<style scoped/>
