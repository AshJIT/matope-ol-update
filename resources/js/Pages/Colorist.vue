<template>
    <kin-template :title="'Kin colored by ' + kin.data[0].colourist.name" :kin="kin"></kin-template>
</template>

<script>
    import KinTemplate from "@/Components/KinTemplate";

    export default {
        props: {
            kin: Object
        },
        components: {
            KinTemplate
        },
        data: function() {
            return {
                showImages: true,
            }
        }
    }
</script>
