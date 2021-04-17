<template>
    <kin-template title="Kindex Listings" :kin="kin"></kin-template>
</template>

<script>
import KinTemplate from '@/Components/KinTemplate';

export default {
    props: ['kin'],
    components: { KinTemplate },
    data: function() {
        return {
            showImages: true,
        }
    }
}
</script>
