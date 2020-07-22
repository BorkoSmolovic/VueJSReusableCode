<template>
  <v-container>
    <v-toolbar dark color="primary">
      <v-toolbar-title class="headline"> Tabelarni selekt</v-toolbar-title>
      <div class="flex-grow-1"></div>
    </v-toolbar>
    <v-card>
      <v-subheader style="color: black; font-size: 25px">Prikaz komponente</v-subheader>
      <v-card-text>
        <v-img
          src="@/SlikeKomponenti/dialog-choose-item.png"
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
                  alt="Propovi komponente Tabelarni selekt"
                  src="@/SlikeKomponenti/dci_props.png"
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
    name: "Tabelarni Selekt",
    data() {
      return {
        inactive: true,
        threeLine: true,
        threeLineProps: false,
        description: [
          {title: "Primjena", subtitle: "Komponenta omogucava detaljan prikaz i selekciju elementa koji se bira"},
          {
            title: "Filteri",
            subtitle: "Komponenta sadrzi univerzalne filtere koji se generisu preko headera koji joj se proslijede"
          },
          {
            title: "Dugmad",
            subtitle: "Komponenta sadrzi univerzalno dugme refresh koje omogucava ponovno ucitavanje podataka kao i dugme find i clear koji vrse ili ciste pretragu po filterima"
          },
          {title: "Checkbox", subtitle: "Checkbox elementi omogucavaju single/multi select elemenata komponente"},
          {
            title: "Akcije",
            subtitle: "Akcije koje se mogu izvrsiti nad komponentom su potvrda selekcije ili zatvaranje komponente"
          },
        ],
        propsDescription: [
          {title: "id", subtitle: "Ovaj prop omogucava citanje iz backenda po proslijedjenom ID-ju"},
          {
            title: "singleSelect",
            subtitle: "Na osnovu proslijedjene vrijednosti (true/false) omogucava se single/multi select"
          },
          {
            title: "api",
            subtitle: "Na osnovu ovog propa komponenta zna na koju rutu salje zahtjev backendu"
          },
          {
            title: "translation",
            subtitle: "Ovaj prop govori komponenti koje prevode da koristi"
          },
          {
            title: "headers",
            subtitle: "Headeri omogucavaju komponenti da dinamicki izgenerise odgovarajuce kolone za elemente"
          },
          {
            title: "dialogChooseItem",
            subtitle: "Na osnovu ovog propa komponenta zna kad treba da se prikaze"
          },
          {
            title: "@close",
            subtitle: "Ukoliko se desi dogadjaj 'close', poziva se ogovarajuca metoda koja hendluje taj dogadjaj (zatvara dialog u kom se komponenta prikazuje)"
          },
          {
            title: "@addSuperior",
            subtitle: "Ukoliko se desi dogadjaj 'addSuperior', poziva se ogovarajuca metoda koja hendluje taj dogadjaj (proslijedjuje izabrane podatke iz komponente u parent komponentu)"
          },
        ]
      }
    }
  }
</script>

<style scoped>

</style>
