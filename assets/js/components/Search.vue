<template>
    <ul class="collapsible" data-collapsible="accordion">
        <li>
            <div class="collapsible-header flow-text">
                <i class="material-icons grey-text text-darken-1">search</i>
                Critères de recherche
                <i class="material-icons grey-text text-darken-1 right">keyboard_arrow_down</i>
            </div>
            <div class="collapsible-body white">
                <loader v-if="loading"></loader>
                <div class="row" v-show="!loading">
                    <!-- Dish types -->
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-field">
                            <select id="frmDishTypes" name="dishTypes" multiple>
                                <option value="" disabled>Types de plats</option>
                                <option v-for="type in dishTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                            </select>
                            <label for="frmDishTypes">Filtrer par types de plats</label>
                        </div>
                    </div>
                    <!-- Cities -->
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-field">
                            <select id="frmCities" name="cities" multiple>
                                <option value="" disabled>Villes</option>
                                <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                            </select>
                            <label for="frmCities">Filtrer par villes</label>
                        </div>
                    </div>
                    <!-- Restaurants -->
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-field">
                            <select id="frmRestaurants" name="restaurants" multiple>
                                <option value="" disabled>Restaurants</option>
                                <option v-for="restaurant in restaurants" :key="restaurant.id" :value="restaurant.id">{{ restaurant.name }}</option>
                            </select>
                            <label for="frmRestaurants">Filtrer par restaurants</label>
                        </div>
                    </div>
                    <!-- Price Range -->
                    <div class="col-xs-12 col-sm-6">
                        <div class="input-field">
                            <label for="frmPriceRange" class="active">Filtrer par prix</label>
                            <br>
                            <div id="frmPriceRange"></div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</template>

<script type="text/babel">
    import Vuex from 'vuex'

    export default {
        name: 'Search',
        data () {
            return {
                form: {
                    dishTypes: [],
                    cities: [],
                    restaurants: [],
                    price: {
                        min: 0,
                        max: null
                    }
                },
                loading: true,
                dishTypes: [],
                cities: [],
                restaurants: []
            }
        },
        computed: {
            ...Vuex.mapGetters(['dishes', 'queryResult'])
        },
        methods: {
            ...Vuex.mapActions(['loadOptions', 'updateQuery']),
            updateSelect (name, value) {
                if (value === null) value = []
                let items = value.map(id => this[name].find(item => id == item.id))
                this.$set(this.form, name, items)

                this.filter(this.form)
            },
            updateSlider (min, max) {
                let price = {
                    min: parseFloat(min.replace(' €', '')),
                    max: parseFloat(max.replace(' €', ''))
                }
                this.$set(this.form, 'price', price)

                this.filter(this.form)
            },
            filter (query) {
                let resultSet = this.dishes.filter(dish => {
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

                    return !(query.price.min > dish.selling_price || query.price.max < dish.selling_price);
                })

                this.updateQuery(resultSet)
            }
        },
        created () {
            this.loadOptions().then((response) => {
                this.cities = response.cities
                this.restaurants = response.restaurants
                this.dishTypes = response.dishTypes

                this.$nextTick(() => {
                    window.matetrialSelect.trigger('loaded')
                })
            }).catch((error) => {
                console.error(error)
                Materialize.toast("<i class='material-icons left red-text'>close</i>Une erreur s'est produite ! Le chargement des critères de recherche à échoué.", 3000)
            }).then(() => {
                this.loading = false
            })

            Event.listen('dishes_loaded', () => {
                let max = null
                let prices = []
                this.dishes.forEach(dish => {
                    let candidate = parseFloat(dish.selling_price)
                    prices.push(candidate)
                    if (candidate > max) max = candidate
                })

                this.form.price.max = max
                prices = prices.sort((x, y) => x - y)
                prices.pop()

                prices = prices.reduce((obj, v, i) => {
                    let size = (prices.length + 2)
                    let index = (i + 1)
                    let value = parseFloat((index / size) * 100).toFixed(0)
                    obj[value + "%"] = v
                    return obj;
                }, {})

                window.materialSlider.noUiSlider.updateOptions({
                    range: {  'min': 0, ...prices, 'max': max }
                })
            })
        },
        mounted () {
            let _this = this

            $(document).ready(function() {

                window.matetrialSelect = $('select')

                window.matetrialSelect.on('loaded', function () {
                    $(this).material_select()
                })

                window.matetrialSelect.on('change', function () {
                    _this.updateSelect($(this).attr('name'), $(this).val())
                })
            })

            window.materialSlider = document.getElementById('frmPriceRange')

            window.noUiSlider.create(window.materialSlider, {
                start: [0, 100],
                connect: true,
                snap: true,
                range: {
                    'min': 0,
                    'max': 100
                },
                format: {
                    to: function ( value ) {
                        return value + ' €';
                    },
                    from: function ( value ) {
                        return value.replace(' €', '');
                    }
                }
            })

            window.materialSlider.noUiSlider.on('update', function (values) {
                _this.updateSlider(values[0], values[1])
            })
        }
    }
</script>
