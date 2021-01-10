<template>
    <div>
        <header class="">
            <div>
                <div class="navbar">
                    <router-link to="/issues" class="menu_link" exact >Issues</router-link>
                    <router-link to="/projects" class="menu_link" exact >Projects</router-link>
                    <router-link to="/users" class="menu_link" exact >Users</router-link>
                    <router-link to="/create-issue" class="menu_link" exact >New issue</router-link>
                    <router-link v-if="this.$route.name == 'projects_list'" to="/create-project" class="menu_link" exact >Create Project</router-link>
                </div>
            </div>
            <div class="user_menu">
                <a href="/logout" class="menu_link settings_margin" >Log Out</a>
            </div>
        </header>
    </div>
</template>

<script>

export default {
    data() {
        return {}
    },
    methods: {

    }
}
</script>

<style scoped>

.router-link-active{
    text-decoration: none;
    color: #000000;
}

</style>
