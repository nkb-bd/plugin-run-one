
import Vue from './elements';


export default class PluginRunTwoCard {
    constructor() {
        this.Vue = Vue;
        this.ajaxCommonAction = "plugin_run_two_card";
    }
    $get(options) {
        options.action = "plugin_run_two_card";
        return window.jQuery.get(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        options.action = "plugin_run_two_card";
        return window.jQuery.get(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = "plugin_run_two_card";
        return window.jQuery.post(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $getJSON(options) {
        options.action = "plugin_run_two_card";
        return window.jQuery.getJSON(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }

    $post(options) {
        options.action = "plugin_run_two_card";
        return window.jQuery.post(window.PluginRunTwoCardAdmin.ajaxurl, options);
    }
}


