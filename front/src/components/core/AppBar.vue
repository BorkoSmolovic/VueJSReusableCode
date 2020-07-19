<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-app-bar
    :key="notifications.comments.length+notifications.evidentions.length"
    v-if="$auth.isAuthenticated()"
    id="core-app-bar"
    absolute
    app
    color="transparent"
    flat
    height="88"
  >
    <v-toolbar-title class="tertiary--text font-weight-light align-self-center">
      <v-btn
        v-if="responsive"
        icon
        @click.stop="onClick"
      >
        <v-icon>mdi-view-list</v-icon>
      </v-btn>
      <!--      {{ title }}-->
    </v-toolbar-title>

    <v-row>
      <!-----------------------     Skidanje Uputstva    ---------------------------------->
      <v-menu
        v-if="show"
        v-model="downloadMenu"
        :disabled="disabled"
        :absolute="absolute"
        :open-on-hover="openOnHover"
        :close-on-click="closeOnClick"
        :close-on-content-click="closeOnContentClick"
        :offset-x="offsetX"
        :offset-y="offsetY"
      >
        <template v-slot:activator="{ on }">
          <v-btn
            class="ml-10"
            v-on="on">
            <v-icon>
              mdi-file-document
            </v-icon>
            &nbsp;&nbsp;Preuzmite uputstvo
          </v-btn>
        </template>
        <v-list>
          <v-list-item
            @click="downloadManual"
          >
            <v-icon>mdi-briefcase</v-icon>
            <v-list-item-title>&nbsp;&nbsp;Za Radnike</v-list-item-title>
          </v-list-item>
        </v-list>
        <v-list>
          <v-list-item
            @click="downloadUserManual"
          >
            <v-icon>mdi-account</v-icon>
            <v-list-item-title>&nbsp;&nbsp;Za Korisnike</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-btn
        v-if="!show"
        @click="downloadUserManual"
        class="ml-10"
        dark
        outlined
        color="success">
          <v-icon>
            mdi-account
          </v-icon>
          Preuzmite uputstvo
      </v-btn>
      <div class="flex-grow-1"></div>
    </v-row>

    <v-spacer/>

    <v-toolbar-items>
      <v-row
        align="center"
        class="mx-0">
        <!--<div>
            <button class="langButton" v-for="entry in languages" :key="entry.title"
                    @click="changeLocale(entry.language)">
                <flag :iso="entry.flag" v-bind:squared="false"/>
            </button>
        </div>-->
        <v-menu
          bottom
          left
          offset-y
          transition="slide-y-transition"
        >
          <!-- <template v-slot:activator="{ attrs, on }">
               <v-btn
                       class="toolbar-items"
                       icon
                       v-bind="attrs"
                       v-on="on">
                   <v-badge
                           color="error"
                           overlap>
                       <template slot="badge">
                           {{ notifications.length }}
                       </template>
                       <v-icon color="tertiary">
                           mdi-bell
                       </v-icon>
                   </v-badge>
               </v-btn>
           </template>

           <v-card>
               <v-list dense>
                   <v-list-item
                           v-for="notification in notifications"
                           :key="notification"
                           @click="onClick">
                       <v-list-item-title v-text="notification"/>
                   </v-list-item>
               </v-list>
           </v-card>-->
        </v-menu>
        <!-----------------------      NOTIFIKACIJE    ---------------------------------->
        <v-menu
          v-model="notificationsMenu"
          :disabled="disabled"
          :absolute="absolute"
          :open-on-hover="openOnHover"
          :close-on-click="closeOnClick"
          :close-on-content-click="closeOnContentClick"
          :offset-x="offsetX"
          :offset-y="offsetY"
        >
          <template v-slot:activator="{ on }">
            <v-btn
              @mouseenter="rerenderAppBar"
              icon
              class="mr-5"
              v-on="on">
              <v-badge
                :bottom="false"
                color="warning"
                :left="false"
                :overlap="false"
                class="align-self-center"
              >
                <template v-if="notifications.comments.length + notifications.evidentions.length >= 0 && showNotifications" v-slot:badge>
                  <span>{{notifications.comments.length + notifications.evidentions.length}}</span>
                </template>
                <v-icon>
                  mdi-chat-processing
                </v-icon>
              </v-badge>
            </v-btn>
          </template>
          <v-list v-if="notifications.comments.length > 0"
          dense
          >
            <v-subheader>Novi komentari:</v-subheader>
            <v-list-item
              v-for="(item, index) in notifications.comments"
            >
              <v-list-item-content>
                <v-list-item-title class="grey--text"> {{'(ID:'+ item.id + ')'}} </v-list-item-title>
                <v-list-item-subtitle class="black--text">{{'Evidencija: ' + item.event_name + ', korisnik: '+item.name+''}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <v-list v-if="notifications.evidentions.length > 0"
          dense
          >
            <v-subheader>Nove evidencije:</v-subheader>
            <v-list-item
              v-for="(item, index) in notifications.evidentions"
            >
              <v-list-item-content>
                <v-list-item-title class="grey--text"> {{'(ID:'+ item.id + ')'}} </v-list-item-title>
                <v-list-item-subtitle class="black--text">{{'Evidencija: ' + item.event_name + ', korisnik: '+item.name+''}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <v-list v-if="notifications.comments.length === 0 && notifications.evidentions.length === 0">
            <v-list-item>
              <v-list-item-title> Nema novih notifikacija </v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
        <!-----------------------     Korisnicki meni    ---------------------------------->
        <v-menu
          v-model="value"
          :disabled="disabled"
          :absolute="absolute"
          :open-on-hover="openOnHover"
          :close-on-click="closeOnClick"
          :close-on-content-click="closeOnContentClick"
          :offset-x="offsetX"
          :offset-y="offsetY"
        >
          <template v-slot:activator="{ on }">
            <v-btn
              v-on="on"
            >
              <v-icon>
                mdi-account-circle
              </v-icon>
              &nbsp;Dobrodošli, {{username}}
            </v-btn>
          </template>
          <v-list>
            <v-list-item
              v-for="(item, index) in items"
              :key="index"
              @click="goTo(index)"
            >
              <v-list-item-icon>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-row>
    </v-toolbar-items>
  </v-app-bar>
</template>

<script>
    // Utilities
    import Auth from "../../settings/auth/Auth";
    import {mapMutations} from 'vuex'
    import {readNotifications} from "../../statics/DataTableFunctions";
    import i18n from '../../lang/lang'
    import axios from 'axios'

    export default {
        data: () => ({
            show: isNaN(localStorage.getItem('partner_id')) ,
            downloadMenu:false,
            showNotifications:false,
            notifications: JSON.parse(localStorage.getItem('notifications')),
            username: localStorage.getItem('username'),
            disabled: false,
            absolute: false,
            openOnHover: false,
            value: false,
            notificationsMenu:false,
            closeOnClick: true,
            closeOnContentClick: true,
            offsetX: false,
            offsetY: true,
            items: [
                {title: "Podešavanja profila", link: "/user-profile", icon: "mdi-account-settings"},
                {title: "Logout", link: "logout", icon: "mdi-exit-to-app"}
            ],
            languages: [
                {flag: 'gb', language: 'en', title: 'English'},
                {flag: 'me', language: 'me', title: 'Crnogorski'},

            ],
           /* notifications: [
                'Mike, John responded to your email',
                'You have 5 new tasks',
                'You\'re now a friend with Andrew',
                'Another Notification',
                'Another One'
            ],*/
            title: null,
            responsive: true
        }),
        mounted() {
            this.onResponsiveInverted()
            window.addEventListener('resize', this.onResponsiveInverted)
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.onResponsiveInverted)
        },

        methods: {
            readNotifications,
            rerenderAppBar(){
                this.readNotifications();
                this.$forceUpdate();
                this.notifications = JSON.parse(localStorage.getItem('notifications'));
                this.showNotifications=true;
            },
            downloadUserManual() {
                const FileDownload = require('js-file-download');
                axios({
                    url: 'api/instructionClient',
                    method: "GET",
                    responseType: "blob" // important
                }).then(response => {
                    FileDownload(response.data, 'uputstvo.pdf');
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
                        this.$swal.fire({
                            type: 'error',
                            title: this.$t('validation.error'),
                            text: this.$t('validation.error'),
                        })
                    }
                })
            },
            downloadManual() {
                const FileDownload = require('js-file-download');
                axios({
                    url: 'api/instruction',
                    method: "GET",
                    responseType: "blob" // important
                }).then(response => {
                    FileDownload(response.data, 'uputstvo.pdf');
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
                        this.$swal.fire({
                            type: 'error',
                            title: this.$t('validation.error'),
                            text: this.$t('validation.error'),
                        })
                    }
                })
            },
            goTo(index) {
                if (index == 0) {
                    this.$router.push(this.items[index].link)
                } else {
                    this.logout()
                }

            },
            logout() {
                this.$auth.destroyToken();
                localStorage.clear();
                this.$router.push('/login');
            },
            changeLocale(locale) {
                i18n.locale = locale;
            },
            ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
            onClick() {
                this.setDrawer(!this.$store.state.app.drawer)
            },
            onResponsiveInverted() {
                // if (window.innerWidth < 1920) {
                //   this.responsive = true
                // } else {
                //   this.responsive = false
                // }
            }
        },
        created() {
          this.rerenderAppBar();
        }
    }
</script>

<style>

  .langButton {
    padding: 0px;
    font-size: 25px;
    margin-right: 10px;
  }

  /* Fix coming in v2.0.8 */
  #core-app-bar {
    width: auto;
  }

  #core-app-bar a {
    text-decoration: none;
  }
</style>
