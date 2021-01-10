<template>
    <div v-if="!loading">
        <div class="project_view_width">
            <span class="projects_count">Projects {{projectsList.length}}</span>
            <router-link v-for="pro in projectsList" :to="{ name: 'project_info', params: { code: pro.project_id }}" class="projects_list_el" exact>{{pro.name}}</router-link>
            <div v-if="projectsList.length == 0">
                <span class="no_projects">There is no projects</span>
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
            store: this.factory.createProjectsListStore(),
            projectsList: []
        }
    },
    methods: {
        getProjects: async function() {
            this.$parent.loading = true;
            this.projectsList = await this.store.getProjectsList();
            
            setTimeout(() => {
                if(!this.projectsList || this.projectsList.hasOwnProperty('error'))
                    this.$emit('error');
                this.$parent.loading = false;
            }, 500);
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

.no_projects
{
    font: 36px/44px "Montserrat";
}

</style>