<template>
    <div>
      <app-header></app-header>
      <search-panel></search-panel>
      <toolbar></toolbar>
    </div>
</template>

<script>
import header from "../components/Header";
import tools from "../components/Toolbar";
import search_panel from "../components/SearchPanel";

export default {
    data() {
        return{
            edit_flag: false
        }
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools
    },
    methods: {

    }
}
</script>

<style>

</style>