<template>
    <div class="modal fade" id="settings-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="settings-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between">
                            <h1 class="modal-title fs-5 d-flex" id="staticBackdropLabel">{{ $t('settingsModal.settings') }}</h1>
                            <button type="button" class="btn-close d-flex" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="d-flex flex-row mt-3">
                            <div class="d-flex">
                                <img :src="userAvatar" style="max-width: 80px" class="img-fluid img-thumbnail rounded-circle" alt="avatar">
                            </div>
                            <div class="d-flex ms-2">
                                <div class="d-flex flex-column">
                                    <span class="mb-1">{{ user.login }}</span>
                                    <span class="mb-1">+{{ user.phone }}</span>
                    

                                    <div class="dropdown mb-1">
                                        <a class="btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $t('settingsModal.editAvatar') }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <input id="file" ref="avatar" class="field-file-input" type="file" @change="handleFileUpload" name="avatar"/>  
                                                <span class="dropdown-item">Upload</span>
                                            </li>
                                            <li>
                                                <span ref="dropzone" id="dropzone" class="dropdown-item" href="#">Camera</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <span @click="editAvatar">Send</span>
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
import axios from "axios";
import {useToast} from "vue-toastification";

export default {
    name: "SettingModal",
    components: {DropdownSettings},

    setup () {
        return {
            t$: useToast(),
        }
    },

    mounted() {
        console.log(this.user)
    },

    data(){
        return{
            user: JSON.parse(localStorage.getItem('user_info')),
            userAvatar: JSON.parse(localStorage.getItem('user_info')).avatar,
            avatar:null,
        }
    },

    methods:{

        handleFileUpload(){
            console.log('image uploaded')
            console.log('avatar path: ', this.user.avatar)
            console.log(this.$refs.avatar.files[0])
            this.avatar = this.$refs.avatar.files[0]
        },

        editAvatar(){
            const data = new FormData();
            const id = JSON.parse(localStorage.getItem('user_info')).id;
            data.append('avatar', this.avatar)

            axios.post(`/api/client/profile/${id}/edit-avatar`, data, {
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }        
            })
                .then(res => {
                    console.log(res)
                    localStorage.setItem('user_info', JSON.stringify(res.data.userInfo));
                    this.t$.success(res.data.message);

                })
                .catch(error => {
                    console.log(error)
                    this.t$.error(error.response.data.message ?? 'Error');
                })
            
        }
    },
}
</script>

<style scoped>
.field-file-input {
    position: absolute;
    opacity: 0;
}

</style>
