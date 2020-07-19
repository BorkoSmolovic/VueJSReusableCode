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
                            <v-col>
                              <v-combobox
                                v-model="form.item"
                                :items="items"
                                @change="checkVehicle()"
                                :rules="rules.required"
                                :label="'Naziv'+'*'"
                                item-text="name"
                                autocomplete="off"
                              />
                              <div v-if="form.vehicle!=null && form.vehicle!=undefined">
                                {{'('+form.vehicle.type+','+form.vehicle.plates+')'}}
                              </div>
                            </v-col>
                            <v-col>
                              <v-text-field
                                :label="'Cijena'+'*'"
                                v-model="form.value"
                                :rules="rules.positive_number"
                                autocomplete="off"
                              />
                              <div v-if="form.item !=null && form.item.vehicle!=null" class="white--text ">&nbsp</div>
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
        <!---------------------------------- Add Vehicle Dialog  ----------------------------------------->
        <dialog-choose-item
                v-if="dataForModal != null"
                :id="'-1'"
                :singleSelect="singleSelectVehicle"
                :api="ChooseItemApiVehicle"
                :translation="ChooseItemTranslationVehicle"
                :headers="itemHeadersVehicle"
                :dialogChooseItem="dialogChooseItemVehicle"
                @close="closeVehicles"
                @addSuperior="choosenVehicle"
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
    import {edit, readItemsActive} from "../../statics/DataTableFunctions";
    import ChooseItemDialog from "../licencePartners/ChooseItemDialog";

    export default {
        components: {
            'dialog-choose-item': ChooseItemDialog,
        },
        props: {
            editItemDialog: false,
            dataForModal: null,
        },
        name: "EditWorker",
        data() {
            return {
                singleSelectVehicle: true,
                ChooseItemApiVehicle: 'vehicle',
                ChooseItemTranslationVehicle: 'vehicles',
                dialogChooseItemVehicle: false,
                currentItem: null,
                items: null,
                translation: 'items',
                api: 'evidentionItem',
                loading: false,
                form: {
                    evidention_id: '',
                    vehicle_id: null,
                    vehicle: null,
                    item: '',
                    item_id: '',
                    value: ''
                },
                rules: {
                    required: [
                        v => !!v || this.$t('validation.field'),
                    ],
                    positive_number: [
                        v => /^\d{1,}[.]\d{1,}$/.test(v) && v>0  || /^\d{1,}$/.test(v) && v>0  || "Morate unijeti pozitivan broj"
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
            readItemsActive,
            closeVehicles(number) {
                this.dialogChooseItemVehicle = false
                let value = this.form.value
                if (number == -1) {
                    this.form = {
                        evidention_id: '',
                        vehicle_id: null,
                        vehicle: null,
                        item: '',
                        item_id: '',
                        value: value
                    }
                }
            },
            checkVehicle() {
                this.form.vehicle = null;
                this.form.vehicle_id = null;
                let item = this.form.item;
                if(item !=  null){
                    this.currentItem = item;
                    this.form.item_id = item.id;
                    if (item.hasVehicles) {
                        this.dialogChooseItemVehicle = true;
                    }
                }
            },
            choosenVehicle(item) {
                this.form.vehicle = item;
                this.form.vehicle_id = item.id;
            },
            closeDialog() {
                this.country = '';
                this.form = {
                    evidention_id: '',
                    vehicle_id: null,
                    vehicle: null,
                    item: '',
                    item_id: '',
                    value: ''
                }
                this.$refs.form.resetValidation()
                this.$emit('close')
            },
        },
        watch: {
            editItemDialog: function (val) {
                if (val) {
                    this.form = {
                        evidention_id: this.dataForModal.evidention_id,
                        vehicle_id: this.dataForModal.vehicle_id,
                        vehicle: this.dataForModal.vehicle,
                        item: this.dataForModal.item,
                        item_id: this.dataForModal.item_id,
                        value: this.dataForModal.value,
                    }
                }
            },
        },

        created() {
            this.readItemsActive();
        },
        computed: {
            itemHeadersVehicle() {
                return [
                    {text: 'Tip', name: 'type', align: 'left', sortable: true, value: 'type'},
                    {text: 'Tablice', name: 'plates', align: 'left', sortable: true, value: 'plates'},
                    {text: this.$t('actions'), name: 'actions', align: 'center', sortable: false, value: 'actions'},
                ]
            },
        }
    }
</script>

<style scoped/>
