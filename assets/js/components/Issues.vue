<template>
  <div class="all_screen width_100">
    <div class="list_view">  
      <div v-for="issue in issues" class="issue">
        <div class="issue_details">
          <span class="issue_header">{{issue.issue_code}}</span>
          <router-link :to="{ name: 'issue_details', params: { code: issue.issue_code }}" class="issue_title" exact>{{strings.trimString(issue.name)}}</router-link>
          <span class="issue_date">{{issue.updated_at}}</span>
        </div>
        <div class="issue_footer">
          <div class="issue_fields">
            <div class="issue_field">
              <span v-if="issue.username == null">Unassinged</span>
              <span v-else>{{issue.username}}</span>
            </div>
            <div v-for="field in issue.fields"  class="issue_field">
              <span v-if="field != 'null' && field != null && field != ''">{{field}}</span>
              <span v-else>No field value</span>
            </div>
          </div>
        </div>
        <hr class="issue_border"/>
      </div>
    </div>

    <div v-if="issues.length == 0" class="all_screen center">
      <div class="container no_issues_div">
        <span class="no_issues_list">There is no issues</span>
        <router-link :to="{ name: 'create_issue'}" class="first_create_issue">Create new one <i class="fas fa-long-arrow-alt-right"></i></router-link>
      </div>
      <div class="spacer"></div>
    </div>
  </div>
</template>

<script>
import Strings from "../Utils/Strings";

export default {
  props:[
    'factory',
    'issues'
  ],
  data() {
      return {
        strings: new Strings()
      }
  },
  methods: {
    
  },
  async beforeMount() {
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

.no_issues_list
{
  font: 36px/44px "Montserrat";
  color: #000000;
  display: block;
  margin-bottom: 10%;
}

.first_create_issue
{
  background: #3b3b3b;
  width: 260px;
  height: 40px;
  font: 18px/22px "Montserrat";
  color: #ffffff;
  border-radius: 3px;
  padding: 5px 25px;
}

.no_issues_div
{
  width: 326px;
}

</style>