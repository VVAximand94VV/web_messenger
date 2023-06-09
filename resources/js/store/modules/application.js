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
          if(payload == null){
              payload = false;
          }
          localStorage.setItem('theme', payload);
          const app = document.querySelector('#app');
          app.className = payload;
        },

        changeChatBb({dispatch}, bg){
            if(bg == null){
                bg = 'default-bg.jpg';
            }
            localStorage.setItem('chat-bg-img', bg);
            const chat = document.querySelector('.default-chat-area');
            chat.style.setProperty('--chat-bg', `repeat url('/resources/js/assets/image/chat/background/${bg}')`);
        },

        changeColorStyle({dispatch}, color){
            if(color == null){
                color = 'blue';
            }
          localStorage.setItem('color-them', color);
          const elements = document.querySelectorAll('.default-chat-area, .chat-lists');
          elements.forEach(elem => {
              elem.style.setProperty('--dynamic-color-style', color);
          });
        },

          changeLanguage(event){
            let lang = event.target.value
            // locale
            //this.locale = lang
            localStorage.setItem('lang-locale', lang)
          },

          scrollToBottom({dispatch}){
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight
            })
          }
    },
}
