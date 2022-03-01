<template>
    <div>
        <navbar></navbar>
        <div class="sm:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5 py-5">
                    <h1 class="text-2xl font-bold pb-5">{{ familiar.name }}</h1>
                    <div class="flex lg:w-2/3 flex-col lg:flex-row">
                        <div class="flex-1">
                            <img :src="familiar.current_image_url" alt="familiar image">
                        </div>
                        <div class="flex-1">
                            <ul>
                                <li><strong>Kin:</strong> <inertia-link v-if="familiar.kin" class="text-blue-400 hover:text-blue-700" :href="'/familiar/' + familiar.kin.slug">{{ familiar.kin.name }}</inertia-link>  <span v-else>None</span></li>
                                <li><strong>Owner: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/owner/' + familiar.gaian.slug">{{ familiar.gaian.name }}</inertia-link></li>
                                <li><strong>Species:</strong> {{ familiar.species.name }}</li>
                                <li><strong>Colourist: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/colorist/' + familiar.colourist.slug" v-if="familiar.colourist">{{ familiar.colourist.name }}</inertia-link> <span v-else>None</span></li>
                            </ul>

                            <ul class="mt-5">
                                <li>
                                    <label class="block font-bold" for="uncert">Uncert Link:</label>
                                    <span class="inline-block bg-purple-400 text-white px-2 float-right" v-if="copy.uncert">Copied!</span>
                                    <input class="border-gray-300 rounded-md mt-1 block w-full" type="text" name="uncert" :value="familiar.current_image_url" @click="copyURL">
                                </li>
                                <li class="mt-5">
                                    <label class="block font-bold" for="cert">Cert Link:</label>
                                    <span class="inline-block bg-purple-400 text-white px-2 float-right" v-if="copy.cert">Copied!</span>
                                    <input class="border-gray-300 rounded-md mt-1 block w-full" name="cert" type="text" :value="familiar.cert_url" @click="copyURL">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full flex justify-end p-5 mt-5" v-if="$page.props.user">
                        <div class="">
                            <inertia-link :href="'/admin/familiar/edit/' + familiar.id" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">Edit Familiar</inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "@/Components/Nav";

    export default {
        props: {
            familiar: Object,
        },
        components: { Navbar },
        data: function() {
            return {
                copy: {
                    uncert: false,
                    cert: false,
                }
            }
        },
        methods: {
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
