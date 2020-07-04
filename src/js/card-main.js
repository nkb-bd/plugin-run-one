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
