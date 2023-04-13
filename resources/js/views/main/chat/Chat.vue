<template>

    <div class="chatbox">
        <div class="modal-dialog-scrollable">
            <div class="modal-content">
                <div class="msg-head">
                    <div class="row">
                        <div class="col-8">
                            <div class="d-flex align-items-center">
                                <span class="chat-icon"><i class="fas fa-arrow-left"></i></span>
                                <div class="flex-shrink-0">
                                    <img class="img-fluid" @click.prevent="this.$store.dispatch('changeChatlist')" :src="contact.avatarUrl??localePath$.NO_IMAGE" width="45" height="45" alt="user avatar">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3>{{ contactName }}</h3>
                                    <p v-if="isTyping">{{ $t('chatView.typing') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- ПЕРЕДЕЛАТЬ -->
                        <div class="col-4 d-flex flex-row-reverse">
                            <div class="dropdown">
                                <a class="btn" href="#" role="button" disabled data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <Messages :chatId="this.$route.params.id" /> -->
                <div class="modal-body default-chat-area" ref="feed" style="overflow-x: hidden;">
                    <div class="msg-body">
                        <div class="pt-3 mt-3 pe-3 px-1 container-fluid h-100 mx-1" style="position: absolute;">


                            <Message id="observ-mess" ref="message" v-if="messages" v-for="mess in messages"
                                :messageId = "mess.id"
                                :chatId = "this.chat.id"
                                :to="mess.to"
                                :contactId="contact.id"
                                :text="mess.message"
                                :avatar="mess.sender.avatarUrl"
                                :isRead = "message.isRead"
                                :createdAt="mess.created"
                                :files="mess.files"
                            />


                            <div v-if="!messages">Noting messages</div>
                        </div>
                    </div>
                </div>


                <div class="send-box">

                    <div ref="dropzone-content-container" class="row dropzone-container mb-2">

                    </div>

                    <div class="row">
                        <div class="d-flex flex-row justify-content-between send-inputs">

                            <div class="input-group">
                                <!-- Dropzone -->
                                <span ref="dropzone" class="input-group-text" role="button"  id="file-clip"><i class="fas fa-paperclip"></i></span>
                                <!-- Emoji -->
                                <span class="input-group-text" role="button" id="emoji" data-bs-toggle="dropdown" aria-expanded="false"><i class="far fa-smile"></i></span>
                                <div class="dropdown">
                                    <div class="dropdown-menu">
                                        <Emoji @emoji_click="addEmoji" />
                                    </div>
                                </div>
                                <!-- -->
                                <input @keydown.enter="sendMessage" type="text" v-model="message" @keydown="typingInterceptor" class="form-control d-flex flex-grow-1" :placeholder="$t('chatView.writeMessage')" aria-label="message…">
                            </div>

                            <button type="button" @click.prevent="sendMessage" class="btn btn-primary mx-1"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


</template>

<script>
import axios from 'axios';
import Message from '../../../components/chat/Message.vue';
import Emoji from "../../../components/emoji/Emoji.vue";
import Dropzone from 'dropzone';
import {useToast} from "vue-toastification";
import {LOCAL_PATH} from "../../../lib/local-path";

export default {
    name: "Chat",
    components: {Emoji, Message},

    setup(){
        return{
            t$: useToast(),
            localePath$: LOCAL_PATH,
        }
    },

    mounted(){
        this.channel
            .listen('NewMessage', (e) => {
                this.getMessages(this.$route.params.id);
                this.isTyping = false;
            }).listenForWhisper('typing', (e) => {
                this.isTyping = true;

                if(this.timer){
                    clearTimeout(this.timer)
                }

                this.timer = setTimeout(() => {
                    this.isTyping = false;
                }, 1000)
            });

        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/',
            maxFiles: 6,
            acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
            autoProcessQueue: false,
            previewsContainer: this.$refs["dropzone-content-container"],
            previewTemplate: this.dzTemplate,
            maxfilesexceeded:function(file){
                this.removeFile(file)
            },
        });

        this.$store.dispatch('changeChatBb', localStorage.getItem('chat-bg-img'))


    },

    watch:{
        '$route.params.id': {
            immediate: true,
            handler(){
                this.getMessages(this.$route.params.id);
                console.log('change chat!')
            },
        },

        messages(messages){
            this.scrollToBottom();
        },

    },


    data(){
        return{
            dropzone: null,
            message:'',
            contact:[],
            chat:[],
            messages:[],
            unreadMessage:0,
            image:null,
            isTyping: false,
            timer: false,

            dzTemplate:"<div class='dz-preview dz-file-preview m-1'>\n" +
                "  <div class=\"dz-details\" style='position: relative'>\n" +
                "    <img class='rounded-4 dz-img' data-dz-thumbnail />\n" +
                "    <div class='dz-delete-btn-container'>" +
                "       <span role='button' class='dz-delete-btn' data-dz-remove><i class=\"far fa-times-circle\"></i></span>" +
                "       <span class='dz-size' data-dz-size></span>" +
                "    </div>\n" +
                "  </div>\n" +

                "  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n" +
                "</div>",

            //
            // noImage: LOCAL_PATH.NO_IMAGE

        }
    },

    methods:{

        async getMessages(chatId){
            let userId = JSON.parse(localStorage.getItem('user_info')).id;

            await axios.get(`/api/client/chat/${userId}/${chatId}`, {
                headers: {
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
            })
                .then(res => {
                    console.log(res.data.chat.id)
                    this.chat = res.data.chat;
                    this.contact = res.data.contacts;
                    this.messages = res.data.messages;
                    //console.log('Chat contacts..:', res.data.contacts);

                })
                .catch(error =>{
                    console.log(error)
                })
        },

        sendMessage(){
            const data = new FormData();
            data.append('message', this.message);
            data.append('from', Number(JSON.parse(localStorage.getItem('user_info')).id));
            data.append('to', Number(this.contact.id));
            //let files = this.dropzone.files
            let files = this.dropzone.getAcceptedFiles()
            if(files.length>6){
                this.t$.error('You cannot upload more than 6 files in one message.');
                return false;
            }
            files.forEach(file => {
                data.append('files[]', file)
            });

            axios.post(`/api/client/message/${this.chatId}/store`, data, {
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {
                    this.message = '';
                    this.dropzone.removeAllFiles();
                    //this.getMessages(this.chatInfo.id);
                })
                .catch(error => {
                    console.log(error);
                    this.message = '';
                })
        },

        addEmoji(emoji){
            console.log('click on emoji!');
            this.message += emoji;
        },

        scrollToBottom(){
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight
            })

        },

        typingInterceptor(){
            this.channel
                .whisper('typing', {
                    types: true
                });

                // .whisper('typing', {
                //     types: true
                // })
            //console.log('you typing: ', this.message)
            // axios.post(`/api/client/message/${this.chatInfo.id}/${Number(this.contact.id)}/types`, {},{
            //     headers:{
            //         Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
            //     }
            // })
        },

    },

    computed:{
        contactName(){
            return this.contact.firstName+' '+this.contact.lastName;
        },

        chatId(){
          return this.$route.params.id
        },

        channel(){
            return Echo.private(`chat.${this.chatId}`)
        },

        userId(){
            return Number(JSON.parse(localStorage.getItem('user_info')).id)
        }
    }
}
</script>

<style scoped>

input{
    font-size: 1.2em;
}
</style>
