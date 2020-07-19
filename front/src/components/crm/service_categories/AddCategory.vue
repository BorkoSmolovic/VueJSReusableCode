<template lang="html">
  <!-- ============ Dialog Service Category ============ -->
  <v-dialog v-model="dialogAddService" persistent max-width="600px">
    <template v-slot:activator="{ on }">
      <v-btn color="primary" dark v-on="on">{{$t('service_categories_add_category')}}</v-btn>
    </template>
    <!-- ========== ADD FORM =============== -->
    <v-card>
      <v-form ref="form" v-on:submit.prevent>
        <v-layout row wrap>
          <v-flex  xs12 sm12>
            <v-card-title class="ma-2">
              <span class="headline">{{$t('service_categories_add_category')}}</span>
            </v-card-title>
            <v-card-text class="pa-0">
              <v-container class="pt-0" grid-list-md>
                <v-layout wrap>
                  <!-- ### SERVICE CATEGORY NAME ### -->
                  <v-flex xs12>
                    <v-text-field v-model = "form.name" :label="$t('service.service_name')+'*'"
                    :error-messages="formError.name" :rules="rules.required" required></v-text-field>
                  </v-flex>
                </v-layout>
                <v-layout row wrap >
                  <!-- ### SERVICE CATEGORY COLOR PICKER ###-->
                  <v-flex xs6 >
                    <h4>{{$t("service_categories_color_picker")}} *</h4>
                    <chrome-picker class="mt-2" v-model="colors" />
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
          </v-flex>
        </v-layout>
        <!-- ================ ERROR, VALIDATION TEXT ============== -->
        <small class="pl-4">{{$t('required_fields')}}</small>
        <v-alert
        v-model="alert"
        dismissible
        type="error"
        >
        {{ $t('validation.error_form') }}
      </v-alert>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" :disabled = "loading" flat @click.native ="closeDialog()" >{{$t('close')}}</v-btn>
        <v-btn color="blue darken-1" :loading="loading" flat @click="addService()">{{$t('save')}}</v-btn>
      </v-card-actions>
    </v-form>
  </v-card>
</v-dialog>
</template>

<script>
import {Chrome} from 'vue-color'
import axios from 'axios/index'
export default {
  components: {
    'chrome-picker': Chrome
  },
  data: function () {
    return {
      accreditation:[
        {text:this.$t('accreditation.no_accreditation'), value: 0},
        {text:this.$t('accreditation.with_accreditation'), value: 1},
        {text:this.$t('accreditation.choose_accreditation'), value: 2},
      ],
      dialogAddService: false,
      alert: false,
      loading: false,
      colors: '#194d33',
      form : {
        color: null,
        vat: null,
        complete_within_days: null,
        accreditation: null,
        user_id: 0,
        name: '',
        isItem: 0,
        service_category_id: null,
        service_category_root_id: null
      },
      rules:{
        required: [(v) => !!v || this.$t('validation.field')]
      },
      tax:[],
      formError:{}
    }
  },
  methods:{
    // ============= Close Dialog ==========
    closeDialog(){
      this.formError = {}
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
      this.dialogAddService = false
    },
    // ============= ADD Category ==========
    async addService(){
      if(this.$refs.form.validate()){
        this.form.user_id =  this.$store.getters['user_id']
        this.form.color = this.colors.hex
        try{
          this.loading = true
          const {data} = await axios.post('/api/serviceCategories',this.form)
          this.loading = false
          this.alert = false
          this.$emit('close','added')
          this.closeDialog();
        }catch(error){
          console.error("SERVICE CATEGORY-> ADD CATEGORY", error);
          if (error.response.status == 422){
            for (var key in error.response.data.errors) {
              this.formError[key] = error.response.data.errors[key][0]
            }
            this.alert = true
            this.loading = false;
          }
        }
        this.loading = false;
      }else{
        this.alert = true
      }
    },
    // // ==================== READ VAT ===================
    // readVat(){
    //   axios.get('/api/vat').then(({data})=>{
    //     data.forEach(vat => {
    //       this.tax.push({text:vat.rate+'%', value:vat.id})
    //     })
    //   })
    // },
  },
  // created(){
  //   this.readVat();
  // }
}
</script>

<style lang="css" scoped>
</style>
