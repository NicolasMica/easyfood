<template>
    <div class="card">
        <div class="card-content">
            <span class="card-title">Rechercher</span>
            <loader v-if="loading"></loader>
            <div class="row" v-show="!loading">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="input-field">
                        <select id="frmDishTypes" name="dishTypes" multiple>
                            <option value="" disabled>Types de plats</option>
                            <option v-for="type in dishTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                        </select>
                        <label for="frmDishTypes">Filtrer par types de plats</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="input-field">
                        <select id="frmCities" name="cities" multiple>
                            <option value="" disabled>Villes</option>
                            <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                        </select>
                        <label for="frmCities">Filtrer par villes</label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="input-field">
                        <select id="frmRestaurants" name="restaurants" multiple>
                            <option value="" disabled>Restaurants</option>
                            <option v-for="restaurant in restaurants" :key="restaurant.id" :value="restaurant.id">{{ restaurant.name }}</option>
                        </select>
                        <label for="frmRestaurants">Filtrer par restaurants</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    restaurants: []
                },
                loading: true,
                dishTypes: [],
                cities: [],
                restaurants: []
            }
        },
        methods: {
            ...Vuex.mapActions(['loadOptions']),
            updateSelect (name, value) {
                if (value === null) value = []
                let items = value.map(id => this[name].find(item => id == item.id))
                this.$set(this.form, name, items)
                Event.fire('input', this.form)
            }
        },
        created () {
            this.loadOptions().then((response) => {
                this.cities = response.cities
                this.restaurants = response.restaurants
                this.dishTypes = response.dishTypes

                this.$nextTick(() => {
                    $('select').trigger('loaded')
                })
            }).catch((error) => {
                console.error(error)
                Materialize.toast("<i class='material-icons left red-text'>close</i>Une erreur s'est produite ! Le chargement des critères de recherche à échoué.", 3000)
            }).then(() => {
                this.loading = false
            })
        },
        mounted () {
            let _this = this

            $(document).ready(function() {

                $('select').on('loaded', function () {
                    $(this).material_select()
                })

                $('select').on('change', function () {
                    _this.updateSelect($(this).attr('name'), $(this).val())
                })
            })
        }
    }
</script>
