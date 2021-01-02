<template>
    <access-denied></access-denied>
</template>

<script>
import AccessDenied from "../components/AccessDenied";

export default {
    props: ['factory'],
    data() {
        return{}
    },
    components: {
        "access-denied": AccessDenied
    }
}
</script>

<style>

</style>