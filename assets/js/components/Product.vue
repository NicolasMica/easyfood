<template>
    <div class="card">
        <div class="card-image">
            <img :src="product.picture" :alt="product.name">
            <span class="card-title">{{ product.name }}</span>
            <a class="btn-floating halfway-fab waves-effect waves-light green" @click.prevent="storeOrder(product)">
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
            ...Vuex.mapActions(['storeOrder'])
        }
    }
</script>
