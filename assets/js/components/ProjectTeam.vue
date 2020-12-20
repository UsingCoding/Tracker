<template>
  <div class="project_view_width">
      <h1 class="administration_path">Own Tracker <i class="arrow fas fa-chevron-right"></i> Team</h1>
      <div>
          <div class="edit_team_btns">
              <button v-on:click="addMembers()" class="project_form_btn add_member">Add members</button>
              <button v-on:click="removeMembers()" type="button" class="project_form_btn remove_member">Remove from team</button>
          </div>
          <div class="project_team">
              <div v-for="user in users" class="member_div">
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
            usersListStore: this.factory.createUsersListStore(),
            users: [],
            map: new Map(),

        }
    },
    methods: {
        getUsers: async function() {
            this.users = await this.usersListStore.getUsers();
        },
        addMembers: async function() {
            for(var [key, val] of this.map)
            {
                if(val == 1)
                {
                    console.log(key + " is " + val);
                    // this.memberStore.addMember({
                    //     'user_id': key,
                    //     'project_id': this.$route.params.code
                    // })
                }
            }
        },
        removeMembers: async function() {
            for(var [key, val] of this.map)
            {
                if(val == 1)
                {
                    console.log(key + " is " + val);

                }
            }
        }
    },
    async beforeMount() {
        await this.getUsers();
        for(var user of this.users)
        {
            this.map.set(user.id, -1);
        }
    }
}
</script>

<style>

</style>