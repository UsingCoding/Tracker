<template>
  <div class="all_screen">
    <router-view></router-view>
  </div>
</template>

<script>
import login from "../pages/LoginPage";
import issues from "../pages/IssuesPage";
import create_issue from "../pages/CreateIssuePage";
import issue_details from "../pages/IssueDetailsPage";

export default {
  name: "App",
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