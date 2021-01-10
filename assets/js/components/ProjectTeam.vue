<template>
  <div v-if="!loading" class="project_view_width">
      <h1 class="administration_path">{{team.project_name}} <i class="arrow fas fa-chevron-right"></i> Team</h1>
      <div>
          <div class="edit_team_btns">
              <button v-on:click="addFlag = true" class="project_form_btn add_member">Add members</button>
              <button v-on:click="removeMembers()" type="button" class="project_form_btn remove_member">Remove from team</button>
          </div>
          <div class="project_team">
                <form v-if="addFlag" class="edited_field">
                    <span class="new_member">New Member</span>
                    <div class="name_block">
                        <label class="field_name" for="username">Username</label>
                        <select v-model="userId" class="type_options" name="username" id="username">
                            <option v-for="user in usersToAdd" :value="user.user_id">{{user.username}}</option>
                        </select>
                    </div>
                
                    <div class="field_buttons"> 
                        <button v-on:click="addMember()" type="button" class="project_form_btn add_member">Save</button>
                        <button v-on:click="cancel()" type="button" class="project_form_btn remove_member">Cancel</button>
                    </div>
                </form>
              
                <div v-for="user in team.team_members" class="member_div">
                    <input v-if="user.user_id != team.logged_user_id && !user.is_owner " v-on:click="map.set(user.team_member_id, map.get(user.team_member_id)*-1)" class="member_checkbox" type="checkbox"/> 
                    <div v-else class="member_checkbox unclickable_checkbox"></div>
                    <span class="team_member">{{user.username}}</span>
                    <span v-if="user.is_owner" class="owner_tag">OWNER</span>
                    <span v-if="user.user_id == team.logged_user_id" class="owner_tag">YOU</span>
                </div>
          </div>
      </div>
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
            memberStore: this.factory.createMemberStore(),
            membersListStore: this.factory.createMembersListStore(),
            usersListStore: this.factory.createUsersListStore(),
            usersToAdd: [],
            addFlag: false,
            userId: '',
            team: [],
            map: new Map(),
        }
    },
    methods: {
        getMembers: async function() {
            this.team = await this.membersListStore.getMembersList(this.$route.params.code);
            this.usersToAdd = await this.membersListStore.getUsersToAddList(this.$route.params.code);
            if(this.team && this.usersToAdd){
                for(var member of this.team.team_members)
                {
                    this.map.set(member.team_member_id, -1);
                }
            }
        },
        addMember: async function() {
            if(!this.validate())
            {
                let response = await this.memberStore.addMember({
                    'user_id': this.userId,
                    'project_id': this.$route.params.code
                })
                if(response.ok)
                   await this.getMembers();
                   this.cancel();
            }
        },
        removeMembers: async function() {
            for(var [key, val] of this.map)
            {
                if(val == 1)
                {
                    await this.memberStore.removeMember(key);
                }
            }
            await this.getMembers();
        },
        cancel: function() {
            this.addFlag = false;
            this.userId = '';
        },
        showError: function(container) {
            container.style ['border-color'] = '#ff0000';
	        container.setAttribute('onclick', 'this.style=""');
        },
        validate: function() {
            var error = false;
            var username = document.getElementById('username');

            if(!this.userId)
            {
                error = true;
                this.showError(username);
            }

            return error;
        }
    },
    async beforeMount() {
        this.$parent.loading = true;
        await this.getMembers();
        setTimeout(() => {
            this.$parent.loading = false;
        }, 500);
    }
}
</script>

<style>

.new_member
{
    font: 18px/22px "Montserrat";
    color: #3b3b3b;
    margin-left: 1%;
    padding-top: 1%;
    display: block;
}

.owner_tag
{
    font: 12px/15px "Montserrat";
    color: #5c5c5c;
    margin-left: 7%;
}

.type_options
{
    width: 178px;
}

</style>