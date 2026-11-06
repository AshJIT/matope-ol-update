<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Kin Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        <jet-form-section @submitted="breeding ? submitBreeding() : submitKin()">
                            <template #title>
                                Create New Kin
                            </template>

                            <template #description>
                                Add a new kin to the kindex.
                            </template>

                            <template #form>
                                <div class="col-span-6 sm:col-span-4">
                                    <label for="breeding" class="inline-flex items-center gap-3 cursor-pointer">
                                        <input id="breeding" type="checkbox" v-model="breeding" class="sr-only peer">
                                        <span class="relative w-11 h-6 rounded-full bg-gray-300 dark:bg-gray-600 peer-checked:bg-indigo-600 peer-focus-visible:ring-3 peer-focus-visible:ring-indigo-200/50 after:absolute after:top-0.5 after:left-0.5 after:size-5 after:rounded-full after:bg-white after:transition-transform peer-checked:after:translate-x-5"></span>
                                        <span class="font-medium text-sm text-gray-700 dark:text-gray-300">Breeding</span>
                                    </label>
                                </div>

                                <template v-if="breeding">
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="b-mother" value="Mother" />
                                    <dropdown input-id="b-mother" v-model="breedingForm.mother" class="mt-1 block w-full" :options="mothers.data" @filter="searching = 'getMoms'; searchTerm = $event.value; getMoms($event)" :loading="searching === 'getMoms'" :emptyFilterMessage="searching === 'getMoms' ? 'Searching…' : undefined" optionLabel="name" dataKey="id" placeholder="Select a mother" :filter="true" filterPlaceholder="Find Mother"/>
                                    <jet-input-error :message="breedingForm.errors.mother_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="b-father" value="Father" />
                                    <dropdown input-id="b-father" v-model="breedingForm.father" class="mt-1 block w-full" :options="fathers.data" @filter="searching = 'getDads'; searchTerm = $event.value; getDads($event)" :loading="searching === 'getDads'" :emptyFilterMessage="searching === 'getDads' ? 'Searching…' : undefined" optionLabel="name" dataKey="id" placeholder="Select a father" :filter="true" filterPlaceholder="Find Father"/>
                                    <jet-input-error :message="breedingForm.errors.father_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="b-colorist" value="Colorist" />
                                    <dropdown input-id="b-colorist" v-model="breedingForm.colorist" class="mt-1 block w-full" :options="colorist" optionLabel="name" dataKey="id" placeholder="Select a colorist" />
                                    <jet-input-error :message="breedingForm.errors.colourist_id" class="mt-2" />
                                </div>

                                <div v-for="(entry, index) in breedingForm.entries" :key="entry.key" class="col-span-6 grid grid-cols-6 gap-6 rounded-md border border-gray-200 dark:border-gray-700 p-4">
                                    <div class="col-span-6 flex items-center justify-between">
                                        <h3 class="font-medium text-gray-900 dark:text-gray-100">Kin {{ index + 1 }}</h3>
                                        <button type="button" v-if="breedingForm.entries.length > 1" @click="breedingForm.entries.splice(index, 1)" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                                            Remove
                                        </button>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label :for="`name-${index}`" value="Kin Name" />
                                        <jet-input :id="`name-${index}`" type="text" class="mt-1 block w-full" v-model="entry.name" />
                                        <jet-input-error :message="breedingForm.errors[`entries.${index}.name`]" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label :for="`gender-${index}`" value="Gender" />
                                        <dropdown :input-id="`gender-${index}`" v-model="entry.gender" class="mt-1 block w-full" :options="gender" optionLabel="name" dataKey="id" placeholder="Select a gender" />
                                        <jet-input-error :message="breedingForm.errors[`entries.${index}.gender_id`]" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label :for="`species-${index}`" value="Species" />
                                        <dropdown :input-id="`species-${index}`" v-model="entry.species" class="mt-1 block w-full" :options="species" optionLabel="name" dataKey="id" placeholder="Select a species" />
                                        <jet-input-error :message="breedingForm.errors[`entries.${index}.species_id`]" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label :for="`img-url-${index}`" value="Img URL" />
                                        <jet-input :id="`img-url-${index}`" type="text" class="mt-1 block w-full" v-model="entry.img_url" />
                                        <jet-input-error :message="breedingForm.errors[`entries.${index}.current_image_url`]" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label :for="`birthdate-${index}`" value="Birthdate" />
                                        <calendar :input-id="`birthdate-${index}`" :manualInput="false" dateFormat="yy-mm-dd" class="mt-1 block w-full" v-model="entry.birthdate" />
                                        <jet-input-error :message="breedingForm.errors[`entries.${index}.birthdate`]" class="mt-2" />
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label :for="`owner-${index}`" value="Owner" />
                                        <dropdown :input-id="`owner-${index}`" v-model="entry.owner" class="mt-1 block w-full" :options="withSelected(owners.data, entry.owner)" @filter="searching = 'getOwners'; searchTerm = $event.value; getOwners($event)" :loading="searching === 'getOwners'" :emptyFilterMessage="searching === 'getOwners' ? 'Searching…' : undefined" optionLabel="name" dataKey="id" placeholder="Select an owner" :filter="true" filterPlaceholder="Find Owner"/>
                                        <jet-input-error :message="breedingForm.errors[`entries.${index}.owner_id`]" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-span-6">
                                    <button type="button" @click="addEntry" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        + Add another kin
                                    </button>
                                    <jet-input-error :message="breedingForm.errors.entries" class="mt-2" />
                                </div>
                                </template>

                                <template v-else>
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Kin Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                                    <jet-input-error :message="form.errors.name || form.errors.slug" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="gender" value="Gender" />
                                    <dropdown input-id="gender" v-model="form.gender" class="mt-1 block w-full" :options="gender" optionLabel="name" placeholder="Select a gender" />
                                    <jet-input-error :message="form.errors.gender_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="species" value="Species" />
                                    <dropdown input-id="species" v-model="form.species" class="mt-1 block w-full" :options="species" optionLabel="name" placeholder="Select a species" />
                                    <jet-input-error :message="form.errors.species_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="img-url" value="Img URL" />
                                    <jet-input id="img-url" type="text" class="mt-1 block w-full" v-model="form.img_url" />
                                    <jet-input-error :message="form.errors.current_image_url" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="birthdate" value="Birthdate" />
                                    <calendar input-id="birthdate" :manualInput="false" dateFormat="yy-mm-dd" class="mt-1 block w-full" v-model="form.birthdate" />
                                    <jet-input-error :message="form.errors.birthdate" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="mother" value="Mother" />
                                    <dropdown input-id="mother" v-model="form.mother" class="mt-1 block w-full" :options="mothers.data" @filter="searching = 'getMoms'; searchTerm = $event.value; getMoms($event)" :loading="searching === 'getMoms'" :emptyFilterMessage="searching === 'getMoms' ? 'Searching…' : undefined" optionLabel="name" placeholder="Select a mother" :filter="true" filterPlaceholder="Find Mother"/>
                                    <jet-input-error :message="form.errors.mother_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="father" value="Father" />
                                    <dropdown input-id="father" v-model="form.father" class="mt-1 block w-full" :options="fathers.data" @filter="searching = 'getDads'; searchTerm = $event.value; getDads($event)" :loading="searching === 'getDads'" :emptyFilterMessage="searching === 'getDads' ? 'Searching…' : undefined" optionLabel="name" placeholder="Select a father" :filter="true" filterPlaceholder="Find Father"/>
                                    <jet-input-error :message="form.errors.father_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="owner" value="Owner" />
                                    <dropdown input-id="owner" v-model="form.owner" class="mt-1 block w-full" :options="owners.data" @filter="searching = 'getOwners'; searchTerm = $event.value; getOwners($event)" :loading="searching === 'getOwners'" :emptyFilterMessage="searching === 'getOwners' ? 'Searching…' : undefined" optionLabel="name" placeholder="Select an owner" :filter="true" filterPlaceholder="Find Owner"/>
                                    <jet-input-error :message="form.errors.owner_id" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="colorist" value="Colorist" />
                                    <dropdown input-id="colorist" v-model="form.colorist" class="mt-1 block w-full" :options="colorist" optionLabel="name" placeholder="Select a colorist" />
                                    <jet-input-error :message="form.errors.colourist_id" class="mt-2" />
                                </div>
                                </template>
                            </template>

                            <template #actions>
                                <jet-action-message :on="activeForm.recentlySuccessful" class="mr-3">
                                    Saved.
                                </jet-action-message>

                                <jet-button :class="{ 'opacity-25': activeForm.processing }" :disabled="activeForm.processing">
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
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout';
import JetActionMessage from '@/Jetstream/ActionMessage';
import JetButton from '@/Jetstream/Button';
import JetFormSection from '@/Jetstream/FormSection';
import JetInput from '@/Jetstream/Input';
import JetInputError from '@/Jetstream/InputError';
import JetLabel from '@/Jetstream/Label';
import DatePicker from 'primevue/datepicker';
import Select from 'primevue/select';
import _ from 'lodash';

export default {
    props: {
        gender: Array,
        species: Array,
        mothers: Object,
        fathers: Object,
        owners: Object,
        colorist: Array
    },
    components: { 
        AppLayout,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        Calendar: DatePicker,
        Dropdown: Select
    },
    data: function() {
        return {
            searching: null,
            searchTerm: null,
            breeding: false,
            nextKey: 1,
            breedingForm: useForm({
                mother: '',
                father: '',
                colorist: '',
                entries: []
            }),
            form: useForm({
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
        this.form.birthdate = this.dateToday;
        this.addEntry();
    },
    computed: {
        activeForm: function() {
            return this.breeding ? this.breedingForm : this.form;
        },
        dateToday: function() {
            let today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

            return today;
        }
    },
    methods: {
        addEntry: function() {
            const last = this.breedingForm.entries[this.breedingForm.entries.length - 1];

            this.breedingForm.entries.push({
                key: this.nextKey++,
                name: '',
                gender: '',
                species: last ? last.species : '',
                img_url: '',
                birthdate: last ? last.birthdate : this.dateToday,
                owner: ''
            });
        },

        withSelected: function(options, selected) {
            return !selected || options.some(option => option.id === selected.id) ? options : [selected, ...options];
        },

        submitBreeding: function() {
            this.breedingForm.post(route('admin.kin.store-breeding'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.breedingForm.reset();
                    this.breedingForm.entries = [];
                    this.addEntry();
                }
            });
        },

        submitKin: function() {
            this.form.post(route('admin.kin.store'), {
                preserveScroll: false,
                onSuccess: () => {
                    this.form.reset();
                    this.form.birthdate = this.dateToday;
                },
                onError: (errors) => {
                    const fields = {
                        name: 'name', slug: 'name', gender_id: 'gender', species_id: 'species',
                        current_image_url: 'img-url', birthdate: 'birthdate', mother_id: 'mother',
                        father_id: 'father', owner_id: 'owner', colourist_id: 'colorist'
                    };
                    const first = Object.keys(fields).find(key => errors[key]);

                    if (first) {
                        this.$nextTick(() => document.getElementById(fields[first])?.focus());
                    }
                }
            })
        },

        getMoms: _.debounce(function(event) {
            this.$inertia.reload({
                onFinish: () => { if (event.value === this.searchTerm) this.searching = null },
                only: ['mothers'],
                data: {
                    mom: event.value
                }
            });

        }, 600),

        getDads: _.debounce(function(event) {
            this.$inertia.reload({
                onFinish: () => { if (event.value === this.searchTerm) this.searching = null },
                only: ['fathers'],
                data: {
                    dad: event.value
                }
            })
        }, 600),

        getOwners: _.debounce(function(event) {
            this.$inertia.reload({
                onFinish: () => { if (event.value === this.searchTerm) this.searching = null },
                only: ['owners'],
                data: {
                    owner: event.value
                }
            })
        }, 600)
    },
}
</script>