<template>
    <div class="search_panel">
        <div class="">
            <span class="search_type" >Everything</span>
        </div>
        <div class="search_field">
            <input v-model="search" v-on:keyup.enter="findIssues()" class="search_input" type="text" id="search_str"/>
            <div class="">
                <span v-on:click="findIssues()" class="search_button">Search</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: ''
        }
    },
    methods: {
        findIssues: function () {
            if(this.$route.name=="issues")
            {
                this.$emit('find', this.search);
            }
        }
    }
}
</script>

<style>

</style>