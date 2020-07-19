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
                    v-model="form.account_number"
                    :label="$t(translation+'.number')+'*'" required
                    :rules="rules.required_length"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="12">
                  <v-combobox
                    v-model="bank"
                    :items="banks"
                    @change="form.bank_id = bank.id"
                    :rules="rules.required"
                    :label="$t(translation+'.bank')+'*'"
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
          <v-btn color="blue darken-1" text :loading="loading" @click="edit(api,dataForModal)">
            {{$t('edit')}}
          </v-btn>
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
    import {edit, readBanksActive} from "../../statics/DataTableFunctions";

    export default {
        props: {
            editItemDialog: false,
            dataForModal: {},
        },
        name: "EditBankAccount",
        data() {
            return {
                translation: 'bankAccounts',
                api: 'bankAccount',
                loading: false,
                bank: null,
                banks: [],
                form: {
                    account_number: '',
                    bank_id: '',
                    partner_id: this.partnerId,
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
            edit,
            readBanksActive,
            closeDialog() {
                this.$emit('close')
            },
        },
        watch: {
            editItemDialog: function (val) {
                if (val) {
                    this.bank = this.dataForModal.bank;
                    this.form = {
                        account_number: this.dataForModal.account_number,
                        bank_id: this.dataForModal.bank_id,
                        partner_id: this.partner_id
                    }
                }
            },
        },
        created() {
            this.readBanksActive();
        }
    }
</script>

<style scoped/>
