import Vue from 'vue'

export default class Event {

    /**
     * Class constructor
     */
    constructor () {
        this.vue = new Vue()
    }

    /**
     * Fire an event
     * @param event - Event name
     * @param playload - Event playload
     */
    fire (event, playload = null) {
        this.vue.$emit(event, playload)
    }

    /**
     * Listen to an event
     * @param event - Event name
     * @param callback - Callback function
     */
    listen (event, callback) {
        this.vue.$on(event, callback)
    }
}
