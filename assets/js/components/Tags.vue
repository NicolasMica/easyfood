<template>
    <div @click.stop="$refs.input.focus()">
        <label :class="activeLabel">{{ label }}</label>
        <div class="chips" :class="{focus: focus === true}">
            <div class="chip" v-for="tag in selected">{{ tag | capitalize }}<i class="material-icons close" @click="remove(tag)">close</i></div>
            <input ref="input" type="text" class="input" v-model="query" :placeholder="placeholder !== null && focus ? placeholder : ''" @keypress.enter="add(query, $event)">
            <input type="hidden" :name="name" v-model="selected">
            <ul class="dropdown-content autocomplete-content">
                <li v-for="tag in available">
                    <a @click.stop="add(tag)">{{ tag | capitalize }}</a>
                </li>
            </ul>
        </div>
    </div>

</template>

<script type="text/babel">
    export default {
        props: {
            name: { type: String, default: 'tag' },
            label: { type: String, default: null },
            placeholder: { type: String, default: null },
            tags: { default: () => [] },
            value: { default: () => [] },
            minLength: { type: Number, default: 1 },
            limit: { type: Number, default: 20 }
        },
        data () {
            return {
                selected: [],
                items: [],
                focus: false,
                active: false,
                query: ''
            }
        },
        computed: {
            available () {
                if (this.query.length < this.minLength) return []
                return this.items.filter(item => item.toLowerCase().indexOf(this.query.toLowerCase()) >= 0)
            },
            activeLabel () {
                return this.focus === true || this.selected.length > 0 || this.query.length > 0 ? 'active' : null
            }
        },
        methods: {
            add (name, event = null) {
                // Prevent default enter behavior
                if (event !== null && event.keyCode === 13) {
                    event.preventDefault()
                }

                name = name.toLowerCase()

                if (this.selected.includes(name) === false)
                    this.selected.push(name)

                if (this.items.includes(name))
                    this.items = this.items.filter(item => item !== name)

                this.query = ''
            },
            remove (name) {
                name = name.toLowerCase()

                this.selected = this.selected.filter(item => item !== name)

                let items = Object.values(this.tags)
                if (items.find(item => item.toLowerCase() === name))
                    this.items.push(name)
            }
        },
        mounted () {

            let values = Object.values(this.value).sort()
            let items = Object.values(this.tags).sort()

            for (let value of values)
                this.selected.push(value.toLowerCase())

            for (let item of items) {
                if (this.selected.includes(item.toLowerCase()) === false)
                    this.items.push(item.toLowerCase())
            }

            this.$refs.input.addEventListener('focus', event => {
                this.focus = true
            })

            this.$refs.input.addEventListener('blur', event => {
                this.focus = false
            })
        }
    }
</script>
