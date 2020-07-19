<template>
  <v-card class="py-8 px-8">
    <v-form ref="form" v-on:submit.prevent>
      <!--  <div v-if="file != null">
          <p>{{file}}</p>
        </div>-->
      <v-row>
        <v-col cols="11">
          <v-row>
            <v-col cols="4">
              <v-text-field
                :key="hasInvoice ? form.net : ''"
                v-model="form.net"
                v-money="moneyFloat"
                filled
                :label="$t('net')"
                :rules="!hasInvoice ? rules.required : []"
                :readonly="hasInvoice"
              />
            </v-col>
            <v-col cols="4">
              <v-text-field
                :key="hasInvoice ? form.rebate : ''"
                v-model="form.rebate"
                v-money="moneyFloat"
                filled
                :label="$t('rebate')"
                :rules="!hasInvoice ? rules.required : []"
                :readonly="hasInvoice"
              />
            </v-col>
            <v-col cols="4">
              <v-text-field
                :key="hasInvoice ? form.net_rebate : ''"
                v-model="form.net_rebate"
                v-money="moneyFloat"
                filled
                :rules="(parseFloat(this.form.net) - parseFloat(this.form.rebate)
                !== parseFloat(form.net_rebate) && !hasInvoice) ? rules.equalityControl : []"
                :label="$t('net_rebate')"
                :readonly="hasInvoice"
              />
            </v-col>
            <v-col cols="4">
              <v-text-field
                :key="hasInvoice ? form.vat : ''"
                v-model="form.vat"
                v-money="moneyFloat"
                filled
                :label="$t('vat')"
                :rules="!hasInvoice ? rules.required : []"
                :readonly="hasInvoice"
              />
            </v-col>
            <v-col cols="4">
              <v-text-field
                :key="hasInvoice ? form.gross : ''"
                v-model="form.gross"
                v-money="moneyFloat"
                filled
                :rules="(parseFloat(this.form.vat) + parseFloat(this.form.net_rebate)
                !== parseFloat(form.gross) && !hasInvoice) ? rules.equalityControl : []"
                :label="$t('gross')"
                :readonly="hasInvoice"
              />
            </v-col>
            <v-col cols="4">
              <div v-if="!show && !hasInvoice" class="text-center pl-10">Faktura nije dodata</div>
              <div class="ml-10" v-if="!show && hasInvoice">
                <v-file-input
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
                </v-file-input>
              </div>
              <v-file-input
                filled
                v-if="show"
                :disabled="file !==null && hasInvoice"
                :clearable="true"
                v-model="file"
                placeholder="Učitajte vaš dokument"
                label="Unos fajla"
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
              </v-file-input>
            </v-col>
          </v-row>
          <v-row>
            <v-col class="alignment">
              <v-btn icon v-if="hasInvoice" dark class="white grey--text" @click="downloadInvoice()"
                     :disabled="file == null" :loading="loadingDownload">
                <v-icon>mdi-download</v-icon>
              </v-btn>
              <v-btn icon v-if="hasInvoice && show" dark class="white grey--text" @click="removeInvoice(api,file)"
                     :disabled="file == null" :loading="loadingDelete">
                <v-icon>mdi-trash-can-outline</v-icon>
              </v-btn>
              <v-btn v-if="!hasInvoice  && show" color="primary" dark @click="add(api)"
                     :loading="loadingAdd">
                {{ $t('add') }}
              </v-btn>
            </v-col>
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
        net: '',
        rebate: '',
        net_rebate: '',
        vat: '',
        gross: '',
        file_name: ''
      },
      moneyFloat: {
        decimal: '.',
        thousands: '',
        prefix: '',
        suffix: '',
        precision: 2,
        masked: true /* doesn't work with directive */
      },
      file_name: null,
      file: null,
      api: 'evidentionInvoice',
      loading: false,
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
          v => !!v || 'Morate unijeti vrijednost'
        ],
        equalityControl: [
          v => 'Vrijednosti se ne podudaraju'
        ]
      },
    }),
    methods: {
      readInvoice() {
        this.loading = true;
        axios.get('api/evidentionInvoice/' + this.dataForModal.id).then(response => {
          if (response.data.invoice == null) {
            this.file = null;
            this.hasInvoice = false
          } else {
            this.file = {
              name: response.data.invoice,
            };
            this.form.net = parseFloat(response.data.net).toFixed(2)
            this.form.rebate = parseFloat(response.data.rebate).toFixed(2)
            this.form.net_rebate = parseFloat(response.data.net_rebate).toFixed(2)
            this.form.vat = parseFloat(response.data.vat).toFixed(2)
            this.form.gross = parseFloat(response.data.gross).toFixed(2)
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
                this.form.net = ''
                this.form.rebate = ''
                this.form.net_rebate = ''
                this.form.vat = ''
                this.form.gross = ''
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
        if (this.$refs.form.validate()) {
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
          formData.append("net", this.form.net);
          formData.append("rebate", this.form.rebate);
          formData.append("net_rebate", this.form.net_rebate);
          formData.append("vat", this.form.vat);
          formData.append("gross", this.form.gross);
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
        }
      },
      downloadInvoice() {
        this.loadingDownload = true
        const FileDownload = require('js-file-download');
        axios({
          url: 'api/evidentionInvoiceDownload/' + this.dataForModal.id,
          method: "GET",
          responseType: "blob" // important
        }).then(response => {
          this.loadingDownload = false
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
            this.loadingDownload = false
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

<style scoped>
  .alignment {
    text-align: center;
  }
</style>
