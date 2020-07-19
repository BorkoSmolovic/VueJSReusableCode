<template>
    <div>
        <v-form>
        <v-combobox
                v-model="contactType"
                :items="items"
                :hide-selected="hideSelected"
                label="Add some tags"
                :multiple="multiple"
                persistent-hint
                :small-chips="chips"
                :clearable="clearable"
        >
            <template v-if="noData" v-slot:no-data>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title>
                            No results matching "<strong>{{ search }}</strong>". Press <kbd>enter</kbd> to create a new one
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-combobox>
        <v-col cols="12">
            <v-text-field
                    v-model="form.name"
                    label="*Ime" required
                    :rules="rules.required"
                    autocomplete="off"
            />
        </v-col>
            <v-col>
                <v-btn>
                    <v-icon>mdi-plus-circle-outline</v-icon>
                </v-btn>
            </v-col>
        </v-form>
    </div>
</template>

<script>
    export default {
        name: "AddContactForm",
        data: () => ({
            items: ['Gaming', 'Programming', 'Vue', 'Vuetify'],
            model: ['Vuetify'],
            search: null,
            chips: true,
            multiple: true,
            hideSelected: false,
            noData: true,
            clearable: false,
        }),
    }
</script>

<style scoped/>
