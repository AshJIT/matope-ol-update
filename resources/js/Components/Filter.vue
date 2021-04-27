<template>
    <div class="relative inline-block text-left">
        <div>
            <button type="button" @click="showMenu = !showMenu" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                Filter
                <icon type="adjustments" class="ml-2"></icon>
            </button>
        </div>

        <div v-show="showMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1 px-5 flex justify-between" role="none">
                 <div class="mt-2">
                    <div v-for="(type, index) in sortTypes" :key="index">
                        <label class="inline-flex items-center">
                            <button class="m-1 px-3 py-1 border-2 border-blue-300 rounded-full" @click="applySort(type)">
                                <span class="mr-2">{{ type.name }}</span>
                                <icon class="inline-block" type="chevron-up" v-show="type.sorting === 'desc'"></icon>
                                <icon class="inline-block" type="chevron-down" v-show="type.sorting === 'asc'"></icon>
                            </button>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Icon from "@/Components/Icon";

export default {
    props: { 
        sortBy: String
    },
    emits: [ 'sort' ],
    components: { Icon },
    data: function() {
        return {
            showMenu: false,
            sortTypes: [
                { 
                    name: "Name", 
                    sort: "kin.name", 
                    sorting: false 
                }, { 
                    name: "DOB",
                    sort: "kin.birthdate",
                    sorting: false 
                }, {
                    name: "Colorist",
                    sort: "colourist.name",
                    sorting: false
                }, {
                    name: "Gender",
                    sort: "gender.name",
                    sorting: false
                }, {
                    name: "Owner",
                    sort: "owner.name",
                    sorting: false,
                }, {
                    name: "Species",
                    sort: "species.name",
                    sorting: false
                }]
        }
    },
    methods: {
        applySort: function(sortBy) {
            const sorting = sortBy.sorting === 'asc' ? 'desc' : 'asc';
            this.sortTypes.forEach(type => {
                type.sorting = false;
            });
            sortBy.sorting = sorting;
            this.$emit("sort", sortBy.sorting === 'desc' ? sortBy.sort : '-' + sortBy.sort);
        }
    }
}

</script>