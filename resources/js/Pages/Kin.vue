<template>
    <layout>
        <h1 class="text-2xl font-bold py-5">{{ kin.name }}</h1>
        <div class="flex lg:w-2/3 flex-col lg:flex-row mb-10">
            <div class="flex-1">
                <img :src="kin.current_image_url" alt="kin image">
            </div>
            <div class="flex-1">
                <ul>
                    <li><strong>Owner: </strong> <inertia-link class="text-matope-darktan hover:text-matope-brown" :href="'/owner/' + kin.gaian.slug">{{ kin.gaian.name }}</inertia-link></li>
                    <li><strong>Birthdate: </strong> {{ displayBirthdate(kin.birthdate) }}</li>
                    <li><strong>Gender: </strong> {{ kin.gender.name }}</li>
                    <li><strong>Species:</strong> {{ kin.species.name }}</li>
                    <li><strong>Colourist: </strong> <inertia-link class="text-matope-darktan hover:text-matope-brown" :href="'/colorist/' + kin.colourist.slug" v-if="kin.colourist">{{ kin.colourist.name }}</inertia-link> <span v-else>None</span></li>
                    <li><strong>Mother: </strong> <inertia-link class="text-matope-darktan hover:text-matope-brown" :href="'/kin/view/' + kin.mother.slug" v-if="kin.mother">{{ kin.mother.name }}</inertia-link> <span v-else>None</span></li>
                    <li><strong>Father: </strong> <inertia-link class="text-matope-darktan hover:text-matope-brown" :href="'/kin/view/' + kin.father.slug" v-if="kin.father">{{ kin.father.name }}</inertia-link> <span v-else>None</span></li>
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
                <inertia-link :href="'/admin/kin/edit/' + kin.id" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">Edit Kin</inertia-link>
            </div>
        </div>

        <tabs :items="tabs" v-model="active" v-if="tabs.length > 0"></tabs>

        <div class="border border-matope-lightbrown rounded-b-md rounded-r-md shadow-md px-10 py-2 mb-10" v-if="tabs.length > 0">
            <div class="mt-5" v-if="active === 'Children'">
                <div class="shadow rounded-md p-5 my-5" v-for="(breeding, index) in groupBy(children, 'birthdate')" :key="index">
                    <p class="my-2">
                        <inertia-link v-if="breeding[0].mother" class="py-5 text-matope-darktan hover:text-matope-brown" :href="'/kin/view/' + breeding[0].mother.slug">{{ breeding[0].mother.name }}</inertia-link> <span v-else>???</span>
                        <span> x </span>
                        <inertia-link v-if="breeding[0].father" class="py-5 text-matope-darktan hover:text-matope-brown" :href="'/kin/view/' + breeding[0].father.slug">{{ breeding[0].father.name }}</inertia-link> <span v-else>???</span>
                    </p>

                    <div class="flex flex-wrap">
                        <div v-for="child in breeding" :key="child.id" class="flex justify-center items-end">
                            <inertia-link :href="'/kin/view/' + child.slug" class="flex flex-col justify-between items-center">
                                <img :src="child.current_image_url" :alt="child.name">
                                <span class="py-5 text-matope-darktan hover:text-matope-brown">{{ child.name }}</span>
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5" v-if="active === 'Familiars'">
                <div class="flex flex-wrap">
                    <div v-for="pet in familiars" :key="pet.id" class="flex justify-center items-end m-5 p-5 shadow rounded-md">
                        <inertia-link :href="'/familiar/view/' + pet.slug" class="flex flex-col justify-between items-center">
                            <img :src="pet.current_image_url" :alt="pet.name">
                            <span class="py-5 text-matope-darktan hover:text-matope-brown">{{ pet.name }}</span>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from "@/Components/Layout";
    import Tabs from "@/Components/Tabs";
    import birthdate from "../Mixins/birthdate";

    export default {
        props: {
            kin: Object,
            children: Object,
            familiars: Object,
        },
        components: { Layout, Tabs },
        mixins: [ birthdate ],
        
        data: function() {
            return {
                copy: {
                    uncert: false,
                    cert: false,
                },
                tabs: [],
                active: null,
            }
        },

        computed: {
            certLink: function() {
                return this.kin.current_image_url.replace('_uncert.png', '.gif');
            }
        },

        mounted() {
            this.generateTabs();
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

            generateTabs: function() {
                if (this.children.length > 0) {
                    this.tabs.push("Children");
                }

                if (this.familiars.length > 0) {
                    this.tabs.push("Familiars");
                }

                if (this.tabs.length > 0) {
                    this.active = this.tabs[0];
                }
            }
        }
    }
</script>
