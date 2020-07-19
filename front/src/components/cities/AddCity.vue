<template>
    <v-row justify="end" class="mr-0">
        <v-dialog persistent v-model="addItemDialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{$t(translation+'.add')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-on:submit.prevent>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.name"
                                            :label="$t(translation+'.name')+'*'" required
                                            :rules="rules.required_length"
                                            autocomplete="off"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.post_code"
                                            :label="$t(translation+'.post_code')+'*'" required
                                            :rules="rules.required_length"
                                            autocomplete="off"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-combobox
                                            v-model="country"
                                            :items="countries"
                                            @change="form.country_id = country.id"
                                            :rules="rules.required"
                                            :label="$t(translation+'.country')+'*'"
                                            item-text="name"
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
                    <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">{{$t('close')}}</v-btn>
                    <v-btn color="blue darken-1" text :loading="loading" @click="add(api)">{{$t('add')}}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!---------------------------------- Snackbar  ----------------------------------------->
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
    import {add, readCountriesActive} from "../../statics/DataTableFunctions";

    export default {
        props: {
            addItemDialog: false,
        },
        name: "AddCity",
        data() {
            return {
                translation: 'cities',
                api: 'city',
                loading: false,
                country: '',
                countries: [],
                form: {
                    name: '',
                    post_code: '',
                    country_id: null,
                },
                rules: {
                    required: [
                        v => (v.id != null || v.id != undefined) || this.$t('validation.field'),
                    ],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v === '' || v.length > 1 || this.$t(this.translation+'.validation')
                    ],
                },
                snackbar: {
                    color: 'success',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
            }
        },
        methods: {
            add,
            readCountriesActive,
            closeDialog() {
                this.country = '';
                this.form = {
                    name: '',
                    post_code: '',
                    country_id: -1
                }
                this.$refs.form.resetValidation()
                this.$emit('close')
            },
        },
        created() {
            this.readCountriesActive()
        },
    }
</script>

<style scoped/>
