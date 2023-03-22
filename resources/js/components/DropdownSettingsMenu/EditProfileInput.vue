<template>
    <div class="mb-1 row d-flex flex-row">
        <div class="col-6">
            <i :class="`fas ${icon} icon`"  style="font-size: 1.2em"></i> <label :for="fieldKey" class="form-label">{{ label }}</label>
        </div>
        <div class="col-6 d-flex flex-row" @focusin="switchUpdBtn">
            <div class="d-flex flex-row">
                <input :type="type"  class="form-control-plaintext" :id="fieldKey" v-model.trim="fieldValue">
                <span :id="`upd-${fieldKey}-btn`" class="upd-btns">
                    <i class="fas fa-save upd-btn mx-2" role="button" @click.prevent="updateProfile"></i>
                    <i class="fas fa-window-close upd-btn" style="font-size: 1.2em" @click.prevent="switchUpdBtn"></i>
                </span>

            </div>
        </div>
    </div>
</template>

<script>
import {useToast} from "vue-toastification";

export default {
    name: "EditProfileInput",

    props:['icon', 'label', 'id', 'type', 'value'],

    setup(){
        return{
            t$: useToast()
        }
    },

    data(){
        return{
            fieldKey: this.id,
            fieldValue: this.value,
            user: JSON.parse(localStorage.getItem('user_info')),

        }
    },

    methods:{
        updateProfile(){
            const elem = document.querySelector(`#upd-${this.id}-btn`);
            elem.classList.remove('show');
            const data = new FormData();
            data.append(this.fieldKey, this.fieldValue)

            // for(let [key, value] of data) {
            //     console.log(`${key} = ${value}`);
            // }

            let id = JSON.parse(localStorage.getItem('user_info')).id;
            axios.post(`/api/client/profile/${id}/profile-update`,
                data, {
                headers:{
                    Authorization: `Bearer ${localStorage.getItem('X-XSRF-TOKEN')}`
                }
            })
                .then(res => {
                    //console.log(res);
                    this.t$.success(res.data.message);
                    localStorage.setItem('user_info', JSON.stringify(res.data.userInfo));
                
                })
                .catch(error => {
                    console.log(error);
                    this.t$.error(res.data.message ?? 'Error!');
                })
        },

        switchUpdBtn(){
            const elem = document.querySelector(`#upd-${this.id}-btn`);
            elem.classList.toggle('show');
        },

        hideBtn(){
            const elem = document.querySelector(`#upd-${this.id}-btn`);
            elem.classList.toggle('show');
        }
    },

    watch:{

    },
}
</script>

<style scoped>

.upd-btns{
    display: none;
}

.upd-btn{
    display: flex;
    font-size: 1.2em;
}
.show{
    display: flex;
    align-items: center;
}


</style>
