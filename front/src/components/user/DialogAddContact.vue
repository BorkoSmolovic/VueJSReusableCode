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
                    v-model="form.contact"
                    :label="$t(translation+'.contact')+'*'" required
                    :rules="rules.required_length"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="12">
                  <v-combobox
                    v-model="contactType"
                    :items="contactTypes"
                    @change="form.contact_type_id = contactType.id"
                    :rules="rules.required"
                    :label="$t(translation+'.contactType')+'*'"
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
    import {add, readContactTypesActive} from "../../statics/DataTableFunctions";

    export default {
        props: {
            addItemDialog: false,
            partnerId: null,
        },
        name: "AddContact",
        data() {
            return {
                translation: 'contacts',
                api: 'contact',
                loading: false,
                contactType: null,
                contactTypes: [],
                form: {
                    contact: '',
                    contact_type_id: '',
                    partner_id: this.partnerId,
                },
                rules: {
                    required: [
                        v => !!v || this.$t('validation.field'),
                    ],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v == '' || v.length > 1 || this.$t(this.translation + '.validation')
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
            readContactTypesActive,
            closeDialog() {
                this.$refs.form.resetValidation()
                this.contactType = null;
                this.form.contact = '';
                this.form.contact_type_id = '';
                this.$emit('close')
            },
        },
        created() {
            this.readContactTypesActive()
        },
    }
</script>

<style scoped/>
