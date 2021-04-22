<template>
    <navbar></navbar>
    <div class="sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5">
                <h1 class="text-3xl font-bold pt-5">{{ title }}</h1>
                <div class="py-5">
                    <paginator :paginator="kin"></paginator>
                </div>
                <div class="flex justify-end items-center">
                    <input type="checkbox" id="show-images" name="show-images" v-model="showImages">
                    <label class="ml-2" for="show-images"> Show Images</label><br>
                </div>
                <!-- <div class="flex justify-end py-5">
                    <sort :sortBy="sortBy"></sort>
                </div> -->
                <div class="hidden font-bold border-b border-gray-300 py-2 md:grid md:grid-cols-6 md:gap-4">
                    <div class="col-span-2" v-show="showImages">Image</div>
                    <div>Name</div>
                    <div>Owner</div>
                    <div>Colorist</div>
                    <div>Birthdate</div>
                </div>
                <div class="odd:bg-blue-100">
                    <div v-for="singleKin in kin.data" :key="singleKin.id" class="border-b border-gray-300 grid grid-cols-1 md:grid-cols-6 gap-4">
                        <inertia-link :href="'/kin/' + singleKin.slug" class="md:col-span-2 py-5" v-show="showImages">
                            <img :src="singleKin.current_image_url" alt="kin image" >
                        </inertia-link>
                        <inertia-link :href="'/kin/' + singleKin.slug" class="md:py-5 text-blue-400 hover:text-blue-700">{{ singleKin.name }}</inertia-link>
                        <inertia-link :href="'/owner/' + singleKin.gaian.slug" class="md:py-5 text-blue-400 hover:text-blue-700" v-if="singleKin.gaian">{{ singleKin.gaian.name }}</inertia-link>
                        <inertia-link :href="'/colorist/' + singleKin.colourist.slug" class="md:py-5 text-blue-400 hover:text-blue-700" v-if="singleKin.colourist">{{ singleKin.colourist.name }}</inertia-link>
                        <div class="md:py-5">{{ displayBirthdate(singleKin.birthdate) }}</div>
                    </div>
                </div>
                <div class="py-5">
                    <paginator :paginator="kin"></paginator>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Paginator from "@/Components/Paginator";
    import Navbar from "@/Components/Nav";
    import Sort from "@/Components/Sort";
    import birthdate from "../Mixins/birthdate";

    export default {
        props: {
            title: String,
            kin: Object
        },
        components: {
            Paginator,
            Navbar,
            Sort
        },
        mixins: [ birthdate ],
        data: function() {
            return {
                showImages: true,
                sortBy: null
            }
        }
    }
</script>