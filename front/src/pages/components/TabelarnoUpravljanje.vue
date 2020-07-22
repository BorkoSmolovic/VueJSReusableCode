<template>
  <v-container>
    <v-toolbar dark color="primary">
      <v-toolbar-title class="headline">Tabelarno upravljanje</v-toolbar-title>
      <div class="flex-grow-1"></div>
    </v-toolbar>
    <v-card>
      <v-subheader style="color: black; font-size: 25px">Prikaz komponente</v-subheader>
      <v-card-text>
        <v-img
          src="@/SlikeKomponenti/table_management.png"
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
              <v-col cols="5">
                <v-img
                  alt="Propovi komponente za Tabelarno upravljanje"
                  src="@/SlikeKomponenti/table_management_props.png"
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
              <v-col cols="7">
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
          {title: "Primjena", subtitle: "Komponenta omogucava tabelarni prikaz elemenata"},
          {
            title: "Filteri",
            subtitle: "Komponenta sadrzi univerzalne filtere koji se generisu preko headera koji joj se proslijede"
          },
          {
            title: "Dugmad",
            subtitle: "Komponenta sadrzi univerzalno dugme refresh koje omogucava ponovno ucitavanje podataka kao i dugme find i clear koji vrse ili ciste pretragu po filterima"
          },
          {
            title: "Akcije",
            subtitle: "Akcije koje se mogu izvrsiti nad komponentom su dodavanje i editovanje izabranog elementa"
          },
        ],
        propsDescription: [
          {title: "mobile-breakpoint", subtitle: "Na osnovu ovog propa komponenta zna kako da se prilagodi za mobilne uredjaje"},
          {
            title: "headers",
            subtitle: "Headeri omogucavaju komponenti da dinamicki izgenerise odgovarajuce kolone za elemente"
          },
          {
            title: "items",
            subtitle: "Ovaj prop predstavlja niz elemenata koji treba da se prikazu u tabeli"
          },
          {
            title: "items-per-page",
            subtitle: "Na osnovu ovog propa komponenta zna koliko elemenata treba da prikaze na jednoj stranici"
          },
          {
            title: "footer-props",
            subtitle: "Ovaj prop predstavlja opcije za footer (broj vidljivih elemenata na jednoj stranici)"
          },
          {
            title: "dense",
            subtitle: "Ovaj prop suzava tabelu i daje ljepsi prikaz elemenata"
          },
          {
            title: "loading-text",
            subtitle: "Prop koji oznacava tekst koji ce se prikazati pri ucitavanju tabele"
          },
          {
            title: "loading",
            subtitle: "Na osnovu ovog propa komponenta zna kad je zapoceto/zavrseno ucitavanje podataka u tabelu"
          },
        ]
      }
    }
  }
</script>

<style scoped>

</style>
