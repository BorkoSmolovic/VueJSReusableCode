<template>
    <v-row justify="end">
        <v-dialog persistent v-model="dialogEdit" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline text-uppercase">{{$t('tax.edit_vat')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container v-if="dialogEdit">
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
                    <v-btn color="blue darken-1" text :loading="loading" @click="editVat">{{$t('edit')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
    import VueSweetalert2 from 'vue-sweetalert2';
    import axios from 'axios';

    export default {
        name: "Edit-vat",
        props: {
            vat: null,
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
                    required: [v => !!v || this.$t('validation.field')]

                },
                form : {
                    rate: this.vat.rate
                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {
            editVat() {
                this.formError = {}
                if (!this.$refs.form.validate()) {
                    this.alert = true
                    return;
                }
                this.loading = true;

                let data = {
                    rate: this.form.rate
                };

                axios.put('/api/vat/' + this.vat.id, data).then((response) => {
                    this.alert = false
                    this.loading = false;
                    this.$emit('update', response.data)
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
                this.$emit('update:dialogEdit', false)
            }
            ,
        },

    }
</script>

<style scoped/>
