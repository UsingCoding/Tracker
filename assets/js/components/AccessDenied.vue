<template>
    <div class="all_screen center">
        <div class="container">
            <span class="lost">Get Lost?</span>
            <button v-on:click="goHome()" class="log_in">Go To Issues <i class="fas fa-long-arrow-alt-right"></i></button>
        </div>
        <div class="spacer"></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
        
        }
    },
    methods: {
        goHome: function() {
            this.$router.push({name: 'issues'});
        }
    }
}
</script>

<style>

</style>