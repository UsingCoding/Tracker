<template>
    <div v-if="popupFlag" class="popup_div">
        <div class="popup_content">
            <div class="popup_header">
                <span class="popup_title">Oh crap!</span>
                <div v-on:click="close()" class="popup_close"><i class="fas fa-times"></i></div>
            </div>
            <span class="popup_warn">An error occured while we try to make request. Please try later</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['popupFlag'],
    data() {
        return {
            
        }
    },
    methods: {
        close: function() {
            this.$emit('close');
        }
    }
}
</script>

<style>

</style>