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
                        <input required placeholder="Summary" v-model="issue_title" type="text" class="new_issue_title width_100" name="new_issue_title" id="title">
                        <textarea placeholder="Description" v-model="issue_description" class="new_issue_description width_100" name="new_issue_description" id="description"></textarea>
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
                                        <option value="null">Unassigned</option>
                                        <option v-for="member in team" :value="member.user_id">{{member.username}}</option>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr v-for="field in fields" class="tag_row">
                                <td><label class="tag" :for="field.id">{{field.name}}</label></td>
                                <td>
                                    <input class="field_input" type="text" name="" :id="field.id">
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

export default {
    props: ['factory'],
    data() {
        return {
            issue_title: '',
            issue_description: '',
            assignee: 'null',
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
            if(!this.validate()){
                if(this.assignee == 'null')
                    this.assignee = null;
                issue_code = await this.issueStore.createIssue({
                    "title": this.issue_title,
                    "description": this.issue_description,
                    "fields": this.getFieldsValues()
                });

                if(issue_code && !issue_code.hasOwnProperty('error')){
                    this.$router.push({ name: 'issue_details', params: { code: this.chosenProject.name_id + "-" + issue_code }});
                }
                else {
                    this.$emit('error');
                }
            }
        },
        getFieldsValues: function() {
            var fieldsValues = {};
            fieldsValues.user_id = this.assignee;
            fieldsValues.project_id = this.chosenProject.project_id;

            for(var field of this.fields)
            {
                var elem = document.getElementById(field.id);
                var fieldName = field.name;
                fieldsValues[field.name] = elem.value;
            }

            return fieldsValues;
        },
        cancel: function() {
            this.$router.push({ name: 'issues' });
        },
        showError: function(container) {
            container.style ['border-color'] = '#ff0000';
	        container.setAttribute('onclick', 'this.style=""');
        },
        validate: function() {
            var error = false;
            var title = document.getElementById('title');
            var description = document.getElementById('description');

            if(!this.issue_title)
            {
                error = true;
                this.showError(title);
            }

            if(!this.issue_description)
            {
                error = true;
                this.showError(description);
            }

            return error;
        }
    },
    computed: {
        teamC: async function() {
            var teamC = await this.teamStore.getMembersList(this.chosenProject.project_id);
            this.assignee = 'null'
            if(teamC)
                this.team = teamC.team_members;
            return this.team;
        },
        fieldsC: async function() {
            var response = await this.fieldsStore.getFields(this.chosenProject.project_id);
            if(response)
                this.fields = response.fields;
            return this.fields;
        }
    },
    async beforeMount() {
        let projectsStore = this.factory.createProjectsListStore();
        this.projects = await projectsStore.getProjectsList();
        this.chosenProject = this.projects[0];
    },
    async beforeUpdate() {
        this.teamC;
        this.fieldsC;
    }
}
</script>

<style>

</style>