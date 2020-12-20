<template>
    <div class="project_view_width">
        <h1 class="administration_path">Users</h1>
        <div>
            <div class="edit_team_btns">
              <router-link :to="{ name: 'create_user'}" class="project_form_btn add_member">Add User</router-link>
          </div>
            <div class="project_team">
                <div v-for="user in users" class="member_div">
                    <input v-on:click="map.set(user.id, map.get(user.id)*-1)" class="member_checkbox" type="checkbox"/> 
                    <router-link :to="{ name: 'user_info', params: {code: user.id}}" class="team_member">{{user.username}}</router-link>
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
            store: this.factory.createUsersListStore(),
            users: []
        }
    },
    methods: {
        getUsers: async function() {
            this.users = await this.store.getUsers();
        }
    },
    async beforeMount() {
        await this.getUsers();
    }
}
</script>

<style>

</style>