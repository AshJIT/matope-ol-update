<template>
    <kin-template :title="`${owner.name}'s kin`" :kin="kin"></kin-template>
</template>

<script>
    import KinTemplate from "@/Components/KinTemplate";

    export default {
        props: {
            kin: Object,
            owner: Object
        },
        components: {
            KinTemplate
        },
    }
</script>
