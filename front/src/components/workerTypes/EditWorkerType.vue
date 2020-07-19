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
          <v-btn color="blue darken-1" text :disabled="loading" @click="closeDialog">{{$t('close')}}</v-btn>
          <v-btn color="blue darken-1" text :loading="loading" @click="edit(api,dataForModal)">{{$t('edit')}}</v-btn>
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
    import {edit} from "../../statics/DataTableFunctions";

    export default {
        props:{
            editItemDialog: false,
            dataForModal: {},
        },
        name: "EditWorkerType",
        data() {
            return {
                translation: 'worker_types',
                api: 'workerType',
                loading: false,
                form: {
                    name: '',
                },
                rules: {
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v == '' || v.length > 1 || this.$t(this.translation+'.validation')
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
            closeDialog() {
                this.form = {
                    name: ''
                }
                this.$refs.form.resetValidation()
                this.$emit('close')
            },
        },
        watch:{
            editItemDialog: function (val) {
                if (val) {
                    this.form = {
                        name: this.dataForModal.name,
                    }
                }
            },
        },
    }
</script>

<style scoped/>
