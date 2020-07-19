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
    import {edit, readWorkerTypesActive} from "../../statics/DataTableFunctions";

    export default {
        props: {
            editItemDialog: false,
            dataForModal: {},
        },
        name: "EditWorker",
        data() {
            return {
                translation: 'workers',
                api: 'workers',
                workerType: '',
                workerTypes: [],
                loading: false,
                form: {
                    name: '',
                    surname: '',
                    worker_types: null,
                },
                rules: {
                    required: [
                        v => !!v || this.$t('validation.field'),
                    ],
                    required_array: [
                        v => v.length>0 || this.$t('validation.field'),
                    ],
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
        watch: {
            editItemDialog: function (val) {
                if (val) {
                    this.workerType = this.dataForModal.worker_type;
                    this.form = {
                        name: this.dataForModal.name,
                        surname: this.dataForModal.surname,
                        worker_types: [],
                    }
                    for (let i=0; i<this.dataForModal.worker_type_worker.length; i++){
                        this.form.worker_types.push(this.dataForModal.worker_type_worker[i].worker_type)
                    }

                }
            },
        },
        created() {
            this.readWorkerTypesActive();
        }
    }
</script>

<style scoped/>
