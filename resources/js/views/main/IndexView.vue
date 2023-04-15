<template>

    <!-- char-area -->
    <section class="message-area p-0">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <div class="col-12 px-0">
                    <div class="chat-area h-100">

                        <!-- chatlist -->
                        <div class="chatlist">



                            <div class="">
                                    <!-- chatlist content -->
                                <div class="chatlist-content">

                                    <!-- chatlist-header -->
                                    <div class="chatlist-header">
                                        <div class="d-flex flex-row justify-content-between">
                                            <div class="d-flex">
                                                <button class="btn" @click.prevent="this.$store.dispatch('changeSidebar')" style="font-size:1.2em;"><i class="fas fa-bars"></i> </button>
                                            </div>

                                            <!-- Search chats and users -->
                                            <input type="text" class="form-control" id="inlineFormInputGroup" :placeholder="$t('chatList.search')" aria-label="search">
                                        </div>
                                    </div>

                                                <!-- chatlist-body -->
                                    <div class="modal-body">

                                        <!-- chat-list -->
                                        <div class="chat-lists">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="" id="Open" role="tabpanel" aria-labelledby="Open-tab">

                                                    <!-- chat-list -->
                                                    <div class="chat-list">
                                                        <!-- Chat list / conatcs -->

                                                            <router-link
                                                                v-if="chats" v-for="chat in chatsByLastMessage"
                                                                @click="this.$store.dispatch('changeChatlist'); this.updateUnreadMessage(chat.id, true);"
                                                                :to="{ name:'chat.single', params:{id:chat.id} }" :class="`d-flex p-1 mt-3 justify-content-between chat ${chat.id == this.selectedChat?'active-chat':''}`">
                                                                <div class="d-flex flex-row">
                                                                <div>
                                                                    <img
                                                                        src="../../assets/image/avatar/ava6-bg.webp"
                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                    <span class="badge bg-success badge-dot"></span>
                                                                </div>
                                                                <div class="pt-1">
                                                                    <p v-for="contact in chat.contacts" class="fw-bold mb-0 user-name">
                                                                        {{ contact.id !== userId ? contact.login:'' }}
                                                                        <svg class="online-status" viewBox="0 0 80 80" width="11" height="11">
                                                                            <circle :style="`fill:`+this.userCheckOnline(contact.id)+`;`" class="online-status-circle" cx="40" cy="40" r="38"/>
                                                                        </svg>
                                                                    </p>
                                                                    <p class="small last-message">Lorem ipsum dolor sit.</p>
                                                                </div>
                                                                    </div>
                                                                <div v-if="chat.unreadMessages" class="pt-1">
                                                                    <p class="unread-message small mt-1 mb-1">{{ chat.unreadMessages }}</p>
                                                                </div>
                                                            </router-link>


                                                        <!-- -->

                                                    </div>
                                                    <!-- chat-list -->

                                                </div>
                                            </div>

                                        </div>
                                        <!-- chat-list -->

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- chatlist -->

                        <!-- chatbox -->

                        <router-view id="chatbox"></router-view>

                    </div>
                    <!-- chatbox -->


                </div>
            </div>
        </div>

    </section>
    <!-- char-area -->



</template>

<script>
import axios from "axios";
import DropdownSettings from "../../components/DropdownSettingsMenu/DropdownSettings.vue";
import SettingModal from "../../components/SettingModal.vue";
import {useToast} from "vue-toastification";
export default {
    name: "IndexView",
    components: {SettingModal, DropdownSettings},

    setup(){
        return {
            t$: useToast(),
        }
    },

    mounted() {
        this.getChats();

        this.$store.dispatch('changeColorStyle', localStorage.getItem('color-them'));

        // user check status
        Echo.join(`users-online`)
            .here((users) => {
                console.log('Users online: ', users)
                this.usersOnline = users;
            })
            .joining((user) => {
                this.usersOnline.push('User joining:', user)
                console.log(user.name);
            })
            .leaving((user) => {
                this.usersOnline.splice(this.usersOnline.indexOf(user), 1)
                console.log('User leaving:', user.name);
            })
            .error((error) => {
                console.error(error);
            });


        console.log('selected chat: ', this.selectedChat)

        Echo.private(`chat.${this.selectedChat}`)
            .listen('NewMessage', (e) => {
                //console.log('new message.......', e);
                if(e.message.to == this.userId){
                    // toast
                    this.t$.info('You have a nave message');
                    this.updateUnreadMessage(e.message.chatId, false)
                }
            });
    },

    watch:{
        '$route.params.id': {
            immediate: true,
            handler(){
                this.selectedChat = this.$route.params.id
            },
        },
    },

    data(){
      return{
          userId:JSON.parse(localStorage.getItem('user_info')).id,
          chats:[],
          selectedChat:0,
          usersOnline:[],
      }
    },

    methods:{
        userCheckOnline(userId){
            // return userId
            return this.usersOnline.find(userOnline => userOnline.id == userId) ? 'green':'red';
        },

        async getChats(){
            let id = JSON.parse(localStorage.getItem('user_info')).id;
            await axios.get(`/api/client/chat/${id}/`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
                })
                .then(res => {
                    //console.log('Chat info....:', res)
                    this.chats = res.data.chats;
                    console.log('chatsByLastMessage', this.chatsByLastMessage)
                })
                .catch(error => {
                    console.log(error)
                })
        },

        updateUnreadMessage(chatId, reset){

            this.chats = this.chats.map((elem) => {
                if(chatId == elem.id){
                    if(reset){
                        elem.unreadMessages = 0
                        this.updateUnreadMessageInDB(elem.id);
                    }else{
                        elem.unreadMessages += 1;
                    }
                }
                return elem;
            })
        },

        updateUnreadMessageInDB(chatId){
            axios.post(`/api/client/message/${chatId}/${this.userId}/read`, {},{
                    headers:{
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
                })
        },
    },

    computed:{
        // sorted chats by unread messages
        chatsByLastMessage(){
            let chats = this.chats;
            return _.sortBy(chats, [(chat) => {
                chat.unreadMessages;
            }]).reverse();
        },

    },
}
</script>

<style scoped>

.sidebar{
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1;
    background-color: #111;
    overflow-x: hidden;
    padding-top: 20px;
    transition: 0.5s;
    filter: none;
}

.sidebar li{
    padding: 8px 32px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.hidden-sidebar{
    display: none;
}

.close-btn{
    color: white;
    position: absolute;
    top: 25px;
    right: 25px;
    font-size: 16px;

}

.unread-message{
    background-color: #00DB75;
    color: white;
    border-radius: 5px;
    padding: 2px 6px;

}


.active-chat p{
    color: #ffffff;
}

.active-chat .user-name{
    color: #111111;
}

.active-chat .last-message{
    color: white;
}

.last-message{
    color: #6c757d;
}

.online-status{
    margin-left: 8px;
    margin-bottom: 5px;
}

.online-status-circle {
    fill: #00DB75;
    /*fill: red;*/
    stroke-width: 0.1875em;
}

</style>
