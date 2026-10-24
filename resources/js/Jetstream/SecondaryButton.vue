<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-xs hover:text-gray-500 dark:hover:text-gray-400 focus:outline-hidden focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 dark:active:text-gray-200 active:bg-gray-50 dark:active:bg-gray-900 disabled:opacity-25 transition">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    }
</script>
