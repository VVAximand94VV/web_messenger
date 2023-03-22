//import { useI18n } from 'vue-i18n';
//let locale = useI18n();

export  default {

    actions:{
        changeSidebar({dispatch}){
          const sidebar = document.querySelector('.sidebar');
          const main = document.querySelector('.main');

          sidebar.classList.toggle('active-sidebar');
          main.classList.toggle('blur');
        },

        changeChatlist({dispatch}){
          const elem = document.querySelector('#chatbox');
          elem.classList.toggle('showbox')
        }, 

        changeTheme({dispatch},payload){
          //let theme = payload ? 'dark':'light';
          localStorage.setItem('theme', payload);
          const app = document.querySelector('#app');
          app.className = payload;
      },

      changeLanguage(event){
        let lang = event.target.value
        // locale
        //this.locale = lang
        localStorage.setItem('lang-locale', lang)
      }
    },
}