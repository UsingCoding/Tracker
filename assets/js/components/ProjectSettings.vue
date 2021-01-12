<template>
  <div v-if="!loading" class="project_view_width">
      <h1 class="administration_path">{{projectInfo.name}} <i class="arrow fas fa-chevron-right"></i> Settings</h1>
      <form class="create_project">
            <div class="create_project_label">
                <label for="name">Name</label>
                <input v-model="new_project_title" class="project_input project_input_margin" type="text" id="name">
            </div>

            <div class="create_project_label">
                <label for="id">ID</label>
                <div class="has_description">
                    <input v-model="new_project_id" class="project_input" type="text" id="id">
                    <span class="description_label">Will be in uppercase</span>
                </div>
            </div>

            <div class="create_project_label">
                <label for="owner">Owner</label>
                <select v-model="project_owner" class="owner_input project_input" type="text" id="owner">
                    <option v-for="member in team" :value="member.user_id">{{member.username}}</option>
                </select>        
            </div>
            
            <div class="create_project_label description_project">
                <label for="description">Description</label>
                <textarea v-model="new_project_description" class="new_project_description" name="new_project_description" id="description"></textarea>
            </div>
            <div>
                <button v-on:click="editProject()" type="button" class="project_form_btn create_project_btn">Save</button>
                <button v-on:click="cancel()" type="button" class="project_form_btn cancel_btn">Cancel</button>
            </div>
        </form>
  </div>
</template>

<script>

export default {
    props: [
        'factory',
        'loading'    
    ],
    data() {
        return {
            store: this.factory.createProjectStore(),
            new_project_title: '',
            new_project_description: '',
            new_project_id: '',
            project_owner: '',
            projectInfo: {},
            team: []
        }
    },
    methods: {
        getProjectInfo: async function() {
            this.projectInfo = await this.store.getProjectInfo(this.$route.params.code);
        },
        getMembers: async function() {
            var membersListStore = this.factory.createMembersListStore();
            var result = await membersListStore.getMembersList(this.$route.params.code);
            this.team = result.team_members;
        },
        editProject: async function() {
            if(!this.validate()){
                let result = await this.store.updateProject({
                    'project_id': this.$route.params.code,
                    'name': this.new_project_title,
                    'new_owner_id': this.project_owner,
                    'description': this.new_project_description 
                });
                if(result.ok)
                    this.$router.push({ name: 'project_info', params: { code: this.$route.params.code } })
            }
        },
        cancel: function() {
            this.$router.push({ name: 'project_info', params: { code: this.$route.params.code } });
        },
        showError: function(container) {
            container.style ['border-color'] = '#ff0000';
	        container.setAttribute('onclick', 'this.style=""');
        },
        validate: function() {
            var error = false;
            var name = document.getElementById('name');
            var id = document.getElementById('id');
            var description = document.getElementById('description');
            var owner = document.getElementById('owner');

            if(!this.new_project_title)
            {
                error = true;
                this.showError(name);
            }

            if(!this.new_project_id)
            {
                error = true;
                this.showError(id);
            }

            if(!this.project_owner)
            {
                error = true;
                this.showError(owner);
            }

            if(!this.new_project_description)
            {
                error = true;
                this.showError(description);
            }

            return error;
        }
    },
    async beforeMount() {
        this.$parent.loading = true;
        await this.getProjectInfo();
        await this.getMembers();
        setTimeout(() => {
            this.new_project_title = this.projectInfo.name;
            this.new_project_id = this.projectInfo.nameId;
            this.new_project_description = this.projectInfo.description;
            this.project_owner = this.projectInfo.owner_id;
            this.$parent.loading = false;
        }, 500);
    }
}
</script>

<style>

</style>