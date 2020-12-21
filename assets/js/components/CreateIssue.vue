<template>
    <div>
        <div>
            <h1 class="new_issue_header">
                <span>New issue in</span>
                <span class="project_title" >Some test</span>
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
                                    <select v-model="project_id" class="tag_value" name="project" id="project">
                                        <option v-for="project in projects" :value="project.project_id">{{project.name}}</option>
                                    </select>
                                </td>
                            </tr>

                            <!-- <tr class="tag_row">
                                <td><label class="tag" for="assignee">Assignee</label></td>
                                <td>
                                    <select v-model="assignee" class="tag_value" name="assignee" id="assignee">
                                        <option value="jojo">jojo</option>
                                        <option value="Unassigned">Unassigned</option>
                                    </select>
                                </td>
                            </tr> -->

                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

const user_id = 1;
// const project_id = 1;

export default {
    props: ['factory'],
    data() {
        return {
            issue_title: '',
            issue_description: '',
            assignee: 'Unassigned',
            project_id: '',
            store: this.factory.createCreateIssueStore(),
            projects: []
        }
    },
    methods: {
        create_issue: async function() {
            let issue_code = await this.store.createIssue({
                "title": this.issue_title,
                "description": this.issue_description,
                "fields": {
                    "user_id": user_id,
                    "project_id": this.project_id
                }
            });
            
            this.$router.push({ name: 'issue_details', params: { code: "PANDA-" + issue_code }});
        },

        cancel: function() {
            this.$router.push({ name: 'issues' });
        }
    },
    async beforeMount() {
        let projectsStore = this.factory.createProjectsListStore();
        this.projects = await projectsStore.getProjectsList();
        this.project_id = this.projects[0].project_id;
    }
}
</script>

<style>

</style>