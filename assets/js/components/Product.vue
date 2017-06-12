<template>
    <div class="card">
        <!-- Dish -->
        <div :id="'dish-' + product.id">
            <div class="card-image">
                <img :src="product.picture" :alt="product.name">
                <span class="card-title">
                {{ product.name }}
            </span>
                <a class="btn-floating halfway-fab waves-effect waves-light green" @click.prevent="store(product)">
                    <i class="material-icons">add_shopping_cart</i>
                </a>
                <a class="btn-floating halfway-fab waves-effect white black-text left activator">
                    <i class="material-icons grey-text text-darken-3">more_horiz</i>
                </a>
            </div>
            <div class="card-content">
            <span class="strong-text black-text">
                {{ product.restaurant.name }}
            </span>
                <p>
                    <span class="green-text flow-text right">{{ product.selling_price }} €</span>
                    <span class="grey-text text-darken-2">{{ product.dish_type.name }}</span>
                </p>
            </div>
        </div>
        <div class="card-reveal">
            <span class="card-title">
                {{ product.name }}
                <i class="material-icons right">close</i>
            </span>
            <p>{{ product.description }}</p>
        </div>
        <!-- Restaurant -->
        <div :id="'restaurant-' + product.id" class="card-content">
            <span class="card-title">{{ product.restaurant.name }}</span>
            <div class="rates">
                <rate :label="review.label" :value="review.value" v-for="review in reviews" :key="review.id" readonly></rate>
                <p v-if="reviews === false">Ce restaurant n'a pas encore de note</p>
            </div>
        </div>
        <div class="card-tabs">
            <ul class="tabs tabs-fixed-width">
                <li class="tab">
                    <a :href="'#dish-' + product.id">Plat</a>
                </li>
                <li class="tab">
                    <a :href="'#restaurant-' + product.id">Restaurant</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script type="text/babel">
    import Vuex from 'vuex'
    import mixins from '../modules/mixins'
    import Rate from './Rate.vue'

    export default {
        name: 'Product',
        components: { Rate },
        mixins: [mixins],
        props: ['product'],
        data () {
            return {
                reviews: false
            }
        },
        methods: {
            ...Vuex.mapActions(['storeOrder']),
            /**
             * Vérifie la connexion & ajout le produit au panier
             * @param product - Produit à ajouter au panier
             * @returns {boolean} - Retourne faux si l'utilisateur est pas connecté
             */
            store (product) {

                if (!this.authCheck()) {
                    this.toast()
                    return false
                }

                let action = `<a class="btn-flat yellow-text waves-effect right" onclick="$('#cartBtn').sideNav('show');">
								<i class="material-icons right">arrow_forward</i> Voir
							</a>`
                this.toast('Plat ajouté au panier avec succès !', action)
                this.storeOrder(product)
                Event.fire('order_updated')
            }
        },
        created () {
            if (this.product.restaurant.reviews.length) {
                let review = this.product.restaurant.reviews[0]
                this.reviews = [
                    {
                        label: "Qualité du plat",
                        value: review.quality
                    },
                    {
                        label: "Respect de la recette",
                        value: review.recipe
                    },
                    {
                        label: "Esthétique du plat",
                        value: review.design
                    },
                    {
                        label: "Prix du plat",
                        value: review.price
                    }
                ]
            }
        },
        mounted () {
            // Setup card tabs
            $(document).ready(() => {
                $('ul.tabs').tabs();
            })
        }
    }
</script>
