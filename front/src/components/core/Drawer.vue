<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
  <v-navigation-drawer
    v-if="$auth.isAuthenticated()"
    id="app-drawer"
    v-model="inputValue"
    :src="image"
    app
    color="grey darken-2"
    dark
    floating
    mobile-break-point="991"
    persistent
    width="300"
  >
    <template v-slot:img="attrs">
      <v-img
        v-bind="attrs"
        gradient="to top, rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)"
      />
    </template>

    <v-list-item two-line>
      <v-list-item-avatar color="white">
        <v-img
          src="../../assets/logo.png"
          height="47"
          contain
        />
      </v-list-item-avatar>

      <v-list-item-title class="title">
        Media biro
      </v-list-item-title>
    </v-list-item>

    <v-divider class="mx-3 mb-3"/>


    <!-- Bug in Vuetify for first child of v-list not receiving proper border-radius -->
    <div/>

    <v-list>
      <div v-for="link in computedMenu">
        <v-list-item
          v-if="link.sub_pages === undefined"
          :prepend-icon="link.icon"
          :key="link.text"
          :to="link.to"
          active-class="primary white--text">
          <v-list-item-icon>
            <v-icon>{{link.icon}}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{link.text}}</v-list-item-title>
        </v-list-item>
        <v-list-group v-else
                      class="lighten-3"
                      :key="link.text"
                      :prepend-icon="link.icon"
                      active-class="white--text"
                      no-action>
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title v-text="link.text"></v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item
            v-for="subItem in link.sub_pages"
            :key="subItem.text"
            :prepend-icon="subItem.icon"
            :to="subItem.to"
            active-class="primary white--text"
            style="padding-left: 50px !important;">
            <v-list-item-icon>
              <v-icon>{{subItem.icon}}</v-icon>
            </v-list-item-icon>
            <v-list-item-title>{{subItem.text}}</v-list-item-title>
          </v-list-item>
        </v-list-group>
      </div>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
  // Utilities
  import {mapMutations, mapState} from 'vuex'
  import axios from 'axios'
  import {readNotifications} from "../../statics/DataTableFunctions";


  export default {
    props: {
      opened: {
        type: Boolean,
        default: false
      }
    },
    data: function () {
      return {
        notifications: localStorage.getItem('notifications')
      }
    },
    watch: {
      '$route' (to,from) {
        this.readNotifications()
      }
    },
    computed: {
      computedMenu() {
        if (isNaN(localStorage.getItem('partner_id'))) {
          return [
            {
              to: '/',
              icon: 'mdi-view-dashboard',
              text: 'Dashboard',
            },
            {
              to: '',
              icon: 'mdi-cog-outline',
              text: this.$t('drawer.management'),
              sub_pages: [
                {
                  to: '/bank',
                  icon: 'mdi-cash-100',
                  text: this.$t('drawer.banks')
                },
                {
                  to: '/items',
                  icon: 'mdi-ballot-outline',
                  text: this.$t('drawer.items')
                },
                {
                  to: '/worker',
                  icon: 'mdi-account-hard-hat',
                  text: this.$t('drawer.workers')
                },
                {
                  to: '/cities',
                  icon: 'mdi-home-city-outline',
                  text: this.$t('drawer.cities')
                },
                {
                  to: '/contactTypes',
                  icon: 'mdi-card-account-phone-outline',
                  text: this.$t('drawer.contact_types')
                },
                {
                  to: '/countries',
                  icon: 'mdi-earth',
                  text: this.$t('drawer.countries')
                },
                {
                  to: '/partnerType',
                  icon: 'mdi-account-tie',
                  text: this.$t('drawer.partner_types')
                },
                {
                  to: '/partners',
                  icon: 'mdi-briefcase-account',
                  text: this.$t('drawer.partners')
                },
                {
                  to: '/users',
                  icon: 'mdi-account-supervisor',
                  text: this.$t('drawer.users')
                },
                {
                  to: '/vehicles',
                  icon: 'mdi-car',
                  text: this.$t('drawer.vehicles')
                },
                {
                  to: '/serviceTypes',
                  icon: 'mdi-alpha-u-box',
                  text: this.$t('drawer.serviceTypes')
                },
                /*{
                    to: '/statuses',
                    icon: 'mdi-align-vertical-bottom',
                    text: this.$t('drawer.statuses')
                },*/
                {
                  to: '/workerTypes',
                  icon: 'mdi-account-multiple',
                  text: this.$t('drawer.worker_types')
                },
              ],
            },
            /* {
                to: '/table-list',
                icon: 'mdi-clipboard-outline',
                text: 'Table List'
            },

            {
                to: '/typography',
                icon: 'mdi-format-font',
                text: 'Typography'
            },
            {
                to: '/icons',
                icon: 'mdi-chart-bubble',
                text: 'Icons'
            },
            {
                to: '/maps',
                icon: 'mdi-map-marker',
                text: 'Maps'
            },
            {
                to: '/notifications',
                icon: 'mdi-bell',
                text: this.$t('drawer.notifications')
            },*/
            {
              to: '/evidention',
              icon: 'mdi-newspaper-variant-multiple-outline',
              text: 'Radna zona'
            },
            {
              to: '/evidentions',
              icon: 'mdi-clipboard-check-multiple-outline',
              text: 'Evidencije'
            },
            {
              to: '/reports',
              icon: 'mdi-clipboard-outline',
              text: 'Izvještaji'
            },
            {
              to: '',
              icon: 'mdi-cog-sync',
              text: this.$t('drawer.components'),
              sub_pages: [
                {
                  to: '/dialog-choose-item',
                  icon: 'mdi-table-check',
                  text: 'Tabelarni selekt'
                },
                {
                  to: '/table-management',
                  icon: 'mdi-google-spreadsheet',
                  text: 'Tabelarno upravljanje'
                },
                {
                  to: '/add-component',
                  icon: 'mdi-plus',
                  text: 'Dialog za dodavanje'
                },
                {
                  to: '/edit-component',
                  icon: 'mdi-pencil-outline',
                  text: 'Dialog za izmjenu'
                },
                {
                  to: '/details-component',
                  icon: 'mdi-account-details',
                  text: 'Dialog za detalje'
                },
              ],
            },
          ]
        } else {
          return [
            {
              to: '/',
              icon: 'mdi-view-dashboard',
              text: 'Dashboard',
            },
            {
              to: '/contracts',
              icon: 'mdi-file-account-outline',
              text: this.$t('drawer.contracts')
            },
            {
              to: '/partner-evidentions',
              icon: 'mdi-newspaper-variant-multiple-outline',
              text: this.$t('drawer.evidentions'),
            },
            {
              to: '/reportsPartner',
              icon: 'mdi-clipboard-outline',
              text: 'Izvještaji'
            },
          ]
        }
      },
      ...mapState('app', ['image', 'color']),
      inputValue: {
        get() {
          return this.$store.state.app.drawer
        },
        set(val) {
          this.setDrawer(val)
        }
      }
    },

    methods: {
      readNotifications,
      sortSubPages(array) {
        return array.sort(function (a, b) {
          b.text > a.text ? -1 : 1
        })
      },
      logout() {
        this.$auth.destroyToken();
        this.$router.push('/login');
      },
      ...mapMutations('app', ['setDrawer', 'toggleDrawer'])
    },

    created() {
      this.computedMenu.forEach(function (link) {
        if (link.sub_pages != undefined) {
          link.sub_pages.sort(function (a, b) {
            return a.text > b.text ? 1 : -1;
          });
        }
      });

    }
  }
</script>

<style lang="scss">
  #app-drawer {
    .v-list__tile {
      border-radius: 4px;

      &--buy {
        margin-top: auto;
        margin-bottom: 17px;
      }
    }

    .v-image__image--contain {
      top: 9px;
      height: 60%;
    }

    .search-input {
      margin-bottom: 30px !important;
      padding-left: 15px;
      padding-right: 15px;
    }
  }
</style>
