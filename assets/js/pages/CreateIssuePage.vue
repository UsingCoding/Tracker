<template>
  <div>
        <app-header></app-header>
        <search-panel></search-panel>
        <toolbar></toolbar>
        <loader v-if="loading"></loader>
        <create-issue-form v-bind:loading="loading" v-bind:factory="factory" v-on:error="openPopup()"></create-issue-form>
        <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
  </div>
</template>

<script>
import tools from "../components/Toolbar";
import header from "../components/Header";
import create_issue from "../components/CreateIssue";
import search_panel from "../components/SearchPanel";
import popup from "../components/Popup";
import loader from "../components/Loader";

export default {
    props: ['factory'],
    data() {
        return {
            popupFlag: false,
            loading: true           
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "create-issue-form": create_issue,
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