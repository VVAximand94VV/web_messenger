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
                                                                v-if="chats" v-for="chat in chats"
                                                                @click="this.$store.dispatch('changeChatlist')" 
                                                                :to="{ name:'chat.single', params:{id:chat.id} }" class="d-flex justify-content-between">
                                                                <div class="d-flex flex-row chat">
                                                                <div>
                                                                    <img
                                                                        src="../../assets/image/avatar/ava6-bg.webp"
                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                    <span class="badge bg-success badge-dot"></span>
                                                                </div>
                                                                <div class="pt-1">
                                                                    <p v-for="contact in chat.users" class="fw-bold mb-0">
                                                                        {{ contact.id !== userId ? contact.login:'' }}
                                                                    </p>
                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                </div>                    
                                                                    </div>
                                                                <div class="pt-1">
                                                                    <p class="small text-muted mb-1">Yesterday</p>
                                                                </div>                
                                                            </router-link>
                                                    
        
                                                        <!-- -->

                                                        <!-- <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }"  class="d-flex mt-2 justify-content-between">
                                                            <div class="d-flex flex-row">
                                                                <div>
                                                                    <img
                                                                        src="../../assets/image/avatar/ava5-bg.webp"
                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                    <span class="badge bg-warning badge-dot"></span>
                                                                </div>
                                                                <div class="pt-1">
                                                                    <p class="fw-bold mb-0">Kate Moss</p>
                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                </div>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="small text-muted mb-1">Yesterday</p>
                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }"  class="d-flex justify-content-between">
                                                            <div class="d-flex flex-row">
                                                                <div>
                                                                    <img
                                                                        src="../../assets/image/avatar/ava5-bg.webp"
                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                    <span class="badge bg-warning badge-dot"></span>
                                                                </div>
                                                                <div class="pt-1">
                                                                    <p class="fw-bold mb-0">Kate Moss</p>
                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                </div>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="small text-muted mb-1">Yesterday</p>
                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }"  class="d-flex justify-content-between">
                                                            <div class="d-flex flex-row">
                                                                <div>
                                                                    <img
                                                                        src="../../assets/image/avatar/ava5-bg.webp"
                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                    <span class="badge bg-warning badge-dot"></span>
                                                                </div>
                                                                <div class="pt-1">
                                                                    <p class="fw-bold mb-0">Kate Moss</p>
                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                </div>
                                                            </div>
                                                            <div class="pt-1">
                                                                <p class="small text-muted mb-1">Yesterday</p>
                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }" class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row">
                                                                                <div>
                                                                                    <img
                                                                                        src="../../assets/image/avatar/ava1-bg.webp"
                                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                                    <span class="badge bg-success badge-dot"></span>
                                                                                </div>
                                                                                <div class="pt-1">
                                                                                    <p class="fw-bold mb-0">Marie Horwitz</p>
                                                                                    <p class="small text-muted">Hello, Are you there?</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="pt-1">
                                                                                <p class="small text-muted mb-1">Just now</p>
                                                                                <span class="badge bg-danger rounded-pill float-end">3</span>
                                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }" class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row">
                                                                                <div>
                                                                                    <img
                                                                                        src="../../assets/image/avatar/ava2-bg.webp"
                                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                                    <span class="badge bg-warning badge-dot"></span>
                                                                                </div>
                                                                                <div class="pt-1">
                                                                                    <p class="fw-bold mb-0">Alexa Chung</p>
                                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="pt-1">
                                                                                <p class="small text-muted mb-1">5 mins ago</p>
                                                                                <span class="badge bg-danger rounded-pill float-end">2</span>
                                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }" class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row">
                                                                                <div>
                                                                                    <img
                                                                                        src="../../assets/image/avatar/ava3-bg.webp"
                                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                                    <span class="badge bg-success badge-dot"></span>
                                                                                </div>
                                                                                <div class="pt-1">
                                                                                    <p class="fw-bold mb-0">Danny McChain</p>
                                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="pt-1">
                                                                                <p class="small text-muted mb-1">Yesterday</p>
                                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }" class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row">
                                                                                <div>
                                                                                    <img
                                                                                        src="../../assets/image/avatar/ava4-bg.webp"
                                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                                    <span class="badge bg-danger badge-dot"></span>
                                                                                </div>
                                                                                <div class="pt-1">
                                                                                    <p class="fw-bold mb-0">Ashley Olsen</p>
                                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="pt-1">
                                                                                <p class="small text-muted mb-1">Yesterday</p>
                                                                            </div>
                                                        </router-link>
                                                        <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:1} }" class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row">
                                                                                <div>
                                                                                    <img
                                                                                        src="../../assets/image/avatar/ava6-bg.webp"
                                                                                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                                                                                    <span class="badge bg-success badge-dot"></span>
                                                                                </div>
                                                                                <div class="pt-1">
                                                                                    <p class="fw-bold mb-0">Ben Smith</p>
                                                                                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="pt-1">
                                                                                <p class="small text-muted mb-1">Yesterday</p>
                                                                            </div>
                                                        </router-link> -->
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
export default {
    name: "IndexView",
    components: {SettingModal, DropdownSettings},

    mounted() {
        this.getChats()
    },

    data(){
      return{
        userId:JSON.parse(localStorage.getItem('user_info')).id,
        chats:[],
      }
    },

    methods:{
        async getChats(){
            let id = JSON.parse(localStorage.getItem('user_info')).id;
            await axios.get(`/api/client/chat/${id}/`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
                })
                .then(res => {
                    //console.log('chat info:', res)
                    this.chats = res.data.chats;
                })
                .catch(error => {
                    console.log(error)
                })
        },
    },

    computed:{
        contactLogin(contacts){
            let userId = JSON.parse(localStorage.getItem('user_info')).id;
            
            contacts.forEach(e => {

            })

            let result = contacts.find(elem => elem.id != userId);

            return result;
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
</style>
