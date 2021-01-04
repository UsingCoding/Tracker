<template>
  <div class="project_view_width project_info_view">
      <div class="project_info">
        <h1 class="project_name">{{projectInfo.name}}</h1>
        <div class="issues_in_project">
            <div v-for="issue in issuesList" class="issue_in_project">
                <span>{{issue.issue_code}}</span>
                <router-link :to="{ name: 'issue_details', params: { code: issue.issue_code }}" class="issue_name">{{issue.name}}</router-link>
            </div>
        </div>
      </div>
      <div class="sidebar_project">
          <div class="sidebar_content">
            <h3 class="sidebar_project_header">Administration</h3>
            <router-link :to="{ name: 'project_settings', params: { code: this.$route.params.code } }" class="sidebar_link" exact>Settings</router-link>
            <router-link :to="{ name: 'project_team', params: { code: this.$route.params.code } }" class="sidebar_link" exact>Team</router-link>
            <router-link to="/" class="sidebar_link" exact>Access</router-link>
            <router-link :to="{ name: 'project_fields', params: { code: this.$route.params.code } }" class="sidebar_link" exact>Fields</router-link>
            <span v-on:click="deleteProject()" class="delete_project">Delete</span>
          </div>
      </div>
  </div>
</template>

<script>

export default {
    props: ['factory'],
    data() {
        return {
            store: this.factory.createProjectStore(),
            issuesStore: this.factory.createIssuesListStore(),
            projectInfo: {},
            issuesList: []
        }
    },
    methods: {
        getProjectInfo: async function() {
            this.projectInfo = await this.store.getProjectInfo(this.$route.params.code);
            if(!this.projectInfo || typeof this.projectInfo['error'] !== "undefined")
                this.$emit('error');
        },
        getIssueList: async function() {
            this.issuesList = await this.issuesStore.getIssueList(this.projectInfo.nameId);
            if(!this.issuesList || typeof this.issuesList['error'] !== "undefined")
                this.$emit('error');
        },
        deleteProject: async function() {
            let response = await this.store.deleteProject(this.$route.params.code);
            if(response.ok && typeof response['error'] === "undefined")
                this.$router.push({ name: "projects_list" });
            else
                this.$emit('error');
        }
    },
    async beforeMount() {
        await this.getProjectInfo();
        await this.getIssueList();
    }
}
</script>

<style>

</style>