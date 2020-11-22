<template>
  <div>
      <app-header></app-header>
      <search-panel></search-panel>
      <toolbar></toolbar>
      <create-issue-form></create-issue-form>
  </div>
</template>

<script>
import tools from "../components/Toolbar";
import header from "../components/Header";
import create_issue from "../components/CreateIssue";
import search_panel from "../components/SearchPanel";

export default {
    data() {
        return{}
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "create-issue-form": create_issue
    },
    methods: {

    }
}
</script>

<style>

</style>