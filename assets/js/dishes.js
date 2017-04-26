import Vue from 'vue'
import store from './store'
import Event from './modules/Event'
import App from './components/App.vue'
import Loader from './components/Loader.vue'

Vue.component('Loader', Loader)

window.Event = new Event

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    template: '<App/>'
})
