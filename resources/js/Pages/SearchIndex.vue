<template>
    <div class="container mx-auto rounded-md border border-gray-300 py-5 px-10 my-10">
        <h1 class="text-2xl font-bold">Matope Index Listing</h1>
        <div class="">
            <pagination :data="kin"></pagination>
            <search @input="search"></search>
        </div>
        <div class="flex justify-end items-center">
            <input type="checkbox" id="show-images" name="show-images" v-model="showImages">
            <label class="ml-2" for="show-images"> Show Images</label><br>
        </div>
        <div class="hidden font-bold border-b border-gray-300 py-2 md:flex">
            <div class="flex-1" v-if="showImages">Image</div>
            <div class="flex-1">Name</div>
            <div class="flex-1">Owner</div>
            <div class="flex-1">Colorist</div>
        </div>
        <div class="">
            <div v-for="singleKin in kin.data" :key="singleKin.id" class="flex md:flex-row flex-col border-b border-gray-300">
                <inertia-link :href="'/kin/' + singleKin.slug" class="flex-1 py-2" v-if="showImages">
                    <img :src="singleKin.current_image_url" alt="kin image" >
                </inertia-link>
                <inertia-link :href="'/kin/' + singleKin.slug" class="flex-1 py-5 text-blue-400 hover:text-blue-700">{{ singleKin.name }}</inertia-link>
                <inertia-link :href="'/owner/' + singleKin.gaian.slug" class="flex-1 py-5 text-blue-400 hover:text-blue-700">{{ singleKin.gaian.name }}</inertia-link>
                <div class="flex-1 py-5">{{ singleKin.colourist.name }}</div>
            </div>
        </div>
        <pagination :data="kin"></pagination>
    </div>
</template>

<script>
import Pagination from "@/Components/Pagination";
import Search from "@/Components/Search";

export default {
    props: ['kin'],
    components: { Pagination, Search },
    data: function() {
        return {
            showImages: true,
        }
    },
    mounted() {

    },
    methods: {
        search: function(searchString) {
            this.$inertia.reload({
                data: {
                    page: 1,
                    filter: searchString
                        ? { 'name': searchString }
                        : null
                }
            });
        }
    }
}
</script>
