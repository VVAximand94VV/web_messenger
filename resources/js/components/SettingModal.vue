<template>

    <div class="modal fade" id="settings-modal" tabindex="-1" aria-labelledby="settings-modal" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between">
                            <h1 class="modal-title fw-bold fs-5 d-flex" id="staticBackdropLabel">{{ $t('settingsModal.settings') }}</h1>
                            <button type="button" class="btn-close d-flex" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="d-flex flex-row mt-3">
                            <!-- Avatar -->
                                <ChangeableAvatar :src="user.avatar" />
                            <!-- ./ Avatar -->
                            <div class="d-flex ms-2">
                                <div class="d-flex flex-column">
                                    <h5 class="mb-1 px-3 fw-bold">{{ user.login }}</h5>
                                    <span class="mb-1 px-3">{{ user.phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <DropdownSettings></DropdownSettings>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $t('settingsModal.close') }}</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import DropdownSettings from "./DropdownSettingsMenu/DropdownSettings.vue";
import {useToast} from "vue-toastification";
import ChangeableAvatar from "./ChangeableAvatar.vue";
export default {
    name: "SettingModal",
    components: {ChangeableAvatar, DropdownSettings},

    setup () {
        return {
            t$: useToast(),
        }
    },

    mounted() {

    },

    data(){
        return{
            user: JSON.parse(localStorage.getItem('user_info')),
        }
    },

    methods:{

    },
}
</script>

<style scoped>

</style>
