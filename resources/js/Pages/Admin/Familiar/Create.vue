<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Familiar Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        <jet-form-section @submitted="storeFamiliar">
                            <template #title>
                                Create New Familiar Record
                            </template>

                            <template #description>
                                Adds a new familiar to the kindex.
                            </template>

                            <template #form>
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Familiar Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" ref="name" />
                                    <jet-input-error :message="form.errors.name" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="familiar_species_id" value="Species" />
                                    <dropdown id="familiar_species_id" v-model="form.familiar_species" class="mt-1 block w-full" ref="familiar_species_id" :options="familiar_species.data" @filter="getSpecies($event)" optionLabel="name" placeholder="Select a species" :filter="true" filterPlaceholder="Find Species"/>
                                    <jet-input-error :message="form.errors.familiar_species_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="current_image_url" value="Uncert URL" />
                                    <jet-input id="curent_image_url" type="text" class="mt-1 block w-full" @change="form.cert_url = $event.target.value.replace('_uncert.png', '.gif')" v-model="form.current_image_url" />
                                    <jet-input-error :message="form.errors.current_image_url" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="cert_url" value="Cert URL" />
                                    <jet-input id="cert_url" type="text" class="mt-1 block w-full" v-model="form.cert_url" />
                                    <jet-input-error :message="form.errors.cert_url" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="kin_id" value="Kin" />
                                    <dropdown id="kin_id" v-model="form.kin" class="mt-1 block w-full" ref="kin_id" :options="kin.data" @filter="getKin($event)" optionLabel="name" placeholder="Select a kin" :filter="true" filterPlaceholder="Find Kin"/>
                                    <jet-input-error :message="form.errors.kin_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4" v-show="!form.kin">
                                    <jet-label for="owner_id" value="Owner" />
                                    <dropdown id="owner_id" v-model="form.owner" class="mt-1 block w-full" ref="owner_id" :options="owners.data" @filter="getOwners($event)" optionLabel="name" placeholder="Select an owner" :filter="true" filterPlaceholder="Find Owner"/>
                                    <jet-input-error :message="form.errors.owner_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="colourist_id" value="Colorist" />
                                    <dropdown id="colourist_id" v-model="form.colorist" class="mt-1 block w-full" ref="colourist_id" :options="colorist.data" @filter="getColorists($event)" optionLabel="name" placeholder="Select a colorist" :filter="true" filterPlaceholder="Find Colorist"/>
                                    <jet-input-error :message="form.errors.colourist_id" class="mt-2" />
                                </div>
                            </template>

                            <template #actions>
                                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                    Saved.
                                </jet-action-message>

                                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Save
                                </jet-button>
                            </template>
                        </jet-form-section>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import JetActionMessage from '@/Jetstream/ActionMessage';
import JetButton from '@/Jetstream/Button';
import JetFormSection from '@/Jetstream/FormSection';
import JetInput from '@/Jetstream/Input';
import JetInputError from '@/Jetstream/InputError';
import JetLabel from '@/Jetstream/Label';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import _ from 'lodash';

export default {
    props: {
        familiar_species: Object,
        owners: Object,
        colorist: Object,
        kin: Object,
    },

    components: { 
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        Calendar,
        Dropdown
    },

    data: function() {
        return {
            form: this.$inertia.form({
                name: '',
                familiar_species: '',
                current_image_url: '',
                cert_url: '',
                kin: '',
                owner: '',
                colorist: ''
            })
        }
    },

    computed: {
        certLink: function() {
            this.form.current_image_url ? this.form.current_image_url.replace('_uncert.png', '.gif') : null;
        }
    },

    methods: {
        storeFamiliar: function() {
            this.form.post(route('admin.familiar.store'), {
                preserveScroll: false,
                onSuccess: () => {
                    this.form.reset();
                },
                onError: () => {
                    if (this.form.errors.name) {
                        this.$refs.name.focus()
                    }

                    if (this.form.errors.familiar_species_id) {
                        this.$refs.familiar_species_id.focus()
                    }

                    if (this.form.errors.current_image_url) {
                        this.$refs.current_image_url.focus()
                    }

                    if (this.form.errors.kin_id) {
                        this.$refs.kin_id.focus()
                    }

                    if (this.form.errors.owner_id) {
                        this.$refs.owner_id.focus()
                    }

                    if (this.form.errors.colourist_id) {
                        this.$refs.colourist_id.focus()
                    }
                }
            })
        },

        getOwners: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    owner: event.value
                }
            })
        }, 300),

        getKin: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    kin: event.value
                }
            })
        }, 300),

        getColorists: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    colorist: event.value
                }
            })
        }, 300),

        getSpecies: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    familiar_species: event.value
                }
            })
        }, 300)
    },
}
</script>