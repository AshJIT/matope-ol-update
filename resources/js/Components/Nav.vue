<template>
<nav class="flex items-center flex-wrap md:justify-between bg-matope-green p-6">
  <div class="flex flex-wrap lg:flex-no-wrap items-center justify-center md:justify-between text-white mr-6">
    <Link href="/">
      <img src="/images/dakindex.png" alt="Matope home of the kimeti">
    </Link>
    <Link href="https://matope-swamp.com/forums/">
      <img src="/images/dajointheforums.png" alt="Join the forums">
    </Link>
  </div>

  <div class="w-full md:w-1/3">
    <search @input="search"></search>
  </div>
</nav>
</template>

<script>
  import Search from '@/Components/Search';

  export default {
    components: { Search },
    data: function() {
      return {
        searchBy: 1,
      }
    },
    methods: {
      search: function(searchString) {
        let searchTerms = {
          page: 1,
        };

        if (searchString) {
          this.searchBy == 1 ? searchTerms["filter[name]"] = searchString : searchTerms["filter[owner.name]"] = searchString;
        }

        this.$inertia.visit('/', {
          method: 'get',
          data: searchTerms,
          replace: false,
          preserveState: true,
          preserveScroll: true,
        })
      }
    }
  }
</script>