<template>
    <div>
        <div v-if="!edit_flag" class="issue_view">
            <div class="issue_view_info">
                <div class="top_issue_view">
                    <span class="project_title">{{this.$route.params.code}}</span>
                    <span class="created_date">Created {{this.issueInfo.updated_at}}</span>
                </div>
                <div class="issue_view_body">
                    <span class="issue_view_title">{{new_title}}</span>
                    <p class="issue_view_description">{{new_description}}</p>
                    <hr class="issue_border"/>
                    <div class="comments">
                      <div v-on:dblclick="showEditComment(comment)" class="comment" v-for="comment in issueInfo.comments" >

                        <div class="user_img">
                          <!-- <div class="user_img_test"></div> -->
                          <img :src="comment.avatar_url" alt="sorry(">
                        </div>
                    
                        <div class="comment_content width_100">
                          <span class="comment_owner">{{comment.username}} commented 32.12.2020</span>
                          <p v-if="commentId != comment.id" class="comment_text">{{comment.content}}</p>

                          <div class="width_100" v-if="commentId == comment.id">
                            <textarea v-model="commentContent" placeholder="Comment Content" class="new_issue_description comment_input width_100"></textarea>
                            <div class="comment_controls">
                                <div class="comment_btns">
                                  <span v-on:click="editComment()" class="project_form_btn create_project_btn add_comment_btn">Save</span>
                                  <span v-on:click="closeEditComment()" class="project_form_btn cancel_btn add_comment_btn">Cancel</span>
                                </div>
                                <div>                                
                                  <span v-on:click="deleteComment()" class="project_form_btn create_project_btn delete_field add_comment_btn">Delete</span>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="comment add_comment">
                        <textarea v-model="newCommentContent" placeholder="Comment Content" class="new_issue_description comment_input width_100"></textarea>
                        <div class="">
                          <span v-on:click="addComment()" class="project_form_btn create_project_btn add_comment_btn">Add comment</span>
                        </div>
                      </div>

                    </div>
                </div>

            </div>


            <div class="tags_rectangle view_tags">
                <div class="tags">
                  <table class="tags_table">
                    <tr class="tag_row">
                      <td>Project</td>
                      <td class="tag_value tag_value_view">{{project.name}}</td>
                    </tr>
                    <tr class="tag_row">
                      <td>Assignee</td>
                      <td v-if="assignee.id" class="tag_value tag_value_view">{{assignee.username}}</td>
                      <td v-if="!assignee.id" class="tag_value tag_value_view">Unassigned</td>
                    </tr>
                    <tr v-for="(val, key) in issueInfo.fields" class="tag_row">
                      <td>{{key}}</td>
                      <td v-if="val != null && val != 'null' && val != ''" class="tag_value tag_value_view">{{val}}</td>
                      <td v-else class="tag_value tag_value_view">Empty value</td>
                    </tr>
                  </table>
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

          <div class="tags_rectangle">
            <div class="tags">
              <table class="tags_table">
                <tr class="tag_row">
                  <td><label class="tag" for="project">Project</label></td>
                  <td>
                    <select v-model="project.id" class="tag_value" name="project" id="project">
                      <option v-for="proj in projects" :value="proj.project_id">{{proj.name}}</option>
                    </select>
                  </td>
                </tr>

                <tr class="tag_row">
                  <td><label class="tag" for="assignee">Assignee</label></td>
                  <td>
                    <select v-model="assignee.id" class="tag_value" name="assignee" id="assignee">
                      <option value="null">Unassigned</option>
                      <option v-for="member in team" :value="member.user_id">{{member.username}}</option>
                    </select>
                  </td>
                </tr>
                            
                <tr v-for="field in fields" class="tag_row">
                  <td><label class="tag" :for="field.id">{{field.name}}</label></td>
                  <td>
                    <input class="field_input" type="text" :id="field.id">
                  </td>
                </tr>

              </table>
            </div>
          </div>
        </form>
    </div>
</template>

<script>

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
      new_title: '',
      assignee: {},
      project: { id: 1 },
      projects: [],
      team: [],
      fields: [],
      newCommentContent: '',
      commentContent: '',
      createCommentStore: this.factory.createCreateCommentStore(),
      commentStore: this.factory.createCommentStore(),
      commentId: ''
    }
  },
  methods: {
    edit_issue: async function() {
      if(this.assignee.id == 'null')
        this.assignee.id = null;
      console.log(this.assignee.id);
      let result = await this.store.updateIssue({
        "issue_id": this.issueInfo.issue_id,
        "title": this.new_title,
        "description": this.new_description,
        "fields": this.getFieldsValues()
      });
       
      if(result.success == 1)
      {
        await this.getIssueInfo();
        this.cancel_edit();
      }
    },
    cancel_edit: function() {
      this.$emit('cancel_edit');
    },
    getIssueInfo: async function() {
      this.issueInfo = await this.store.getIssueInformation(this.$route.params.code);  
      let projectsStore = this.factory.createProjectsListStore();
      this.projects = await projectsStore.getProjectsList();
      this.new_title = this.issueInfo.name;
      this.new_description = this.issueInfo.description;
      if(this.issueInfo.user)
      {
        this.assignee = this.issueInfo.user;
      }
      else
        this.assignee.id = null;
      this.project = this.issueInfo.project;
    },
    delete_issue: async function() {
      let result = await this.store.deleteIssue(this.issueInfo.issue_id);
      if(result.ok)
        this.$router.push({ name: 'issues' })
    },
    getFieldsValues: function() {
      var fieldsValues = {};
      fieldsValues.user_id = this.assignee.id;
      fieldsValues.project_id = this.project.id;

      for(var field of this.fields)
      {
        var elem = document.getElementById(field.id);
        var fieldName = field.name;
        fieldsValues[field.name] = elem.value;
      }

      return fieldsValues;
    },
    addComment: async function() {
      if(this.newCommentContent)
      {
        let response = await this.createCommentStore.addComment({
          'user_id': null,
          'issue_id': this.issueInfo.issue_id,
          'content': this.newCommentContent
        });
        this.newCommentContent = '';
        await this.getIssueInfo();
      }
    },
    showEditComment: function(comment) {
      this.commentId = comment.id;
      this.commentContent = comment.content;
    },
    closeEditComment: function() {
      this.commentId = '';
      this.commentContent = '';
    },
    editComment: async function() {
      if(this.commentContent)
      {
        let response = await this.commentStore.editComment({
          'comment_id': this.commentId,
          'content': this.commentContent
        })
        if(response.ok)
          await this.getIssueInfo();
        this.closeEditComment();
      }
    },
    deleteComment: async function() {
      let response = await this.commentStore.deleteComment(this.commentId)
      if(response.ok)
        await this.getIssueInfo();
    }
  },
  computed: {
    teamC: async function() {
      var teamStore = this.factory.createMembersListStore();
      var response = await teamStore.getMembersList(this.project.id);
      if(response)
        this.team = response.team_members;
      return this.team;
    },
    fieldsC: async function() {
      var fieldsStore = this.factory.createFieldsListStore();
      var response = await fieldsStore.getFields(this.project.id);
      if(response)
        this.fields = response.fields;
      return this.fields;
    }
  },
  async beforeMount() {
    await this.getIssueInfo();
  },
  async beforeUpdate() {
    this.teamC;
    this.fieldsC;
  }
}
</script>

<style>

.comment_input
{
  height: 110px;
}

.add_comment
{
  flex-direction: column;
}

.comment_controls
{
  display: flex;
  justify-content: space-between;
}

.comment_btns
{
  width: 35.5%;
}

.add_comment_btn
{
  padding: 2px 15px;
}

.delete_comment
{
  margin-left: 80%;
}

.comment
{
  cursor: pointer;
}

.tag_value_view
{
  cursor: auto;
}

</style>