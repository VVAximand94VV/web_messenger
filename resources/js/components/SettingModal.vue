<template>

    <div class="modal fade" id="settings-modal" tabindex="-1" aria-labelledby="settings-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between">
                            <h1 class="modal-title fw-bold fs-5 d-flex" id="staticBackdropLabel">{{ $t('settingsModal.settings') }}</h1>
                            <button type="button" class="btn-close d-flex" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="d-flex flex-row mt-3">
                            <div class="d-flex avatar-container">
                                <div class="z-3 position-relative rounded-circle">
                                    <img :src="user.avatar" style="max-width: 95px; max-height: 95px" class="rounded-circle" alt="avatar">
                                </div>
                                <!-- Edit avatar -->
                                <div class="z-2 position-absolute rounded-circle overlay" role="button"  data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <ul class="dropdown-menu">
                                    <li>
                                        <input id="file" ref="avatar" class="field-file-input" type="file" @change="handleFileUpload" name="avatar"/>
                                        <span ref="dropzone">Upload</span>
                                    </li>
                                    <li>
                                        <span id="dropzone" class="dropdown-item">Camera</span>
                                    </li>
                                    <li>
                                        <span @click="editAvatar">Send</span>
                                    </li>
                                </ul>
                            </div>
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
import axios from "axios";
import {useToast} from "vue-toastification";
import Dropzone from 'dropzone';
export default {
    name: "SettingModal",
    components: {DropdownSettings},

    setup () {
        return {
            t$: useToast(),
        }
    },

    mounted() {
        console.log(this.user);

        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/',
            maxFiles: 1,
            acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
            autoProcessQueue: false,
            previewsContainer: this.$refs["dropzone-content-container"],
            previewTemplate: this.dzTemplate,
            maxfilesexceeded:function(file){
                this.removeFile(file)
            },
        });
    },

    data(){
        return{
            user: JSON.parse(localStorage.getItem('user_info')),
            //userAvatar: JSON.parse(localStorage.getItem('user_info')).avatar,
            avatar:null,
            dropzone:null,

            dzTemplate:"<div class='dz-preview dz-file-preview m-1'>\n" +
                "  <div class=\"dz-details\" style='position: relative'>\n" +
                "    <img class='rounded-4 dz-img' data-dz-thumbnail />\n" +
                "  </div>\n" +

                "  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n" +
                "</div>",
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

/* overlay */
.avatar-container{
    position: relative;
}

.overlay {
    /*position: absolute;*/
    bottom: 0;
    /*background: rgb(0, 0, 0);*/
    /*background: rgba(0, 0, 0, 0.5);*/
    text-shadow: black 2px 2px 0, black -2px -2px 0,
    black -1px 1px 0, black 1px -1px 0;
    color: #f1f1f1;
    height: 50%;
    width: 100%;
    transition: .5s ease;
    opacity:0;
    font-size: 20px;
    padding: 10px;
    text-align: center;
}

.avatar-container:hover .overlay {
    opacity: 1;
}
</style>
