import Vue from 'vue'
import App from '@/components/App'
import router from '@/router'
import store from '@/store'
import i18n from '@/plugins/i18n'
import Vuesax from 'vuesax'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faLine, faWhatsapp } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'


import * as firebase from 'firebase'

import firebaseConfig from '@/plugins/firebaseConfig'

import '@/plugins'
import '@/components'
import '@/assets/css/output.css'

library.add({ faLine, faWhatsapp })

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false

Vue.use(Vuesax, {
  // options here
})

const firebaseApp = firebase.initializeApp(firebaseConfig)

export const db = firebaseApp.firestore()
export const storage = firebaseApp.storage().ref()

new Vue({
  router,
  i18n,
  store,
  render: h => h(App),
}).$mount('#app')

