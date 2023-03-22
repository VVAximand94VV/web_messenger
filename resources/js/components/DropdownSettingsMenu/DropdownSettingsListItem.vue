<template>
    <li class="my-2"><a class="" role="button"><i :class="icon" id="list-icon"></i>{{ label }}</a></li>
</template>

<script>
export default {
    name: "DropdownSettingsListItem",

    props:['label', 'icon'],
}
</script>

<style scoped>

#list-icon{
    margin-right: 10px;
}

a{
    text-decoration: none;
    color: black;
}

</style>
