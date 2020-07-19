<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex xs12>
        <v-card class="elevation-5" color="grey lighten-4">
          <v-card-title>
            <v-row>
              <v-col cols="2" class="text-center">
               Korisnik

              </v-col>
              <v-col cols="8">
                Komentar
              </v-col>
              <v-col cols="2">
                Vrijeme
              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text>
            <v-alert color="error" v-if="messages.length < 1" icon="mdi-alert-circle-outline" class="justify-center">
              <div class="text-center">Nema podataka</div>
            </v-alert>
            <v-list v-if="messages.length > 0" ref="chat" id="messages" class="p-0 m-0">

              <template v-for="(item, index) in messages">
                <v-row>
                  <v-col cols="2">
                    <v-subheader class="pl-5"  v-if="item" :key="index">{{ item.user.name }}</v-subheader>
                  </v-col>
                  <v-col cols="8">
                    <v-textarea auto-grow dense rows="2" solo readonly v-if="item" :key="index" v-model="item.comment"/>
                  </v-col>
                  <v-col cols="2">
                    <v-subheader v-if="item" :key="index">{{ item.created_at }}</v-subheader>
                  </v-col>
                </v-row>
                <v-divider class="py-0 my-0"/>
              </template>
            </v-list>
          </v-card-text>
       <!--   <v-card-actions>
            <v-row>
              <v-col cols="11">
                <v-form ref="form">
                  <v-textarea
                    class="pl-5"
                    auto-grow
                    dense
                    rows="1"
                    v-model="form.comment"
                    :label="$t('message')"
                    single-line
                    solo-inverted
                  ></v-textarea>
                </v-form>
              </v-col>
              <v-col cols="1" align-self="end" class="pb-9">
                  <v-btn fab dark small color="primary" @click="add(api)">
                    <v-icon dark>mdi-send</v-icon>
                  </v-btn>
              </v-col>
            </v-row>
          </v-card-actions>-->
        </v-card>
      </v-flex>
    </v-layout>
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
  </v-container>
</template>

<script>
    import axios from 'axios'
    export default {
        props: {
            dataForModal: {},
            detailsItemDialog: false,
        },
        name: "EvidentionMessages",
        data() {
            return {
                snackbar: {
                    color: 'success',
                    show: false,
                    text: '',
                    timeout: 3000,
                },
                api: "comment",
                messages: [],
                form: {
                    evidention_id: this.dataForModal.id,
                    comment: '',
                },

            }
        },
        methods: {
            add(api) {
                if (!this.form.comment.trim().length>0) {
                    this.snackbar.color = 'error';
                    this.snackbar.text = this.$t('Morate unijeti poruku');
                    this.snackbar.show = true;
                    return;
                }
                axios.post('api/' + api, this.form).then((response) => {
                    this.messages.push(response.data)
                    this.form.comment="";
                }).catch(error => {
                    this.$swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: error,
                    })
                })
            }
        },
        created(){
          this.messages=this.dataForModal.comment
        },
        watch: {
            messages() {
                if(this.messages.length>0){
                    setTimeout(() => {
                        this.$refs.chat.$el.scrollTop = this.$refs.chat.$el.scrollHeight;
                    }, 0);
                }
            },
        },
    }
</script>

<style scoped>
  #messages {
    padding: 0;
    margin: 0;
    max-height: 400px;
    height: auto;
    overflow: auto;
  }
</style>
