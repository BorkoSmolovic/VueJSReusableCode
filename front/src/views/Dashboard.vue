<template>
  <v-container v-if="$auth.isAuthenticated()" fluid>
    <v-row v-if="!isChartLoaded">
      <v-col cols="12">
        <div class="text-center ma-12">
          <v-progress-circular
            indeterminate
            color="primary"
            size="55"
            class="pb-8"
          />
          <div class="pt-5">Učitavanje podataka, molimo sačekajte</div>
        </div>
      </v-col>

    </v-row>
    <v-row v-else>
      <!-- <v-col
               cols="12"
               lg="6"
       >
           <material-chart-card
                   @click="$router.push('/partner-evidentions')"
                   :data="emailsSubscriptionChart.data"
                   :options="emailsSubscriptionChart.options"
                   :responsive-options="emailsSubscriptionChart.responsiveOptions"
                   color="red"
                   type="Bar"
           >
               <h4 class="title font-weight-light">
                   Evidencija snimanja
               </h4>
               <p class="category d-inline-flex font-weight-light">
                   Podijeljena po statusima
               </p>

               <template v-slot:actions>
                   <v-icon
                           class="mr-2"
                           small
                   >
                       mdi-clock-outline
                   </v-icon>
                   <span class="caption grey&#45;&#45;text font-weight-light">Za više informacija kliknite ovdje..</span>
               </template>
           </material-chart-card>
       </v-col>-->
      <v-col cols="6" sm="12" md="6" lg="6">
        <div id="chart" class="justify-content-center">
          <apexchart
            type=pie
            :options="chartOptions"
            :series="series"/>
        </div>
      </v-col>
      <v-col v-if="checkPartner" cols="6" sm="12" md="12" lg="6">
        <v-row>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="6"
          >
            <material-stats-card
              color="purple"
              icon="mdi-camcorder"
              title="Radna zona"
              :value="stats == null ? '' : totalWorkZone+''"
              @click="$router.push('/evidention')"
              sub-icon="mdi-camera-iris"
              sub-icon-color="purple"
              sub-text="Provjerite radnu zonu.."
            />
          </v-col>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="6"
          >
            <material-stats-card
              color="green"
              icon="mdi-account-supervisor"
              title="Ukupno partnera"
              :value="stats == null ? '' : stats[1].no+''"
              @click="$router.push('/partners')"
              sub-icon="mdi-format-list-bulleted"
              sub-icon-color="success"
              sub-text="Provjerite ugovore ovdje.."
            />
          </v-col>
        </v-row>
      </v-col>
      <v-col v-else cols="6" sm="12" md="12" lg="6">
        <v-row>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="6"
          >
            <material-stats-card
              color="blue"
              icon="mdi-file"
              title="Ukupno evidencija"
              :value="total+''"
              sub-icon="mdi-calendar"
              sub-icon-color="blue"
              @click="$router.push('/partner-evidentions')"
              sub-text="Pogledajte sve evidencije.."
              sub-text-color="text-primary"
            />
          </v-col>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="6"
          >
            <material-stats-card
              color="green"
              icon="mdi-camera"
              title="Preostala snimanja"
              :value="stats == null ? '' : stats[1].recordings_remaining+''"
              @click="$router.push('/contracts')"
              sub-icon="mdi-format-list-bulleted"
              sub-icon-color="success"
              sub-text="Provjerite ugovore ovdje.."
            />
          </v-col>
        </v-row>
        <v-row>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="6"
          >
            <material-stats-card
              color="orange"
              icon="mdi-update"
              title="Datum isticanja poslednjeg ugovora"
              :value="stats == null ? '' : (stats[0].lastContract == null ? $t('no_contract') : stats[0].lastContract)"
              sub-icon="mdi-calendar"
              sub-icon-color="warning"
              @click="$router.push('/contracts')"
              sub-text="Provjerite ugovore ovdje.."
              sub-text-color="text-primary"
            />
          </v-col>
          <v-col
            cols="12"
            sm="12"
            md="12"
            lg="6"
          >
            <material-stats-card
              color="purple"
              icon="mdi-camcorder"
              title="Ukupno završenih snimanja"
              :value="stats == null ? '' : stats[7].no+''"
              @click="$router.push('/partner-evidentions')"
              sub-icon="mdi-camera-iris"
              sub-icon-color="purple"
              sub-text="Provjerite snimanja u evidencijama.."
            />
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                total: 0,
                totalWorkZone: 0,
                isChartLoaded: false,
                series: [],
                chartOptions: {
                    labels: [],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                },
                series2: [],
                chartOptions2: {
                    labels: [],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                },
                stats: null,
                dailySalesChart: {
                    data: {
                        labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
                        series: [
                            [12, 17, 7, 17, 23, 18, 38]
                        ]
                    },
                    options: {
                        lineSmooth: this.$chartist.Interpolation.cardinal({
                            tension: 0
                        }),
                        low: 0,
                        high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    }
                },
                dataCompletedTasksChart: {
                    data: {
                        labels: ['12am', '3pm', '6pm', '9pm', '12pm', '3am', '6am', '9am'],
                        series: [
                            [300, 750, 450, 300, 280, 240, 200, 190]
                        ]
                    },
                    options: {
                        lineSmooth: this.$chartist.Interpolation.cardinal({
                            tension: 0
                        }),
                        low: 0,
                        high: 100, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    }
                },
                emailsSubscriptionChart: {
                    data: {
                        labels: ['Naruceno', 'Prihvaceno', 'Odbijeno', 'U izradi', 'Zavrseno', 'Kompletirano'],
                        series: [[45, 22, 33, 44, 55, 66]]
                    },
                    options: {
                        axisX: {
                            showGrid: false
                        },
                        low: 0,
                        high: 80,
                        chartPadding: {
                            top: 0,
                            right: 5,
                            bottom: 0,
                            left: 0
                        }
                    },
                    responsiveOptions: [
                        ['screen and (max-width: 640px)', {
                            seriesBarDistance: 5,
                            axisX: {
                                labelInterpolationFnc: function (value) {
                                    return value[0]
                                }
                            }
                        }]
                    ]
                },
                headers: [
                    {
                        sortable: false,
                        text: 'ID',
                        value: 'id'
                    },
                    {
                        sortable: false,
                        text: 'Name',
                        value: 'name'
                    },
                    {
                        sortable: false,
                        text: 'Salary',
                        value: 'salary',
                        align: 'right'
                    },
                    {
                        sortable: false,
                        text: 'Country',
                        value: 'country',
                        align: 'right'
                    },
                    {
                        sortable: false,
                        text: 'City',
                        value: 'city',
                        align: 'right'
                    }
                ],
                items: [
                    {
                        id: 1,
                        name: 'Dakota Rice',
                        country: 'Niger',
                        city: 'Oud-Tunrhout',
                        salary: '$35,738'
                    },
                    {
                        id: 2,
                        name: 'Minerva Hooper',
                        country: 'Curaçao',
                        city: 'Sinaai-Waas',
                        salary: '$23,738'
                    },
                    {
                        id: 3,
                        name: 'Sage Rodriguez',
                        country: 'Netherlands',
                        city: 'Overland Park',
                        salary: '$56,142'
                    },
                    {
                        id: 4,
                        name: 'Philip Chanley',
                        country: 'Korea, South',
                        city: 'Gloucester',
                        salary: '$38,735'
                    },
                    {
                        id: 5,
                        name: 'Doris Greene',
                        country: 'Malawi',
                        city: 'Feldkirchen in Kārnten',
                        salary: '$63,542'
                    }
                ],
                tabs: 0,
                list: {
                    0: false,
                    1: false,
                    2: false
                }
            }
        },
        computed: {
            checkPartner() {
                if (isNaN(localStorage.getItem('partner_id'))) {
                    return true
                } else {
                    return false
                }
            },
        },
        methods: {
            complete(index) {
                this.list[index] = !this.list[index]
            },
            readStats() {
                axios.get('api/partnerInfo')
                    .then(response => {
                        let count = 0;
                        this.stats = response.data;
                        this.chartOptions.labels = [];
                        this.series = [];
                        for (let i = 2; i < this.stats.length; i++) {
                            count += this.stats[i].no;
                            this.chartOptions.labels.push(this.stats[i].status)
                            this.series.push(this.stats[i].no)
                            if (i > 6) {
                                this.total += count
                            }
                        }
                      this.totalWorkZone = this.stats[2].no + this.stats[3].no + this.stats[5].no + this.stats[6].no
                        if (count === 0) {
                            this.chartOptions.labels = ['Nema dovoljno podataka']
                            this.series = [1]
                        }
                        this.isChartLoaded = true;
                    })
                    .catch(error => {
                      console.log(error)
                        if (error.response != undefined && error.response.status == 401) {
                            this.loading = false
                            this.$swal.fire({
                                type: 'info',
                                title: "Info",
                                text: this.$t('validation.session'),
                            })
                        } else {
                            this.$swal.fire({
                                type: 'error',
                                title: this.$t('validation.error'),
                                text: this.$t('validation.error'),
                            })
                        }
                    })
            }
        },
        created() {
            if (!this.$auth.isAuthenticated()) {
                this.$router.push('/login')
            }
            this.readStats();

        }
    }
</script>
