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
                                    <img class="img-fluid" @click.prevent="this.$store.dispatch('changeChatlist')" src="../../../assets/image/avatar/ava6-bg.webp" width="45" height="45" alt="user img">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3>Ben Smith - {{ this.$route.params.id }}</h3>
                                    <p>{{ $t('chatView.typing') }}...</p>
                                </div>
                            </div>
                        </div>

                        <!-- ПЕРЕДЕЛАТЬ -->
                        <div class="col-4 d-flex flex-row-reverse">
                            <div class="dropdown">
                                <a class="btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                <div class="modal-body" ref="feed" style="overflow-x: hidden;">
                    <div class="msg-body">
                        <div class="pt-3 mt-3 pe-3 px-1 container-fluid h-100 mx-1" style="position: absolute;">


                            <Message id="observ-mess" ref="message" v-if="messages" v-for="mess in messages"
                                :messageId = "mess.id"
                                :chatId = "this.chatInfo.id"
                                :to="mess.to"
                                :contactId="contactInfo.id"
                                :text="mess.message"
                                :avatar="mess.sender.avatarUrl"
                                :isRead = "message.isRead"
                                :createdAt="mess.created" />


                            <div v-if="!messages">Noting messages</div>
                        </div>
                    </div>
                </div>


                <div class="send-box">

                    <div class="d-flex flex-row justify-content-between">
                        <input @keydown.enter="sendMessage" type="text" v-model="message" class="form-control d-flex flex-grow-1" aria-label="message…" :placeholder="$t('chatView.writeMessage')">

                        <button type="button" @click.prevent="sendMessage" class="btn btn-primary mx-1"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

                        <button type="button" class="btn btn-danger mx-1"><i class="fas fa-folder-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import axios from 'axios';
import Message from '../../../components/chat/Message.vue';

export default {
    name: "Chat",
    components: {Message},

    mounted(){
        Echo.private(`messages`)
            .listen('NewMessage', (e) => {
                //alert('New message!');
                console.log(e);
                this.getMessages(this.$route.params.id);
            });

        //const el = document.querySelector('#observ-mess');
        //this.observer();

        //this.updateUnreadMessage();
    },

    watch:{
        '$route.params.id': {
            immediate: true,
            handler(){
                this.getMessages(this.$route.params.id);
                //this.updateUnreadMessage(this.$route.params.id);
                console.log('change chat!')
            },
        },

        // isNotReadMessage(messages){
        //     //let res = messages.map(item => item.isRead).indexOf(0)
        //     let res = Object.values(messages).filter(elem => {
        //         elem.isRead == 0
        //     })
        //     return res;
        // },

        messages(messages){
            this.scrollToBottom();
            this.updateUnreadMessage(this.$route.params.id);

        },
    },


    data(){
        return{
            message:'',
            contactInfo:[],
            chatInfo:[],
            messages:[],
            unreadMessage:0,
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
                    console.log('chat-info: ',res.data.chat)
                    this.chatInfo = res.data.chat;
                    this.contactInfo = res.data.contacts;
                    this.messages = res.data.messages;

                })
                .catch(error =>{
                    console.log(error)
                })
        },

        sendMessage(){
            const data = new FormData();
            data.append('message', this.message);
            data.append('from', Number(JSON.parse(localStorage.getItem('user_info')).id));
            data.append('to', Number(this.contactInfo.id));

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

        scrollToBottom(){
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight
            })

        },

        updateUnreadMessage(chatId){
            //console.log('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA')
            //console.log('unread:', this.messages)
            let unreadMessage = Object.values(this.messages).filter(elem => {
                return elem.isRead === 0
            }).length;

            console.log('unreadMessage', unreadMessage)

            if(unreadMessage===0){
                console.log('all message is read.')
                return false;
            }

            axios.post(`/api/client/message/${this.chatInfo.id}/read`, {},{
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {
                    this.getMessages(chatId);
                    console.log(res);
                })
                .catch(error => {
                    console.log(error);
                })
        },

    }
}
</script>

<style scoped>

</style>
