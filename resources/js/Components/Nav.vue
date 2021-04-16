<template>
<nav class="flex items-center justify-between flex-wrap bg-gray-700 p-6">
  <div class="flex items-center flex-shrink-0 text-white mr-6">
    <inertia-link href="/">
      <img src="https://matope.pixel-blueberry.com/forums/Themes/Fumes/images/logo.png" alt="Matope home of the kimeti">
    </inertia-link>
  </div>
  <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
    <div class="text-sm lg:flex-grow">
      <a href="https://matope-swamp.com/forums/" target="_blank" class="inline-block text-base px-4 py-2 leading-none text-white hover:text-yellow-200 mt-4 lg:mt-0">Join the Forums</a>
    </div>
    <div>
      <search @input="search"></search>
    </div>
  </div>
</nav>
</template>

<script>
  import Search from '@/Components/Search';

  export default {
    components: { Search },
    methods: {
      search: function(searchString) {
        this.$inertia.visit('/', {
          method: 'get',
          data: {
              page: 1,
              name: searchString
          },
          replace: false,
          preserveState: true,
          preserveScroll: true,
        })
      }
    }
  }
</script>