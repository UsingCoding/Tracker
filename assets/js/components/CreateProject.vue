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
                    <span class="description_label">Will be in uppercase</span>
                </div>
            </div>

            <div class="create_project_label description_project">
                <label for="description">Description</label>
                <textarea v-model="new_project_description" class="new_project_description" name="new_project_description" id="description"></textarea>
            </div>
            <div>
                <button v-on:click="create_project()" type="button" class="project_form_btn create_project_btn">Save</button>
                <button v-on:click="cancel()" type="button" class="project_form_btn cancel_btn">Cancel</button>
            </div>
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
            if(!this.validate()){
                if(this.new_project_description == '')
                    this.new_project_description = null;
                let response =  await this.store.createProject({
                    "name": this.new_project_title,
                    "nameId": this.new_project_id,
                    "description": this.new_project_description 
                });

                if(response)
                    this.$router.push({ name: "projects_list" });
                else   
                    this.$emit('error');
            }
        },
        cancel: function() {
            this.$router.push({ name: "projects_list" });
        },
        showError: function(container) {
            container.style ['border-color'] = '#ff0000';
	        container.setAttribute('onclick', 'this.style=""');
        },
        validate: function() {
            var error = false;
            var name = document.getElementById('name');
            var id = document.getElementById('id');
            var description = document.getElementById('description');

            if(!this.new_project_title)
            {
                error = true;
                this.showError(name);
            }

            if(!this.new_project_id)
            {
                error = true;
                this.showError(id);
            }

            return error;
        }
    }
}
</script>

<style>

</style>