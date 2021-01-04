<template>
  <div>
      <app-header></app-header>
      <user-info v-bind:factory="factory" v-on:error="openPopup()"></user-info>
      <pop-up v-bind:popupFlag="popupFlag" v-on:close="closePopup()"></pop-up>
  </div>
</template>

<script>
import header from "../components/Header";
import userInfo from "../components/UserInfo";
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
        'user-info': userInfo,
        "pop-up": popup
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