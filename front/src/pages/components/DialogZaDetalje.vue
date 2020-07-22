<template>
  <v-container>
    <v-toolbar dark color="primary">
      <v-toolbar-title class="headline">Dialog za detalje</v-toolbar-title>
      <div class="flex-grow-1"></div>
    </v-toolbar>
    <v-card>
      <v-subheader style="color: black; font-size: 25px">Prikaz komponente</v-subheader>
      <v-card-text>
        <v-img
          src="@/SlikeKomponenti/details_dialog.png"
          style="margin-bottom: 15px; border: 3px solid #4CAF50"
        >
          <template v-slot:placeholder>
            <v-row
              class="fill-height ma-0"
              align="center"
              justify="center"
            >
              <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
            </v-row>
          </template>
        </v-img>
        <template style="margin-bottom: 15px">
          <v-card>
            <v-list
              :disabled="true"
              :three-line="threeLine"
            >
              <v-subheader style="color: black; font-size: 25px">Opis komponente</v-subheader>
              <v-list-item-group color="primary">
                <v-list-item
                  v-for="(item, i) in description"
                  :key="i"
                  :inactive="inactive"
                  style="color: black; font-weight: bold;"
                >
                  <v-list-item-content>
                    <v-list-item-title v-html="item.title"></v-list-item-title>
                    <v-list-item-subtitle v-if="threeLine" v-html="item.subtitle"></v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
            <v-divider style="margin: 20px 40px"></v-divider>
            <v-subheader style="color: black; font-size: 25px">Propovi</v-subheader>
            <v-row>
              <v-col cols="4">
                <v-img
                  alt="Propovi komponente dialog za detalje"
                  src="@/SlikeKomponenti/details_props.png"
                  style="margin: 5px 15px"
                >
                  <template v-slot:placeholder>
                    <v-row
                      class="fill-height ma-0"
                      align="center"
                      justify="center"
                    >
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                    </v-row>
                  </template>
                </v-img>
              </v-col>
              <v-col cols="8">
                <v-list
                  dense
                  :disabled="true"
                  :three-line="threeLineProps"
                >
                  <v-list-item-group color="primary">
                    <v-list-item
                      v-for="(item, i) in propsDescription"
                      :key="i"
                      :inactive="inactive"
                      style="color: black; font-weight: bold;"
                    >
                      <v-list-item-content>
                        <v-list-item-title v-html="item.title"></v-list-item-title>
                        <v-list-item-subtitle v-if="threeLine" v-html="item.subtitle"></v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                  </v-list-item-group>
                </v-list>
              </v-col>
            </v-row>
          </v-card>
        </template>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
  export default {
    name: "Dialog za detalje",
    data() {
      return {
        inactive: true,
        threeLine: true,
        threeLineProps: false,
        description: [
          {
            title: "Primjena",
            subtitle: "Univerzalna komponenta koja omogucava prikaz detaljanih informacija o izabranom elementu"
          },
          {
            title: "Sekcije",
            subtitle: "Podijeljena je na 2 sekcije, od kojih prva pruza osnovne informacije o izbranom elementu, dok druga omogucava tabelarni prikaz kao i izmjenu elemnata sadrzanih u izabranom"
          },
          {
            title: "Slajder",
            subtitle: "Desna sekcija sadrzi slajder pomocu kojeg se moze pregledati vise razlicitih evidencija podijeljenih po tabelama"
          },
        ],
        propsDescription: [
          {title: "detailsItemDialog", subtitle: "Na osnovu ovog propa komponenta zna kad treba da se prikaze"},
          {
            title: "dataForModal",
            subtitle: "Ovaj prop predstavlja podatke koje komponenta prima od parent komponente i vrsi prikaz tih podataka"
          },
          {
            title: "@close",
            subtitle: "Ukoliko se desi dogadjaj 'close', poziva se ogovarajuca metoda koja hendluje taj dogadjaj (zatvara dialog u kom se komponenta prikazuje)"
          },
        ]
      }
    }
  }
</script>

<style scoped>

</style>
