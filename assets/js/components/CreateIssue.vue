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

                        <label class="tag">Assignee
                            <select v-model="assignee" class="tag_value" name="assignee">
                        <!--<option v-for="employee in command" value="">{{employee}}</option>-->
                                <option value="Temp employee">Temp employee</option>
                            </select>
                        </label>

                        <label class="tag">State
                            <select v-model="state" class="tag_value" name="state">
                                <option value="Submited">Submited</option>
                                <option value="Open">Open</option>
                                <option value="In Progress">In Progress</option>
                            </select>
                        </label>

                        <label class="tag">Stage
                            <select v-model="stage" class="tag_value" name="stage">
                                <option value="Backlog">Backlog</option>
                                <option value="Test">Test</option>
                                <option value="Develop">Develop</option>
                            </select>
                        </label>

                        <label class="tag">Estimation
                            <input v-model="estimation" class="estimation" type="text" name="estimation">
                        </label>

                        <label class="tag">Difficulty
                            <select v-model="difficulty" class="tag_value" name="difficulty">
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </label>

                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import header from "./Header";
import tools from "./Toolbar";

export default {
    data() {
        return {
            issue_title: '',
            issue_description: '',
            assignee: 'Temp',
            state: 'Submited',
            stage: 'Backlog',
            estimation: '3h',
            difficulty: 'Easy'
        }
    },
    components: {
        "app-header": header,
        "toolbar": tools
    },
    methods: {
        create_issue: /*async*/ function() {
            console.log(this.issue_title);
            console.log(this.issue_description);
            console.log(this.assignee);
            console.log(this.state);
            console.log(this.stage);
            console.log(this.estimation);
            console.log(this.difficulty);
            // let response = await fetch('/api/issue/create', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json;charset=utf-8'
            //     },
            //     body: JSON.stringify({
            //         "title": this.issue_title,
            //         "description": this.issue_description,
            //         "fields": JSON.stringify({
            //             "employee": this.assignee
            //             // "project": project from class Store
            //         })       
            //     })
            // })

            // let result = await response.json();
            // if(result === 1){

            // }
            // else {
            //     alert("Ooops, something went wrong =(");
            // }
        },

        cancel: function() {
            // console.log(sessionStorage.getItem("name"));
            this.$router.push({path: '/issues'});
        }
    }
}
</script>

<style>

</style>