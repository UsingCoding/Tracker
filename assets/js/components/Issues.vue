<template>
  <div class="all_issues">  
    <div v-for="issue in issuesList" class="issue">
      <div class="issue_details">
        <router-link :to="{name: 'issue_details', params: { code: issue.name }}" class="issue_header" exact>Some project</router-link>
        <router-link :to="{name: 'issue_details', params: { code: issue.name }}" class="issue_title" exact>{{issue.name}}</router-link>
        <span class="issue_date">{{issue.created_at["date"]}}</span>
      </div>
      <div class="issue_footer">
        <div class="issue_fields">
          <div class="issue_field">
            <span>{{issue.employee}}</span>
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

.router-link-active
{
  text-decoration: none;
}


</style>