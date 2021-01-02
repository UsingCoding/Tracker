<template>
  <div>
      <app-header></app-header>
      <search-panel v-on:find="getIssueList($event)"></search-panel>
      <toolbar></toolbar>
      <issues-list v-bind:factory="factory" v-bind:issues="issues"></issues-list>
  </div>
</template>

<script>
import header from "../components/Header";
import tools from "../components/Toolbar";
import issues from "../components/Issues";
import search_panel from "../components/SearchPanel";

export default {
    props: ['factory'],
    data() {
        return {
            store: this.factory.createIssuesListStore(),
            issues: []
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "issues-list": issues
    },
    methods: {
        getIssueList: async function(search) {
            this.issues = await this.store.getIssueList(search);
        }
    },
    async beforeMount() {
        await this.getIssueList('');
    }
}
</script>

<style>

</style>