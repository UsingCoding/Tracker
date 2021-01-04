<template>
  <div>
      <app-header></app-header>
      <project-fields v-bind:factory="factory" v-on:error="openPopup()"></project-fields>
      <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
  </div>
</template>

<script>
import header from "../components/Header";
import projectFields from "../components/ProjectFields";
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
        'project-fields': projectFields,
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