<template>
    <inertia-link :href="'/kin/view/' + kin.slug" class="md:col-span-2 py-5" v-show="showImages">
        <img :src="kin.current_image_url" alt="kin image" >
    </inertia-link>
    <inertia-link :href="'/kin/view/' + kin.slug" class="md:py-5 text-matope-darktan hover:text-matope-darkertan">{{ kin.name }}</inertia-link>
    <inertia-link :href="'/owner/' + kin.gaian.slug" class="md:py-5 text-matope-darktan hover:text-matope-darkertan" v-if="kin.gaian">{{ kin.gaian.name }}</inertia-link>
    <inertia-link :href="'/colorist/' + kin.colourist.slug" class="md:py-5 text-matope-darktan hover:text-matope-darkertan" v-if="kin.colourist">{{ kin.colourist.name }}</inertia-link>
    <div class="md:py-5">{{ displayBirthdate(kin.birthdate) }}</div>
</template>

<script>
    import birthdate from "../Mixins/birthdate";

    export default {
        props: {
            kin: {
                type: Object,
                required: true,
            },
            showImages: {
                type: Boolean,
                required: true
            }
        },
        mixins: [ birthdate ],
    }
</script>