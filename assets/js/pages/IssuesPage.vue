<template>
  <div>
      <app-header></app-header>
      <search-panel></search-panel>
      <toolbar></toolbar>
      <issues-list></issues-list>
  </div>
</template>

<script>
import header from "../components/Header";
import tools from "../components/Toolbar";
import issues from "../components/Issues";
import search_panel from "../components/SearchPanel";

export default {
    data() {
        return {}
    },
    components: {
        "app-header": header,
        "search-panel": search_panel,
        "toolbar": tools,
        "issues-list": issues
    }
}
</script>

<style>

</style>