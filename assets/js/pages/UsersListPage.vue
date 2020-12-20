<template>
    <div>
        <app-header></app-header>
        <users-list v-bind:factory="factory"></users-list>
    </div>
</template>

<script>
import header from "../components/Header";
import usersList from "../components/UsersList";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'users-list': usersList
    },
    methods: {

    }
}
</script>

<style>

</style>