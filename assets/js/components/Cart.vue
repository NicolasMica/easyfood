<template>
    <aside id="cart" class="side-nav">
        <loader v-if="loading"></loader>
        <ul class="collection with-header" v-show="!loading">
            <li class="collection-header">
                <h3 class="flow-text">Panier</h3>
            </li>
            <li class="collection-item avatar" v-for="item in orders">
                <div class="circle blue" :style="'background-image: url(' + item.picture + ')'"></div>
                <span>{{ item.name }}</span>
                <p>
                    <small class="grey-text text-darken-3">{{ item.restaurant.name }}</small>
                    <small class="grey-text text-darken-1">{{ item.dish_type.name }}</small>
                    <br>
                    Quantité: <span class="strong-text">{{ item.amount }}</span>
                </p>
                <small class="left">
                    <i @click="removeOrder(item)" class="material-icons red-text waves-effect cursor-interact">remove</i>
                    <i @click="storeOrder(item)" class="material-icons green-text waves-effect cursor-interact">add</i>
                </small>
                <p class="right-align">
                    <span class="green-text">{{ item.selling_price * item.amount }} €</span>
                </p>
                <div class="secondary-content">
                    <a href="#!" @click.prevent="destroyOrder(item)"><i class="material-icons red-text">delete</i></a>
                </div>
            </li>
            <li class="collection-item">
                <p>Total: <span class="flow-text green-text">{{ bill }} €</span></p>
            </li>
        </ul>
        <div class="collection">
            <a href="#!" class="collection-item waves-effect green-text">
                <i class="material-icons right">payment</i> Commander
            </a>
        </div>
    </aside>
</template>

<script type="text/babel">
    import Vuex from 'vuex'

    export default {
        name: 'Cart',
        data () {
            return {
                loading: false
            }
        },
        computed: {
            ...Vuex.mapGetters(['orders']),
            bill () {
                let total = 0
                this.orders.forEach(item => total += (item.selling_price * item.amount))
                return total
            }
        },
        methods: {
            ...Vuex.mapActions(['storeOrder', 'removeOrder', 'destroyOrder'])
        }
    }
</script>
