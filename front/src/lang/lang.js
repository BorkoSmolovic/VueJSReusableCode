import Vue from 'vue'
import VueI18n from 'vue-i18n'

import en from './locale/en.json'
import me from './locale/me.json'

Vue.use(VueI18n)

const locale = 'me'
const messages = {
  en, me
}

const i18n = new VueI18n({
  locale,
  messages
})

export default i18n
