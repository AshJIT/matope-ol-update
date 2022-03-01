<template>
    <familiar-template title="Familiar Listings" :familiars="familiars"></familiar-template>
</template>

<script>
import FamiliarTemplate from '@/Components/FamiliarTemplate';

export default {
    props: ['familiars'],
    components: { FamiliarTemplate },
    data: function() {
        return {
            showImages: true,
        }
    }
}
</script>
