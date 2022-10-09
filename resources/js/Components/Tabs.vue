<template>
    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:border-gray-700 dark:text-gray-400">
        <li class="mr-2" v-for="tab in tabs">
            <a href="#" :aria-current="tab.active ?? page" @click="setTab(tab)" :class="{'bg-matope-darktan text-matope-lighttan' : tab.active === true, 'bg-matope-lightbrown text-matope-brown hover:text-gray-800' : tab.active === false}" class="inline-block p-4 rounded-t-lg">{{ tab.title }}</a>
        </li>
    </ul>
</template>

<script>
    export default {
        emits: ['update:modelValue'],
        props: {
            items: {
                type: Array,
                required: true,
            },
            modelValue: {
                type: String,
            }
        },

        data: function() {
            return {
                tabs: null,
            }
        },

        mounted() {
            this.tabs = this.items.map(item => {
                return {
                    title: item,
                    active: false,
                }
            });

            this.tabs[0].active = true;
        },
        
        computed: {
            active: function() {
                return this.tabs.filter(tab => tab.active)[0].title;
            }
        },

        methods: {
            setTab: function(selected) {
                this.tabs = this.tabs.map(tab => {
                    return {...tab, active: selected.title === tab.title ? true : false }
                });

                this.$emit('update:modelValue', this.active);                
            }
        }
    }
</script>