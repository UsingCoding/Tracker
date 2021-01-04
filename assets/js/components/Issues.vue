<template>
  <div class="list_view">  
    <div v-for="issue in issues" class="issue">
      <div class="issue_details">
        <span class="issue_header">{{issue.issue_code}}</span>
        <router-link :to="{name: 'issue_details', params: { code: issue.issue_code }}" class="issue_title" exact>{{issue.name}}</router-link>
        <span class="issue_date">{{issue.updated_at}}</span>
      </div>
      <div class="issue_footer">
        <div class="issue_fields">
          <div class="issue_field">
            <span v-if="issue.username == ''">Unassinged</span>
            <span v-else>{{issue.username}}</span>
          </div>
          <!-- <div v-for="field in issue.fields" class="issue_field">
            <span>{{field}}</span>
          </div> -->
        </div>
      </div>
      <hr class="issue_border"/>
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


</style>