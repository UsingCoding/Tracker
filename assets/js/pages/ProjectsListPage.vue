<template>
    <div>
        <app-header></app-header>
        <projects-list v-bind:factory="factory"></projects-list>
    </div>
</template>

<script>
import header from "../components/Header";
import projects_list from "../components/ProjectsList";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'projects-list': projects_list
    },
    methods: {

    }
}
</script>

<style>

</style>