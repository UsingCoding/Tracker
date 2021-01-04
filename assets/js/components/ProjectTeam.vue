<template>
  <div class="project_view_width">
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
                        <label class="field_name" id="username">Username</label>
                        <select v-model="userId" class="type_options" name="username" id="username">
                            <option v-for="user in team.team_members" :value="user.id">{{user.username}}</option>
                        </select>
                    </div>
                
                    <div class="field_buttons"> 
                        <button v-on:click="addMember()" type="button" class="project_form_btn add_member">Save</button>
                        <button v-on:click="cancel()" type="button" class="project_form_btn remove_member">Cancel</button>
                    </div>
                </form>
              
                <div v-for="user in team.team_members" class="member_div">
                    <input v-on:click="map.set(user.id, map.get(user.id)*-1)" class="member_checkbox" type="checkbox"/> 
                    <span class="team_member">{{user.username}}</span>
                </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    props: ['factory'],
    data() {
        return {
            memberStore: this.factory.createMemberStore(),
            membersListStore: this.factory.createMembersListStore(),
            addFlag: false,
            userId: '',
            team: [],
            map: new Map(),
        }
    },
    methods: {
        getMembers: async function() {
            this.team = await this.membersListStore.getMembersList(this.$route.params.code);
        },
        addMember: async function() {
            this.memberStore.addMember({
                'user_id': this.userId,
                'project_id': this.$route.params.code
            })
            await this.getMembers();
        },
        removeMembers: async function() {
            for(var [key, val] of this.map)
            {
                if(val == 1)
                {
                    console.log(key + " is " + val);

                }
            }
            await this.getMembers();
        },
        cancel: function() {
            this.addFlag = false;
            this.userId = '';
        }
    },
    async beforeMount() {
        await this.getMembers();
        for(var member of this.team.team_members)
        {
            this.map.set(member.id, -1);
        }
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

.type_options
{
    width: 178px;
}

</style>