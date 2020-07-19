<template>
    <v-row justify="end" class="mr-0">
        <v-dialog persistent v-model="editItemDialog" max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{$t(translation+'.edit')}}</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-form ref="form" v-on:submit.prevent>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.name"
                                            :label="$t(translation+'.name')+'*'" required
                                            :rules="rules.required"
                                            autocomplete="off"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="form.username"
                                                  :label="$t(translation+'.username')+'*'"
                                                  :rules="rules.required"
                                                  required
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.password"
                                            :label="$t(translation+'.password')"
                                            type="password"
                                            required
                                            :rules="form.password != undefined ? (form.password.length > 0 ? rules.required_password_length : []) : []"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                            v-model="form.confirmPassword"
                                            :label="$t(translation+'.password_again')"
                                            type="password"
                                            required
                                            :rules="form.confirmPassword != undefined ? (form.confirmPassword.length > 0 ? rules.password_match : []) : []"
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-switch
                                            v-model="isPartner"
                                            :label="$t(translation+'.superior_partner')"
                                            type="text"
                                    ></v-switch>
                                </v-col>
                                <v-col v-if="showFields" cols="9" px-2>
                                    <v-text-field v-if="isPartner"
                                                  readonly
                                                  v-model="form.partner == null ? '' : form.partner.name"
                                                  :label="$t(translation+'.superior_partner')"
                                                  type="text"
                                    ></v-text-field>
                                </v-col>
                                <v-col v-if="this.form.partner != null && isPartner" xs1 px-2 pt-2
                                       justify-center>
                                    &nbsp
                                    <v-btn @click="dialogChooseItem=true" icon class="success white--text">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                    &nbsp
                                    <v-btn @click="cleanPartner" icon class="error white--text">
                                        <v-icon>mdi-minus</v-icon>
                                    </v-btn>
                                </v-col>
                                <v-col v-else-if="showFields && isPartner" xs1 pt-2 px-2 justify-center>
                                    <v-btn @click="dialogChooseItem=true" icon class="success white--text">
                                        <v-icon>mdi-plus</v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                    <small>{{$t('required_fields')}}</small>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">{{$t('close')}}</v-btn>
                    <v-btn color="blue darken-1" text :loading="loading" @click="edit(api,dataForModal)">
                        {{$t('edit')}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!---------------------------------- Add Partner Dialog  ----------------------------------------->
        <dialog-choose-item
                :singleSelect="singleSelect"
                :id="-1"
                :api="ChooseItemApi"
                :translation="ChooseItemTranslation"
                :headers="itemHeaders"
                :dialogChooseItem="dialogChooseItem"
                @close="dialogChooseItem=false"
                @addSuperior="choosenPartner"
        />
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
    import {edit} from "../../statics/DataTableFunctions";
    import ChooseItemDialog from "../licencePartners/ChooseItemDialog";

    export default {
        props: {
            editItemDialog: false,
            dataForModal: {},
        },
        components: {
            'dialog-choose-item': ChooseItemDialog,
        },
        name: "EditUser",
        data() {
            return {
                ChooseItemApi: 'partners',
                ChooseItemTranslation: 'partners',
                singleSelect: true,
                showFields: true,
                isPartner: false,
                dialogChooseItem: false,
                translation: 'users',
                api: 'users',
                loading: false,
                form: {
                    name: '',
                    username: '',
                    password: '',
                    confirmPassword: '',
                    partner: null,
                    partner_id: null,
                },
                rules: {
                    required: [
                        v => !!v || this.$t('validation.field')
                    ],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v === '' || v.length > 1 || this.$t(this.translation + '.validation')
                    ],
                    required_password_length: [
                        v => !!v || this.$t('validation.field'),
                        v => this.form.password != undefined && this.form.password.length >= 8 || this.$t('short_password')
                    ],
                    password_match: [
                        v => !!v || this.$t('validation.field'),
                        v => v === this.form.password || this.$t('validation.password_match')
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
            edit,
            cleanPartner() {
                this.form.partner = null;
                this.form.partner_id = null;
            },
            choosenPartner(item) {
                this.form.partner = item;
                this.form.partner_id = item.id;
            },
            closeDialog() {
                this.$refs.form.resetValidation()
                this.isPartner = false;
                this.form = {
                    name: '',
                    username: '',
                    password: '',
                    confirmPassword: '',
                    partner: {},
                    partner_id: null,
                }
                this.$emit('close')
            },
        },
        watch: {
            editItemDialog: function (val) {
                if (val) {
                    this.isPartner = this.dataForModal.partner == null ? false : true
                    this.form = {
                        name: this.dataForModal.name,
                        username: this.dataForModal.username,
                        partner: this.dataForModal.partner,
                        partner_id: this.dataForModal.partner == null ? null : this.dataForModal.partner.id,
                        password: '',
                    }
                }
            },
        },
        computed: {
            itemHeaders() {
                return [
                    {
                        text: this.$t(this.ChooseItemTranslation + '.name'),
                        name: 'name',
                        align: 'left',
                        sortable: true,
                        value: 'name'
                    },
                    {
                        text: this.$t(this.ChooseItemTranslation + '.address'),
                        name: 'address',
                        align: 'left',
                        value: 'address'
                    },
                    {
                        text: this.$t(this.ChooseItemTranslation + '.pib'),
                        name: 'pib',
                        align: 'left',
                        value: 'pib'
                    },
                    {
                        text: this.$t(this.ChooseItemTranslation + '.pdv'),
                        name: 'pdv',
                        align: 'left',
                        value: 'pdv'
                    },
                    {
                        text: this.$t(this.ChooseItemTranslation + '.active'),
                        name: 'active',
                        align: 'left',
                        value: 'isActive'
                    },
                    {
                        text: this.$t(this.ChooseItemTranslation + '.type'),
                        name: 'type',
                        align: 'left',
                        value: 'partner_type.name'
                    },
                    {text: this.$t('actions'), name: 'actions', align: 'center', value: 'actions'},
                ]
            },
        }
    }
</script>

<style scoped/>
