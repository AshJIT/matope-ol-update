<template>
    <navbar></navbar>
    <div class="sm:py-12 bg-matope-tan">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-matope-lighttan overflow-hidden shadow-xl sm:rounded-lg px-5">
                <h1 class="text-3xl font-bold pt-5">{{ title }}</h1>
                <div class="py-5">
                    <paginator :paginator="kin"></paginator>
                </div>
                <div class="flex justify-end items-center">
                    <input type="checkbox" id="show-images" name="show-images" v-model="showImages">
                    <label class="ml-2" for="show-images"> Show Images</label><br>
                </div>
                <div class="flex justify-end py-5">
                    <kin-filter :sortBy="sortBy" @sort="sort" />
                </div>
                <div class="hidden font-bold border-b border-gray-300 py-2 md:grid md:grid-cols-6 md:gap-4">
                    <div class="col-span-2" v-show="showImages">Image</div>
                    <div>Name</div>
                    <div>Owner</div>
                    <div>Colorist</div>
                    <div>Birthdate</div>
                </div>
                <div class="odd:bg-blue-100">
                    <div v-for="singleKin in kin.data" :key="singleKin.id" class="border-b border-gray-300 grid grid-cols-1 md:grid-cols-6 gap-4">
                        <kin :showImages="showImages" :kin="singleKin"></kin>
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
    import KinFilter from "@/Components/Filter";
    import Kin from "@/Components/Kin";
    import birthdate from "../Mixins/birthdate";

    export default {
        props: {
            title: String,
            kin: Object
        },
        components: {
            Paginator,
            Navbar,
            KinFilter,
            Kin
        },
        mixins: [ birthdate ],
        data: function() {
            return {
                showImages: true,
                sortBy: null
            }
        },
        mounted() {
            console.log(this.kin);
        },
        methods: {
            sort: function(sortType) {
                this.$inertia.reload({
                    data: {
                        sort: sortType
                    }
                })
            }
        }
    }
</script>