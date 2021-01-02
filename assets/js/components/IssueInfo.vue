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
                      <div class="comment">

                        <div class="user_img">
                          <div class="user_img_test"></div>
                        </div>

                        <div class="comment_content">
                          <span class="comment_owner">root commented 32.12.2020</span>
                          <p class="comment_text">Test Text in 2021</p>
                        </div>
                      </div>
                    </div>
                </div>

            </div>


            <div class="tags_rectangle view_tags">
                <div class="tags">
                  <table class="tags_table">
                    <tr v-for="(val, key) in issueInfo.fields" class="tag_row">
                      <td>{{store.getFieldName(key)}}</td>
                      <td class="tag_value">{{val}}</td>
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
                    <select v-model="project" class="tag_value" name="project" id="project">
                      <option v-for="proj in projects" :value="proj.name">{{proj.name}}</option>
                    </select>
                  </td>
                </tr>

                <tr class="tag_row">
                  <td><label class="tag" for="assignee">Assignee</label></td>
                  <td>
                    <select v-model="assignee" class="tag_value" name="assignee" id="assignee">
                      <option value="0">Unassigned</option>
                      <!-- <option v-for="member in team" :value="member.id">{{member.username}}</option> -->
                    </select>
                  </td>
                </tr>
                            
                <!-- <tr v-for="field in fields" class="tag_row">
                        <td><label class="tag" for="assignee">{{field.id}}</label></td>
                        <td>
                          <input class="field_input" type="text" name="">
                        </td>
                      </tr> -->

              </table>
            </div>
          </div>
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
      new_title: '',
      assignee: '',
      project: '',
      projects: []
    }
  },
  methods: {
    edit_issue: async function() {
        let result = await this.store.updateIssue({
          "issue_id": this.issueInfo.issue_id,
          "title": this.new_title,
          "description": this.new_description,
          "fields": {
            "user_id": user_id,
            "project_id": project_id
          }
        });
        if(result.ok)
          this.cancel_edit();
    },
    cancel_edit: function() {
      this.$emit('cancel_edit');
    },
    getIssueInfo: async function() {
      this.issueInfo = await this.store.getIssueInformation(this.$route.params.code);  
    },
    delete_issue: async function() {
      let result = await this.store.deleteIssue(this.issueInfo.issue_id);
      if(result.ok)
        this.$router.push({ name: 'issues' })
    }
  },
  async beforeMount() {
    await this.getIssueInfo();
    let projectsStore = this.factory.createProjectsListStore();
    this.projects = await projectsStore.getProjectsList();
    this.new_title = this.issueInfo.name;
    this.new_description = this.issueInfo.description;
    this.assignee = this.issueInfo.fields.assignee;
    this.project = this.issueInfo.fields.project_name;
  }
}
</script>

<style>

</style>