<template>
    <div class="project_view_width">
        <h1 class="administration_path">Users</h1>
        <div>
            <div class="edit_team_btns">
                <router-link :to="{ name: 'create_user'}" class="project_form_btn add_member">Add User</router-link>
                <button v-on:click="deleteUsers()" type="button" class="project_form_btn delete_field">Delete</button>
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
            userStore: this.factory.createUserStore(),
            users: [],
            map: new Map()
        }
    },
    methods: {
        getUsers: async function() {
            this.users = await this.store.getUsers();
            for(var user of this.users)
            {
                this.map.set(user.id, -1);
            }
        },
        deleteUsers: async function() {
            for(var [key, val] of this.map)
            { 
                if(val == 1)
                {
                    this.userStore.deleteUser(key);
                }
            }
            this.map.clear();

            await this.getUsers();
        }
    },
    async beforeMount() {
        await this.getUsers();
    }
}
</script>

<style>

</style>