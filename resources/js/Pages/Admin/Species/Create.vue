<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Species Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        <jet-form-section @submitted="submit">
                            <template #title>
                                Create New Species
                            </template>

                            <template #description>
                                Add a new kin or familiar species.
                            </template>

                            <template #form>
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Species Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                                    <jet-input-error :message="form.errors.name" class="mt-2" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="type" value="Species Type" />
                                    <select id="type" v-model="form.type" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-300 focus:ring-3 focus:ring-indigo-200/50 rounded-md shadow-xs">
                                        <option value="kin">Kin</option>
                                        <option value="familiar">Familiar</option>
                                    </select>
                                    <jet-input-error :message="form.errors.type" class="mt-2" />
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

export default {
    components: { AppLayout, JetActionMessage, JetButton, JetFormSection, JetInput, JetInputError, JetLabel },
    data() {
        return {
            form: useForm({ name: '', type: 'kin' }),
        };
    },
    methods: {
        submit() {
            this.form.post(route('admin.species.store'), {
                preserveScroll: true,
                onSuccess: () => this.form.reset('name'),
            });
        },
    },
};
</script>
