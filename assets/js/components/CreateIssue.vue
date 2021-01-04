<template>
    <div>
        <div>
            <h1 class="new_issue_header">
                <span>New issue in</span>
                <span class="project_title" >{{chosenProject.name}}</span>
            </h1>

            <form class="create_issue" action="index.html" method="post">

                <div class="new_issue_body">
                    <div class="width_100">
                        <input required placeholder="Summary" v-model="issue_title" type="text" class="new_issue_title width_100" name="new_issue_title">
                        <textarea placeholder="Description" v-model="issue_description" class="new_issue_description width_100" name="new_issue_description"></textarea>
                        <hr class="issue_border"/>
                        <button v-on:click="create_issue()" class="create_button" type="button" name="create">Create</button>
                        <button v-on:click="cancel()" class="create_button" type="button" name="cancel">Cancel</button>
                    </div>
                </div>

                <div class="tags_rectangle">
                    <div class="tags">
                            
                        <table class="tags_table">
                            <tr class="tag_row">
                                <td><label class="tag" for="project">Project</label></td>
                                <td>
                                    <select v-model="chosenProject" class="tag_value" name="project" id="project">
                                        <option v-for="project in projects" :value="project">{{project.name}}</option>
                                    </select>
                                </td>
                            </tr>

                            <tr class="tag_row">
                                <td><label class="tag" for="assignee">Assignee</label></td>
                                <td>
                                    <select v-model="assignee" class="tag_value" name="assignee" id="assignee">
                                        <option value="0">Unassigned</option>
                                        <option v-for="member in team" :value="member.id">{{member.username}}</option>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr v-for="field in fields.fields" class="tag_row">
                                <td><label class="tag" for="assignee">{{field.name}}</label></td>
                                <td>
                                    <input class="field_input" type="text" name="">
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

const user_id = 10;

export default {
    props: ['factory'],
    data() {
        return {
            issue_title: '',
            issue_description: '',
            assignee: '0',
            chosenProject: {},
            issueStore: this.factory.createCreateIssueStore(),
            teamStore: this.factory.createMembersListStore(),
            fieldsStore: this.factory.createFieldsListStore(),
            team: [],
            projects: [],
            fields: []
        }
    },
    methods: {
        create_issue: async function() {
            let issue_code;
            if(this.title && this.description){
                issue_code = await this.issueStore.createIssue({
                    "title": this.issue_title,
                    "description": this.issue_description,
                    "fields": {
                        "user_id": user_id,
                        "project_id": this.chosenProject.project_id
                    }
                });
            }
            if(issue_code && !issue_code.hasOwnProperty['error']){
                this.$router.push({ name: 'issue_details', params: { code: this.chosenProject.name_id + "-" + issue_code }});
            }
            else {
                this.$emit('error');
            }
        },

        cancel: function() {
            this.$router.push({ name: 'issues' });
        }
    },
    async beforeMount() {
        let projectsStore = this.factory.createProjectsListStore();
        this.projects = await projectsStore.getProjectsList();
        this.chosenProject = this.projects[0];
        // this.team = await this.teamStore.getMembersList(this.chosenProject.project_id).team_members;
        // this.assignee = this.team[0].id;
        this.fields = await this.fieldsStore.getFields(this.chosenProject.project_id);
    }
}
</script>

<style>

</style>