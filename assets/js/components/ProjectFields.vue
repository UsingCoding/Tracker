<template>
    <div v-if="!loading" class="project_view_width">
        <h1 class="administration_path">{{projectTitle}} <i class="fas fa-chevron-right arrow"></i> Fields</h1>
        <div>
            <span class="autoassigneeWarning" >
                Auto assignee feature will be available if project exist fields
                with names and types estimation - Time interval, difficulty - String
            </span>
            <div class="edit_team_btns">
                <button v-on:click="addFlag = true" type="button" class="project_form_btn add_member">Add field</button>
                <button v-on:click="deleteFields()" type="button" class="project_form_btn delete_field">Delete</button>
            </div>
            <div class="project_team">
                <form v-if="addFlag" class="edited_field">
                    <div class="name_block">
                        <label class="field_name" for="name">Name</label>
                        <input v-model="name" class="name_input" type="text" id="name"/>
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
                    <div v-if="field_id != field.id">
                        <input v-on:click="map.set(field.id, map.get(field.id)*-1)" class="member_checkbox" type="checkbox" :id="field.fieldId"/> 
                        <span v-on:click="openEdit(field)" class="team_member">{{field.name}}</span>
                    </div>

                    <form v-if="field_id == field.id" class="edited_field">
                        <div class="name_block">
                            <label class="field_name" for="field_name">Name</label>
                            <input v-model="name" class="name_input" type="text" id="field_name"/>
                        </div>
                    
                        <div class="field_type">
                            <label for="field_type">Type</label>
                            <select v-model="type" class="type_options" name="type" id="field_type">
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
                <span v-if="projectFields.length == 0" class="no_fields">There is no fields...</span>
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
            projectTitle: '',
            projectFields: [],
            fieldListStore: this.factory.createFieldsListStore(),
            createFieldStore: this.factory.createCreateFieldStore(),
            fieldStore: this.factory.createFieldStore(),
            addFlag: false,
            field_id: '',
            name: '',
            type: '',
            map: new Map()
        }
    },
    methods: {
        addField: async function() {
            if(!this.validateAdd())
            {
                let response = await this.createFieldStore.addField({
                    'name': this.name,
                    'type': this.type,
                    'project_id': this.$route.params.code 
                });

                if(response)
                {
                    await this.getFieldsList();
                    this.cancel();
                }
                else
                    this.$emit('error');
            }
        },
        cancel: function() {
            this.name = '';
            this.type = '';
            this.addFlag = false;
        },
        editField: async function() {
            if(!this.validateEdit())
            {
                let response = await this.fieldStore.editField({
                    'name': this.name,
                    'type': this.type,
                    'issue_field_id': this.field_id
                });
            
                if(response.ok)
                    await this.getFieldsList();

                this.cancelEdit();
            }
        },
        openEdit: function (field) {
            this.field_id = field.id;
            this.name = field.name;
            this.type = field.type;
        },
        cancelEdit: function() {
            this.name = '';
            this.type = '';
            this.field_id = '';
        },
        deleteFields: async function() {
            for(var [key, val] of this.map)
            { 
                if(val == 1)
                {
                    var result = await this.fieldStore.deleteField(key);  
                }
            }
            this.map.clear();

            await this.getFieldsList();
        },
        getFieldsList: async function() {
            var response = await this.fieldListStore.getFields(this.$route.params.code);
            if(response)
            {
                this.projectTitle = response.project_name;
                this.projectFields = response.fields
                for(var field of this.projectFields)
                {
                    this.map.set(field.id, -1);
                }
            }
            else
                this.$emit('error');
        },
        showError: function(container) {
            container.style ['border-color'] = '#ff0000';
	        container.setAttribute('onclick', 'this.style=""');
        },
        validateAdd: function() {
            var error = false;
            var name = document.getElementById('name');
            var type = document.getElementById('type');

            if(!this.name)
            {
                error = true;
                this.showError(name);
            }

            if(!this.type)
            {
                error = true;
                this.showError(type);
            }

            return error;
        },
        validateEdit: function() {
            var error = false;
            var name = document.getElementById('field_name');
            var type = document.getElementById('field_type');

            if(!this.name)
            {
                error = true;
                this.showError(name);
            }

            if(!this.type)
            {
                error = true;
                this.showError(type);
            }

            return error;
        }
    },
    async beforeMount() {
        this.$parent.loading = true;
        await this.getFieldsList();
        setTimeout(() => {
            this.$parent.loading = false;
        }, 500);
    }
}
</script>

<style>

.autoassigneeWarning
{
    font: 14px/17px "Montserrat";
    color: #6f6f6f;
    display: block;
    width: 481px;
    margin-top: 1.5%;
}

.team_member:hover
{
    cursor: pointer;
    text-decoration: underline;
    color: #ff318c;
}

.no_fields
{
    font: 36px/44px "Montserrat";
}

</style>