<template>
    <div class="project_view_width">
        <h1 class="administration_path">Users</h1>
        <div>
            <div class="edit_team_btns">
                <router-link :to="{ name: 'create_user'}" class="project_form_btn add_member">Add User</router-link>
                <button v-on:click="deleteUsers()" type="button" class="project_form_btn delete_field">Delete</button>
            </div>
            <loader v-if="loading"></loader>
            <div v-else-if="!loading" class="project_team">
                <div v-for="user in users" class="member_div">
                    <input v-if="user.id != logged_user && user.id != owner_id" v-on:click="map.set(user.id, map.get(user.id)*-1)" class="member_checkbox" type="checkbox"/> 
                    <div v-else class="member_checkbox unclickable_checkbox"></div>
                    <router-link :to="{ name: 'user_info', params: {code: user.id}}" class="team_member">{{user.username}}</router-link>
                    <span v-if="user.id == owner_id" class="owner_tag">FIRST ARRIVED</span>
                    <span v-if="user.id == logged_user" class="owner_tag">YOU</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import loader from "../components/Loader";

export default {
    props: [
        'factory'  
    ],
    data() {
        return {
            store: this.factory.createUsersListStore(),
            userStore: this.factory.createUserStore(),
            users: [],
            logged_user: '',
            owner_id: '',
            map: new Map(),
            loading: true
        }
    },
    components: {
        'loader': loader
    },
    methods: {
        getUsers: async function() {
            this.loading = true;
            var response = await this.store.getUsers();
            if(response)
            {
                setTimeout(() => {
                    this.users = response.users;
                    this.logged_user = response.logged_user_id;
                    this.owner_id = response.owner_id;
                    for(var user of this.users)
                    {
                        this.map.set(user.id, -1);
                    }
                    this.loading = false;
                }, 500);
            }
        },
        deleteUsers: async function() {
            for(var [key, val] of this.map)
            { 
                if(val == 1)
                {
                    await this.userStore.deleteUser(key);
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

.add_member
{
    padding: 2px 15px;
}

</style>