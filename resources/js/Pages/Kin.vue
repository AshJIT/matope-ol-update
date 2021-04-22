<template>
    <navbar></navbar>
    <div class="sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5 py-5">
                <h1 class="text-2xl font-bold pb-5">{{ kin.name }}</h1>
                <div class="flex lg:w-2/3 flex-col lg:flex-row">
                    <div class="flex-1">
                        <img :src="kin.current_image_url" alt="kin image">
                    </div>
                    <div class="flex-1">
                        <ul>
                            <li><strong>Owner: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/owner/' + kin.gaian.slug">{{ kin.gaian.name }}</inertia-link></li>
                            <li><strong>Birthdate: </strong> {{ displayBirthdate(kin.birthdate) }}</li>
                            <li><strong>Gender: </strong> {{ kin.gender.name }}</li>
                            <li><strong>Species:</strong> {{ kin.species.name }}</li>
                            <li><strong>Colourist: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/colorist/' + kin.colourist.slug" v-if="kin.colourist">{{ kin.colourist.name }}</inertia-link> <span v-else>None</span></li>
                            <li><strong>Mother: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/kin/' + kin.mother.slug" v-if="kin.mother">{{ kin.mother.name }}</inertia-link> <span v-else>None</span></li>
                            <li><strong>Father: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/kin/' + kin.father.slug" v-if="kin.father">{{ kin.father.name }}</inertia-link> <span v-else>None</span></li>
                        </ul>

                        <ul class="mt-5">
                            <li>
                                <label class="block font-bold" for="uncert">Uncert Link:</label>
                                <span class="inline-block bg-purple-400 text-white px-2 float-right" v-if="copy.uncert">Copied!</span>
                                <input class="border-gray-300 rounded-md mt-1 block w-full" type="text" name="uncert" :value="kin.current_image_url" @click="copyURL">
                            </li>
                            <li class="mt-5">
                                <label class="block font-bold" for="cert">Cert Link:</label>
                                <span class="block text-xs">Cert links may not work for older kin.</span>
                                <span class="inline-block bg-purple-400 text-white px-2 float-right" v-if="copy.cert">Copied!</span>
                                <input class="border-gray-300 rounded-md mt-1 block w-full" name="cert" type="text" :value="certLink" @click="copyURL">
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full flex justify-end p-5 mt-5" v-if="$page.props.user">
                    <div class="">
                        <inertia-link :href="'/admin/kin/edit/' + kin.id" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">Edit Kin</inertia-link>
                    </div>
                </div>
                <div class="border-t border-gray-300 mt-5" v-if="children.length > 0">
                    <div class="flex justify-between my-5">
                        <h1 class="text-xl font-bold">Children</h1>
                        <div class="">
                            <input class="rounded" type="checkbox" id="show-offspring" name="show-offspring" v-model="showOffspring">
                            <label class="ml-2" for="show-images"> Show Offspring</label><br>
                        </div>
                    </div>

                    <div class="border-b border-gray-300" v-for="(breeding, index) in groupBy(children, 'birthdate')" :key="index" v-show="showOffspring">
                        <p class="my-2">
                            <inertia-link v-if="breeding[0].mother" class="py-5 text-blue-400 hover:text-blue-700" :href="'/kin/' + breeding[0].mother.slug">{{ breeding[0].mother.name }}</inertia-link> <span v-else>???</span>
                            <span> x </span>
                            <inertia-link v-if="breeding[0].father" class="py-5 text-blue-400 hover:text-blue-700" :href="'/kin/' + breeding[0].father.slug">{{ breeding[0].father.name }}</inertia-link> <span v-else>???</span>
                        </p>

                        <div class="flex flex-wrap">
                            <div v-for="child in breeding" :key="child.id" class="flex justify-center items-end">
                                <inertia-link :href="'/kin/' + child.slug" class="flex flex-col justify-between items-center">
                                    <img :src="child.current_image_url" :alt="child.name">
                                    <span class="py-5 text-blue-400 hover:text-blue-700">{{ child.name }}</span>
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "@/Components/Nav";
    import birthdate from "../Mixins/birthdate";

    export default {
        props: {
            kin: Object,
            children: Object
        },
        components: { Navbar },
        mixins: [ birthdate ],
        data: function() {
            return {
                showOffspring: true,
                copy: {
                    uncert: false,
                    cert: false,
                }
            }
        },
        computed: {
            certLink: function() {
                return this.kin.current_image_url.replace('_uncert.png', '.gif');
            }
        },
        mounted() {
            console.log(this.$page);
        },
        methods: {
            groupBy: function(items, key) {
                const result = {};

                items.forEach(item => {
                    if (!result[item[key]]){
                        result[item[key]] = [];
                    }
                    result[item[key]].push(item);
                });

                return result;
            },

            copyURL(evnt) {
                var Url = evnt.target;
                Url.select();
                document.execCommand("copy");

                this.copy[evnt.target.name] = true;
                setTimeout(() => {
                    this.copy[evnt.target.name] = false;
                }, 1000);
            },
        }
    }
</script>
