<template>
    <layout>
        <h1 class="text-3xl font-bold pt-5">{{ owner.name }}'s Kindex Listings</h1>
        <div class="py-5">
            <paginator :paginator="kin" v-if="active === 'Kin'"></paginator>
            <paginator :paginator="familiars" v-if="active === 'Familiars'"></paginator>
        </div>

        <div class="flex justify-end items-center">
            <input type="checkbox" class="form-tick appearance-none h-5 w-5 border border-gray-300 rounded-md checked:border-transparent focus:outline-none checked:bg-yellow-800 hover:text-yellow-800 active:text-yellow-800 focus:text-yellow-800" id="show-images" name="show-images" v-model="showImages">
            <label class="ml-2" for="show-images"> Show Images</label><br>
        </div>

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

            <div v-else>
                <div class="hidden font-bold bg-matope-lightbrown rounded-md px-5 border-b border-gray-300 py-2 md:grid md:grid-cols-6 md:gap-4 -mb-5" v-if="familiars.data.length >0">
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
        </div>

        <div class="py-5">
            <paginator :paginator="kin" v-if="active === 'Kin'"></paginator>
            <paginator :paginator="familiars" v-if="active === 'Familiars'"></paginator>
        </div>
    </layout>
</template>

<script>
    import Layout from "@/Components/Layout";
    import Paginator from "@/Components/Paginator";
    import Kin from "@/Components/Kin";
    import Familiar from "@/Components/Familiar";
    import Tabs from "@/Components/Tabs";

    export default {
        props: {
            kin: Object,
            owner: Object,
            familiars: Object
        },
        components: { Kin, Familiar, Layout, Paginator, Tabs },
        data: function() {
            return {
                tabs: ["Kin", "Familiars"],
                showImages: true,
                active: "Kin",
            }
        },
    }
</script>
