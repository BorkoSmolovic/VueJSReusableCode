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
                    v-model="form.worker_type"
                    :items="workerTypes"
                    @change="getWorkersByType()"
                    :rules="rules.required"
                    :label="'Tip radnika'+'*'"
                    item-text="name"
                    autocomplete="off"
                  />
                </v-col>
                <v-col>
                  <v-combobox
                    v-model="form.worker"
                    :items="form.filteredWorkers"
                    :disabled="form.filteredWorkers == null"
                    @change="form.worker === null? '' :form.worker_id = form.worker.id"
                    :rules="rules.required"
                    :label="'Ime radnika'+'*'"
                    item-text="fullName"
                    autocomplete="off"
                  />
                </v-col>
                <v-col>
                  <v-text-field
                    :label="'Dnevnica'+'*'"
                    v-model="form.salary"
                    :rules="rules.positive_number"
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
  import {edit, readWorkersActive, readWorkerTypesActive,} from "../../statics/DataTableFunctions";

  export default {
    props: {
      editItemDialog: false,
      dataForModal: null,
    },
    name: "EditWorker",
    data() {
      return {
        workerTypes: null,
        workers: null,
        translation: 'workers',
        api: 'evidentionWorker',
        loading: false,
        form: {
          evidention_id: '',
          filteredWorkers: null,
          worker: '',
          worker_type: '',
          salary: null,
          worker_id: '',
          worker_type_id: '',
        },
        rules: {
          required: [
            v => !!v || this.$t('validation.field'),
          ],
          positive_number: [
            v => /^\d{1,}[.]\d{1,}$/.test(v) && v > 0 || /^\d{1,}$/.test(v) && v > 0 || "Morate unijeti pozitivan broj"
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
      readWorkersActive,
      getWorkersByType() {
        this.form.evidention_id = this.dataForModal.evidention_id;
        if (this.form.worker_type) {
          this.form.worker_type_id = this.form.worker_type.id;
          this.form.worker = null
          this.form.filteredWorkers = [];
          for (let i = 0; i < this.workers.length; i++) {
            for (let j = 0; j < this.workers[i].worker_type_worker.length; j++) {
              if (this.workers[i].worker_type_worker[j].worker_type_id === this.form.worker_type.id) {
                this.form.filteredWorkers.push(this.workers[i])
              }
            }
          }
        }
      },
      closeDialog() {
        this.country = '';
        this.form = {
          evidention_id: '',
          filteredWorkers: null,
          worker: '',
          worker_type: '',
          salary: null,
          worker_id: '',
          worker_type_id: '',
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
            filteredWorkers: this.dataForModal.filteredWorkers,
            worker: this.dataForModal.worker,
            worker_type: this.dataForModal.worker_type,
            salary: this.dataForModal.salary,
            worker_id: this.dataForModal.worker_id,
            worker_type_id: this.dataForModal.worker_type_id,
          }
          this.getWorkersByType();
          this.form.worker = this.dataForModal.worker;
        }
      },
    },
    created() {
      this.readWorkerTypesActive();
      this.readWorkersActive();
    }
  }
</script>

<style scoped/>
