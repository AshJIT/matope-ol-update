<template>
    <nav v-if="paginator!==undefined" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between" role="navigation">
        <div class="flex justify-between flex-1 sm:hidden">
            <span v-if="onFirstPage" class="invisible">First page</span>

            <inertia-link preserve-state v-else :href="previousPageUrl" class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-matope-lightbrown border border-matope-lightbrownalt leading-5 rounded-md text-matope-brown hover:text-matope-darkbrown focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active transition ease-in-out duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" fill-rule="evenodd"/>
                </svg>
            </inertia-link>

            <inertia-link preserve-state v-if="hasMorePages" :href="nextPageUrl" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium bg-matope-lightbrown border border-matope-lightbrownalt leading-5 rounded-md text-matope-brown hover:text-matope-darkbrown focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active transition ease-in-out duration-150">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" fill-rule="evenodd"/>
                </svg>
            </inertia-link>
            
            <span v-else class="invisible">Last page</span>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Showing <span class="font-medium" v-text="firstItem"></span> to <span class="font-medium" v-text="lastItem"></span> of <span class="font-medium" v-text="total"></span> results
                </p>
            </div>

            <div class="relative z-0 inline-flex shadow-sm rounded-md">
                <inertia-link preserve-state v-if="!onFirstPage" :href="previousPageUrl" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-matope-brown bg-matope-lightbrown border border-matope-lightbrownalt rounded-l-md leading-5 text-matope-brown hover:text-gray-800 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-matope-brown transition ease-in-out duration-150" rel="prev">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" fill-rule="evenodd"/>
                    </svg>
                </inertia-link>

                <div v-for="link in paginator.links">
                    <inertia-link preserve-state v-if="!isFirstOrLastOrDots(link.label)" :class="{'bg-matope-darktan text-matope-lighttan' : link.active === true, 'bg-matope-lightbrown text-matope-brown hover:text-gray-800' : link.active === false}" :href="link.url" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium border border-matope-lightbrownalt leading-5 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active transition ease-in-out duration-150">
                        {{ link.label }}
                    </inertia-link>

                    <span v-else-if="link.label==='...'" aria-disabled="true">
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-matope-lightbrown border border-matope-lightbrownalt cursor-default leading-5">
                            {{ link.label }}
                        </span>
                    </span>
                </div>

                <inertia-link preserve-state v-if="hasMorePages" :href="nextPageUrl" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-matope-brown bg-matope-lightbrown border border-matope-lightbrownalt rounded-r-md leading-5 text-matope-brown hover:text-gray-800 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-matope-brown transition ease-in-out duration-150">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" fill-rule="evenodd"/>
                    </svg>
                </inertia-link>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Paginator",
    props: {
        paginator: {
            current_page: Number,
            data: Array,
            first_page_url: String,
            from: Number,
            last_page: Number,
            last_page_url: String,
            links: Array,
            next_page_url: String,
            path: String,
            per_page: Number,
            prev_page_url: String,
            to: Number,
            total: Number,
        }
    },

    methods: {
        isFirstOrLastOrDots(label) {
            return label.includes('Next') || label.includes('Previous') || label.includes('...')
        },
    },

    computed: {
        onFirstPage() {
            return this.paginator.current_page === 1;
        },

        hasMorePages() {
            return this.paginator.current_page < this.paginator.last_page;
        },

        nextPageUrl() {
            return this.paginator.next_page_url;
        },

        previousPageUrl() {
            return this.paginator.prev_page_url;
        },

        firstItem() {
            return this.paginator.from;
        },

        lastItem() {
            return this.paginator.to;
        },

        total() {
            return this.paginator.total;
        },
    }
}
</script>

