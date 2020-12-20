<template>
  <div class="list_view">  
    <div v-for="issue in issuesList" class="issue">
      <div class="issue_details">
        <span class="issue_header">{{issue.issue_code}}</span>
        <router-link :to="{name: 'issue_details', params: { code: issue.issue_code }}" class="issue_title" exact>{{issue.name}}</router-link>
        <span class="issue_date">{{issue.updated_at}}</span>
      </div>
      <div class="issue_footer">
        <div class="issue_fields">
          <!-- <div v-for="field in issue.fields" class="issue_field">
            <span>{{field}}</span>
          </div> -->
          <div class="issue_field">
            <span>{{issue.username}}</span>
          </div>
        </div>
      </div>
      <hr class="issue_border"/>
    </div>
  </div>
</template>

<script>
import Strings from "../Utils/Strings";

export default {
  props:['factory'],
  data() {
      return {
        store: this.factory.createIssuesListStore(),
        issuesList: {}
      }
  },
  methods: {
    getIssueList: async function() {
      this.issuesList = await this.store.getIssueList();
    }
  },
  async beforeMount() {
    await this.getIssueList();
  }
}

</script>

<style>

a
{
  text-decoration: none;
}

.router-link-active
{
  text-decoration: none;
}


</style>