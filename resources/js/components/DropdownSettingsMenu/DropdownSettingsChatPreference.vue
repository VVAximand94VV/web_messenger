<template>
    <DropdownSettingsHeader @back="$emit('select-menu', 'main')" :title="$t('dropdownMenu.chatPreference')" />
    <div class="mt-4">
        <div>
            <span>Chat background:</span>
            <div>
                <template v-if="backgroundImages" v-for="background in backgroundImages">
                    <img :src="`http://127.0.0.1:5173/resources/js/assets/image/chat/background/${background.path}`" class="m-2 bg-img" style="max-height: 50px;max-width: 50px;" :alt="background.alt">
                </template>
            </div>
        </div>

        <div class="mt-2">
            <div>
                <span>Chat style:</span>
            </div>
            <div>
                <button class="btn btn-danger btn-circle m-2"></button>
                <button class="btn btn-info btn-circle m-2"></button>
                <button class="btn btn-primary btn-circle m-2"></button>
                <button class="btn btn-success btn-circle m-2"></button>
            </div>
        </div>
    </div>
</template>

<script>
import DropdownSettingsHeader from "./DropdownSettingsHeader.vue";
export default {
    name: "DropdownSettingsChatPreference",
    components: {DropdownSettingsHeader},

    data(){
        return{
            backgroundImages:[
                {
                    'alt':'bg1',
                    'path':'bg1.webp'
                },
                {
                    'alt':'bg2',
                    'path':'bg2.jpg'
                },
                {
                    'alt':'bg3',
                    'path':'bg3.jpg'
                },
                {
                    'alt':'bg4',
                    'path':'bg4.jpg'
                },
                {
                    'alt':'bg5',
                    'path':'bg5.jpg'
                },

            ]
        }
    },
}
</script>

<style scoped>
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
.btn-circle:hover{
    opacity: 0.8;
}

.bg-img{

}
.bg-img:hover{
    cursor: pointer;
}
</style>
