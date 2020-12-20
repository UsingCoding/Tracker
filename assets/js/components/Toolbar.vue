<template>
    <div>
        <div class="toolbar">
            <div class="tools">
                <i class="tool fas fa-rocket"></i>
                <i v-if="this.$route.name != 'create_issue'" v-on:click="openModal()" class="tool fas fa-user-alt"></i>
                <i class="tool right_tool fas fa-beer"></i>
            </div>
            <div class="tools second_tools">
                <i v-if="this.$route.name != 'issues'" v-on:click="goEdit()" class="tool far fa-edit"></i>
                <i class="tool right_tool fas fa-trash"></i>
            </div>
        </div>
        <div v-if="modalFlag" class="modalWindow">
            <div class="modalContent"> 
                <div class="autoassigneeWindow">
                    <span class="assigneeQuestion">Auto assignee not assigned issues?</span>
                    <span v-if="this.$route.name == 'issues'" class="assigneeWarning">
                        Tasks will be automatically assigned in those projects that meet
                        the contidions of the "Auto assignee" function
                    </span>
                    <div class="timeWarnBlock">
                        <span class="timeWarning">It can take several minutes</span>
                        <div class="buttons_div"> 
                            <button class="project_form_btn add_member">Start</button>
                            <button class="project_form_btn remove_member" v-on:click="closeModal()">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        edit_flag: {
            type: Boolean
        }
    },
    data() {
        return {
            modalFlag: false
        }
    },
    methods: {
        delete: function(id) {
            console.log(id);
        },
        goEdit: function() {
            this.$emit('goEdit');
        },
        openModal: function() {
            this.modalFlag = true;
        },
        closeModal: function() {
            this.modalFlag = false;
        }
    }
}
</script>

<style>

.modalWindow
{
    position: fixed;
    z-index: 1;
    overflow: auto;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(59, 59, 59, 0.7);
}

.modalContent
{
    width: 480px;
    margin: 13% auto;
    overflow-y: hidden;
}

.autoassigneeWindow
{
    width: 480px;
    height: 177px;
    background: #ffffff;
    border-radius: 10px;
    position: relative;
}

.assigneeQuestion
{
    font: 18px/22px "Montserrat";
    display: block;
    margin-left: 5%;
    padding-top: 7%;
}

.assigneeWarning
{
    font: 14px/17px "Montserrat";
    width: 284px;
    display: block;
    margin: 2% 0 0 5%;
}

.timeWarnBlock
{
    position: absolute;
    left: 22px;
    top: 138px;
    display: flex;
    justify-content: space-between;
    width: 95%;
}

.timeWarning
{
    font: 14px/26px "Montserrat";
    color: #848484;   
    display: block;
    /* margin: 2% 0 0 5%; */   
}

.buttons_div
{
    width: 41%;
}

</style>