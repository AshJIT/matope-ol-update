<template>
    <layout>
        <h1 class="text-3xl font-bold pt-5">{{ active }} Listings</h1>
        <div class="py-5">
            <paginator :paginator="kin" v-if="active === 'Kin'"></paginator>
            <paginator :paginator="familiars" v-if="active === 'Familiars'"></paginator>
            <paginator :paginator="owners" v-if="active === 'Owners'"></paginator>
        </div>

        <div class="flex justify-end items-center">
            <input type="checkbox" class="form-tick appearance-none h-5 w-5 border border-gray-300 rounded-md checked:border-transparent focus:outline-none checked:bg-yellow-800 hover:text-yellow-800 active:text-yellow-800 focus:text-yellow-800" id="show-images" name="show-images" v-model="showImages">
            <label class="ml-2" for="show-images"> Show Images</label><br>
        </div>

        <!-- <div class="flex justify-end py-5">
            <kin-filter :sortBy="sortBy" @sort="sort" />
        </div> -->

        <tabs :items="tabs" v-model="active"></tabs>

        <div class="border border-matope-lightbrown rounded-b-md rounded-r-md shadow-md px-10 py-2">
            <div v-if="active === 'Kin'">
                <div class="hidden font-bold bg-matope-lightbrown rounded-md px-5 border-b border-gray-300 py-2 md:grid md:grid-cols-6 md:gap-4 -mb-5" v-if="kin.data.length > 0">
                    <div class="col-span-2" v-show="showImages">Image</div>
                    <div>Name</div>
                    <div>Owner</div>
                    <div>Colorist</div>
                    <div>Birthdate</div>
                </div>
                
                <div>
                    <div v-for="singleKin in kin.data" :key="singleKin.id" class="rounded-md shadow px-5 my-5 grid grid-cols-1 md:grid-cols-6 gap-4">
                        <kin :showImages="showImages" :kin="singleKin"></kin>
                    </div>
                </div>
            </div>

            <div v-if="active === 'Familiars'">
                <div class="hidden font-bold bg-matope-lightbrown rounded-md px-5 border-b border-gray-300 py-2 md:grid md:grid-cols-6 md:gap-4 -mb-5" v-if="familiars.data.length > 0">
                    <div class="col-span-2" v-show="showImages">Image</div>
                    <div>Name</div>
                    <div>Species</div>
                    <div>Owner</div>
                    <div>Colorist</div>
                </div>

                <div>
                    <div v-for="familiar in familiars.data" :key="familiar.id" class="rounded-md shadow px-5 my-5 grid grid-cols-1 md:grid-cols-6 gap-4">
                        <familiar :familiar="familiar" :showImages="showImages"></familiar>
                    </div>
                </div>
            </div>

            <div v-if="active === 'Owners'">
                <div v-for="owner in owners.data" :key="owner.id" class="rounded-md shadow p-5 my-5 flex flex-col md:flex-row">
                    <div class="text-white bg-matope-brown rounded-full h-24 w-24 flex items-center justify-center mr-10 mb-5 md:mb-0">
                        <inertia-link :href="'/owner/' + owner.slug" >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-14 h-14">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                        </inertia-link>
                    </div>
                    <div class="text-lg">
                        <p><span class="text-matope-darkbrown font-bold">Name:</span> <inertia-link class="text-matope-darktan hover:text-matope-brown" :href="'/owner/' + owner.slug">{{ owner.name }}</inertia-link></p>
                        <p><span class="text-matope-darkbrown font-bold">Kin Count:</span> {{ owner.kin_count }}</p>
                        <p><span class="text-matope-darkbrown font-bold">Familiar Count:</span> {{ owner.familiar_count }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <paginator :paginator="kin" v-if="active === 'Kin'"></paginator>
            <paginator :paginator="familiars" v-if="active === 'Familiars'"></paginator>
            <paginator :paginator="owners" v-if="active === 'Owners'"></paginator>
        </div>
    </layout>
</template>

<script>
    import Layout from "@/Components/Layout";
    import Kin from "@/Components/Kin";
    import Familiar from "@/Components/Familiar";
    import Paginator from "@/Components/Paginator";
    import KinFilter from "@/Components/Filter";
    import Tabs from "@/Components/Tabs";

    export default {
        props: ['kin', 'familiars', 'owners'],
        components: { Kin, Familiar, Layout, Paginator, KinFilter, Tabs },
        data: function() {
            return {
                showImages: true,
                tabs: ["Kin", "Familiars", "Owners"],
                active: "Kin",
            }
        },
        mounted() {
            console.log(this.owners);
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
