<template>
    <div class="all_screen center">
        <div class="container">
            <span class="lost">Get Lost?</span>
            <button v-on:click="goLogin()" class="log_in">Go To Login <i class="fas fa-long-arrow-alt-right"></i></button>
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
        goLogin: function() {
            this.$router.push({name: 'login'});
        }
    }
}
</script>

<style>

</style>