<template>
    <div class="card">
        <div class="card-image">
            <img :src="product.picture" :alt="product.name">
            <span class="card-title">{{ product.name }}</span>
            <a class="btn-floating halfway-fab waves-effect waves-light red">
                <i class="material-icons">add</i>
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
        <div class="card-action right-align">
            <a href="#">En savoir plus</a>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        name: 'Product',
        props: ['product']
    }
</script>
