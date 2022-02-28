<template>
    <div>
        <navbar></navbar>
        <div class="sm:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5">
                    <h1 class="text-3xl font-bold pt-5">{{ title }}</h1>
                    <div class="py-5">
                        <paginator :paginator="familiars"></paginator>
                    </div>
                    <div class="flex justify-end items-center">
                        <input type="checkbox" id="show-images" name="show-images" v-model="showImages">
                        <label class="ml-2" for="show-images"> Show Images</label><br>
                    </div>
                    <div class="hidden font-bold border-b border-gray-300 py-2 md:grid md:grid-cols-7 md:gap-4">
                        <div class="col-span-2" v-show="showImages">Image</div>
                        <div>Name</div>
                        <div>Species</div>
                        <div>Owner</div>
                        <div>Colorist</div>
                        <div>Cert</div>
                    </div>
                    <div class="odd:bg-blue-100">
                        <div v-for="familiar in familiars.data" :key="familiar.id" class="border-b border-gray-300 grid grid-cols-1 md:grid-cols-7 gap-4">
                            <inertia-link :href="'/familiar/view/' + familiar.slug" class="md:col-span-2 py-5" v-show="showImages">
                                <img :src="familiar.current_image_url" alt="familiar image" >
                            </inertia-link>
                            <inertia-link :href="'/familiar/view/' + familiar.slug" class="md:py-5 text-blue-400 hover:text-blue-700">{{ familiar.name }}</inertia-link>
                            <p>{{ familiar.species ? familiar.species.name : '' }}</p>
                            <inertia-link :href="'/owner/' + familiar.gaian.slug" class="md:py-5 text-blue-400 hover:text-blue-700" v-if="familiar.gaian">{{ familiar.kin ? familiar.kin.name + " (" + familiar.gaian.name + ")" : familiar.gaian.name }}</inertia-link>
                            <inertia-link :href="'/colorist/' + familiar.colourist.slug" class="md:py-5 text-blue-400 hover:text-blue-700" v-if="familiar.colourist">{{ familiar.colourist.name }}</inertia-link><div v-else></div>
                            <div><img v-show="showImages" :src="familiar.cert_url" alt="familiar cert image" ></div>
                        </div>
                    </div>
                    <div class="py-5">
                        <paginator :paginator="familiars"></paginator>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Paginator from "@/Components/Paginator";
    import Navbar from "@/Components/Nav";

    export default {
        props: {
            title: String,
            familiars: Object
        },
        components: {
            Paginator,
            Navbar
        },
        data: function() {
            return {
                showImages: true,
                sortBy: null
            }
        },
    }
</script>