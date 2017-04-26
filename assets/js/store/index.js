import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

const ajax = axios.create({
    headers: {
        ContentType: 'application/json',
        Accept: 'application/json'
    },
    baseURL: 'http://easyfood.dev/'
})

const state = {
    dishes: [],
    cities: [],
    dishTypes: [],
    restaurants: [],
    orders: []
}

const mutations = {
    LOAD_DISHES: (state, entities) => state.dishes = entities,
    LOAD_CITIES: (state, entities) => state.cities = entities,
    LOAD_RESTAURANTS: (state, entities) => state.restaurants = entities,
    LOAD_DISH_TYPES: (state, entities) => state.dishTypes = entities,
    STORE_ORDER: (state, entity) => state.orders.push(entity),
    DESTROY_ORDER: (state, entity) => state.orders.splice(state.orders.findIndex(order => order === entity), 1)
}

const actions = {
    loadDishes (store) {
        return new Promise((resolve, reject) => {
            ajax.get('plats').then(response => {
                store.commit('LOAD_DISHES', response.data.dishes)
                resolve(store.state.dishes)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    },
    loadOptions (store) {
        return new Promise((resolve, reject) => {
            axios.all([
                ajax.get('villes'),
                ajax.get('restaurants'),
                ajax.get('plats/types')
            ]).then(axios.spread(function (cities, restaurants, types) {
                store.commit('LOAD_CITIES', cities.data.cities)
                store.commit('LOAD_RESTAURANTS', restaurants.data.restaurants)
                store.commit('LOAD_DISH_TYPES', types.data.dishTypes)

                resolve({
                    cities: cities.data.cities,
                    restaurants: restaurants.data.restaurants,
                    dishTypes: types.data.dishTypes,
                })
            })).catch(error => {
                reject(error)
            })
        })
    },
    storeOrder: (store, entity) => store.commit('STORE_ORDER', entity),
    destroyOrder: (store, entity) => store.commit('DESTROY_ORDER', entity),
    submitOrder (store, order) {
        return new Promise((resolve, reject) => {
            ajax.post('dishes/submit', order).then(response => {
                resolve(response.data)
            }).catch(error => {
                reject(error.response.data)
            })
        })
    }
}

const getters = {
    orders: (state) => state.orders,
    dishes: (state) => state.dishes
}

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',
    state,
    mutations,
    actions,
    getters
})
