<template>
    <div id="app">
        <div class="fixed-action-btn">
            <a id="cartBtn" class="btn-floating btn-large waves-effect waves-light red" data-activates="cart" @click.prevent="authCheck">
                <i class="material-icons">shopping_cart</i>
            </a>
        </div>
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
                    <div class="col-xs-12">
                        <transition-group name="scale" tag="div" class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" :key="product.id" v-for="product in products">
                                <product :product="product"></product>
                            </div>
                        </transition-group>
                    </div>
                </template>
            </div>
        </div>
        <cart></cart>
    </div>
</template>

<script type="text/babel">
    import Vuex from 'vuex'
    import Product from './Product.vue'
    import Search from './Search.vue'
    import Cart from './Cart.vue'
    import mixins from '../modules/mixins'

    export default {
        name: 'App',
        components: { Product, Search, Cart },
        mixins: [mixins],
        data () {
            return {
                loading: true
            }
        },
        computed: {
            ...Vuex.mapGetters({
                products: 'queryResult'
            })
        },
        methods: {
            ...Vuex.mapActions(['loadDishes'])
        },
        /**
         * Evenement lancé une fois Vue prêt
         */
        created () {
            this.loadDishes().then(response => {
                this.products = response
            }).catch((error) => {
                console.error(error)
                this.toast("<i class='material-icons left red-text'>close</i>Une erreur s'est produite ! Le chargement des plats à échoué.")
            }).then(() => {
                this.loading = false
            })
        },
        /**
         * Evenement lancé une fois le DOM chargé
         */
        mounted () {
            $('#cartBtn').sideNav({
                    menuWidth: 300,
                    edge: 'right',
                    closeOnClick: false,
                    draggable: true
                }
            )
        }
    }
</script>
