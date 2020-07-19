<template>
    $END$
</template>

<script>
  import axios from 'axios'

  export default {
    name: "Excel",
    methods: {
        downloadReport(nesto) {
            const FileDownload = require('js-file-download');
            axios({
                url: 'api/excel' + nesto,
                method: "POST",
                // data: {
                //     date: "2019-12",
                //     event_name: 'D',
                //     city: 'K',
                //     is_commercial: true,
                // partner: null,
                // user: null,
                // status: null,
                // isActive: null
                // },
                data: {
                    dateFrom: '2019-01-01',
                    dateTo: '2019-12-31',
                    event_name: 'a',
                    // event_name: null,
                    city: 'a',
                    // city: null,
                    is_commercial: true,
                    partner: 'a',
                    user: 'p',
                    status: null,
                    isActive: true
                },
                responseType: "blob" // important
            }).then(response => {
                FileDownload(response.data, 'File.xlsx');
            }).catch(error => {
                this.$swal.fire({
                    type: "error",
                    title: "Error",
                    text: error
                });
            });
        },
        getWorkerReport() {
            const FileDownload = require('js-file-download');
            axios({
                url: 'api/downloadReportExcel',
                method: "POST",
                data: {
                    workers: [
                        {'id': 1},
                        {'id': 2}
                    ],
                    worker_types: [
                        {'id': 1},
                        {'id': 2}
                    ]
                },
                responseType: "blob" // important
            }).then(response => {

                // return;
                FileDownload(response.data, 'File.xlsx');
                // this.downloadingReport = -1;
            }).catch(error => {
                // this.downloadingReport = -1;
                this.$swal.fire({
                    type: "error",
                    title: "Error",
                    text: error
                });
            });
        }
    }
  }
</script>

<style scoped>

</style>
