<template>
    <div>
        <header class="">
            <div>
                <div class="navbar">
                    <router-link to="/issues" class="menu_link" exact >Issues</router-link>
                    <router-link to="/" class="menu_link" exact >Projects</router-link>
                    <router-link to="/create_issue" class="menu_link" exact >New issue</router-link>
                    <!-- <router-link to="/" class="menu_link" exact >New project</router-link> -->
                </div>
            </div>
            <div class="user_menu">
                <span class="menu_link settings_margin" >Settings</span>
            </div>
        </header>
        <!-- <div class="toolbar">
            <div class="tools">
                <i class="tool fas fa-rocket"></i>
                <i class="tool fas fa-mobile"></i>
                <i class="tool fas fa-user-alt"></i>
                <i class="tool right_tool fas fa-beer"></i>
            </div>

            <div class="tools second_tools">
                <i class="tool far fa-edit"></i>
                <i class="tool right_tool fas fa-trash"></i>
            </div>
        </div> -->
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
