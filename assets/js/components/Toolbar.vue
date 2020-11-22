<template>
    <div class="toolbar">
        <div class="tools">
            <i class="tool fas fa-rocket"></i>
            <!-- <i class="tool fas fa-mobile"></i> -->
            <i class="tool fas fa-user-alt"></i>
            <i class="tool right_tool fas fa-beer"></i>
        </div>
        <div class="tools second_tools">
            <i v-on:click="goEdit()" class="tool far fa-edit"></i>
            <i class="tool right_tool fas fa-trash"></i>
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
        return {}
    },
    methods: {
        delete: function(id) {
            console.log(id);
        },
        goEdit: function() {
            this.$emit('changeEdit');
        }
    }
}
</script>

<style>

</style>