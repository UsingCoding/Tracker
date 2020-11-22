<template>
    <div>
        <div class="issue_view">
            <div class="issue_view_info">
                <div class="top_issue_view">
                    <span class="project_title">{{issue_details.he}}</span>
                    <span class="created_date">Created {{issue_details.create_date}}</span>
                </div>
                <div class="issue_view_body">
                    <span class="issue_view_title">{{issue_details.title}}</span>
                    <p class="issue_view_description">{{issue_details.description}}</p>
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
        <!--<form v-if="edit_flag" class="create_issue" action="index.html" method="post">

                <div class="new_issue_body">
                  <div class="width_100">
                    <input required placeholder="Summary" type="text" class="new_issue_title width_100" v-bind:value="title" name="new_issue_title">
                    <textarea placeholder="Description" class="new_issue_description width_100" v-bind:value="description" name="new_issue_description"></textarea>
                    <hr class="issue_border"/>
                    <button v-if="edit_issue_flag" v-on:click="edit_issue()" class="create_button" type="button" name="save">Save</button>
                    <button v-on:click="cancel_edit()" class="create_button" type="button" name="cancel">Cancel</button>
                  </div>
                </div>

                <div class="tags_rectangle">
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
                </div>
              </form>-->
    </div>
</template>

<script>


export default {
  props: {
    edit_flag: {
      type: Boolean
    }
  },
  data() {
    return {}
  },
  methods: {
    edit: function() {
        
    },
    cancel_edit: function() {
      this.$emit('goEdit');
    }
  }
}
</script>

<style>

</style>