<template lang="html">
  <!-- ================== DIALOG ============== -->
  <v-dialog v-model="dialogAdd" persistent max-width="1000px">
    <template v-slot:activator="{ on }">
      <v-btn color="primary" dark v-on="on">{{$t("add_supplement")}}</v-btn>
    </template>
    <v-card>
      <!-- ============== DIALOG TITLE ============== -->
      <v-card-title class="ma-2 pb-3">
        <span class="headline">{{$t("add_supplement")}}</span>
        <v-spacer></v-spacer>
        <!-- ================= DIALOG ACTIONS ============== -->
        <v-btn color="blue darken-1" :disabled="loading" flat @click="closeDialog">{{$t('close')}}</v-btn>
        <v-btn color="blue darken-1" :loading="loading" flat @click="addSupplements">{{$t('save')}}</v-btn>
      </v-card-title>
      <!-- ======= ALERT ====== -->
      <v-alert v-model="alert" dismissible type="error">{{ $t('validation.error_form') }}</v-alert>
    <v-card-text class="pa-0">
      <!-- ======== TREE VIEW SUPPLEMENT -> components ======== -->
      <suplement-treeview :addedSuplements="items" @chosenSupplements="form.supplements = $event"></suplement-treeview>
    </v-card-text>
  </v-card>
</v-dialog>
</template>

<script>
import axios from 'axios/index'
import SupplementTreeView from '@/components/sigurnost/SupplementTreeView.vue'
export default {
  components:{
    'suplement-treeview':SupplementTreeView
  },
  props: {
    items:Array,
    service_id:Number,
  },
  data: function () {
    return {
      dialogAdd: false,
      loading: false,
      alert: false,
      form:{
        supplements:[],
        name:'',
        is_method: 0,
        user_id:'',
      },
      rules:{
        required: [(v) => !!v || this.$t('validation.field')],
        email: [(v) => !!v || this.$t('validation.field'), (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || this.$t('validation.email')
      ],
    },
    formError:{}
  }
},
methods:{
  // ========================== POST ADD SERVICE SUPPLEMENTS ===============
  async addSupplements(){
    let user = this.$store.getters['user_id']
    let service_supplements = []
    this.form.supplements.forEach(item =>{
      service_supplements.push({service_category_id:this.service_id, supplement_id: item.id, user_id: user})
    })
    if(service_supplements.length > 0){
      try {
          this.loading = true
          const {data} = await axios.post('/api/supplementService',{services:service_supplements})
          this.loading = false
          this.alert = false
          this.$emit('close', data)
          this.closeDialog()
      }catch(error){
        console.error("ADDING SUPPLEMENTS FOR SERVICE", error);
        this.alert = true
        this.loading = false;
      }
    }else{
      this.alert = true
    }
  },
  // CLOSE DIALOG ADD 
  closeDialog(){
    this.formError = {}
    this.method_instrument={}
    this.dialogAdd = false
  }
}
}
</script>

<style lang="css" scoped>
</style>
