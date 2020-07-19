<template>
    <v-row justify="end" class="mr-0">
        <v-dialog persistent v-model="dialog" max-width="600px">

            <v-card>
                <v-card-title>
                    <span class="headline">{{$t('edit_user_info')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-on:submit.prevent>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="dataForModal.password"
                                            :label="$t('user_info.password')"
                                            type="password"
                                            :rules="rules.required_length"
                                    />
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                            v-model="dataForModal.confirmPassword"
                                            :label="$t('user_info.password_again')"
                                            type="password"
                                            :rules="rules.password_match"
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
                    <v-btn color="blue darken-1" text :loading="loading" @click="editUser">{{$t('edit')}}
                    </v-btn>
                </v-card-actions>
            </v-card>

        </v-dialog>
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
    </v-row>
</template>

<script>
    import axios from 'axios';
    import i18n from '../../lang/lang'

    export default {

        name: "Edit-user-details",
        props: {
            dataForModal: {},
            dialog: false
        },
        data() {
            return {
                snackbar: {
                    color: 'error',
                    show: false,
                    text: '',
                    timeout: 5000,
                },
                form: {
                    name: this.dataForModal.name,
                    username: this.dataForModal.username,
                    language: this.dataForModal.language,
                    password: this.dataForModal.password,
                    confirmPassword: this.dataForModal.confirmPassword,
                },
                rules: {
                    required: [v => !!v || this.$t('validation.field')],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v === '' || this.dataForModal.password.length >= 8 || this.$t('short_password')
                    ],
                    password_match: [
                        v => v === this.dataForModal.password || this.$t('validation.password_match')
                    ],
                },
                formError: {},
                loading: false,
                alert: false,
            }
        },
        methods: {

            editUser() {

                if (this.$refs.form.validate()) {
                    this.loading = true
                    axios.post('/api/userUpdate', {
                        name: this.dataForModal.name,
                        username: this.dataForModal.username,
                        language_id: this.dataForModal.language.id,
                        password: this.dataForModal.password,
                    })
                        .then((response) => {
                            let data = {
                                response: response.data,
                                language: this.dataForModal.language,
                            }
                            this.$emit('editedUser', data)

                            this.closeDialog();
                            this.changeLocale(data.language.value)
                            this.snackbar.color = 'success',
                                this.snackbar.text = this.$t('edit_success')
                            this.snackbar.show = true;
                            this.loading = false
                        })
                        .catch(error => {
                            if (error.response.status == 422) {
                                this.loading = false
                                this.$swal.fire({
                                    type: 'error',
                                    title: this.$t('validation.error'),
                                    text: this.$t('validation.unique_username'),
                                })
                            } else if (error.response.status == 401) {
                                this.loading = false
                                this.$swal.fire({
                                    type: 'info',
                                    title: "Info",
                                    text: this.$t('validation.session'),
                                })
                                this.$router.push('/login')
                            } else {
                                this.loading = false
                                this.$swal.fire({
                                    type: 'error',
                                    title: this.$t('validation.error'),
                                    text: this.$t('validation.error'),
                                })
                            }
                        })
                } else {
                    this.snackbar.color = "error"
                    this.snackbar.text = this.$t('snackbar_required')
                    this.snackbar.show = true;
                }
            },
            changeLocale(locale) {
                i18n.locale = locale;
            },
            resetForm() {
                this.form.name = this.dataForModal.name,
                    this.form.username = this.dataForModal.username,
                    this.form.language = this.dataForModal.language,
                    this.form.password = this.dataForModal.password,
                    this.form.confirmPassword = this.dataForModal.confirmPassword
            },
            closeDialog() {
                this.formError = {}
                this.resetForm()
                this.$refs.form.resetValidation()
                this.$emit('closeEditUserDetailsDialog', false)
            },
        },
    }
</script>

<style scoped/>
