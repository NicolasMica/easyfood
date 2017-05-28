<template>
    <aside id="cart" class="side-nav">
        <loader v-if="loading"></loader>
        <ul class="collection with-header" v-show="!loading">
            <li class="collection-header">
                <h3 class="flow-text">Panier</h3>
            </li>
            <li class="collection-item">
                <div class="input-field">
                    <select id="frmPayment" v-model="payment">
                        <option value="0">Carte bancaire</option>
                        <option value="1">Espece</option>
                    </select>
                    <label for="frmPayment">Méthode de paiement</label>
                </div>
                <div class="input-field">
                    <input type="date" id="frmDate" class="datepicker" name="date">
                    <label for="frmDate">Date de la livraison</label>
                </div>
                <div class="input-field">
                    <input type="time" id="frmTime" class="timepicker" name="time">
                    <label for="frmTime">Heure de la livraison</label>
                </div>
            </li>
            <transition-group name="scale" tag="li" v-if="orders.length > 0">
                <div class="collection-item avatar" :key="item.id" v-for="item in orders">
                    <div class="circle" :style="'background-image: url(' + item.picture + ')'"></div>
                    <span>{{ item.name }}</span>
                    <p>
                        <small class="grey-text text-darken-3">{{ item.restaurant.name }}</small>
                        <small class="grey-text text-darken-1">{{ item.dish_type.name }}</small>
                        <br>
                        Quantité: <span class="strong-text">{{ item.amount }}</span>
                    </p>
                    <small class="left">
                        <i @click="removeOrder(item)" class="material-icons waves-effect" :class="(item.amount === 1) ? 'grey-text' : 'red-text cursor-interact'">remove</i>
                        <i @click="storeOrder(item)" class="material-icons green-text waves-effect cursor-interact">add</i>
                    </small>
                    <p class="right-align">
                        <span class="green-text">{{ parseFloat(item.selling_price * item.amount).toFixed(2) }} €</span>
                    </p>
                    <div class="secondary-content">
                        <a href="#!" @click.prevent="destroy(item)">
                            <i class="material-icons red-text waves-effect">delete</i>
                        </a>
                    </div>
                </div>
            </transition-group>
            <li class="collection-item">
                <p>Total: <span class="flow-text green-text">{{ bill }} €</span></p>
            </li>
            <a href="#!" class="collection-item btn-flat waves-effect green-text" :class="submittable ? null : 'disabled'" @click.prevent="order">
                <i class="material-icons right">payment</i> Commander
            </a>
        </ul>
    </aside>
</template>

<script type="text/babel">
    import Vuex from 'vuex'
    import mixins from '../modules/mixins'
    import '../modules/materialize.clockpicker'

    export default {
        name: 'Cart',
        mixins: [mixins],
        data () {
            return {
                loading: false,
                payment: 0,
                date: null,
                time: null
            }
        },
        computed: {
            ...Vuex.mapGetters(['orders']),
            /**
             * Calcul le montant total de la commande
             * @returns {string} - Montant de la facture
             */
            bill () {
                let total = 0
                this.orders.forEach(item => total += (item.selling_price * item.amount))
                return total.toFixed(2)
            },
            /**
             * Génère un objet Date correspondant au choix de l'utilisateur
             * @returns {number}
             */
            timestamp () {
                if (this.time === null || this.date === null) return null
                let date = new Date(this.date)
                let time = this.time.split(':')
                date.setHours(time[0], time[1])
                return parseInt(date.getTime() / 1000)
            },
            submittable () {
                return this.orders.length > 0 && this.date !== null && this.time !== null
            }
        },
        methods: {
            ...Vuex.mapActions(['storeOrder', 'removeOrder', 'destroyOrder', 'submitOrder']),
            /**
             * Soumet la commande (submitOrder wrapper)
             */
            order () {
                this.submitOrder({
                    date: this.timestamp,
                    payment: this.payment
                }).then(response => {
                    if (response.success) this.reset()
                    this.toast(response.message, null, 5000)
                }).catch(error => {
                    this.toast(error.message, null, 5000)
                })
            },
            /**
             * Réinitialise le panier
             */
            reset () {
                this.payment = 0
                this.date = null
                this.time = null
                $('.datepicker').val(null)
                $('.timepicker').val(null)
                Materialize.updateTextFields()
            },
            /**
             * Supprime un produit du panier & actualise le filtre de recherche
             * @param item - Produit à supprimer du panier
             */
            destroy (item) {
                this.toast('Plat supprimé du panier avec succès !')
                this.destroyOrder(item)
                Event.fire('order_updated')
            }
        },
        mounted () {

            let _this = this

            $(document).ready(function() {

                $('#cart').find('select').on('change', function () {
                    _this.payment = $(this).val()
                })

                $('.datepicker').pickadate({
                    selectMonths: true,
                    selectYears: false,
                    closeOnSelect: true,
                    min: 'now',
                    onSet (value) {
                        _this.date = value.select
                    },
                    onClose () {
                        $('.datepicker').blur();
                    }
                })

                $('.timepicker').pickatime({
                    autoclose: true,
                    twelvehour: false,
                    fromnow: 0,
                    donetext: "Ok",
                    afterDone (element, value) {
                        _this.time = value
                        Materialize.updateTextFields()
                    }
                })
            })
        }
    }
</script>
