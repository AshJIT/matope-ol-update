<template>
<div>
    <div>
        <ul class="flex justify-end flex-wrap">
            <li class="p-2 border border-gray-300 m-1 rounded-lg inline-block" :class="{'bg-gray-100 text-gray-300': !link.url }" v-for="link in data.links" :key="link.label">
                <inertia-link :href="link.url" v-if="link.url" v-html="link.label" preserve-state preserve-scroll></inertia-link>
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