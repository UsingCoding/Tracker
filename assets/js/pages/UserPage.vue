<template>
    <div>
        <app-header></app-header>
        <loader v-if="loading"></loader>
        <user-info v-bind:loading="loading" v-bind:factory="factory" v-on:error="openPopup()"></user-info>
        <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
    </div>
</template>

<script>
import header from "../components/Header";
import userInfo from "../components/UserInfo";
import popup from "../components/Popup";
import loader from "../components/Loader";

export default {
    props: ['factory'],
    data(){
        return {
            popupFlag: false,
            loading: true
        }
    },
    components: {
        'app-header': header,
        'user-info': userInfo,
        "pop-up": popup,
        'loader': loader
    },
    methods: {
        openPopup: function() {
            this.popupFlag = true;
        },
        closePopup: function() {
            this.popupFlag = false;
        }
    }
}
</script>

<style>

</style>