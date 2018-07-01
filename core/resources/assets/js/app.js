
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    mounted() {
      //do something after creating vue instance
      Echo.private('chatChannel')
          .listen('NewMessagePosted', (e) => {
              // console.log(e);
              $("#AllMessagesContainer").load(location.href + " #AllMessagesContainer", function() {
                var elem = document.getElementById('AllMessages');
                elem.scrollTop = elem.scrollHeight;
              });
              $("#ChatBoxScrollableDivContainer").load(location.href + " #ChatBoxScrollableDivContainer", function() {
                var elem = document.getElementById('chatBoxContainer');
                elem.scrollTop = elem.scrollHeight;
              });
          });
    }
});

// const appSellerToBuyer = new Vue({
//     el: '#appSellerToBuyer',
//     created() {
//       //do something after creating vue instance
//       Echo.private('chatChannel')
//           .listen('NewMessagePosted', (e) => {
//               console.log(e);
//           });
//     }
// });
