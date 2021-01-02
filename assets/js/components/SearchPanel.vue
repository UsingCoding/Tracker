<template>
    <div class="search_panel">
        <div class="">
            <span class="search_type" >Everything</span>
        </div>
        <div class="search_field">
            <!-- <div class="search_input" spellcheck="false" tabindex="0" contenteditable="true" role="textbox">
            </div> -->
            <input v-model="search" class="search_input" type="text"/>
            <div class="">
                <span v-on:click="find()" class="search_button">Search</span>
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
        find: function () {
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