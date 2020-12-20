<template>
    <div>
        <div class="project_view_width">
            <span class="projects_count">Projects {{projectsList.length}}</span>
            <router-link v-for="pro in projectsList" :to="{name: 'project_info', params: { code: pro.project_id }}" class="projects_list_el" exact>{{pro.name}}</router-link>
            <!-- <router-link :to="{name: 'project_info', params: { code: 1 }}" class="projects_list_el" exact>{{project_title}}</router-link> -->
        </div>
    </div>
</template>

<script>

export default {
    props: ['factory'],
    data() {
        return {
            project_title: 'Own Tracker',
            store: this.factory.createProjectsListStore(),
            projectsList: []
        }
    },
    methods: {
        getProjects: async function() {
            this.projectsList = await this.store.getProjectsList();
        }
    },
    async beforeMount() {
        await this.getProjects();
    }
}
</script>

<style>

a
{
    text-decoration: none;
    color: #000000;
}

</style>