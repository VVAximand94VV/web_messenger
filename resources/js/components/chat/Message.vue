<template>

    <div :class="`d-flex flex-row justify-content-${to !== contactId ? 'start':'end'}`">
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

    props:['contactId', 'to', 'avatar', 'text', 'createdAt'],


}

</script>

<style scoped>

</style>