<template>
    <div class="d-flex justify-content-start">
        <span><i role="button" @click="$emit('back')" class="fas fa-chevron-left"></i> <b style="margin-left: 30px">{{ title }}</b></span>
    </div>
</template>

<script>
export default {
    name: "DropdownSettingsHeader",

    props:['title']
}
</script>

<style scoped>

</style>
