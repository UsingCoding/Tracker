<template>
  <div>
      <app-header></app-header>
      <search-panel></search-panel>
      <toolbar></toolbar>
      <create-issue-form v-bind:factory="factory" v-on:error="changeFlag()"></create-issue-form>
      <pop-up v-bind:popupFlag="popupFlag" v-on:close="changeFlag()"></pop-up>
  </div>
</template>

<script>
import tools from "../components/Toolbar";
import header from "../components/Header";
import create_issue from "../components/CreateIssue";
import search_panel from "../components/SearchPanel";
import popup from "../components/Popup";

export default {
    props: ['factory'],
    data() {
        return {
            popupFlag: false           
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "create-issue-form": create_issue,
        "pop-up": popup
    },
    methods: {
        changeFlag: function() {
            this.popupFlag = !this.popupFlag;
        }
    }
}
</script>

<style>

</style>