<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <search></search>
            </div>
            <template v-if="loading">
                <!-- Loader -->
                <div class="col-xs-12">
                    <div class="preloader-container">
                        <loader></loader>
                    </div>
                </div>
            </template>
            <template v-else>
                <!-- Products -->
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" v-for="product in products">
                    <product :product="product"></product>
                </div>
            </template>
        </div>
    </div>
</template>

<script type="text/babel">
    import Vuex from 'vuex'
    import Product from './Product.vue'
    import Search from './Search.vue'

    export default {
        name: 'App',
        components: { Product, Search },
        data () {
            return {
                loading: true,
                products: [],
            }
        },
        computed: {
            ...Vuex.mapGetters(['dishes'])
        },
        methods: {
            ...Vuex.mapActions(['loadDishes']),
            search (query) {
                this.products = this.dishes.filter(dish => {
                    if (query.dishTypes.length > 0) {
                        let dishTypes = query.dishTypes.find(item => item.id === dish.dish_type.id)
                        if (dishTypes === undefined) return false
                    }

                    if (query.cities.length > 0) {
                        let cities = query.cities.find(item => item.id === dish.restaurant.city_id)
                        if (cities === undefined) return false
                    }

                    if (query.restaurants.length > 0) {
                        let restaurants = query.restaurants.find(item => item.id === dish.restaurant.id)
                        if (restaurants === undefined) return false
                    }

                    return true
                })
                console.log(this.products)
            }
        },
        created () {
            this.loadDishes().then(response => {
                this.products = response
            }).catch((error) => {
                console.error(error)
                Materialize.toast("<i class='material-icons left red-text'>close</i>Une erreur s'est produite ! Le chargement des plats à échoué.", 3000)
            }).then(() => {
                this.loading = false
            })

            Event.listen('input', query => this.search(query))
        }
    }
</script>
