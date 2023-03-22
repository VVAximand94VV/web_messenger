<template>
    <DropdownSettingsHeader @back="$emit('select-menu', 'main')" :title="$t('dropdownMenu.language')" />
    <div class="mt-3 p-1">
        <div v-for="lang in languages" class="form-check">
            <input class="form-check-input" @click="changeLanguage" :checked="locale==lang.value??true" :value="lang.value" type="radio" name="language" :id="lang.value">
            <label class="form-check-label" :for="lang.value">
                {{ lang.label }}
            </label>
        </div>
    </div>
</template>

<script>
import DropdownSettingsHeader from "./DropdownSettingsHeader.vue";
import { useI18n } from 'vue-i18n';

export default {
    name: "DropdownSettingsLanguagePreference",
    components: {DropdownSettingsHeader},

    setup() {
        const { locale } = useI18n();
        return {
            locale,
        };
    },

    data(){
        return{
            languages:[
                {
                    'label':'English',
                    'value':'en'
                },
                {
                    'label':'Russian',
                    'value':'ru'
                }
            ]
        }

    },

    methods:{
        changeLanguage(event){
            let lang = event.target.value
            this.locale = lang
            localStorage.setItem('lang-locale', lang);
        }
    },


}
</script>

<style scoped>

.icon{
    font-size: 1.2em;
    margin-right: 10px;
}
</style>
