<template lang="html">
  <v-layout row justify-center>
    <!-- ================ FULL SCREEN - DIALOG =============  -->
    <v-dialog  v-model="dialogMethods" fullscreen  transition="dialog-bottom-transition">
      <v-card >
        <v-toolbar dark class="primary">
          <!-- ### TITLE ### -->
          <!-- {{$t('service_method_instrument')}} -->
          <v-toolbar-title>{{serviceName}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <!-- ## CLOSE ## -->
            <v-btn dark flat @click.native="closeDialog()">{{$t('close')}}</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <br>
        <div class="px-5">
          <!-- ================== TABS (METHOD, INSTRUMENT, SUPPLEMENT) =====================-->
          <v-tabs v-model="tab" color="white">
            <v-tabs-slider color="yellow"></v-tabs-slider>
            <v-tab :key="0" @click="items = methods" >{{$t('service_tabs.tab_method')}}</v-tab>
            <v-tab :key="1"  @click="items = instruments">{{$t('service_tabs.tab_instrument')}}</v-tab>
            <v-tab :key="2"  @click="items = supplements">{{$t("service_tabs.tab_suplement")}}</v-tab>
          </v-tabs>
          <!-- ============== TOOLBAR ============== -->
          <v-toolbar color="white">
            <!-- ### TITLE ### -->
            <v-toolbar-title v-if="tab === 0">{{$t('service_tabs.tab_method')}}</v-toolbar-title>
            <v-toolbar-title v-else-if= "tab === 1">{{$t('service_tabs.tab_instrument')}}</v-toolbar-title>
            <v-toolbar-title v-else >{{$t("service_tabs.tab_suplement")}}</v-toolbar-title>
            <v-spacer></v-spacer>
            <!-- ### DIALOGS ADD ### -->
            <!-- Supplement add -->
            <add-service-supplement :items = 'supplementData' :service_id="serviceId" @close="newSupplement"  v-if="tab === 2" ></add-service-supplement>
            <!-- Method and Instrument add -->
            <add-method-instrument v-else :items="items" :is_method="tab" :disabled="!enabledRefresh" :service_id="serviceId" @close="closeAddMethod"></add-method-instrument>
            <!-- RESTART -->
            <v-btn :loading="!enabledRefresh" v-if="tab === 2" :disabled="!enabledRefresh" color="warning" @click="newSupplement()"><v-icon>refresh</v-icon></v-btn>
            <v-btn :loading="!enabledRefresh" v-else :disabled="!enabledRefresh" color="warning" @click="refresh(false)"><v-icon>refresh</v-icon></v-btn>
          </v-toolbar>
          <br>
          <!-- ==================== TREE VIEW for SUPPLEMENT ================= -->
          <v-card v-if="tab === 2" color="white">
            <v-text-field v-if="!showErrorMessage" @keyup.enter.native ="filterData" ref="searchData" v-bind:label="this.$t('search')" solo-inverted hide-details clearable></v-text-field>
            <v-treeview
            open-all
            activatable
            :items="items"
            :search="search"
            :filter="filter"
            :open="open"
            item-children="supplement"
            class="pa-3">
            <template v-slot:prepend="{ item, active }">
              <v-icon v-if="item.isItem === 0">folder_open</v-icon>
              <v-icon v-else>info</v-icon>
            </template>
            <template slot="label" slot-scope="{ item,  active }">
              <div>
                <v-layout row>
                  <div  v-if="item.isItem === 0" class="pt-1 pr-2" style="max-width: 60%; word-break:break-all; word-wrap:break-word; display:inline-block;">
                    {{item.number}}. {{item.name}}
                  </div>
                  <div v-if="item.isItem === 1" v-html="item.name" class="pt-1 pr-2 ml-1" style="max-width: 70%; word-break:break-all; word-wrap:break-word; display:inline-block;">
                  </div>
                  <div v-if="active">
                    <v-btn @click.stop="onDeleteSupplement(item)" small flat icon class="ma-1">
                      <v-icon>delete</v-icon>
                    </v-btn>
                  </div>
                </v-layout>
              </div>
            </template>
          </v-treeview>
        </v-card>
        <!-- ================= DATA TABLE for METHOD and INSTRUMENT ================== -->
        <v-card v-else>
          <v-data-table
          :headers="headers"
          :items="items"
          :pagination.sync="pagination"
          class="elevation-4 px-"
          >
          <!-- ### HEADERS ###  -->
          <template slot="headers" slot-scope="props">
            <tr>
              <th v-for="header in props.headers"
              :key = "header.text"
              :class = "getSortClass(header)"
              @click="changeSort(header)">
              <v-icon v-if="header.value != null" small>arrow_upward</v-icon>
              {{header.text}}
            </th>
          </tr>
          <!-- ### SEARCH METHOD INSTRUMENT ### -->
          <tr class="grey lighten-3">
            <th v-for="header in props.headers" :key="header.text" class="py-2">
              <v-text-field v-if="header.value === 'name'" solo hide-details v-model = "filters[header.value]" :label="header.text"></v-text-field>
              <v-text-field v-else-if="header.value === 'isActive'" solo hide-details v-model = "filters[header.value]" :label="header.text" ></v-text-field>
              <div v-else>
                <v-btn :disabled="!enabledSearch" color="success" @click="searchMethodInstrument"> <v-icon>search</v-icon></v-btn>
                <v-btn :disabled="!enabledSearch" color="error" @click="refresh(true)"><v-icon>cancel</v-icon></v-btn>
              </div>
            </th>
          </tr>
        </template>
        <!-- ### CONTENT ### -->
        <template v-slot:items="props">
          <td v-for="(cell, index) in headers" class="text-xs-center">
            <div v-if = "cell.value === null">
              <v-btn icon @click="onDelete(props.index, props.item)"><v-icon>delete</v-icon></v-btn>
            </div>
            <div v-else-if="cell.value === 'isActive' ">
              <v-chip v-if="props.item[cell.value] == 1" color="green" text-color="white">{{$t('active')}}</v-chip>
              <v-chip v-else color="red" text-color="white">{{$t('not_active')}}</v-chip>
            </div>
            <div v-else>{{props.item[cell.value]}}</div>
          </td>
        </template>
        <!-- ### NO DATA ### -->
        <template v-slot:no-data>
          <div class="text-xs-center">
            <v-progress-circular v-if="showLoading"
            :size="70"
            color="black"
            indeterminate
            ></v-progress-circular>
            <v-alert :value="showErrorMessage" color="error" icon="warning">
              {{errorMessage}}
            </v-alert>
          </div>
        </template>
      </v-data-table>
    </v-card>
    <!--  ================ SNACKBAR ================ -->
    <v-snackbar v-model="snackbar" :timeout="timeout" :right="true" color="success">
      {{ notification }}<v-btn dark flat icon @click="snackbar = false"> <v-icon>close</v-icon> </v-btn>
    </v-snackbar>
  </div>
</v-card>
</v-dialog>
</v-layout>
</template>

<script>
import axios from 'axios'
import AddServiceMethodInstrument from "./AddServiceMethodInstrument";
import AddServiceSupplement from "./AddServiceSupplement";
export default {
  components:{
    'add-method-instrument':AddServiceMethodInstrument,
    'add-service-supplement':AddServiceSupplement
  },
  props:{
    serviceId:Number,
    serviceName:"",
    dialogMethods:{default: false}
  },
  data: function(){
    return{
      // SNACK BAR
      snackbar: false,
      timeout: 6000,
      notification: '',
      // Supplement
      supplementData:[],
      tab: 0,
      enabledSearch: false,
      enabledRefresh: false,
      showLoading: true,
      showErrorMessage: false,
      errorMessage: '',
      dialogMethod:false,
      methodOrInstrument:[
        {text:'All', value: -1},
        {text:this.$t('service_method'), value: 1},
        {text:this.$t('service_instrument'), value: 0},
      ],
      methods:[],
      instruments:[],
      supplements:[],
      items:[],
      open: [],
      search: null,
      pagination: {sortBy: 'name', descending: 'asc'},
      headers: [
        {text: this.$t('service_table.name'), align: 'center', sortable: true, value: 'name'},
        {text: this.$t('service_table.active'), align: 'center', sortable: true, value: 'isActive'},
        {text: this.$t('actions'), align: 'center', sortable: true, value: null}
      ],
      filters: {
        name: '',
        isActive: ''
      },
      methodData:{}
    }
  },
  methods:{
    // ============== DELETE ===============
    onDelete(index, item) {
      // return
      this.$swal
      .fire({
        title: this.tab === 0 ? this.$t("method_delete_msg") : this.$t("instrument_delete_msg"),
          icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#71C074",
        reverseButtons: true,
        cancelButtonText: this.$t("cancel"),
        confirmButtonText: this.$t("servis_delete_true")
      })
      .then(result => {
        if (result.value) {
          axios.delete("api/methods/" + item.method_service_id).then(({ data }) => {
          this.readMethods()
          this.notification = this.tab === 0 ? this.$t("method_snackbar_delete") : this.$t("instrument_snackbar_delete");
          this.snackbar = true;
        }).catch(error => {
          console.error("ON DELETE METHOD INSTRUMENT SERVICE", error);
        })
        }
      });
    },
    onDeleteSupplement(item) {
      this.$swal
      .fire({
        title: this.$t("supplement_delete_msg"),
          icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#71C074",
        reverseButtons: true,
        cancelButtonText: this.$t("cancel"),
        confirmButtonText: this.$t("servis_delete_true")
      })
      .then(result => {
        if (result.value) {
          axios.delete("api/supplementService/"+this.serviceId+"/"+item.id).then(({ data }) => {
          this.readSuplements(true)
          this.notification = this.$t("supplement_snackbar_delete")
          this.snackbar = true;
          }).catch(error => {
            console.error("ON DELETE supplement SERVICE", error);
          })
        }
      });
    },

    // =============== FILTER DATA TREE VIEW  ===============
    filterData(){
      let data = this.$refs.searchData.lazyValue
      this.search = data
    },
    openParentItem(id, item) {
      if (item == null) {
        this.items.forEach(temp => {
          this.openParentItem(id, temp);
        })
      } else {
        if(item.supplement === undefined) {
          return;
        }
        item.supplement.forEach(child => {
          if (child.id === id) {
            if (!this.open.includes(child.supplement_id)) {
              this.open.push(child.supplement_id);
              this.openParentItem(child.supplement_id, null)
            }
          } else {
            this.openParentItem(id, child);
          }
        })
      }
    },
    // =============== SEARCH METHOD INSTRUMENT ==================
    searchMethodInstrument() {
      if(this.tab === 0){
        this.items = this.methods
      }else{
        this.items = this.instruments
      }
      Object.keys(this.filters).forEach(val => {
        if (this.filters[val] === "") {
          return;
        }
        this.items = this.items.filter(item => item[val].toLowerCase().indexOf(this.filters[val].toLowerCase()) > -1)
      })
    },
    // ================ DATA TABLE ==============
    refresh(isReset) {
      Object.keys(this.filters).forEach(f => {
        this.filters[f] = ''
      })
      if (isReset) {
        if(this.tab === 0){
          this.items = this.methods
        }else{
          this.items = this.instruments
        }
      } else {
        this.readMethods()
      }

    },
    getSortClass(header) {
      if (header.value === null) {
        return '';
      }
      return ['column sortable', this.pagination.descending ? 'desc' : 'asc',
      header.value === this.pagination.sortBy ? 'active' : '']
    },
    changeSort(header) {
      if (header.value === null) {
        return;
      }
      if (this.pagination.sortBy === header.value) {
        this.pagination.descending = !this.pagination.descending
      } else {
        this.pagination.sortBy = header.value
        this.pagination.descending = false
      }
    },
    // ============ CLOSE FULL SCREEN DIALOG =======
    closeDialog() {
      this.$emit('update:dialogMethods', false)
    },
    // ========== ADDed SUPPLEMENT and METHOD or INSTRUMENT ===========
    newSupplement(){
      this.readSuplements(true)
    },
    closeAddMethod(value){
      this.readMethods()
    },
    // ================== READ DATA ==============
    // READ -> SErvice Supplements
    readSuplements(is_reset){
      this.supplementData = []
      this.showLoading = true
      axios.get('/api/supplementService/'+this.serviceId).then(({data}) => {
        data.forEach( supplement => {
          supplement.supplement.forEach( item => {
            this.supplementData.push(item.id)
            let name = item.name
            if(name.includes('&lt;br&gt;')){
              item.name = name.replace(new RegExp('&lt;br&gt;', 'g'),'<br>')
            }
          })
        })
        this.supplements = data
        if(is_reset){
          this.items = this.supplements
        }
        if (data.length === 0){
          this.errorMessage = this.$t('error_loading_data')
          this.showErrorMessage = true
        }
        this.showLoading = false
      }).catch(error =>{
        console.error("READ SERVICE SUPPLEMENT -> ServiceMethods.vue", error);
        this.errorMessage = this.$t('error_loading_data')
        this.showLoading = false
        this.showErrorMessage = true
      })
    },
    // READ METHODS and INSTRUMENTS
    readMethods(){
      this.items = []
      this.instruments= []
      this.methods= []
      this.enabledSearch = false;
      this.enabledRefresh = false;
      this.showLoading = true
      axios.get('/api/methods/'+this.serviceId).then(({data}) =>{
        data.forEach(method =>{
            method.method_instrument['method_service_id'] = method.id
          if(method.method_instrument.is_method === 1){

            this.methods.push(method.method_instrument)
          }else{
            this.instruments.push(method.method_instrument)
          }
        })
        if(this.tab === 0){
          this.items = this.methods
        }else{
          this.items = this.instruments
        }

        if (data.length === 0) {
          this.errorMessage = this.$t('no_data')
          this.showErrorMessage = true
        } else {
          this.enabledSearch = true;
        }
        this.enabledRefresh = true;
        this.showLoading = false
      }).catch(error => {
        console.error("READ SERVICE METHOD INSTRUMENT -> ServiceMethods.vue", error);
        if (error.response === undefined) {
          this.errorMessage = this.$t('error_loading_data_timeout')
        } else {
          this.errorMessage = this.$t('error_loading_data')
        }
        this.showLoading = false
        this.showErrorMessage = true
        this.enabledRefresh = true;
      })
    },
  },
  watch:{
    'serviceId':function(val){
      this.readMethods();
      this.readSuplements(false)
    }
  },
  computed: {
    filter() {
      if (this.search === '') {
        this.open = [];
      }
      return (item, search, textKey) => {
        if (item[textKey].toLowerCase().includes(search.toLowerCase())) {
          var scId = item['id'];
          if (item['isItem'] === 0) {
            this.open.push(scId);
          }
          this.openParentItem(scId, null);
          return true;
        }
        return false;
      }
    }
  },
}
</script>

<style lang="css" scoped>

</style>
