<template>

    <div class="d-flex avatar-container">
        <div class="z-3 position-relative rounded-circle">
            <img :src="defaultAvatar" style="max-width: 95px; max-height: 95px" class="rounded-circle" alt="avatar">
        </div>
        <!-- Edit avatar input and btn -->
        <div class="z-2 h-100 w-100 d-flex align-items-center justify-content-center align-items-center position-absolute rounded-circle overlay" role="button">
            <input type="file" name="avatar" hidden ref="avatar" @change="handleFileUpload">

            <div v-if="!isFileUpload">
                <span @click="browse"><i class="fas fa-camera"></i></span>
            </div>

            <div v-if="isFileUpload">
                <span class="mx-2"><i class="fas fa-check" @click="editAvatar"></i></span>
                <span class="mx-2"><i class="fas fa-times" @click="removeAvatar"></i></span>
            </div>

        </div>

    </div>

</template>

<script>
import axios from "axios";

export default {
    name: "ChangeableAvatar",

    props:['src',],

    data(){
        return{
            defaultAvatar: this.src,
            newAvatar:null,
            isFileUpload:null,
        }
    },

    watch:{
        editAvatar(){
            this.printUploadImgButton()
        }
    },

    methods:{
        browse(){
            this.$refs.avatar.click();
        },

        handleFileUpload(){
            console.log(this.$refs.avatar.files[0])
            this.newAvatar = this.$refs.avatar.files[0]
            let reader = new FileReader();
            reader.readAsDataURL(this.newAvatar);
            reader.onload = () => {
                this.defaultAvatar = reader.result;
            };
            this.isFileUpload = 1;
        },

        printUploadImgButton(){
            let overlay = document.querySelector('.overlay')
            overlay.style.opacity = 1;

        },

        editAvatar(){
            this.isFileUpload = null;

            const data = new FormData();
            const id = JSON.parse(localStorage.getItem('user_info')).id;
            data.append('avatar', this.newAvatar)

            axios.post(`/api/client/profile/${id}/edit-avatar`, data, {
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {
                    localStorage.setItem('user_info', JSON.stringify(res.data.userInfo));
                    this.$parent.t$.success(res.data.message);

                })
                .catch(error => {
                    console.log(error)
                    this.$parent.t$.error(error.response.data.message ?? 'Error');
                })
        },

        removeAvatar(){
            this.defaultAvatar = this.src
            this.newAvatar = null;
            this.isFileUpload = null;
        },
    }
}
</script>

<style scoped>
/* overlay */
.avatar-container{
    position: relative;
}

.overlay {
    text-shadow: black 2px 2px 0, black -2px -2px 0,
    black -1px 1px 0, black 1px -1px 0;
    color: #f1f1f1;
    transition: .5s ease;
    opacity:0;
    font-size: 20px;
    padding: 10px;
}

.avatar-container:hover .overlay {
    opacity: 1;
}
</style>
