<template>
    <div>
        <app-header></app-header>
        <search-panel v-bind:projects="projectsList" v-on:find="getIssueList($event)"></search-panel>
        <toolbar></toolbar>
        <issues-list ref="issuesList" v-on:loadMore="getMoreIssueList($event)" v-bind:loading="loading" v-bind:factory="factory" v-bind:issues="issues"></issues-list>
        <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
        <scroll-loader :loader-method="getMoreIssueList" :loader-disable="loadMore" :loader-size="50"></scroll-loader>
    </div>
</template>

<script>
import header from "../components/Header";
import tools from "../components/Toolbar";
import issues from "../components/Issues";
import search_panel from "../components/SearchPanel";
import popup from "../components/Popup";
import loader from "../components/Loader";

export default {
    props: ['factory'],
    data() {
        return {
            store: this.factory.createIssuesListStore(),
            issues: [],
            projectsList: [],
            popupFlag: false,
            search: '',
            projectId: null ,
            loading: true,
            loadMore: false,
            page: 0
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "issues-list": issues,
        'pop-up': popup,
        'loader': loader
    },
    methods: {
        getIssueList: async function(props) {
            this.issues = [];
            this.loading = true;
            this.page = 1;
            var response = await this.store.getIssueList({
                'search_query': props.search_query,
                'page': this.page,
                'project_id': props.project_id
            });
            this.projectId = props.project_id;
            this.search = props.search_query;
            if(response.length != 0)
            {
                for(var issue of response)
                {
                    this.issues.push(issue);
                }
            }
            this.loadMore = false;
            this.loading = false;
        },
        getMoreIssueList: async function(props) {
            this.page += 1;
            if(this.page == 1)
                this.loading = true;
            
            var response = await this.store.getIssueList({
                'search_query': this.search,
                'page': this.page,
                'project_id': this.projectId
            });
            if(response.length != 0)
            {
                for(var issue of response)
                {
                    this.issues.push(issue);
                }
            }
            else
                this.loadMore = true;
            if(this.page == 1)
                this.loading = false;
            
        },
        openPopup: function() {
            this.popupFlag = true;
        },
        closePopup: function() {
            this.popupFlag = false;
        },
        getProjects: async function() {
            var projectsStore = this.factory.createProjectsListStore();
            this.projectsList = await projectsStore.getProjectsList();
            if(!this.projectsList || this.projectsList.hasOwnProperty('error'))
                this.$emit('error');
        }
    },
    async beforeMount() {
        await this.getProjects();
    }
}
</script>

<style>

</style>