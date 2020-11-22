<template>
  <div class="all_issues">  
    <div v-for="issue in issuesList" class="issue">
      <div class="issue_details">
        <span class="issue_header">{{issue.issue_code}}</span>
        <router-link :to="{name: 'issue_details', params: { code: issue.issue_code }}" class="issue_title" exact>{{issue.name}}</router-link>
        <span class="issue_date">{{issue.updated_at}}</span>
      </div>
      <div class="issue_footer">
        <div class="issue_fields">
          <div class="issue_field">
            <span>{{issue.username}}</span>
          </div>
          <div class="issue_field">
            <span>{{issue.state}}</span>
          </div>
          <div class="issue_field">
            <span>{{issue.stage}}</span>
          </div>
          <div class="issue_field">
            <span>{{issue.time}}</span>
          </div>
          <div class="issue_field difficulty">
            <span>{{issue.difficulty}}</span>
          </div>
        </div>
      </div>
      <hr class="issue_border"/>
    </div>
  </div>
</template>

<script>

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