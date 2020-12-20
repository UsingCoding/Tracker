<template>
  <div>
      <app-header></app-header>
      <user-info v-bind:factory="factory"></user-info>
  </div>
</template>

<script>
import header from "../components/Header";
import userInfo from "../components/UserInfo";

export default {
    props: ['factory'],
    data(){
        return {}
    },
    components: {
        'app-header': header,
        'user-info': userInfo
    },
    methods: {

    }
}
</script>

<style>

</style>