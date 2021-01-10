<template>
    <div class="search_panel">
        <div class="">
            <select v-on:change="findIssues()" class="search_type" v-model="projectId" name="" id="">
                <option :value="null">Everything</option>
                <option v-for="project in projects" :value="project.project_id">{{strings.trimString(project.name, 10)}}</option>
            </select>
        </div>
        <div class="search_field">
            <input placeholder="Enter search request" v-model="search" v-on:keyup.enter="findIssues()" class="search_input" type="text" id="search_str"/>
            <div class="">
                <span v-on:click="findIssues()" class="search_button">Search</span>
            </div>
        </div>
    </div>
</template>

<script>
import Strings from "../Utils/Strings";

export default {
    props: [
        'projects',
        'searchQuery',
        'project_id'
    ],
    data() {
        return {
            search: '',
            projectId: null,
            strings: new Strings()
        }
    },
    methods: {
        findIssues: function () {
            if(this.$route.name == "issues")
            {
                this.$emit('find', { 'search_query': this.search, 'project_id': this.projectId });
            }
            if(this.$route.name == "create_issue" || this.$route.name == "issue_details")
            {
                this.$router.push({ name: 'issues', params: { search: this.search, project_id: this.projectId} });
            }
        }
    },
    beforeMount() {
        if(this.searchQuery)
        {
            this.search = this.searchQuery;
            this.projectId = this.project_id;
        }
    }
}
</script>

<style>

</style>