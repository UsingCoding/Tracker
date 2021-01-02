<template>
    <div>
      <app-header></app-header>
      <search-panel></search-panel>
      <toolbar v-on:delete="deleteIssue()" v-on:goEdit="changeEdit()" v-bind:edit_flag="edit_flag"></toolbar>
      <issue-info ref="issue_info" v-on:cancel_edit="changeEdit()" v-bind:factory="factory" v-bind:edit_flag="edit_flag"></issue-info>
    </div>
</template>

<script>
import header from "../components/Header";
import tools from "../components/Toolbar";
import search_panel from "../components/SearchPanel";
import issue_info from "../components/IssueInfo";

export default {
    props: ['factory'],
    data() {
        return{
            edit_flag: false
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "issue-info": issue_info
    },
    methods: {
        changeEdit: function () {
            this.edit_flag = !this.edit_flag;
        },
        deleteIssue: function() {
            var child = this.$refs.issue_info;
            child.delete_issue();
        }
    }
}
</script>

<style>

</style>