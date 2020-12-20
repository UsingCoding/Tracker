<template>
    <div class="project_view_width">
        <h1 class="administration_path">Create Project</h1>
        <form class="create_project">
            <div class="create_project_label">
                <label for="name">Name</label>
                <input v-model="new_project_title" class="project_input project_input_margin" type="text" id="name">
            </div>

            <div class="create_project_label">
                <label for="id">ID</label>
                <div class="has_description">
                    <input v-model="new_project_id" class="project_input" type="text" id="id">
                    <span class="description_label">Must be in uppercase</span>
                </div>
            </div>

            <div class="create_project_label description_project">
                <label for="description">Description</label>
                <textarea v-model="new_project_description" class="new_project_description" name="new_project_description" id="description"></textarea>
            </div>
            <button v-on:click="create_project()" type="button" class="project_form_btn create_project_btn">Save</button>
            <button v-on:click="cancel()" type="button" class="project_form_btn cancel_btn">Cancel</button>
        </form> 
    </div>
</template>

<script>
export default {
    props: ['factory'],
    data() {
        return {
            new_project_title: '',
            new_project_id: '',
            new_project_description: '',
            store: this.factory.createCreateProjectStore()
        }
    },
    methods: {
         create_project: async function() {
            let response =  await this.store.createProject({
                "name": this.new_project_title,
                "nameId": this.new_project_id,
                "description": this.new_project_description 
            });

            // this.$router.push({ name: "project_info" })
            this.$router.push({ name: "projects_list" });

        },
        cancel: function() {
            this.$router.push({ name: "projects_list" });
        }

    }
}
</script>

<style>

</style>