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
                    v-model="form.surname"
                    :label="$t(translation+'.surname')+'*'" required
                    :rules="rules.required_length"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="12">
                  <v-combobox
                    v-model="form.worker_types"
                    :items="workerTypes"
                    :rules="rules.required_array"
                    :multiple="true"
                    :label="$t(translation+'.worker_type')+'*'"
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
  import {add, readWorkerTypesActive} from "../../statics/DataTableFunctions";

  export default {
    props: {
      addItemDialog: false,
    },
    name: "AddWorker",
    data() {
      return {
        translation: 'workers',
        api: 'workers',
        loading: false,
        workerType: '',
        workerTypes: [],
        form: {
          name: '',
          surname: '',
          worker_types: null,
        },
        rules: {
          required: [
            v => !!v || this.$t('validation.field'),
          ],
          required_length: [
            v => !!v || this.$t('validation.field'),
            v => v === '' || v.length > 1 || this.$t(this.translation + '.validation')
          ],
          required_array: [
            v => v != null ? v.length > 0 : "" || this.$t('validation.field'),
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
      readWorkerTypesActive,
      closeDialog() {
        this.workerType = '';
        this.form = {
          name: '',
          surname: '',
          worker_types: []
        }
        this.$refs.form.resetValidation()
        this.$emit('close')
      },
    },
    created() {
      this.readWorkerTypesActive()
    },
  }
</script>

<style scoped/>
