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
                <v-col cols="6">
                  <v-text-field
                    v-model="form.contract_name"
                    :label="$t(translation+'.contract_name')+'*'" required
                    :rules="rules.required"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    v-model="form.number_of_recordings"
                    :label="$t(translation+'.no')+'*'" required
                    :rules="rules.positive_number"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="6">
                  <v-menu
                    v-model="dateFrom"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="form.dateFrom"
                        :label="$t(translation+'.dateFrom')+'*'"
                        readonly
                        :rules="rules.required"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker :max="form.dateTo" v-model="form.dateFrom" @input="dateFrom = false"></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="6">
                  <v-menu
                    v-model="dateTo"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="form.dateTo"
                        :label="$t(translation+'.dateTo')+'*'"
                        readonly
                        :rules="rules.required"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker :min="form.dateFrom" v-model="form.dateTo" @input="dateTo = false"></v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
          <small>{{$t('required_fields')}}</small>
        </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">{{$t('close')}}</v-btn>
          <v-btn color="blue darken-1" text :loading="loading" @click="edit(api,dataForModal)">{{$t('edit')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!---------------------------------- Add Partner Dialog  ----------------------------------------->
    <dialog-choose-partners
      :singleSelect="singleSelect"
      :dialogChoosePartners.sync="dialogChoosePartners"
      @closeDialogChoosePartners="dialogChoosePartners=false"
      @choosenPartners="choosenPartner"
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
    import ChoosePartners from "../licencePartners/ChoosePartners";

    export default {
        components: {
            'dialog-choose-partners': ChoosePartners,
        },
        props:{
            partnerId: '',
            editItemDialog: false,
            dataForModal: {},
        },
        name: "EditContract",
        data() {
            return {
                dateFrom:false,
                dateTo:false,
                dialogChoosePartners:false,
                singleSelect:true,
                translation: 'contracts',
                api: 'contract',
                loading: false,
                form: {
                    contract_name: "",
                    partner_id: this.partnerId,
                    dateFrom: "",
                    dateTo: "",
                    number_of_recordings: ""
                },
                rules: {
                    required: [
                        v => !!v || this.$t('validation.field'),
                    ],
                    positive_number: [
                        v => /^\d{1,}[.]\d{1,}$/.test(v) && v>0  || /^\d{1,}$/.test(v) && v>0  || "Morate unijeti pozitivan broj"
                    ],
                    required_date:[
                        v => !!v || this.$t('validation.field'),
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
            edit,
            choosenPartner(item){
                this.form.name = item.name;
                this.form.partner_id = item.id;
            },
            closeDialog() {
                this.form = {
                    contract_name: "",
                    partner_id: "",
                    dateFrom: "",
                    dateTo: "",
                    number_of_recordings: ""
                }
                this.$refs.form.resetValidation()
                this.$emit('close')
            },
        },
        watch:{
            editItemDialog: function (val) {
                if (val) {
                    this.form = {
                        contract_name: this.dataForModal.contract_name,
                        partner_id: this.partnerId,
                        dateFrom: this.dataForModal.dateFrom,
                        dateTo: this.dataForModal.dateTo,
                        number_of_recordings: this.dataForModal.number_of_recordings
                    }
                }
            },
        },
    }
</script>

<style scoped/>
