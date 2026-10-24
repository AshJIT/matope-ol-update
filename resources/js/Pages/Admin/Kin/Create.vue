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
                        <jet-form-section @submitted="updatePassword">
                            <template #title>
                                Create New Kin
                            </template>

                            <template #description>
                                Add a new kin to the kindex.
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
                                    <dropdown v-model="form.mother" class="mt-1 block w-full" :options="mothers.data" @filter="searching = 'getMoms'; searchTerm = $event.value; getMoms($event)" :loading="searching === 'getMoms'" :emptyFilterMessage="searching === 'getMoms' ? 'Searching…' : undefined" optionLabel="name" placeholder="Select a mother" :filter="true" filterPlaceholder="Find Mother"/>
                                    <jet-input-error :message="form.errors.mother" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="father" value="Father" />
                                    <dropdown v-model="form.father" class="mt-1 block w-full" :options="fathers.data" @filter="searching = 'getDads'; searchTerm = $event.value; getDads($event)" :loading="searching === 'getDads'" :emptyFilterMessage="searching === 'getDads' ? 'Searching…' : undefined" optionLabel="name" placeholder="Select a father" :filter="true" filterPlaceholder="Find Father"/>
                                    <jet-input-error :message="form.errors.father" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="owner" value="Owner" />
                                    <dropdown v-model="form.owner" class="mt-1 block w-full" ref="owner" :options="owners.data" @filter="searching = 'getOwners'; searchTerm = $event.value; getOwners($event)" :loading="searching === 'getOwners'" :emptyFilterMessage="searching === 'getOwners' ? 'Searching…' : undefined" optionLabel="name" placeholder="Select an owner" :filter="true" filterPlaceholder="Find Owner"/>
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
    },
    computed: {
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
        updatePassword: function() {
            this.form.post(route('admin.kin.store'), {
                preserveScroll: false,
                onSuccess: () => {
                    this.form.reset();
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