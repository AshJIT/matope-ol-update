<template>
<div>
    <div>
        <ul class="flex justify-end flex-wrap">
            <li class="p-2 border border-gray-300 m-1 rounded-lg inline-block" :class="{'bg-gray-100 text-gray-300': !link.url, 'bg-amber-100 border-amber-300':  data.current_page == link.label }" v-for="link in data.links" :key="link.label">
                <Link :href="link.url" v-if="link.url" v-html="link.label" preserve-state></Link>
                <span v-else v-html="link.label"></span>
            </li>
        </ul>

        <div class="flex justify-end my-2">Showing {{ data.from }} of {{ data.to }}</div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        data: Object
    }
}
</script>