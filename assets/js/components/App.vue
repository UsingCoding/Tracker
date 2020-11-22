<template>
  <div class="all_screen">
    <!-- <router-view v-bind:factory="factory"></router-view> -->
    <router-view></router-view>
  </div>
</template>

<script>
import login from "../pages/LoginPage";
import issues from "../pages/IssuesPage";
import create_issue from "../pages/CreateIssuePage";
import issue_details from "../pages/IssueDetailsPage";
import StoreFactory from '../Factory/StoreFactory';
import ServerApi from "../Api/ServerApi";

const server_api = new ServerApi();

export default {
  name: "App",
  data() {
    return {
      //factory: new StoreFactory(server_api)
    }
  },
  components: {
    "login": login,
    "issues": issues,
    "create-issue": create_issue,
    "issue-details": issue_details
  }
}

</script>

<style scoped>

</style>