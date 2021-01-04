<template>
  <div>
      <app-header></app-header>
      <project-info v-bind:factory="factory" v-on:error="openPopup()"></project-info>
      <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
  </div>
</template>

<script>
import header from "../components/Header";
import projectInfo from "../components/ProjectInfo";
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
        'project-info': projectInfo,
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