
import Vue from './elements';


export default class PluginRunTwoCard {
    constructor() {
        this.Vue = Vue;
        this.ajaxCommonAction = "plugin_run_two_card";
    }
    $get(options) {
        if(!options.action){
            options.action = "plugin_run_two_card";
        }
        return window.jQuery.get(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        if(!options.action){
            options.action = "plugin_run_two_card";
        }
        return window.jQuery.get(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        if(!options.action){
            options.action = "plugin_run_two_card";
        }
        return window.jQuery.post(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $getJSON(options) {
        if(!options.action){
            options.action = "plugin_run_two_card";
        }
        return window.jQuery.getJSON(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $post(options) {
        if(!options.action){
            options.action = "plugin_run_two_card";
        }
        return window.jQuery.post(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }
}


