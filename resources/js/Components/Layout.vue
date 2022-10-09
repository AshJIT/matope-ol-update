<template>
    <div>
        <navbar></navbar>
        <div class="sm:py-12 bg-gradient-to-b from-matope-darktan to-matope-tan min-h-screen">
            <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-matope-lighttan overflow-hidden shadow-xl sm:rounded-lg px-5">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "@/Components/Nav";

    export default {
        components: {
             Navbar,
        }
    }
</script>