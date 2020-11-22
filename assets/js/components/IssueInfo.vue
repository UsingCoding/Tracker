<template>
    <div>
        <div v-if="!edit_flag" class="issue_view">
            <div class="issue_view_info">
                <div class="top_issue_view">
                    <span class="project_title">Some Project</span>
                    <span class="created_date">Created {{this.issueInfo.created_at["date"]}}</span>
                </div>
                <div class="issue_view_body">
                    <span class="issue_view_title">{{new_title}}</span>
                    <p class="issue_view_description">{{new_description}}</p>
                    <hr class="issue_border"/>

                    <!-- <div class="comments">
                        <div v-for="comment in issue_details.comments" class="comment">

                            <div class="user_img">
                                <div class="user_img_test"></div>
                            </div>

                            <div class="comment_content">
                                <span class="comment_owner">{{comment.user}} commented {{comment.date}}</span>
                                <p class="comment_text">{{comment.text}}</p>
                            </div>
                        </div>
                    </div> -->
                </div>

            </div>


            <div class="tags_rectangle view_tags">
                <div class="tags">
                    <!-- <div v-for="(val,key) in issue_details.tags" class="tag" >{{key}}<span class="tag_value"></span>{{val}}</div> -->
                </div>
            </div>
        </div>
        <form v-if="edit_flag" class="create_issue" action="index.html" method="post">

                <div class="new_issue_body">
                  <div class="width_100">
                    <input required placeholder="Summary" v-model="new_title" type="text" class="new_issue_title width_100" name="new_issue_title">
                    <textarea placeholder="Description" v-model="new_description" class="new_issue_description width_100" name="new_issue_description"></textarea>
                    <hr class="issue_border"/>
                    <button v-if="edit_flag" v-on:click="edit_issue()" class="create_button" type="button" name="save">Save</button>
                    <button v-on:click="cancel_edit()" class="create_button" type="button" name="cancel">Cancel</button>
                  </div>
                </div>

                <!--<div class="tags_rectangle">
                  <div class="tags">

                    <label class="tag">Assignee
                      <select v-model="assignee" v-bind="assignee" class="tag_value" name="assignee">
                        <option v-for="employee in command" value="">{{employee}}</option>
                        <option value="Temp employee">Temp employee</option>
                      </select>
                    </label>

                    <label class="tag">State
                      <select v-model="state" v-bind="state" class="tag_value" name="state">
                        <option value="Submited">Submited</option>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                      </select>
                    </label>

                    <label class="tag">Stage
                      <select v-model="stage" v-bind="stage" class="tag_value" name="stage">
                        <option value="Backlog">Backlog</option>
                        <option value="Test">Test</option>
                        <option value="Develop">Develop</option>
                      </select>
                    </label>

                    <label class="tag">Estimation
                      <input v-model="estimation" v-bind="estimation" class="estimation" type="text" name="estimation">
                    </label>

                    <label class="tag">Difficulty
                      <select v-model="difficulty" v-bind="difficulty" class="tag_value" name="difficulty">
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                      </select>
                    </label>

                  </div>
                </div>-->
              </form>
    </div>
</template>

<script>

const user_id = 1;
const project_id = 1;

export default {
  props: [
    'edit_flag',
    'factory'
  ],
  data() {
    return {
      store: this.factory.createIssueStore(),
      issueInfo: {},
      new_description: '',
      new_title: ''
    }
  },
  methods: {
    edit_issue: async function() {
        let result = await this.store.updateIssue({
          "issue_id": this.$route.params.code,
          "title": this.new_title,
          "description": this.new_description,
          "fields": {
            "user_id": user_id,
            "project_id": project_id
          }
        });
        this.cancel_edit();
    },
    cancel_edit: function() {
      this.$emit('cancel_edit');
    },
    getIssueInfo: async function() {
      this.issueInfo = await this.store.getIssueInformation(this.$route.params.code);  
    }
  },
  async beforeMount() {
    await this.getIssueInfo();
    this.new_title = this.issueInfo.name;
    this.new_description = this.issueInfo.description;
  }
}
</script>

<style>

</style>