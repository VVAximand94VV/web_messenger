<template>
    <div class="modal fade" id="contacts-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="contacts-modal" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-md-down">
            <div class="modal-content">
                <div class="modal-header d-flex flex-column">
                    <h5 class="d-flex">Contacts</h5>
                    <input type="search" v-model="userName" class="form-control" placeholder="Search users">
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="overflow-auto">
                            <ul class="list-unstyled">



                                <template v-if="users" v-for="contact in users">
                                    <li class="d-flex justify-content-between">
                                        <div @click="createChat(contact.id)" role="button" class="d-flex flex-row">
                                            <div>
                                                <img :src="contact.avatar" alt="avatar" class="d-flex align-self-center me-3" width="45">
                                                <span class="badge bg-warning badge-dot"></span>
                                            </div>
                                            <div class="pt-1">
                                                <p class="fw-bold mb-0">{{ contact.name }}</p>
                                                <p class="small text-muted">{{ contact.status ? 'Online':'Offline' }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <i class="fas fa-user-friends mx-2" title="Contact in your friends list." style="font-size: 1.3em;"></i>
                                            <a class="btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v mx-2" style="font-size: 1.3em;"></i>
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li><a @click.prevent="addContact(contact.id)" class="dropdown-item" href="#">Add/Remove in contacts list</a></li>
                                                <li><a class="dropdown-item" href="#">Other</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </template>

                                <p class="mt-2" v-if="users==0"><b>Users for your request were not found.</b></p>

                            </ul>
                        </div>

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
import { useToast } from "vue-toastification";
export default {
    name: "ContactsModal",

    setup(){
        const toast = useToast();
        return{
            t$: useToast()
        }
    },

    watch:{
        'userName':{
            handler(){
                this.searchUserName()
            }
        }
    },

    mounted() {
        this.getContacts()
    },

    data(){
      return{
        users:[],
        userName:'',
      }
    },

    methods:{
        async getContacts(){
            let id = JSON.parse(localStorage.getItem('user_info')).id;
            await axios.get(`/api/client/contacts/${id}/`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
                })
                .then(res => {

                    this.users = res.data.contacts
                })
                .catch(error => {
                    console.log(error)
                })
        },

        async createChat(recipientId){
            let id = JSON.parse(localStorage.getItem('user_info')).id;
            await axios.post(`/api/client/chat/${id}/store`, {
                recipientId: recipientId
            },{
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                    }
                })
                .then(res => {
                    this.t$.success(res.data.message);
                    if(res.data.chat){
                        this.$router.push({name:'chat.single', params:{id:res.data.chat.id}});
                    }
                })
                .catch(error => {
                    console.log(error);
                })
        },

        searchUserName(){
            //console.log(this.userName)

            let id = JSON.parse(localStorage.getItem('user_info')).id;
            axios.post(`/api/client/contacts/${id}/search`, {userName: this.userName}, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {
                    console.log('All users: ', res.data.users)
                    this.users = res.data.users
                })
                .catch(error => {
                    console.log(error)
                })
        },

        addContact(contactId){
            let id = JSON.parse(localStorage.getItem('user_info')).id;
            axios.post(`/api/client/contacts/${id}/toggle-contact`, {contactId: contactId}, {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {

                    this.getContacts()
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>
.field-file-input {
    position: absolute;
    opacity: 0;
}

</style>
