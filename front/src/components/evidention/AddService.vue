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
                <v-col>
                  <v-combobox
                    v-model="chosenService"
                    :items="services"
                    return-object
                    :rules="rules.required"
                    :label="'Tip usluge'+'*'"
                    item-text="name"
                    autocomplete="off"
                    @change="setServiceID()"
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
  import {add, readServicesActive} from "../../statics/DataTableFunctions";

  export default {
    props: {
      dataForModal: null,
      addItemDialog: false,
    },
    name: "AddWorker",
    data() {
      return {
        workerTypes: null,
        workers: null,
        translation: 'serviceTypes',
        api: 'evidentionServices',
        loading: false,
        services: [],
        chosenService: null,
        form: {
          evidention_id: '',
          service_id: ''
        },
        rules: {
          required: [
            v => !!v || this.$t('validation.field'),
          ],
          required_length: [
            v => !!v || this.$t('validation.field'),
            v => v === '' || v.length > 1 || this.$t(this.translation + '.validation')
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
      setServiceID() {
        console.log(this.dataForModal)
        this.form.service_id = this.chosenService.id;
        this.form.evidention_id = this.dataForModal.id;
      },
      readServicesActive,
      closeDialog() {
        this.form = {
          evidention_id: '',
          service_id: ''
        }
        this.chosenService = null
        this.$refs.form.resetValidation()
        this.$emit('close')
      },
    },
    created() {
      this.readServicesActive();
    },
  }
</script>

<style scoped/>
