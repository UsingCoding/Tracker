<template>
  <div class="project_view_width project_info_view">
      <div class="project_info">
        <h1 class="project_name">{{projectInfo.name}}</h1>
        <div class="issues_in_project">
            <span v-if="issuesList.length == 0" class="no_issues">Seems there no issues for project</span>
            <div v-for="issue in issuesList" class="issue_in_project">
                <span>{{issue.issue_code}}</span>
                <router-link :to="{ name: 'issue_details', params: { code: issue.issue_code }}" class="issue_name">{{strings.trimString(issue.name, 25)}}</router-link>
            </div>
        </div>
        <div class="project_stat_div">
            <table class="project_stat">
                <tr>
                    <td class="stat_name stat_width">User</td>
                    <td class="stat_name stat_width">Issues count</td>
                </tr>
                <tr v-for="stat in projectInfo.user_to_issues_count" class="stat_value">
                    <td v-if="stat[0] != null" class="stat_width">{{stat[0]}}</td>
                    <td v-if="stat[0] == null" class="stat_width">Unassigned</td>
                    <td class="stat_width">{{stat[1]}}</td>
                </tr>
            </table>
            <span v-if="statistics.length == 0" class="no_issues">Seems there no statistics for project :(</span>
        </div>
      </div>
      <div class="sidebar_project">
          <div class="sidebar_content">
            <h3 class="sidebar_project_header">Administration</h3>
            <router-link v-if="projectInfo.is_owner" :to="{ name: 'project_settings', params: { code: this.$route.params.code } }" class="sidebar_link" exact>Settings</router-link>
            <router-link :to="{ name: 'project_team', params: { code: this.$route.params.code } }" class="sidebar_link" exact>Team</router-link>
            <router-link :to="{ name: 'project_fields', params: { code: this.$route.params.code } }" class="sidebar_link" exact>Fields</router-link>
            <span v-if="projectInfo.is_owner" v-on:click="deleteProject()" class="delete_project">Delete</span>
          </div>
      </div>
  </div>
</template>

<script>
import Strings from "../Utils/Strings";

export default {
    props: ['factory'],
    data() {
        return {
            store: this.factory.createProjectStore(),
            issuesStore: this.factory.createIssuesListStore(),
            projectInfo: {},
            issuesList: [],
            statistics: [],
            strings: new Strings()
        }
    },
    methods: {
        getProjectInfo: async function() {
            this.projectInfo = await this.store.getProjectInfo(this.$route.params.code);
            if(!this.projectInfo || typeof this.projectInfo['error'] !== "undefined")
                this.$emit('error');
            else
                this.statistics = this.projectInfo.user_to_issues_count;
        },
        getIssueList: async function() {
            this.issuesList = await this.issuesStore.getIssueList({
                'search_query': '',
                'project_id': this.$route.params.code
            });
            if(!this.issuesList)
                this.$emit('error');
        },
        deleteProject: async function() {
            let response = await this.store.deleteProject(this.$route.params.code);
            if(response.ok)
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

.project_stat
{
    margin-left: 3%;
}

.stat_name
{
    font: 18px/22px "Montserrat";
}

.stat_value
{
    font: 18px/22px "Montserrat";
    color: #0f5b99;
    height: 26px;
}

.stat_width
{
    width: 114px;
}

.no_issues
{
    font: 18px/22px "Montserrat";
    display: block;
    margin: 1% 0 7% 3%;
}

</style>