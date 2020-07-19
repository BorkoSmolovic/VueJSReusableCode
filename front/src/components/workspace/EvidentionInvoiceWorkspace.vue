<template>
  <v-card class="py-8 px-8">
    <v-form ref="form" v-on:submit.prevent>
      <!--  <div v-if="file != null">
          <p>{{file}}</p>
        </div>-->
      <v-row>
        <v-col cols="11">
          <div v-if="!hasInvoice" class="text-center pl-10">Faktura nije dodata</div>
          <div class="ml-10" v-if="hasInvoice"><v-file-input
            :disabled="true"
            :clearable="false"
            v-model="file"
            label="Preuzimanje fakture"
            prepend-icon="mdi-paperclip"
          >
            <template v-slot:selection="{ file }">
              <v-chip
                small
                label
                color="grey white--text"
              >
                {{ file.name }}
              </v-chip>
            </template>
          </v-file-input></div>
        </v-col>
        <v-col cols="1">
          <v-row>
            <v-btn icon v-if="hasInvoice" dark class="white grey--text" @click="downloadInvoice()"
                   :disabled="file === null" :loading="loadingDownload">
              <v-icon>mdi-download</v-icon>
            </v-btn>
          </v-row>
        </v-col>
      </v-row>
    </v-form>


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
  </v-card>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            dataForModal: null,
        },
        name: 'AddInvoice',
        data: () => ({
            show: isNaN(localStorage.getItem('partner_id')),
            invoiceName: null,
            hasInvoice: false,
            form: {
                invoice: '',
                evidention_id: '',
                file_name: ''
            },
            file_name: null,
            file: null,
            api: 'evidentionInvoice',
            loading:false,
            loadingDownload: false,
            loadingDelete: false,
            loadingAdd: false,
            snackbar: {
                color: 'success',
                show: false,
                text: '',
                timeout: 3000,
            },
            rules: {
                required: [
                    v => !!v || 'Morate unijeti fakturu'
                ]
            },
        }),
        methods: {
            readInvoice() {
                this.loading = true;
                axios.get('api/evidentionInvoice/' + this.dataForModal.id).then(response => {
                    if (response.data.invoice === null) {
                        this.file = null;
                        this.hasInvoice = false
                    } else {
                        this.file = {
                            name: response.data.invoice,
                        };
                        this.hasInvoice = true;
                    }
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
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
            },
            removeInvoice(api, item) {
                this.loadingDelete = true;
                this.$swal
                    .fire({
                        title: 'Da li ste sigurni da zelite da izbrišete fakturu',
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
                            axios.delete('api/' + api + '/' + this.dataForModal.id).then(({data}) => {
                                this.file = null;
                                this.hasInvoice = false;
                                this.snackbar.color = 'success'
                                this.snackbar.text = this.$t('edit_success');
                                this.snackbar.show = true;
                                this.loadingDelete = false;
                            });
                        } else {
                            this.loadingDelete = false;
                        }
                    }).catch(error => {
                    if (error.response.status == 401) {
                        this.loading = false
                        this.$swal.fire({
                            type: 'info',
                            title: "Info",
                            text: this.$t('validation.session'),
                        })
                        this.$router.push('/login')
                    } else {
                        this.loading = false;
                        this.$swal.fire({
                            type: 'error',
                            title: this.$t('validation.error'),
                            text: this.$t('validation.error'),
                        })
                    }
                });
            },
            add(api) {
                if (!this.file) {
                    this.snackbar.color = 'error';
                    this.snackbar.text = 'Morate unijeti fakturu';
                    this.snackbar.show = true;
                    return;
                }
                this.form.file_name = this.file.name;
                this.form.invoice = this.file;
                this.form.evidention_id = this.dataForModal.id;

                let formData = new FormData();
                formData.append("invoice", this.file);
                formData.append("file_name", this.file.name);
                formData.append("evidention_id", this.dataForModal.id);

                this.loadingAdd = true;
                axios.post('api/' + api, formData).then((response) => {
                    this.hasInvoice = true;
                    this.loadingAdd = false;
                    this.snackbar.color = 'success';
                    this.snackbar.text = 'Uspješno dodavanje';
                    this.snackbar.show = true;
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.loadingAdd = false
                        this.$swal.fire({
                            type: 'info',
                            title: "Info",
                            text: this.$t('validation.session'),
                        })
                        this.$router.push('/login')
                    } else {
                        this.loadingAdd = false
                        this.$swal.fire({
                            type: 'error',
                            title: this.$t('validation.error'),
                            text: this.$t('validation.error'),
                        })
                    }
                })
            },
            downloadInvoice() {
                const FileDownload = require('js-file-download');
                axios({
                    url: 'api/evidentionInvoiceDownload/' + this.dataForModal.id,
                    method: "GET",
                    responseType: "blob" // important
                }).then(response => {
                    // return;
                    FileDownload(response.data, this.file.name);
                    // this.downloadingReport = -1;
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.loadingDownload = false
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
                });
            },
        },
        created() {
            this.readInvoice()
        }

    }
</script>

<style/>
