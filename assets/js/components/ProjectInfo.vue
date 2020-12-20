<template>
  <div class="project_view_width project_info_view">
      <div class="project_info">
        <h1 class="project_name">{{projectInfo.name}}</h1>
        <div class="issues_in_project">
            <div class="issue_in_project">
                <span>HIPPO-1</span>
                <router-link :to="{ name: 'issue_details', params: { code: 'HIPPO-1' }}" class="issue_name">Hard text of issue</router-link>
            </div>
            <div class="issue_in_project">
                <span>HIPPO-1</span>
                <router-link :to="{ name: 'issue_details', params: { code: 'HIPPO-1' }}" class="issue_name">Hard text of issue</router-link>
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
            projectInfo: {}
        }
    },
    methods: {
        getProjectInfo: async function() {
            this.projectInfo = await this.store.getProjectInfo(this.$route.params.code);
        },
        deleteProject: async function() {
            let response = await this.store.deleteProject(this.$route.params.code);
            if(response)
                this.$router.push({ name: "projects_list" });
        }
    },
    async beforeMount() {
        await this.getProjectInfo();
    }
}
</script>

<style>

</style>