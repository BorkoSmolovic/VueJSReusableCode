<template>
  <v-container
          fill-height
          fluid
  >
    <v-row
      justify="center"
    >
      <v-flex xs12 md6 >
        <v-row justify="center">
          <material-card
            color="green"
            :title="$t('edit_user_info')"
          >
            <v-form>
              <v-container class="py-0">
                <v-row>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      readonly
                      v-model="form.name"
                      :label="$t('user_info.name')"
                      class="purple-input"
                    />
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      readonly
                      v-model="form.username"
                      class="purple-input"
                      :label="$t('user_info.username')"
                    />
                  </v-col>
                  <v-col
                    cols="12"
                    class="text-right"
                  >
                    <v-btn color="success" @click="openEditUserDialog">
                      Izmijeni šifru
                    </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </material-card>
        </v-row>

      </v-flex>
    </v-row>
    <edit-user-details
            :dialog.sync="dialog"
            :dataForModal.sync="dataForModal"
            @closeEditUserDetailsDialog="dialog=false"
            @editedUser="editedUser"
    />
  </v-container>
</template>

<script>
    import axios from 'axios';
    import DialogEditUserDetails from "../components/user/DialogEditUserDetails";

    export default {
        components: {
            'edit-user-details': DialogEditUserDetails
        },
        data: function () {
            return {

                languages: [],
                dataForModal: {},
                dialog: false,
                form: {
                    name: '',
                    username: '',
                    language: '',
                }
            }
        },

        methods: {
            editedUser(data) {
                this.form.name=data.response.name
                this.form.username=data.response.username
                this.form.language=data.language
            },
            readLanguages() {
                axios.get("api/language").then(({data}) => {
                    this.languages = data
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
            },
            openEditUserDialog() {
                this.dialog = true;
                this.dataForModal = {
                    name: this.form.name,
                    username: this.form.username,
                    language: this.form.language,
                    languages: this.languages,
                    password: '',
                    confirmPassword: '',
                }
            },
            readUser() {
                axios.get("api/getLogedUserData").then(({data}) => {
                    this.form.name = data[0].name;
                    this.form.username = data[0].username;
                    this.form.language = data[0].language;
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
        },

        created() {
            this.readUser()
            this.readLanguages()
        }



    }
</script>
