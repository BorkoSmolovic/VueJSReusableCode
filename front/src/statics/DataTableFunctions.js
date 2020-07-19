//array, filterArray, filters
import axios from 'axios'
/*---------------------------------- univerzalni search  ----------------------------------------*/
function search() {
  if (this.filteredTableData.length == 0) {
    this.filteredTableData = this.tableData
  }
  this.tableData = this.filteredTableData
  Object.keys(this.filters).forEach(val => {
    if (this.filters[val] == "") {
      return;
    }
    this.tableData = this.tableData.filter(item => {
      if (item != undefined && item != null) {
        //kreiraj varijablu koja sadrzi item
        let value = item;
        //ukoliko val koji predstavlja kljuc iz fitlera sadrzi tacku,
        //to znaci da treba uci u objekat, pa se to mora raditi preko []
        if (val.indexOf(".") != -1) {
          //dobijamo svaki kljuc
          let keys = val.split(".")
          //prolazimo kroz svaki kljuc i ulazimo u value kroz loop i value dobija vrijednost od kljuca
          keys.forEach(part => {
            if(value != null){
              value = value[part];
            }
          })
        } else {
          //ako nema tacke onda samo postaje kao sto pise
          value = item[val];
        }
        return (value + "").toLowerCase().indexOf((this.filters[val] + "").toLowerCase()) > -1
      }
    })
  });
  if (this.tableData.length == 0) {
    this.errorMessage = this.$t('no_data');
  }
}
/*---------------------------------- refresh za filtere  ----------------------------------------*/
function refresh(isReset) {
  if (this.filteredTableData.length == 0) {
    this.filteredTableData = this.tableData
  }
  Object.keys(this.filters).forEach(f => {
    this.filters[f] = ''
  });
  if (isReset) {
    this.tableData = this.filteredTableData
  } else {
    this.readTableData();
  }
}
/*---------------------------------- ne koristi se ali neka ----------------------------------------*/
function refreshTableData(api) {
  this.tableDataLoading = true;
  this.tableData = [];
  this.filteredTableData = [];
  let id = this.dataForModal.partner_data.id
  axios.get('api/'+api+'/' + id).then(response => {
    this.tableDataLoading = false;
    this.tableData = response.data;
    this.filteredTableData = response.data;
    if(this.filters != undefined){
      this.search()
    }
  }).catch(error => {
    this.tableDataLoading = false;
    if(error.response.status == 401){
     this.loading = false;
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')

   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalni read, get od api  ----------------------------------------*/
function readTableData(api) {
  this.tableDataLoading = true
  this.tableData = []
  axios.get('api/'+api).then(response => {
    this.tableDataLoading = false
    this.tableData = response.data;
    this.filteredTableData = response.data;
    if(this.filters != undefined){
      this.search()
    }
  }).catch(error => {
    this.tableDataLoading = false
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalni read po datumu, get od api  ----------------------------------------*/
function readTableDataByDate(api,dateFrom,dateTo) {
  this.tableDataLoading = true
  this.tableData = []
  let data = {
    dateFrom: dateFrom,
    dateTo: dateTo
  }
  axios.post('api/'+api,data).then(response => {
    this.tableDataLoading = false
    this.tableData = response.data;
    this.filteredTableData = response.data;
    if(this.filters != undefined){
      this.search()
    }
  }).catch(error => {
    this.tableDataLoading = false
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalni read, get od api sa dodatnim parametrima /ID ----------------------------------------*/
function readTableDataById(api,id) {
  this.tableDataLoading = true
  this.tableData = []
  axios.get('api/'+api+'/'+id).then(response => {
    console.log(response.data)
    this.tableDataLoading = false
    this.tableData = response.data;
    this.filteredTableData = response.data;
    if(this.filters != undefined){
      this.search()
    }
  }).catch(error => {
    this.tableDataLoading = false
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}


/*---------------------------------- univerzalni delete, delete od api + item  ----------------------------------------*/
function onDelete(api, item) {
  this.deleteLoadingId = item.id
  let message = this.$t('deactivate')
  if (!item.isActive) {
    message = this.$t('reactivate')
  }
  this.$swal
    .fire({
      title: message,
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#4caf50",
      cancelButtonColor: "#ff5252",
      reverseButtons: false,
      cancelButtonText: this.$t('deny'),
      confirmButtonText: this.$t('confirm')
    })
    .then(result => {
      if (result.value) {
        axios.delete('api/'+api+'/' + item.id).then(({data}) => {
          item.isActive = data.isActive ? true : false;
          this.snackbar.color = 'success'
          this.snackbar.text = this.$t('edit_success');
          this.snackbar.show = true;
          this.deleteLoadingId = -1;
          this.search();
        });
      } else {
        this.deleteLoadingId = -1;
      }
    }).catch(error => {
      if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
        this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  });
}
/*---------------------------------- univerzalni delete, delete od api + item  ----------------------------------------*/
function onDeleteRefresh(api, item) {
  this.deleteLoadingId = item.id
  let message = this.$t('deactivate')
  if (!item.isActive) {
    message = this.$t('reactivate')
  }
  this.$swal
    .fire({
      title: message,
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#4caf50",
      cancelButtonColor: "#ff5252",
      reverseButtons: false,
      cancelButtonText: this.$t('deny'),
      confirmButtonText: this.$t('confirm')
    })
    .then(result => {
      if (result.value) {
        axios.delete('api/'+api+'/' + item.id).then(({data}) => {
          item.isActive = data.isActive ? 1 : 0;
          item = data;
          this.readTableDataById(this.api,this.dataForModal.id);
          this.refresh(true);
          this.snackbar.color = 'success'
          this.snackbar.text = this.$t('edit_success');
          this.snackbar.show = true;
          this.deleteLoadingId = -1;
        });
      } else {
        this.deleteLoadingId = -1;
      }
    }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  });
}

/*---------------------------------------------------------*/
function onDeleteSplice(api, item) {
  this.deleteLoadingId = item.id
  let message = this.$t('deactivate')
  if (!item.isActive) {
    message = this.$t('reactivate')
  }
  this.$swal
    .fire({
      title: message,
      type: "info",
      showCancelButton: true,
      confirmButtonColor: "#4caf50",
      cancelButtonColor: "#ff5252",
      reverseButtons: false,
      cancelButtonText: this.$t('deny'),
      confirmButtonText: this.$t('confirm')
    })
    .then(result => {
      if (result.value) {
        axios.delete('api/'+api+'/' + item.id).then(({data}) => {
          // item.isActive = data.isActive ? 1 : 0;
          // item = data;
          this.tableData.splice(this.findById(item.id, this.tableData), 1);
          this.snackbar.color = 'success'
          this.snackbar.text = this.$t('edit_success');
          this.snackbar.show = true;
          this.deleteLoadingId = -1;
        });
      } else {
        this.deleteLoadingId = -1;
      }
    }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  });
}
/*---------------------------------- univerzalno dodavanje post od api  ----------------------------------------*/
function add(api) {
  if (!this.$refs.form.validate()) {
    this.snackbar.color = 'error';
    this.snackbar.text = this.$t('snackbar_required');
    this.snackbar.show = true;
    return;
  }
  this.loading = true;
  axios.post('api/'+api , this.form).then((response) => {

    this.$emit('addEmit', response.data)
    this.closeDialog();
    this.loading = false;
  })
    .catch(error => {
      if(error.response.status == 427){
        this.loading = false;
        this.loading = false
        this.$swal.fire({
          type: 'error',
          title: this.$t('validation.error'),
          text: "Vec postoji (Status: Aktivan)",
        })
      }else if(error.response.status == 434){
        this.loading = false;
        this.loading = false
        this.$swal.fire({
          type: 'error',
          title: this.$t('validation.error'),
          text: "Vec postoji (Status: Neaktivan)",
        })
      }
      else if(error.response.status == 436){
        this.loading = false;
        this.loading = false
        this.$swal.fire({
          type: 'error',
          title: this.$t('validation.error'),
          text: "Neispravni datumi",
        })
      }else if(error.response.status == 435){
        this.loading = false;
        this.loading = false
        this.$swal.fire({
          type: 'error',
          title: this.$t('validation.error'),
          text: "Izmjene zabranjene, koristi se u evidencijama",
        })
      }else if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
     this.$router.push('/login')
   }else{
     this.loading = false
     this.$swal.fire({
       type: 'error',
       title: this.$t('validation.error'),
       text: this.$t('validation.error'),
     })
   }
  })
}
/*---------------------------------- univerzalni emit za dodavanje  ----------------------------------------*/
function addEmit(item) {
  this.filteredTableData.push(item)
  this.search();
  this.snackbar.color = 'success';
  this.snackbar.text = this.$t('add_success');
  this.snackbar.show = true;
}
/*---------------------------------- univerzalni edit za put od api  ----------------------------------------*/
function edit(api,item) {
  if (!this.$refs.form.validate()) {
    this.snackbar.color = 'error';
    this.snackbar.text = this.$t('snackbar_required');
    this.snackbar.show = true;
    return;
  }
  this.loading = true;
  axios.put('api/'+api+'/'+item.id , this.form).then((response) => {
    this.$emit('editEmit', response.data)
    this.snackbar.color = 'success';
    this.snackbar.text = this.$t('edit_success');
    this.snackbar.show = true;
    this.closeDialog();
    this.loading = false;
  }).catch(error => {
    if(error.response.status == 427){
      this.loading = false;
    this.loading = false
    this.$swal.fire({
      type: 'error',
      title: this.$t('validation.error'),
      text: "Vec postoji (Status: Aktivan)",
    })
  }else if(error.response.status == 434){
      this.loading = false;
      this.loading = false
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: "Vec postoji (Status: Neaktivan)",
      })
    }
    else if(error.response.status == 436){
      this.loading = false;
      this.loading = false
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: "Neispravni datumi",
      })
    }else if(error.response.status == 435){
      this.loading = false;
      this.loading = false
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: "Izmjene zabranjene, koristi se u evidencijama",
      })
    }
    else if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.loading = false;
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalni emit za edit  ----------------------------------------*/
function editEmit(item) {
  this.filteredTableData.splice(this.findById(item.id,this.filteredTableData),1,item)
  this.search();
}


/*---------------------------------- univerzalna pomocna metoda za trazenje pozicije u nizu  ----------------------------------------*/
function findById(id, array){
  for (let i=0; i<array.length; i++){
    if(array[i].id == id){
      return i;
    }
  }
  return -1;
}


/*---------------------------------- univerzalna read countries  ----------------------------------------*/
function readCountries(){
  axios.get('api/country').then(response => {
    this.countries = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read worker types  ----------------------------------------*/
function readWorkerTypes(){
  axios.get('api/workerType').then(response => {
    this.workerTypes = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read partner types  ----------------------------------------*/
function readPartnerTypes(){
  axios.get('api/partnerType').then(response => {
    this.partnerTypes = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read banks  ----------------------------------------*/
function readBanks(){
  axios.get('api/bank').then(response => {
    this.banks = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read contact types  ----------------------------------------*/
function readContactTypes(){
  axios.get('api/contactType').then(response => {
    this.contactTypes = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read items  ----------------------------------------*/
function readItems(){
  axios.get('api/items').then(response => {
    this.items = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
       type: 'info',
       title: "Info",
       text: this.$t('validation.session'),
     })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read workers  ----------------------------------------*/
function readWorkers(){
  axios.get('api/workers').then(response => {
    this.workers = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read statuses  ----------------------------------------*/
function readStatuses(){
  axios.get('api/status').then(response => {
    this.statuses = response.data;
  }).catch(error => {
    if(error.response.status == 401){
     this.loading = false
     this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
   }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}

/*---------------------------------- univerzalna read active countries  ----------------------------------------*/
function readCountriesActive(){
  axios.get('api/countryActive').then(response => {
    this.countries = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active worker types  ----------------------------------------*/
function readWorkerTypesActive(){
  axios.get('api/workerTypeActive').then(response => {
    this.workerTypes = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active partner types  ----------------------------------------*/
function readPartnerTypesActive(){
  axios.get('api/partnerTypeActive').then(response => {
    this.partnerTypes = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active banks  ----------------------------------------*/
function readBanksActive(){
  axios.get('api/bankActive').then(response => {
    this.banks = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active contact types  ----------------------------------------*/
function readContactTypesActive(){
  axios.get('api/contactTypeActive').then(response => {
    this.contactTypes = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active items  ----------------------------------------*/
function readItemsActive(){
  axios.get('api/itemsActive').then(response => {
    this.items = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active services  ----------------------------------------*/
function readServicesActive(){
  axios.get('api/servicesActive').then(response => {
    this.services = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read active workers  ----------------------------------------*/
function readWorkersActive(){
  axios.get('api/workersActive').then(response => {
    this.workers = response.data;
  }).catch(error => {
    if(error.response.status == 401){
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    }else{
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}
/*---------------------------------- univerzalna read notifications  ----------------------------------------*/
function readNotifications() {
  axios.get('api/getCommentInfo')
    .then(response => {
      let item = response.data
      if(item.evidentions == 'null'){
        item.evidentions = []
      }
      localStorage.setItem('notifications',JSON.stringify(item))
    })
    .catch(error => {
      if (error.response != undefined && error.response.status == 401) {
        this.loading = false
        this.$swal.fire({
          type: 'info',
          title: "Info",
          text: this.$t('validation.session'),
        })
        this.$router.push('/login')
      } else {
        this.$swal.fire({
          type: 'error',
          title: this.$t('validation.error'),
          text: this.$t('validation.error'),
        })
      }
    })
}


function download(api){
  this.reportDownloading = true;
  const FileDownload = require('js-file-download');
  axios({
    url: 'api/'+api,
    method: "GET",
    responseType: "blob" // important
  }).then(response => {
    this.reportDownloading = false;
    FileDownload(response.data, 'izvjestaj.xlsx');
  }).catch(error => {
    this.reportDownloading = false;
    if (error.response.status == 401) {
      this.loading = false
      this.$swal.fire({
        type: 'info',
        title: "Info",
        text: this.$t('validation.session'),
      })
      this.$router.push('/login')
    } else {
      this.$swal.fire({
        type: 'error',
        title: this.$t('validation.error'),
        text: this.$t('validation.error'),
      })
    }
  })
}

export {
  search,
  refresh,
  refreshTableData,
  readTableData,
  onDelete,
  add,
  addEmit,
  edit,
  findById,
  editEmit,
  readCountries,
  readWorkerTypes,
  readPartnerTypes,
  readTableDataById,
  readBanks,
  readContactTypes,
  readWorkers,
  readItems,
  readStatuses,
  onDeleteRefresh,
  download,
  readBanksActive,
  readContactTypesActive,
  readCountriesActive,
  readItemsActive,
  readPartnerTypesActive,
  readWorkersActive,
  readWorkerTypesActive,
  readNotifications,
  readTableDataByDate,
  readServicesActive,
  onDeleteSplice
}
