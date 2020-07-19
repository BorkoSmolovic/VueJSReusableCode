<template>
  <v-row justify="end" class="mr-0">
    <v-dialog persistent v-model="addItemDialog" max-width="750px">
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
                <v-col cols="6">
                  <v-combobox
                    v-model="country"
                    :items="countries"
                    @change="city=null"
                    :rules="rules.required"
                    :label="$t(translation+'.country')+'*'"
                    item-text="name"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="6">
                  <v-combobox
                    v-model="city"
                    :disabled="country == null || country.city == undefined"
                    :items="country != null && country.city != undefined ? country.city : []"
                    @change="form.city_id = city.id"
                    :rules="rules.required"
                    :label="$t(translation+'.city')+'*'"
                    item-text="name"
                    autocomplete="off"
                  />
                </v-col>
                <v-col cols="12">
                <v-text-field
                  v-model="form.address"
                  :label="$t(translation+'.address')"
                  autocomplete="off"
                />
              </v-col>
                <v-col cols="6">
                  <v-combobox
                    v-model="partnerType"
                    :items="partnerTypes"
                    @change="form.partner_type_id = partnerType.id"
                    :rules="rules.required"
                    :label="$t(translation+'.type')+'*'"
                    item-text="name"
                    autocomplete="off"
                  />
                </v-col>
                <v-col>
                  <v-text-field
                    v-model="form.pib"
                    :label="$t(translation+'.pib')"
                    autocomplete="off"
                  />
                </v-col>
                <v-col v-if="partnerType!= null && partnerType.id!= undefined && partnerType.id == 1" cols="6">
                  <v-text-field
                    v-model="form.pdv"
                    :label="$t(translation+'.pdv')"
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
          <v-btn color="blue darken-1" text :loading="loading" @click="addPartner">{{$t('add')}}</v-btn>
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
    import {add, readCountriesActive,readPartnerTypesActive} from "../../statics/DataTableFunctions";

    export default {
        props: {
            addItemDialog: false,
        },
        name: "AddPartner",
        data() {
            return {
                partnerTypes:[],
                countries: [],
                cities: [],
                city: null,
                country: null,
                partnerType: null,
                translation: 'partners',
                api: 'partners',
                loading: false,
                form: {
                    code:'',
                    name:'',
                    address:'',
                    pib:'',
                    pdv:'',
                    pin:'',
                    partner_type_id:'',
                    city_id:'',
                },
                rules: {
                    required: [
                        v => !!v || this.$t('validation.field'),
                    ],
                    required_length: [
                        v => !!v || this.$t('validation.field'),
                        v => v === '' || v.length > 1 || this.$t(this.translation+'.validation')
                    ],
                    required_length_8: [
                        v => !!v || this.$t('validation.field'),
                        v => /^\d+$/.test(v) || this.$t(this.translation+'.validationNumbers'),
                        v => v === '' || v.length == 8 || this.$t(this.translation+'.validation8')
                    ],
                    required_length_13: [
                        v => !!v || this.$t('validation.field'),
                        v => /^\d+$/.test(v) || this.$t(this.translation+'.validationNumbers'),
                        v => v === '' || v.length == 13 || this.$t(this.translation+'.validation13')
                    ],
                    numbers_only: [
                        v => !!v || this.$t('validation.field'),
                        v => /^\d+$/.test(v) || this.$t(this.translation+'.validationNumbers'),
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
            readCountriesActive,
            readPartnerTypesActive,
            addPartner(){
                this.add(this.api);
            },
            closeDialog() {
                this.country = null;
                this.partnerType = null;
                this.city = null;
                this.form = {
                    code:'',
                    name:'',
                    address:'',
                    pib:'',
                    pdv:'',
                    pin:'',
                    partner_type_id:'',
                    city_id:'',
                }
                this.$refs.form.resetValidation()
                this.$emit('close')
            },
        },
        created() {
            this.readCountriesActive();
            this.readPartnerTypesActive();
        },
    }
</script>

<style scoped/>









