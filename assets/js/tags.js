import Vue from 'vue'
import Tags from './components/Tags'

Vue.filter('capitalize', value => {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
})

new Vue({
    el: '#tags',
    components: { Tags }
})
