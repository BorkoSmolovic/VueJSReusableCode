<template>
    <v-row justify="end" class="mr-0">
        <v-dialog persistent v-model="addFacilityDialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{$t('facilities.add_facility')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-on:submit.prevent>
                            <v-row>

                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.name"
                                            :label="$t('facilities.name')+'*'" required
                                            :rules="rules.required_length"
                                            autocomplete="off"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.address"
                                            :label="$t('facilities.address')+'*'" required
                                            :rules="rules.required_length"
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
                    <v-btn color="blue darken-1" text :loading="loading" @click="addFacility">{{$t('add')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>
    import VueSweetalert2 from 'vue-sweetalert2';
    import axios from 'axios';

    export default {
        name: "Add-facility",
        props:{
            addFacilityDialog: '',
            partnerData: '',
        },
        data() {
            return {

                form: {
                    name: '',
                    address:'',
                },
                rules: {
                    required: [v => !!v || this.$t('validation.field')],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v == '' || v.length > 1 || this.$t('facilities.validation')
                    ],

                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {
            addFacility() {
                this.formError = {}
                if (!this.$refs.form.validate()) {
                    this.alert = true;
                    return;
                }
                this.loading = true;
                let tempFacility={
                    name: this.form.name,
                    address: this.form.address,
                    partner_id: this.partnerData.id
                }
                axios.post('/api/facility', tempFacility).then((response) => {
                    this.alert = false
                    this.loading = false;

                    this.$emit('pushFacility', response.data)
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
                    name: '',
                    address: '',
                }
                this.$emit('close',false);
                this.$refs.form.resetValidation()
            },
        }
    }
</script>

<style scoped/>
