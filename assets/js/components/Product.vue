<template>
    <div class="card">
        <div class="card-image">
            <img :src="product.picture" :alt="product.name">
            <span class="card-title">{{ product.name }}</span>
            <a class="btn-floating halfway-fab waves-effect waves-light green" @click.prevent="storeOrder(product) && toast('Plat ajouté au panier avec succès !')">
                <i class="material-icons">add_shopping_cart</i>
            </a>
        </div>
        <div class="card-content">
            <a :href="product.restaurant.link" class="strong-text black-text">
                {{ product.restaurant.name }}
            </a>
            <p>
                <span class="green-text flow-text right">{{ product.selling_price }} €</span>
                <span class="grey-text text-darken-2">{{ product.dish_type.name }}</span>
            </p>
        </div>
    </div>
</template>

<script type="text/babel">
    import Vuex from 'vuex'

    export default {
        name: 'Product',
        props: ['product'],
        methods: {
            ...Vuex.mapActions(['storeOrder']),
            toast (message, delay = 3000) {
                let html = `${message}
							<a class="btn-flat yellow-text waves-effect right" onclick="$('#cartBtn').sideNav('show');">
								<i class="material-icons right">arrow_forward</i> Voir
							</a>`
                Materialize.toast(html, delay)
            }
        }
    }
</script>
