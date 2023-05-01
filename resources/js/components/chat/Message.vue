<template>

    <div id="mess" :data-message-id="messageId" :class="`d-flex flex-row ${to !== contactId ? 'message-start':'message-end'}`">
        <img :src="avatar"
            alt="avatar 1" style="width: 45px; height: 100%; border-radius: 35%;">
        <div>
            <div :class="`small p-2 ms-3 mb-1 rounded-3 ${to !== contactId ? 'message-start-bg':'message-end-bg'}`">
                <template v-if="files!=0">
                    <template v-for="file in files">
                        <p>
                            <img class="message-image rounded-1" :src="file.fileUrl" alt="img" data-bs-toggle="modal" :data-bs-target="`#full-size-img-${file.id}`">
                        </p>
                        <!-- IMG modal -->
                        <FullSizeImage :imageId="file.id" :src="file.fileUrl" />
                    </template>
                </template>
                <p>
                    {{ text }}
                </p>
            </div>

            <p class="small ms-3 mb-3 rounded-3 float-end message-create-date" style="color: white;">{{ createdAt }}</p>
        </div>
    </div>



</template>

<script>

import FullSizeImage from "./FullSizeImage.vue";
export default {
    name: "Message",
    components: {FullSizeImage},
    props:['messageId', 'chatId','contactId', 'to', 'avatar', 'text', 'files', 'isRead','createdAt'],

    mounted(){
        this.$store.dispatch('changeColorStyle', localStorage.getItem('color-them'))
    },

}

</script>

<style scoped>
p{
    font-size: 14px;
}
.message-image{
    cursor: pointer;
    max-width: 350px;
}
.message-image:hover{
    opacity: 0.7;
}
.message-create-date{
    font: 1em Arial, sans-serif;
    text-shadow: black 1px 1px 0, black -1px -1px 0,
    black -1px 1px 0, black 1px -1px 0;
}
</style>
