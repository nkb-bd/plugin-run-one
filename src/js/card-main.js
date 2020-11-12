import Vue from './elements';
import Router from 'vue-router';


import PluginRunTwoCard from './card-ajax-connector';


window.PluginOneCardClass = new PluginRunTwoCard();


window.PluginRunTwoCard = new window.PluginOneCardClass.Vue();


window.PluginOneCardClass.Vue.mixin({
  methods: {
    // $get: window.PluginRunTwoCard.$get,
    $adminGet: window.PluginOneCardClass.$adminGet,
    $adminPost: window.PluginOneCardClass.$adminPost,
    // $post: window.PluginRunTwoCard.$post,
    $showAjaxError(error) {
      console.log(error)
      if(error.responseJSON && error.responseJSON.message) {
        this.$notify.error(error.responseJSON.message);
      } else if(error.responseText) {
        this.$notify.error(error.responseText);
      }  else if(error.data.response) {
        this.$notify.error(error.data.response);
      } else {
        this.$notify.error('Something is wrong when doing ajax request! Please try again');
      }
    },

  }
});

import AdminApp from './AdminApp'


Vue.use(Router);

import {routes} from './routes'

const router = new Router({
  routes: routes,
  linkActiveClass: 'active'
});


if(document.getElementById("onecardapp")) {
  new Vue({
    el: '#onecardapp',
    render: h => h(AdminApp),
    router: router
  })

}
