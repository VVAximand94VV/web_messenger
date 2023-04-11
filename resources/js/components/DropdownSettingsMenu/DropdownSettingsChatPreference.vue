<template>
    <DropdownSettingsHeader @back="$emit('select-menu', 'main')" :title="$t('dropdownMenu.chatPreference')" />
    <div class="mt-4">
        <div>
            <span>Chat background:</span>
            <div>
                <template v-if="backgroundImages" v-for="background in backgroundImages">
                    <img @click.prevent="this.$store.dispatch('changeChatBb', background.path)" :src="`http://127.0.0.1:5173/resources/js/assets/image/chat/background/${background.path}`" class="m-2 bg-img" style="max-height: 50px;max-width: 50px;" :alt="background.name">
                </template>
            </div>
        </div>

        <div class="mt-2">
            <div>
                <span>Chat style:</span>
            </div>
            <div>
                <template v-for="color in colors">
                    <button @click.prevent="this.$store.dispatch('changeColorStyle', color.hex)" class="btn btn-circle m-2" :style="`background-color: ${color.hex}`" :title="color.name"></button>
                </template>
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
            chatBg: 'default',
            backgroundImages:[
                {
                    'name':'bg1',
                    'path':'bg1.webp'
                },
                {
                    'name':'bg2',
                    'path':'bg2.jpg'
                },
                {
                    'name':'bg3',
                    'path':'bg3.jpg'
                },
                {
                    'name':'bg4',
                    'path':'bg4.jpg'
                },
                {
                    'name':'bg5',
                    'path':'bg5.jpg'
                },

            ],

            colors:[
                {
                  'name':'red',
                  'hex':'#dc3545',
                },
                {
                    'name':'azure',
                    'hex':'#0dcaf0',
                },
                {
                    'name':'blue',
                    'hex':'#0d6efd',
                },
                {
                    'name':'green',
                    'hex':'#198754',
                },
            ],
        }
    },

    methods:{

    }
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
