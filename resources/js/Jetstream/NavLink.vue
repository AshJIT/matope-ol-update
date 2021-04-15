<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
    export default {
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-yellow-200 text-sm font-medium leading-5 text-yellow-100 focus:outline-none focus:border-indigo-700 transition'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-yellow-100 hover:border-yellow-200 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition'
            }
        }
    }
</script>
