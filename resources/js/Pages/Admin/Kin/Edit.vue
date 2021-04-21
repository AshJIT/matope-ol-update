<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Kin Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        <jet-form-section @submitted="updateKin">
                            <template #title>
                                Edit {{ kin.name }}
                            </template>

                            <template #description>
                                Change existing kin's data.
                                <br/>
                                <div class="my-5" v-if="kin.current_image_url">
                                    <img :src="kin.current_image_url" alt="kin">
                                </div>
                            </template>

                            <template #form>
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Kin Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" ref="name" />
                                    <jet-input-error :message="form.errors.name" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="gender" value="Gender" />
                                    <dropdown v-model="form.gender" class="mt-1 block w-full" :options="gender" optionLabel="name" placeholder="Select a gender" />
                                    <jet-input-error :message="form.errors.gender" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="species" value="Species" />
                                    <dropdown v-model="form.species" class="mt-1 block w-full" :options="species" optionLabel="name" placeholder="Select a species" />
                                    <jet-input-error :message="form.errors.species" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="img-url" value="Img URL" />
                                    <jet-input id="img-url" type="text" class="mt-1 block w-full" v-model="form.img_url" />
                                    <jet-input-error :message="form.errors.img_url" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="birthdate" value="Birthdate" />
                                    <calendar id="birthdate" :manualInput="false" dateFormat="yy-mm-dd" class="mt-1 block w-full" v-model="form.birthdate" />
                                    <jet-input-error :message="form.errors.birthdate" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="mother" value="Mother" />
                                    <dropdown v-model="form.mother" class="mt-1 block w-full" :options="mothers.data" @filter="getMoms($event)" optionLabel="name" placeholder="Select a mother" :filter="true" :showClear="true" filterPlaceholder="Find Mother"/>
                                    <jet-input-error :message="form.errors.mother" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="father" value="Father" />
                                    <dropdown v-model="form.father" class="mt-1 block w-full" :options="fathers.data" @filter="getDads($event)" optionLabel="name" name="father" placeholder="Select a father" :filter="true" :showClear="true" filterPlaceholder="Find Father"/>
                                    <jet-input-error :message="form.errors.father" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="owner" value="Owner" />
                                    <dropdown v-model="form.owner" class="mt-1 block w-full" ref="owner" :options="owners.data" @filter="getOwners($event)" optionLabel="name" placeholder="Select an owner" :filter="true" :showClear="true" filterPlaceholder="Find Owner"/>
                                    <jet-input-error :message="form.errors.owner" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="colorist" value="Colorist" />
                                    <dropdown v-model="form.colorist" class="mt-1 block w-full" :options="colorist" optionLabel="name" placeholder="Select a colorist" />
                                    <jet-input-error :message="form.errors.colorist" class="mt-2" />
                                </div>
                            </template>

                            <template #actions>
                                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                    Saved.
                                </jet-action-message>

                                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update
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
        gender: Array,
        species: Array,
        mothers: Object,
        fathers: Object,
        owners: Object,
        colorist: Array,
        kin: Object
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
                gender: '',
                species: '',
                img_url: '',
                mother: '',
                father: '',
                birthdate: '',
                owner: '',
                colorist: ''
            })
        }
    },
    mounted() {
        this.prepareForm();
    },
    methods: {
        updateKin: function() {
            this.form.put(route('admin.kin.update', this.kin.id), {
                preserveScroll: false,
                onSuccess: () => {
                    this.form.birthdate = this.dateToday;
                },
                onError: () => {
                    if (this.form.errors.name) {
                        this.$refs.name.focus()
                    }

                    if (this.form.errors.gender) {
                        this.$refs.gender.focus()
                    }

                    if (this.form.errors.species) {
                        this.$refs.species.focus()
                    }

                    if (this.form.errors.img_url) {
                        this.$refs.img_url.focus()
                    }
                    
                    if (this.form.errors.mother) {
                        this.$refs.mother.focus()
                    }
                    
                    if (this.form.errors.father) {
                        this.$refs.father.focus()
                    }

                    if (this.form.errors.birthdate) {
                        this.$refs.birthdate.focus()
                    }

                    if (this.form.errors.owner) {
                        this.$refs.owner.focus()
                    }

                    if (this.form.errors.father) {
                        this.$refs.father.focus()
                    }

                    if (this.form.errors.colorist) {
                        this.$refs.colorist.focus()
                    }
                }
            })
        },

        getMoms: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    mom: event.value
                }
            });

        }, 300),

        getDads: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    dad: event.value
                }
            })
        }, 300),

        getOwners: _.throttle(function(event) {
            this.$inertia.reload({
                data: {
                    owner: event.value
                }
            })
        }, 300),

        prepareForm: function() {
            this.$inertia.reload({
                data: {
                    owner: this.kin.gaian.name,
                    mom: this.kin.mother ? this.kin.mother.name : null,
                    dad: this.kin.father ? this.kin.father.name : null
                }
            });

            this.form.name = this.kin.name;
            this.form.gender = this.kin.gender;
            this.form.species = this.kin.species;
            this.form.img_url = this.kin.current_image_url;
            this.form.birthdate = this.kin.birthdate;
            this.form.mother = this.kin.mother ? this.kin.mother : null;
            this.form.father = this.kin.father ? this.kin.father : null;
            this.form.owner = this.kin.gaian;
            this.form.colorist = this.kin.colourist;
        }
    },
}
</script>