<template>
  <div class="all_screen">
    <router-view v-bind:factory="factory"></router-view>
  </div>
</template>

<script>
import login from "../pages/LoginPage";
import issues from "../pages/IssuesPage";
import create_issue from "../pages/CreateIssuePage";
import issue_details from "../pages/IssueDetailsPage";
import projects_list from "../pages/ProjectsListPage";
import create_project from "../pages/CreateProjectPage";
import project_info from "../pages/ProjectInfoPage";
import project_fields from "../pages/ProjectFieldsPage";
import project_settings from "../pages/ProjectSettingsPage";

import StoreFactory from '../Factory/StoreFactory';
import ServerApi from "../Api/ServerApi";

const server_api = new ServerApi();
const tempFactory = new StoreFactory(server_api);

export default {
  name: "App",
  data() {
    return {
      factory: tempFactory
    }
  },
  components: {
    "login": login,
    "issues": issues,
    "create-issue": create_issue,
    "issue-details": issue_details,
    "projects-list": projects_list,
    "project-info": project_info
  }
}

</script>

<style scoped>

</style>