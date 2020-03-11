
import Vue from './elements';


export default class PluginRunOneCard {
    constructor() {
        this.Vue = Vue;
        this.ajaxCommonAction = "plugin_run_one_card";
    }
    $get(options) {
        options.action = "plugin_run_one_card";
        return window.jQuery.get(window.pluginRunOneCardAdmin.ajaxurl, options);
    }

    $adminGet(options) {
        options.action = "plugin_run_one_card";
        return window.jQuery.get(window.pluginRunOneCardAdmin.ajaxurl, options);
    }

    $adminPost(options) {
        options.action = "plugin_run_one_card";
        return window.jQuery.post(window.pluginRunOneCardAdmin.ajaxurl, options);
    }

    $getJSON(options) {
        options.action = "plugin_run_one_card";
        return window.jQuery.getJSON(window.pluginRunOneCardAdmin.ajaxurl, options);
    }

    $post(options) {
        options.action = "plugin_run_one_card";
        return window.jQuery.post(window.pluginRunOneCardAdmin.ajaxurl, options);
    }
}


