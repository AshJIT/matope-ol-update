<template>
    <div class="container mx-auto rounded-md border border-gray-300 py-5 px-10 my-10">
        <h1 class="text-2xl font-bold">{{ kin.name }}</h1>
        <div class="flex lg:w-1/2 flex-col lg:flex-row">
            <div class="flex-1">
                <img :src="kin.current_image_url" alt="kin image">
            </div>
            <div class="flex-1">
                <ul>
                    <li><strong>Birthdate: </strong> {{ kin.birthdate }}</li>
                    <li><strong>Gender: </strong> {{ kin.gender.name }}</li>
                    <li><strong>Owner: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/owner/' + kin.gaian.slug">{{ kin.gaian.name }}</inertia-link></li>
                    <li><strong>Colourist: </strong> {{ kin.colourist.name }}</li>
                    <li><strong>Mother: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/kin/' + kin.mother.slug" v-if="kin.mother">{{ kin.mother.name }}</inertia-link> <span v-else>None</span></li>
                    <li><strong>Father: </strong> <inertia-link class="text-blue-400 hover:text-blue-700" :href="'/kin/' + kin.father.slug" v-if="kin.father">{{ kin.father.name }}</inertia-link> <span v-else>None</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-300 mt-5" v-if="children">
            <div class="flex justify-between my-5">
                <h1 class="text-xl font-bold">Children</h1>
                <div class="">
                    <input type="checkbox" id="show-offspring" name="show-offspring" v-model="showOffspring">
                    <label class="ml-2" for="show-images"> Show Offspring</label><br>
                </div>
            </div>

            <div class="border-b border-gray-300" v-for="(breeding, index) in groupBy(children, 'birthdate')" :key="index" v-show="showOffspring">
                <p class="my-2">
                    <inertia-link class="py-5 text-blue-400 hover:text-blue-700" :href="'/kin/' + breeding[0].mother.slug">{{ breeding[0].mother.name }}</inertia-link> 
                    <span> x </span>
                    <inertia-link class="py-5 text-blue-400 hover:text-blue-700" :href="'/kin/' + breeding[0].father.slug">{{ breeding[0].father.name }}</inertia-link>
                </p>

                <div class="flex flex-wrap">
                    <div v-for="child in breeding" :key="child.id" >
                        <inertia-link :href="'/kin/' + child.slug" class="flex flex-col justify-between items-center">
                            <img :src="child.current_image_url" :alt="child.name">
                            <span class="py-5 text-blue-400 hover:text-blue-700">{{ child.name }}</span>
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            kin: Object,
            children: Object
        },
        data: function() {
            return {
                showOffspring: true,
            }
        },
        mounted() {
            console.log(this.children);
        },
        methods: {
            groupBy: function(items, key) {
                const result = {};

                items.forEach(item => {
                    if (!result[item[key]]){
                        result[item[key]] = [];
                    }
                    result[item[key]].push(item);
                });

                console.log(result);

                return result;
            }
        }
    }
</script>
