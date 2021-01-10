<template>
    <div>
        <app-header></app-header>
        <loader v-if="loading"></loader>
        <projects-list v-bind:factory="factory" v-bind:loading="loading" v-on:error="openPopup()"></projects-list>
        <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
    </div>
</template>

<script>
import header from "../components/Header";
import projects_list from "../components/ProjectsList";
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
        'projects-list': projects_list,
        'pop-up': popup,
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