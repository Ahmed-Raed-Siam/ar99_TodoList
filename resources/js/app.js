require('./bootstrap');

import {createApp} from 'vue'
import App from './views/app.vue'

import {library} from '@fortawesome/fontawesome-svg-core'
import {faUserSecret, faPlusSquare, faTrash} from '@fortawesome/free-solid-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'

library.add(faUserSecret, faPlusSquare, faTrash)

const app = createApp({})

app.component('App', App)
    .component('font-awesome-icon', FontAwesomeIcon)

app.mount('#app')
