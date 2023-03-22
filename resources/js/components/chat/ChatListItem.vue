<template>
    <router-link @click.prevent="this.$store.dispatch('changeChatlist')" :to="{ name:'chat.single', params:{id:chatId} }" class="d-flex justify-content-between">
            <div class="d-flex flex-row">
                <div>
                    <img
                        :src="userAvatar"
                        alt="avatar" class="d-flex align-self-center me-3" width="55">
                    <span class="badge bg-success badge-dot"></span>
                </div>
                <div class="pt-1">
                    <p class="fw-bold mb-0">{{ userName }}</p>
                    <p class="small text-muted">Lorem ipsum dolor sit.</p>
                </div>                    
            </div>
        <div class="pt-1">
            <p class="small text-muted mb-1">Yesterday</p>
        </div>                
    </router-link>
</template>

<script>
export default{
    name:"ChatListItem",

    props:['chatId', 'userAvatar', 'userName', 'lastMessage', 'updAt'],

}
</script>

<style scoped>

</style>