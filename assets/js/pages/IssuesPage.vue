<template>
    <div>
        <app-header></app-header>
        <search-panel v-on:find="getIssueList($event)"></search-panel>
        <toolbar></toolbar>
        <issues-list v-bind:factory="factory" v-bind:issues="issues"></issues-list>
        <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
    </div>
</template>

<script>
import header from "../components/Header";
import tools from "../components/Toolbar";
import issues from "../components/Issues";
import search_panel from "../components/SearchPanel";
import popup from "../components/Popup";

export default {
    props: ['factory'],
    data() {
        return {
            store: this.factory.createIssuesListStore(),
            issues: [],
            popupFlag: false
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "issues-list": issues,
        'pop-up': popup
    },
    methods: {
        getIssueList: async function(search) {
            this.issues = await this.store.getIssueList({
                'search_query': search,
                'project_id': null
            });
            if(!this.issues || this.issues.hasOwnProperty('error'))
                this.openPopup();
        },
        openPopup: function() {
            this.popupFlag = true;
        },
        closePopup: function() {
            this.popupFlag = false;
        }
    },
    async beforeMount() {
        await this.getIssueList('');
    }
}
</script>

<style>

</style>