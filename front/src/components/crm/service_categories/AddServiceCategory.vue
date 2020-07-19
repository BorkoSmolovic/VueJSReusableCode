<template lang="html">
  <!-- ================== DIALOG ================= -->
  <v-dialog v-model="dialogAddService" persistent max-width="800px">
    <!-- ================ ADD FORM ============== -->
    <v-card>
      <v-form ref="form" v-on:submit.prevent>
        <v-layout row wrap>
          <v-flex  xs12 sm12>
            <!-- ===== TITLE ==== -->
            <v-card-title class="ma-2">
              <span class="headline">{{$t('add_service')}} ({{service.name}})</span>
            </v-card-title>
            <v-card-text class="pa-0">
              <v-container class="pt-0" grid-list-md>
                <v-layout wrap>
                  <!-- ### SERVICE or CATEGORY  -->
                  <v-flex xs12 >
                    <v-radio-group v-model="form.isItem" row>
                      <v-radio :label="$t('service.service_item')" :value="1"></v-radio>
                      <v-radio :label="$t('service.service_category')" :value="0"></v-radio>
                    </v-radio-group>
                  </v-flex>
                  <!-- ### NAME ### -->
                  <v-flex xs12>
                    <v-text-field v-model = "form.name" :label="$t('service.service_name')+'*'"
                    :error-messages="formError.name" :rules="rules.required" required></v-text-field>
                  </v-flex>
                  <!-- ### ACCREDITATION ### -->
                  <v-flex xs12 v-if="form.isItem === 1">
                    <v-select v-model="form.accreditation"  :items="accreditation" :label="$t('service.service_accreditation')+'*'" required></v-select>
                  </v-flex>
                  <v-flex xs12 v-if="form.isItem === 1">
                    <v-layout row wrap >
                      <!-- ### PDV ### -->
                      <v-flex xs8>
                        <v-select v-model="form.vat" :items="tax" :label="$t('service.service_tax')+'*'" :rules="rules.required" required></v-select>
                      </v-flex>
                      <!-- ### DURATION ### -->
                      <v-flex xs4>
                        <v-text-field v-model = "form.complete_within_days" :label="$t('service.service_complete_day')+'*'"
                        :rules="rules.required" required></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-flex>
                  <!-- ### TEMPLATE ### -->
                  <v-flex xs12 v-if="form.isItem === 1">
                    <v-layout row wrap >
                      <v-flex xs6 v-if="[0,2].includes(form.accreditation)" >
                        <v-select v-model="form.expert_findings_template_without_accreditation_id"
                        :items="template_no_accreditation" :label="$t('service.expert_findings_template_no_accreditation')" item-text="name" item-value="id" required></v-select>
                      </v-flex>
                      <v-flex xs6 v-if="[1,2].includes(form.accreditation)">
                        <v-select v-model="form.expert_findings_template_accreditation_id"
                        :items="template_with_accreditation" :label="$t('service.expert_findings_template_accreditation')" item-text="name" item-value="id" required></v-select>
                      </v-flex>
                    </v-layout>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
          </v-flex>
        </v-layout>
        <!-- ============== ERROR and VALIDATION TEXT ================ -->
        <small class="pl-4">{{$t('required_fields')}}</small>
        <v-alert v-model="alert" dismissible type="error" > {{ $t('validation.error_form') }} </v-alert>
        <!-- ============== ACTIONS ============= -->
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
import axios from 'axios/index'
export default {
  props: {
    service:{},
    template_with_accreditation: Array,
    template_no_accreditation: Array,
    dialogAddService:{
      default: false
    }
  },
  data: function () {
    return {
      // Accreditation Type
      accreditation:[
        {text:this.$t('accreditation.no_accreditation'), value: 0},
        {text:this.$t('accreditation.with_accreditation'), value: 1},
        {text:this.$t('accreditation.choose_accreditation'), value: 2},
      ],
      // TAX
      tax: [],
      // FORM
      form : {
        vat: null,
        complete_within_days: null,
        accreditation: 2,
        user_id: 0,
        name: '',
        isItem: 1,
        service_category_id: this.service.id,
        service_category_root_id:this.service.item.service_category_root_id,
        expert_findings_template_accreditation_id: null,
        expert_findings_template_without_accreditation_id: null
      },
      // ALERT, ERROR, MESSAGEs, VALIDATIONS
      alert: false,
      loading: false,
      rules:{
        required: [(v) => !!v || this.$t('validation.field')]
      },
      formError:{}
    }
  },
  methods:{
    // ========== CLOSE DIALOG =========
    closeDialog(){
      this.formError = {}
      this.$refs.form.reset()
      this.$refs.form.resetValidation()
      this.$emit('update:dialogAddService', false)
    },
    // ========== ADD SERVICE or CATEGORY
    async addService(){
      if(this.$refs.form.validate()){
        this.form.user_id =  this.$store.getters['user_id']
        if(this.form.isItem === 0){
          this.form.accreditation = null
        }
        try{
          this.loading = true
          const {data} = await axios.post('/api/serviceCategories',this.form)
          this.loading = false
          this.alert = false
          this.$emit('addNew',{item:this.service.item, idParent:this.service.id, newData:data})
          this.closeDialog();
        }catch(error){
          // ERROR
          console.error("SERVICE CATEGORY->AddServiceCategory.vue", error);
          if (error.response.status === 422){
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
    // ============= READ VAT ================
    readVat(){
      axios.get('/api/vat').then(({data})=>{
        data.forEach(vat => {
          this.tax.push({text:vat.rate+'%', value:vat.id})
        })
      }).catch( error => {
        console.error("SERVICE CATEGORY->AddServiceCategory.vue", error);
      })
    },
  },
  created(){
    this.readVat();
  },
  watch:{
    'form.accreditation':function(val){
      if(val === 0){
        this.form.expert_findings_template_accreditation_id = null
      }else{
        this.form.expert_findings_template_without_accreditation_id = null
      }


    }
  }
}
</script>
<style lang="css" scoped>
</style>
