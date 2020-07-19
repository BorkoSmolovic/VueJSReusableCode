<template>
    <v-row justify="end">
        <v-dialog persistent v-model="editFacilityDialog" max-width="600px">
            <v-card v-if="editFacilityDialog">
                <v-card-title>
                    <span class="headline">{{$t('facilities.edit_facility')}}</span>
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
                    <v-btn color="blue darken-1" text :loading="loading" @click="editFacility">{{$t('edit')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-row>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Edit-facility",
        props: {
            itemForFacility: {},
            editFacilityDialog: false,
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
                form: {
                    name: '',
                    address: '',
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
            editFacility() {
                this.formError = {}
                if (!this.$refs.form.validate()) {
                    this.alert = true
                    return;
                }
                this.loading = true;
                axios.put('/api/facility/' + this.itemForFacility.id, this.form).then((response) => {
                    this.alert = false
                    this.loading = false;
                    this.$emit('editFacility', response.data)
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
                this.$emit('close', false)
            }
            ,
        },
        watch:{
            editFacilityDialog: function (val) {
                if (val) {
                    this.form = {
                        name: this.itemForFacility.name,
                        address: this.itemForFacility.address,
                    }
                }
            },
        },


    }
</script>

<style scoped/>
