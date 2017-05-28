<template>
    <div class="rate">
        <label class="active">{{ label }}</label>
        <p>
            <i class="material-icons circle"
               :class="[(rate >= index) ? 'amber-text' : 'grey-text text-darken-2', {'waves-effect': readonly === false}]"
               @click="set(index)"
               v-for="index in max">star</i>
            <input type="hidden" :name="name" v-model="rate" v-if="readonly === false">
        </p>
    </div>
</template>

<script type="text/babel">
    export default {
        name: 'Rate',
        props: {
            name: {type: String, default: 'rate'},
            label: {type: String, default: null},
            value: {type: Number, default: null},
            max: {type: Number, default: 5},
            readonly: {default: false}
        },
        data () {
            return {
                rate: null
            }
        },
        methods: {
            set (index) {
                if (this.readonly === false) {
                    this.rate = index
                }
            }
        },
        created () {
            this.rate = (this.value === null) ? 0 : this.value
        }
    }
</script>
