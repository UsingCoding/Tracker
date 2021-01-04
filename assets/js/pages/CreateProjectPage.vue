<template>
  <div>
      <app-header></app-header>
      <create-project v-bind:factory="factory" v-on:error="openPopup()"></create-project>
      <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
  </div>
</template>

<script>
import header from "../components/Header";
import create_project from "../components/CreateProject";
import popup from "../components/Popup";

export default {
    props: ['factory'],
    data(){
        return {
            popupFlag: false
        }
    },
    components: {
        'app-header': header,
        'create-project': create_project,
        'pop-up': popup
    },
    methods: {
        openPopup: function() {
            this.popupFlag = true;
        },
        closePopup: function() {
            this.popupFlag = false;
        } 
    }
}
</script>

<style>

</style>