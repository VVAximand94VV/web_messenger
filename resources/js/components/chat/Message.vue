<template>

    <div id="mess" :data-message-id="messageId" :class="`d-flex flex-row justify-content-${to !== contactId ? 'start':'end'}`">
        <img :src="avatar"
            alt="avatar 1" style="width: 45px; height: 100%; border-radius: 35%;">
        <div>
                <p :class="`small p-2 ms-3 mb-1 rounded-3 ${to !== contactId ? '':'text-white'}`" :style="`background-color: ${to !== contactId ? '#f5f6f7':' #0d6efd'};`">
                    {{ text }}
                </p>
            <p class="small ms-3 mb-3 rounded-3 text-muted float-end">{{ createdAt }}</p>
        </div>
    </div>

</template>

<script>

export default {
    name: "Message",

    props:['messageId', 'chatId','contactId', 'to', 'avatar', 'text', 'isRead','createdAt'],

    mounted(){
        //console.log('observe elem', document.querySelector(`#observe-mess-${this.messageId}`));
        //this.observer();
    },



    methods:{
        readMessage(isRead, messageId){
            console.log('Message read!!!');
            // if(isRead === 1){
            //     return true;
            // }

            // axios.post(`/api/client/message/${this.chatId}/read/${messageId}`, data, {
            //     headers:{
            //         Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
            //     }
            // })
            //     .then(res => {
            //         console.log(res);
            //     })
            //     .catch(error => {
            //         console.log(error);
            //     })
        },

        observer(){
            let elem = document.querySelector(`#mess`);

            let observer = new IntersectionObserver(function(e) {
                e.forEach(function(e){
                    // Выводим в консоль сам элемент
                    console.log(e.target);
                    // Выводим в консоль true (если элемент виден) или false (если нет)
                    console.log(e.isIntersecting);

                });
            });

            observer.observe(elem);
        }



    }


}

</script>

<style scoped>

</style>
