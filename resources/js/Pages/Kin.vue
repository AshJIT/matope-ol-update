<template>
    <div class="container mx-auto rounded-md border border-gray-300 py-5 px-10 my-10">
        <h1 class="text-2xl font-bold">{{ kin.name }}</h1>
        <div class="flex w-1/2">
            <div class="flex-1">
                <img :src="kin.current_image_url" alt="kin image">
            </div>
            <div class="flex-1">
                <ul>
                    <li><strong>Birthdate: </strong> {{ kin.birthdate }}</li>
                    <li><strong>Gender: </strong> {{ kin.gender.name }}</li>
                    <li><strong>Owner: </strong> {{ kin.gaian.name }}</li>
                    <li><strong>Colourist: </strong> {{ kin.colourist.name }}</li>
                    <li><strong>Mother: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/kin/' + kin.mother.slug" v-if="kin.mother">{{ kin.mother.name }}</inertia-link> <span v-else>None</span></li>
                    <li><strong>Father: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/kin/' + kin.father.slug" v-if="kin.father">{{ kin.father.name }}</inertia-link> <span v-else>None</span></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            kin: Object
        },
        mounted() {
        }
    }
</script>
