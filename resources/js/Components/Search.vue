<template>
    <div class="relative text-gray-300 focus-within:text-gray-400 w-full my-2">
        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                <icon type="search"></icon>
            </button>
        </span>
        <input type="search" class="w-full py-2 text-sm rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-500 border-gray-300" placeholder="Search..." autocomplete="off" v-model="searchTerm" @input="debounceInput">
    </div>
</template>

<script>
import Icon from "@/Components/Icon";

export default {
    components: {
        Icon
    },
    emits: ['input'],
    data: function() {
        return {
            searchTerm: "",
        }
    },
    methods: {
        debounceInput: _.debounce(function() {
            this.$emit('input', this.searchTerm);
        }, 500)
    }

}
</script>
