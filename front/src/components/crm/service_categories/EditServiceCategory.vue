<template lang="html">
  <v-dialog v-model="dialogEditService" persistent
  :max-width="form.service_category === null && service.item.isItem === 0 ? '600px' : '800px'">
    <v-card>
      <v-form ref="form" v-on:submit.prevent>
        <v-layout row wrap>
          <v-flex  xs12 sm12>
            <v-card-title class="ma-2">
              <span class="headline" v-if="form.service_category === null && service.item.isItem === 0">{{$t('service_categories_edit')}}</span>
              <span class="headline" v-else>{{$t('service_categories_service_edit')}}</span>
            </v-card-title>
            <v-card-text class="pa-0">
              <v-container class="pt-0" grid-list-md>
                <v-layout wrap>
                  <v-flex xs12>
                    <v-text-field
                    v-model = "form.name"
                    :label="$t('service.service_name')+'*'"
                    :error-messages="formError.name"
                    :rules="rules.required" required
                    ></v-text-field>
                  </v-flex>
                  <v-flex xs12 v-if="form.service_category != null && service.item.isItem != 0" >
                    <v-select v-model="form.accreditation" :items="accreditation" :label="$t('service.service_accreditation')+'*'"  required></v-select>
                  </v-flex>
                  <v-flex xs12 v-if="form.service_category != null && service.item.isItem != 0">
                    <v-layout row wrap>
                      <v-flex xs8>
                        <v-select v-model="form.vat" :items="tax" :label="$t('service.service_tax')+'*'" :rules="rules.required" required></v-select>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field v-model = "form.complete_within_days" :label="$t('service.service_complete_day')+'*'"
                        :rules="rules.required" required></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-flex>
                  <v-flex xs12 >
                    <v-layout row wrap >
                      <!-- TRANSLATE -->
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
                  <v-flex xs12>
                    <v-switch
                    v-model="form.isActive" :label=" form.isActive ? $t('service.service_active') : $t('service.service_not_active') "></v-switch>
                  </v-flex>
                </v-layout>
                <v-layout row wrap  v-if="form.service_category === null && service.item.isItem === 0" >
                  <v-flex xs6 >
                    <h4>{{$t("service_categories_color_picker")}} *</h4>
                    <chrome-picker class="mt-2" v-model="colors" />
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>
          </v-flex>
        </v-layout>
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
        <v-btn color="blue darken-1" :loading="loading" flat @click="editService()">{{$t('save')}}</v-btn>
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
  props: {
    service:{},
    template_with_accreditation:Array,
    template_no_accreditation:Array,
    dialogEditService:{
      default: false
    }
  },
  data: function () {
    return {
      accreditation:[
        {text:this.$t('accreditation.no_accreditation'), value: 0},
        {text:this.$t('accreditation.with_accreditation'), value: 1},
        {text:this.$t('accreditation.choose_accreditation'), value: 2},
      ],
      alert: false,
      loading: false,
      colors:{hex:this.service.item.color},
      form : {
        color: null,
        vat: this.service.item.vat_id,
        complete_within_days: this.service.item.complete_within_days,
        accreditation:this.service.item.accreditation,
        user_id: 0,
        name: this.service.item.name,
        isActive: this.service.item.isActive,
        service_category: this.service.item.service_category_id,
        service_category_root_id:this.service.item.service_category_root_id,
        expert_findings_template_accreditation_id: this.service.item.expert_findings_template_accreditation_id,
        expert_findings_template_without_accreditation_id: this.service.item.expert_findings_template_without_accreditation_id
      },
      rules:{
        required: [(v) => !!v || this.$t('validation.field')]
      },
      tax:[],
      formError:{}
    }
  },
  methods:{
    closeDialog(){
      this.$emit('update:dialogEditService', false)
    },
    async editService(){
      if(this.$refs.form.validate()){
        this.form.user_id =  this.$store.getters['user_id']
        this.form.color = this.colors.hex
        try{
          this.loading = true
          const {data} = await axios.put('/api/serviceCategories/'+this.service.item.id,this.form)
          this.loading = false
          this.alert = false
          this.$emit('editChild',{item:this.service.item, newData:data})
          this.closeDialog();
        }catch(error){
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
    readVat(){
      axios.get('/api/vat').then(({data})=>{
        data.forEach(vat => {
          this.tax.push({text:vat.rate+'%', value:vat.id})
        })
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
