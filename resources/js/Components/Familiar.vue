<template>
    <inertia-link :href="'/familiar/view/' + familiar.slug" class="md:col-span-2 py-5" v-show="showImages">
        <img :src="familiar.current_image_url" alt="familiar image" >
    </inertia-link>
    <inertia-link :href="'/familiar/view/' + familiar.slug" class="md:py-5 text-matope-darktan hover:text-matope-brown">{{ familiar.name }}</inertia-link>
    <p class="md:py-5 text-gray-700">{{ familiar.species ? familiar.species.name : '' }}</p>
    <inertia-link :href="'/owner/' + familiar.gaian.slug" class="md:py-5 text-matope-darktan hover:text-matope-brown" v-if="familiar.gaian">{{ familiar.kin ? familiar.kin.name + " (" + familiar.gaian.name + ")" : familiar.gaian.name }}</inertia-link>
    <inertia-link :href="'/colorist/' + familiar.colourist.slug" class="md:py-5 text-matope-darktan hover:text-matope-brown" v-if="familiar.colourist">{{ familiar.colourist.name }}</inertia-link>
    <p v-if="!familiar.colourist" class="text-gray-700 md:py-5">Unknown</p>
</template>

<script>
    import birthdate from "../Mixins/birthdate";

    export default {
        props: {
            familiar: {
                type: Object,
                required: true,
            },
            showImages: {
                type: Boolean,
                required: true,
            }
        },

        mixins: [ birthdate ]
    }
</script>