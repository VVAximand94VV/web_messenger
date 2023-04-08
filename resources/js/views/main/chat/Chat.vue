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
                                    <img class="img-fluid" @click.prevent="this.$store.dispatch('changeChatlist')" :src="contact.avatarUrl" width="45" height="45" alt="user avatar">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3>{{ contactName }}</h3>
                                    <p>{{ $t('chatView.typing') }}...</p>
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
                                :chatId = "this.chatInfo.id"
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

                    <div class="d-flex flex-row justify-content-between">

                        <div class="input-group">
                            <span class="input-group-text" role="button"  id="file-clip"><i class="fas fa-paperclip"></i></span>
                            <!-- emoji -->
                            <span class="input-group-text" role="button" id="emoji" data-bs-toggle="dropdown" aria-expanded="false"><i class="far fa-smile"></i></span>
                            <div class="dropdown">
                                <div class="dropdown-menu">
                                    <Emoji @emoji_click="addEmoji" />
                                </div>
                            </div>
                            <!-- -->
                            <input @keydown.enter="sendMessage" type="text" v-model="message" class="form-control d-flex flex-grow-1" :placeholder="$t('chatView.writeMessage')" aria-label="message…">
                        </div>

                        <button type="button" @click.prevent="sendMessage" class="btn btn-primary mx-1"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

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

export default {
    name: "Chat",
    components: {Emoji, Message},

    mounted(){
        Echo.private(`messages`)
            .listen('NewMessage', (e) => {
                this.getMessages(this.$route.params.id);
            });
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
            chatInfo:[],
            messages:[],
            unreadMessage:0,
            image:null,
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
                    this.chatInfo = res.data.chat;
                    this.contact = res.data.contacts;
                    this.messages = res.data.messages;
                    console.log('Chat contacts..:', res.data.contacts);

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

            axios.post(`/api/client/message/${this.chatInfo.id}/store`, data, {
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {
                    this.message = '';
                    this.getMessages(this.chatInfo.id);
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

    },

    computed:{
        contactName(){
            return this.contact.firstName+' '+this.contact.lastName;
        }
    }
}
</script>

<style scoped>
input{
    font-size: 1.2em;
}
</style>
