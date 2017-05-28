import Vue from 'vue'
import store from './store'
import Event from './modules/Event'
import App from './components/App.vue'
import Loader from './components/Loader.vue'

Vue.component('Loader', Loader)

window.Event = new Event
window.noUiSlider = require('materialize-css/extras/noUiSlider/nouislider')

jQuery.extend( jQuery.fn.pickadate.defaults, {
    monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
    monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
    weekdaysFull: [ 'Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
    weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
    today: 'Aujourd\'hui',
    clear: false,
    close: 'Fermer',
    firstDay: 1,
    format: 'dddd dd mmmm yyyy',
    // formatSubmit: 'yyyy/mm/dd',
    labelMonthNext:"Mois suivant",
    labelMonthPrev:"Mois précédent",
    labelMonthSelect:"Sélectionner un mois",
    labelYearSelect:"Sélectionner une année"
});

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    template: '<App/>'
})
