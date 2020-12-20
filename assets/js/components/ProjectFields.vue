<template>
  <div class="project_view_width">
        <h1 class="administration_path">Own Tracker <i class="fas fa-chevron-right arrow"></i> Fields</h1>
        <div>
          <div class="edit_team_btns">
                <button v-on:click="addFlag = true" type="button" class="project_form_btn add_member">Add field</button>
                <button v-on:click="deleteFields()" type="button" class="project_form_btn delete_field">Delete</button>
          </div>
          <div class="project_team">
                <form v-if="addFlag" class="edited_field">
                    <div class="name_block">
                        <label class="field_name">Name</label>
                        <input v-model="name" class="name_input" type="text"/>
                    </div>
                    
                    <div class="field_type">
                        <label for="type">Type</label>
                        <select v-model="type" class="type_options" name="type" id="type">
                            <option value="0">Time interval</option>
                            <option value="1">String</option>
                        </select>
                    </div>

                    <div class="field_buttons"> 
                        <button v-on:click="addField()" type="button" class="project_form_btn add_member">Save</button>
                        <button v-on:click="cancel()" type="button" class="project_form_btn remove_member">Cancel</button>
                    </div>
                </form>

                <div v-for="field in projectFields" class="member_div">
                    <div v-if="!edit">
                        <input v-on:click="map.set(field.id, map.get(field.id)*-1)" class="member_checkbox" type="checkbox" :id="field.fieldId"/> 
                        <span v-on:click="openEdit(field)" class="team_member">{{field.name}}</span>
                    </div>

                    <form v-if="edit" class="edited_field">
                        <div class="name_block">
                            <label class="field_name">Name</label>
                            <input v-model="name" class="name_input" type="text"/>
                        </div>
                    
                        <div class="field_type">
                            <label for="type">Type</label>
                            <select v-model="type" class="type_options" name="type" id="type">
                                <option value="0">Time interval</option>
                                <option value="1">String</option>
                            </select>
                        </div>

                        <div class="field_buttons"> 
                            <button v-on:click="editField()" type="button" class="project_form_btn add_member">Save</button>
                            <button v-on:click="cancelEdit()" type="button" class="project_form_btn remove_member">Cancel</button>
                        </div>

                    </form>

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
            projectFields: [],
            fieldListStore: this.factory.createFieldsListStore(),
            createFieldStore: this.factory.createCreateFieldStore(),
            fieldStore: this.factory.createFieldStore(),
            addFlag: false,
            edit: false,
            name: '',
            type: '',
            map: new Map()
        }
    },
    methods: {
        addField: async function() {
            let response = await this.createFieldStore.addField({
                'name': this.name,
                'type': this.type,
                'project_id': this.$route.params.code 
            });

            if(response)
            {
                this.projectFields.push({ 
                    'name': this.name,
                    'type': this.type,
                    'id': response.issue_field_id
                });
                this.map.set(response.issue_field_id, -1);
            }
            this.cancel();
        },
        cancel: function() {
            this.name = '';
            this.type = '';
            this.addFlag = false;
        },
        editField: async function(fieldId) {
            // let response = await this.fieldStore.editField({
            //     'name': this.name,
            //     'type': this.type,
            //     'issue_field_id': fieldId
            // });

        },
        openEdit: function (field) {
            this.edit = true;
            this.name = field.name;
            this.type = field.type;
        },
        cancelEdit: function() {
            this.name = '';
            this.type = '';
            this.edit = false;
        },
        deleteFields: async function() {
            for(var [key, val] of this.map)
            { 
                if(val == 1)
                {
                    this.fieldStore.deleteField(key);
                    this.map.delete(key);
                }
            }
        },
        getFieldsList: async function() {
            this.projectFields = await this.fieldListStore.getFields(this.$route.params.code);
        }
    },
    async beforeMount() {
        await this.getFieldsList();
        for(var field of this.projectFields)
        {
            this.map.set(field.id, -1);
        }
    }
}
</script>

<style>

.team_member:hover
{
    cursor: pointer;
    text-decoration: underline;
    color: #ff318c;
}

</style>