<template>
  <v-container>
    <v-toolbar dark color="primary">
      <v-toolbar-title class="headline">Dialog za dodavanje</v-toolbar-title>
      <div class="flex-grow-1"></div>
    </v-toolbar>
    <v-card>
      <v-subheader style="color: black; font-size: 25px">Prikaz komponente</v-subheader>
      <v-card-text>
        <v-row>
          <v-col cols="6">
            <v-img
              src="@/SlikeKomponenti/add_dialog.png"
              style="margin-bottom: 15px; border: 3px solid #4CAF50; max-height: 550px"
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
          <v-col cols="6">
            <v-img
              src="@/SlikeKomponenti/add_partner_dialog.png"
              style="margin-bottom: 15px; border: 3px solid #4CAF50; max-height: 550px"
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
        </v-row>


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
                  alt="Propovi komponente dialog za dodavanje"
                  src="@/SlikeKomponenti/add_dialog_props.png"
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
    name: "Dialog za dodavanje",
    data() {
      return {
        inactive: true,
        threeLine: true,
        threeLineProps: false,
        description: [
          {
            title: "Primjena",
            subtitle: "Ova komponenta omogucava dodavanje odredjenog elementa popunjavanjem njegovih atributa"
          },
          {
            title: "Polja",
            subtitle: "Komponenta sadrzi polja u zavisnosti od elementa koji se dodaje (lijeva slika predstavlja osnovnu reusable komponentu, dok desna predstavlja dopunjenu lijevu komponentu sa dodatnim poljima)"
          },
          {
            title: "Akcije",
            subtitle: "Akcije koje se mogu izvrsiti nad komponentom su potvrda unosa ili zatvaranje komponente"
          },
        ],
        propsDescription: [
          {
            title: "addItemDialog", subtitle: "Na osnovu ovog propa komponenta zna kad treba da se prikaze"
          },
          {
            title: "dataForModal",
            subtitle: "Ovaj prop predstavlja podatke koje komponenta prima od parent komponente i vrsi prikaz tih podataka"
          },
          {
            title: "@close",
            subtitle: "Ukoliko se desi dogadjaj 'close', poziva se ogovarajuca metoda koja hendluje taj dogadjaj (zatvara dialog u kom se komponenta prikazuje)"
          },
          {
            title: "@addEmit",
            subtitle: "Ukoliko se desi dogadjaj 'addEmit', poziva se metoda koja hendluje taj dogadjaj (prihvata element napravljen od podataka iz komponente za dodavanje i vrsi dodavanje elementa u tabelu)"
          },
        ]
      }
    }
  }
</script>

<style scoped>

</style>
