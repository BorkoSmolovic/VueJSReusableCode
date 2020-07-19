<template lang="html">
  <v-dialog v-model="dialogAdd" persistent max-width="1000px">
    <template v-slot:activator="{ on }">
      <v-btn v-if="is_method === 0" color="primary" dark v-on="on">{{$t('add_method')}}</v-btn>
      <v-btn v-else color="primary" dark v-on="on">{{$t('add_instrument')}}</v-btn>
    </template>
    <v-card>
      <method-table :is_method_instrument='is_method' :addedItems="items" @selectedMethod="method_instrument= $event"></method-table>
      <v-alert
      v-model="alert"
      dismissible
      type="error"
      >
      {{ $t('validation.error_form') }}
    </v-alert>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" :disabled = "loading"
          @click="closeDialog()" flat>{{$t('close')}}</v-btn>
        <v-btn color="blue darken-1" :loading = "loading"  flat
          @click="addPlace()">{{$t('save')}}</v-btn>
      </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
import axios from 'axios/index'
export default {
  components:{
    'method-table':MethodInstrument
  },
  props: {
    items:Array,
    is_method:Number,
    service_id:Number,
  },
  data: function () {
    return {
      method_instrument:[],
      dialogAdd: false,
      loading: false,
      alert: false,
      form:{
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
  async addPlace(){
    let post = {}
    if(this.method_instrument.length > 0){
       post = {service_category_id:this.service_id, method_instrument:this.method_instrument, user_id:this.$store.getters['user_id']}
      try {
        this.loading = true;
        const {data} = await axios.post('/api/methods',post)
        this.loading = false;
        this.alert = false

        this.$emit('close', 'partner_add_msg')
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
    }else{
      this.alert = true
    }

  },
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
