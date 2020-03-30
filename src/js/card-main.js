import Vue from './elements';
import Router from 'vue-router';


import PluginRunOneCard from './card-ajax-connector';


window.PluginOneCardClass = new PluginRunOneCard();


window.PluginRunOneCard = new window.PluginOneCardClass.Vue();


window.PluginOneCardClass.Vue.mixin({
  methods: {
    // $get: window.PluginRunOneCard.$get,
    $adminGet: window.PluginOneCardClass.$adminGet,
    $adminPost: window.PluginOneCardClass.$adminPost,
    // $post: window.PluginRunOneCard.$post,

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
