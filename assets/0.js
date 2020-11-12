(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./src/js/pages/EditGrid.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_card_templates_post_template_grid_1__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/card/templates/post_template_grid_1 */ "./src/js/components/card/templates/post_template_grid_1.vue");
var _methods;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'PostForm',
  props: ['edit', 'id'],
  data: function data() {
    return {
      activeNames: 1,
      postData: '',
      componentKey: true,
      formattedPostCount: 0,
      html_data: '',
      loadingPreview: true,
      layoutType: [{
        label: 'List',
        value: 'list'
      }, {
        label: 'Grid',
        value: 'grid'
      }, {
        label: 'Masonary',
        value: 'masonary',
        disabled: true
      }, {
        label: 'Carousel',
        value: 'carousel',
        disabled: true
      }],
      gridSource: [{
        label: 'Post',
        value: 'post'
      }, {
        label: 'Fluent Form',
        value: 'fluent-from'
      }, {
        label: 'Ninja Table',
        value: 'ninja-table'
      }],
      gridNameDialogVisible: false,
      saved: false,
      saving: false,
      formData: {
        grid_source: 'post',
        grid_template: 'template-one',
        grid_name: 'New Grid',
        postType: 'post',
        columnNumber: '4',
        content_limit: 4,
        taxonomy: '',
        type: '',
        img_status: true,
        view: 'grid',
        limit: 4,
        bgColor: '#f56c6c',
        fontColor: '#fff',
        id: this.id,
        content_align: 'center',
        item_border_radius: 0,
        button_text: 'Read more',
        button_newtab: false,
        button_status: true
      },
      allPostType: [],
      allCategory: [],
      allTaxonomies: [],
      rules: {
        cardName: [{
          required: true,
          message: 'Please input Card Name',
          trigger: 'blur'
        }],
        postType: [{
          required: true,
          message: 'Please Select Post Type',
          trigger: 'blur'
        }],
        category: [{
          required: false,
          message: 'Please Select category',
          trigger: 'blur'
        }],
        taxonomy: [{
          required: false,
          message: 'Please Select taxonomy',
          trigger: 'blur'
        }],
        cardImage: [{
          required: true,
          message: 'Please Select image type',
          trigger: 'blur'
        }],
        limit: [{
          required: true,
          message: 'Please Select card maximum card number',
          trigger: 'blur'
        }],
        view: [{
          required: true,
          message: 'Please Select view',
          trigger: 'blur'
        }]
      }
    };
  },
  methods: (_methods = {
    submit: function submit(formName) {
      var _this = this;

      this.$refs[formName].validate(function (valid) {
        if (valid) {
          _this.submitForm(formName);
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    getPostData: function getPostData() {
      var _this2 = this;

      // get post type data
      this.$adminGet({
        route: "get_post_data"
      }).then(function (data) {
        data.data = data.data.data;
        _this2.allPostType = data.data.post_types;
        _this2.allCategory = data.data.categories;
      });
    },
    getEditCardData: function getEditCardData($id) {
      var _this3 = this;

      return;
      this.$adminPost({
        route: "get_post_data_by_id",
        card_id: $id
      }).then(function (res) {
        var data = res.data.data;
        _this3.formData.cardName = data.card_name;
        _this3.formData.limit = parseInt(data.limit);
        var post_settings = JSON.parse(data.basicSettings);
        _this3.formData.postType = post_settings.post_type;
        _this3.formData.taxonomy = post_settings.taxonomies;
        _this3.formData.category_id = post_settings.category;
        _this3.formData.limit = parseInt(post_settings.limit);
        _this3.formData.cardImage = post_settings.cardImage;
        _this3.formData.color = post_settings.color;
        _this3.formData.view = post_settings.view;
      });
    },
    fetchWpPostData: function fetchWpPostData() {
      this.fetchTaxtonomy();
      this.fetchWpPostData();
      this.generateCSS();
    },
    fetchTaxtonomy: function fetchTaxtonomy() {
      var _this4 = this;

      this.$adminPost({
        route: "get_taxonomies",
        data: this.formData.postType
      }).then(function (data) {
        _this4.allTaxonomies = data.data.data;
      });
    }
  }, _defineProperty(_methods, "fetchWpPostData", function fetchWpPostData() {
    var _this5 = this;

    this.loadingPreview = true; // get all wp posts

    this.$adminGet({
      data: this.formData,
      action: 'plugin_run_two_grid',
      route: "get_wp_posts"
    }).then(function (res) {
      _this5.postData = res.data;
      console.log(res.data); // this.$emit('updated', '1')
    }).always(function () {
      _this5.loadingPreview = false;
      _this5.componentKey = !_this5.componentKey;
    });
  }), _defineProperty(_methods, "submitForm", function submitForm(formName) {
    var _this6 = this;

    this.saving = true;
    this.$adminPost({
      data: this.formData,
      action: 'plugin_run_two_grid',
      route: "update_card"
    }).then(function (res) {
      if (res.success == false) {
        _this6.$showAjaxError(res.response);
      }

      if (!_this6.saved) {
        _this6.formData.id = res.data.insert_id;
        _this6.saved = true;
      }

      if (res.data.insert_id) {
        _this6.success('New Card "' + _this6.formData.grid_name + '" Saved', 'success');
      } else {
        console.log(_this6.id);
        console.log('edit');

        _this6.success('Card "' + _this6.formData.grid_name + '"  Updated', 'success');
      } //this.$emit('updated', '1')

    }).always(function () {
      _this6.saving = false;
    });
  }), _defineProperty(_methods, "resetForm", function resetForm(formName) {
    this.$refs[formName].resetFields();
  }), _defineProperty(_methods, "success", function success(message, type) {
    this.$notify({
      showClose: true,
      message: message,
      type: type,
      offset: 40
    });
  }), _defineProperty(_methods, "generateCSS", function generateCSS() {
    // let [header, ribbon, features, footer, price, border] = styleVars;
    var width,
        displayForList,
        innerDisplayForList = '';

    if (this.formData.view == 'list') {
      width = '100%';
      displayForList = 'display: flex;';
      innerDisplayForList = '.wp-cc-grid-content{flex:2;} .wp-cc-grid-image {flex:1}';
    } else if (this.formData.view == 'grid' || this.formData.view == 'carousel') {
      width = 100 / this.formData.columnNumber + '%';
      displayForList = '';
      innerDisplayForList = '';
    }

    console.log(width);
    console.log(this.formData.view);
    var css = "\n            ".concat(innerDisplayForList, "\n            .wp-cc-grid-item{\n                  width: ").concat(width, ";\n                   text-align: ").concat(this.formData.content_align, ";\n\n            }\n\n            .wp-cc-grid-div{\n                  background-color: ").concat(this.formData.bgColor, ";\n                   ").concat(displayForList, "\n                   border-radius: ").concat(this.formData.item_border_radius, "px;\n                    overflow:hidden;\n            }\n            .wp-cc-grid-title,.wp-cc-grid-text,.wp-cc-grid-content,.wp-cc-grid a {\n                color: ").concat(this.formData.fontColor, "\n            }\n             .wp-cc-grid  .btn {\n                 border: 1px solid ").concat(this.formData.fontColor, ";\n             }\n             .cc-hover-zoom:hover .wp-cc-grid-image img{\n\n                   transition: transform 0.5s ease;transform: scale(1.35);\n            }\n\n             ");
    jQuery('#plugin_run_one_admin_dynamic_style').html(css);
  }), _defineProperty(_methods, "getNewGridKey", function getNewGridKey() {
    var _this7 = this;

    // get all ninja table data
    this.$adminGet({
      action: 'plugin_run_two_grid',
      route: "get_new_grid_key"
    }).then(function (res) {
      _this7.new_grid_key = res.data.id;
      _this7.formData.grid_name = 'New Grid #' + res.data.id;
    }).fail(function (error) {
      _this7.$showAjaxError(error);
    });
  }), _defineProperty(_methods, "refreshComponent", function refreshComponent() {
    this.componentKey = !this.componentKey;
  }), _methods),
  mounted: function mounted() {
    this.fetchWpPostData();
    this.getPostData();
    this.generateCSS();

    if (this.edit) {
      this.getEditCardData(this.id);
    }

    this.getNewGridKey();
  },
  computed: {
    formattedPostData: function formattedPostData() {
      var _this8 = this;

      var data = this.postData;
      var post_type = this.formData.postType;
      var total = 0;

      if (!data) {
        return [];
      }

      return data.filter(function (x) {
        if (x.post_type == post_type) {
          total++;
          _this8.formattedPostCount = total;
          return x;
        }
      });
    }
  },
  components: {
    post_template_grid_1: _components_card_templates_post_template_grid_1__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  watch: {
    id: function id(newVal, oldVal) {
      // watch it
      this.formData.id = newVal;
      this.getEditCardData(newVal);
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.cc-main-section-inner{\n    padding: 20px;\n}\n.cc-grid-settings{\n    max-width: 25%;\n    position: absolute;\n    right: 0px;\n    top: 0px;\n    min-height: 500px;\n\n    border: 1px solid #fff;\n}\n.cc-grid-settings, .el-collapse-item__header, .el-collapse-item__content{\n    background-color: #545c63;\n    color:#fff;\n}\n.cc-grid-settings  .el-input--suffix .el-input__inner {\n    background-color: white;\n}\n.cc-grid-settings .el-radio.is-bordered{\n    background: white;\n    width:100%;\n    margin-left: 0px!important;\n}\n.cc_section_actions{\n    display: flex;\n    align-items: center;\n}\n.cc_one_section_header{\n    display: flex;\n    align-items: center;\n    padding: 10px 15px;}\n.cc-preview-section{\n}\n.cc-preview-section{\n    max-height: 800px;\n    min-height: 400px;\n    overflow:auto;\n}\n.cc-main-section-body{\n    min-height: 100vh;\n}\n\n/* Overwrite the default to keep the scrollbar always visible */\n::-webkit-scrollbar {\n    -webkit-appearance: none;\n    width: 7px;\n}\n::-webkit-scrollbar-thumb {\n    border-radius: 4px;\n    background-color: rgba(0,0,0,.5);\n    -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);\n}\n\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../node_modules/css-loader??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./EditGrid.vue?vue&type=style&index=0&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=template&id=11bb00f8&":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./src/js/pages/EditGrid.vue?vue&type=template&id=11bb00f8& ***!
  \************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {},
    [
      _c("div", { staticClass: "cc_one_section_header" }, [
        _c("div", { staticClass: "cc_one_section_title" }, [
          _c(
            "div",
            { staticClass: "cc_section_actions" },
            [
              _vm._v(
                "\n                " +
                  _vm._s(_vm.formData.grid_name) +
                  "\n                "
              ),
              _c(
                "i",
                {
                  staticClass: "el-icon-edit",
                  staticStyle: { cursor: "pointer" },
                  on: {
                    click: function($event) {
                      _vm.gridNameDialogVisible = true
                    }
                  }
                },
                [_vm._v("\n                    Edit\n                ")]
              ),
              _vm._v(" "),
              _c(
                "el-dialog",
                {
                  attrs: {
                    title: "Grid Name",
                    visible: _vm.gridNameDialogVisible,
                    width: "30%"
                  },
                  on: {
                    "update:visible": function($event) {
                      _vm.gridNameDialogVisible = $event
                    }
                  }
                },
                [
                  _c("el-input", {
                    model: {
                      value: _vm.formData.grid_name,
                      callback: function($$v) {
                        _vm.$set(_vm.formData, "grid_name", $$v)
                      },
                      expression: "formData.grid_name"
                    }
                  }),
                  _vm._v(" "),
                  _c(
                    "span",
                    {
                      staticClass: "dialog-footer",
                      attrs: { slot: "footer" },
                      slot: "footer"
                    },
                    [
                      _c(
                        "el-button",
                        {
                          attrs: { type: "primary" },
                          on: {
                            click: function($event) {
                              _vm.gridNameDialogVisible = false
                            }
                          }
                        },
                        [_vm._v("Update")]
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "cc_one_section_actions" },
          [
            _c(
              "router-link",
              { attrs: { to: "/card_manager/card_list" } },
              [
                _c("el-button", { attrs: { size: "mini", type: "default" } }, [
                  _vm._v("\n                    Back\n                ")
                ])
              ],
              1
            )
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "cc_one_section_actions" },
          [
            _c(
              "el-button",
              {
                attrs: { size: "mini", loading: _vm.saving, type: "primary" },
                on: {
                  click: function($event) {
                    return _vm.submit("formData")
                  }
                }
              },
              [_vm._v("\n                Submit\n            ")]
            )
          ],
          1
        )
      ]),
      _vm._v(" "),
      _c(
        "el-row",
        [
          _c("el-col", { staticClass: "cc-main-section-body" }, [
            _c(
              "div",
              {
                directives: [
                  {
                    name: "loading",
                    rawName: "v-loading",
                    value: _vm.loadingPreview,
                    expression: "loadingPreview"
                  }
                ],
                staticClass: " cc-preview-section"
              },
              [
                _c("post_template_grid_1", {
                  key: _vm.componentKey,
                  tag: "component",
                  attrs: {
                    postData: _vm.formattedPostData,
                    layoutData: _vm.formData
                  }
                })
              ],
              1
            )
          ]),
          _vm._v(" "),
          _c(
            "el-col",
            { staticClass: "cc-grid-settings cc-main-section-inner" },
            [
              _c(
                "div",
                {},
                [
                  _c(
                    "el-form",
                    {
                      ref: "formData",
                      staticClass: "cc-formdata",
                      attrs: {
                        model: _vm.formData,
                        rules: _vm.rules,
                        "label-width": "140px"
                      }
                    },
                    [
                      _c(
                        "el-collapse",
                        {
                          on: { change: function($event) {} },
                          model: {
                            value: _vm.activeNames,
                            callback: function($$v) {
                              _vm.activeNames = $$v
                            },
                            expression: "activeNames"
                          }
                        },
                        [
                          _c(
                            "el-collapse-item",
                            { attrs: { title: "Post Type", name: "1" } },
                            [
                              _c(
                                "div",
                                [
                                  _c(
                                    "el-select",
                                    {
                                      attrs: { placeholder: "Select" },
                                      on: { change: _vm.fetchWpPostData },
                                      model: {
                                        value: _vm.formData.postType,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "postType",
                                            $$v
                                          )
                                        },
                                        expression: "formData.postType"
                                      }
                                    },
                                    _vm._l(_vm.allPostType, function(item) {
                                      return _c("el-option", {
                                        key: item.name,
                                        attrs: {
                                          label: item.singular_name,
                                          value: item.name
                                        }
                                      })
                                    }),
                                    1
                                  )
                                ],
                                1
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-collapse-item",
                            { attrs: { title: "Category", name: "2" } },
                            [
                              _c(
                                "div",
                                [
                                  _c(
                                    "el-select",
                                    {
                                      attrs: {
                                        multiple: "",
                                        placeholder: "Select"
                                      },
                                      on: { change: _vm.fetchWpPostData },
                                      model: {
                                        value: _vm.formData.category,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "category",
                                            $$v
                                          )
                                        },
                                        expression: "formData.category"
                                      }
                                    },
                                    _vm._l(_vm.allCategory, function(item) {
                                      return _c("el-option", {
                                        key: item.category_id,
                                        attrs: {
                                          label: item.category_name,
                                          value: item.category_id
                                        }
                                      })
                                    }),
                                    1
                                  )
                                ],
                                1
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-collapse-item",
                            { attrs: { title: "Taxonomy", name: "3" } },
                            [
                              _c(
                                "div",
                                [
                                  _c(
                                    "el-select",
                                    {
                                      attrs: { placeholder: "Select" },
                                      model: {
                                        value: _vm.formData.taxonomy,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "taxonomy",
                                            $$v
                                          )
                                        },
                                        expression: "formData.taxonomy"
                                      }
                                    },
                                    _vm._l(_vm.allTaxonomies, function(item) {
                                      return _c("el-option", {
                                        key: item.name,
                                        attrs: {
                                          label: item.label,
                                          value: item.name
                                        }
                                      })
                                    }),
                                    1
                                  )
                                ],
                                1
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-collapse-item",
                            { attrs: { title: "Image", name: "4" } },
                            [
                              _c(
                                "div",
                                [
                                  _c("p", [_vm._v("Featured Image")]),
                                  _vm._v(" "),
                                  _c(
                                    "el-switch",
                                    {
                                      attrs: { label: "Show", border: "" },
                                      on: { change: _vm.refreshComponent },
                                      model: {
                                        value: _vm.formData.img_status,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "img_status",
                                            $$v
                                          )
                                        },
                                        expression: "formData.img_status"
                                      }
                                    },
                                    [_vm._v("Show")]
                                  )
                                ],
                                1
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-collapse-item",
                            { attrs: { title: "Button", name: "5" } },
                            [
                              _c(
                                "div",
                                [
                                  _c("p", [_vm._v("Button Text")]),
                                  _vm._v(" "),
                                  _c("el-input", {
                                    attrs: { type: "text" },
                                    on: { change: _vm.refreshComponent },
                                    model: {
                                      value: _vm.formData.button_text,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.formData,
                                          "button_text",
                                          $$v
                                        )
                                      },
                                      expression: "formData.button_text"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Show")]),
                                  _vm._v(" "),
                                  _c(
                                    "el-switch",
                                    {
                                      attrs: { label: "Show", border: "" },
                                      on: { change: _vm.refreshComponent },
                                      model: {
                                        value: _vm.formData.button_status,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "button_status",
                                            $$v
                                          )
                                        },
                                        expression: "formData.button_status"
                                      }
                                    },
                                    [_vm._v("Show")]
                                  ),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Open in New Tab")]),
                                  _vm._v(" "),
                                  _c(
                                    "el-checkbox",
                                    {
                                      model: {
                                        value: _vm.formData.button_newtab,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "button_newtab",
                                            $$v
                                          )
                                        },
                                        expression: "formData.button_newtab"
                                      }
                                    },
                                    [_vm._v("Yes")]
                                  )
                                ],
                                1
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "el-collapse-item",
                            { attrs: { title: "Layout", name: "5" } },
                            [
                              _c(
                                "div",
                                [
                                  _c("p", [_vm._v("Layout Type")]),
                                  _vm._v(" "),
                                  _c(
                                    "el-select",
                                    {
                                      attrs: { placeholder: "Select" },
                                      on: { change: _vm.generateCSS },
                                      model: {
                                        value: _vm.formData.view,
                                        callback: function($$v) {
                                          _vm.$set(_vm.formData, "view", $$v)
                                        },
                                        expression: "formData.view"
                                      }
                                    },
                                    _vm._l(_vm.layoutType, function(item) {
                                      return _c("el-option", {
                                        key: item.value,
                                        attrs: {
                                          label: item.label,
                                          disabled: item.disabled,
                                          value: item.value
                                        }
                                      })
                                    }),
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Column")]),
                                  _vm._v(" "),
                                  _c(
                                    "el-select",
                                    {
                                      attrs: { placeholder: "Select" },
                                      on: { change: _vm.generateCSS },
                                      model: {
                                        value: _vm.formData.columnNumber,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "columnNumber",
                                            $$v
                                          )
                                        },
                                        expression: "formData.columnNumber"
                                      }
                                    },
                                    [
                                      _c("el-option", {
                                        key: "1",
                                        attrs: { label: "1", value: "1" }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        key: "2",
                                        attrs: { label: "2", value: "2" }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        key: "3",
                                        attrs: { label: "3", value: "3" }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        key: "4",
                                        attrs: { label: "4", value: "4" }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Limit")]),
                                  _vm._v(" "),
                                  _c("el-input", {
                                    attrs: { type: "number", min: 1 },
                                    on: { change: _vm.fetchWpPostData },
                                    model: {
                                      value: _vm.formData.content_limit,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.formData,
                                          "content_limit",
                                          $$v
                                        )
                                      },
                                      expression: "formData.content_limit"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Background Color")]),
                                  _vm._v(" "),
                                  _c("el-color-picker", {
                                    on: { change: _vm.generateCSS },
                                    model: {
                                      value: _vm.formData.bgColor,
                                      callback: function($$v) {
                                        _vm.$set(_vm.formData, "bgColor", $$v)
                                      },
                                      expression: "formData.bgColor"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Font Color")]),
                                  _vm._v(" "),
                                  _c("el-color-picker", {
                                    on: { change: _vm.generateCSS },
                                    model: {
                                      value: _vm.formData.fontColor,
                                      callback: function($$v) {
                                        _vm.$set(_vm.formData, "fontColor", $$v)
                                      },
                                      expression: "formData.fontColor"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Align")]),
                                  _vm._v(" "),
                                  _c(
                                    "el-select",
                                    {
                                      attrs: { placeholder: "Select" },
                                      on: { change: _vm.generateCSS },
                                      model: {
                                        value: _vm.formData.content_align,
                                        callback: function($$v) {
                                          _vm.$set(
                                            _vm.formData,
                                            "content_align",
                                            $$v
                                          )
                                        },
                                        expression: "formData.content_align"
                                      }
                                    },
                                    [
                                      _c("el-option", {
                                        attrs: { label: "Left", value: "left" }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        attrs: {
                                          label: "Center",
                                          value: "center"
                                        }
                                      }),
                                      _vm._v(" "),
                                      _c("el-option", {
                                        attrs: {
                                          label: "Right",
                                          value: "right"
                                        }
                                      })
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("p", [_vm._v("Border Radius")]),
                                  _vm._v(" "),
                                  _c("el-input", {
                                    attrs: { type: "number", min: 0 },
                                    on: { change: _vm.generateCSS },
                                    model: {
                                      value: _vm.formData.item_border_radius,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.formData,
                                          "item_border_radius",
                                          $$v
                                        )
                                      },
                                      expression: "formData.item_border_radius"
                                    }
                                  })
                                ],
                                1
                              )
                            ]
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ]
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./src/js/pages/EditGrid.vue":
/*!***********************************!*\
  !*** ./src/js/pages/EditGrid.vue ***!
  \***********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _EditGrid_vue_vue_type_template_id_11bb00f8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditGrid.vue?vue&type=template&id=11bb00f8& */ "./src/js/pages/EditGrid.vue?vue&type=template&id=11bb00f8&");
/* harmony import */ var _EditGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditGrid.vue?vue&type=script&lang=js& */ "./src/js/pages/EditGrid.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./EditGrid.vue?vue&type=style&index=0&lang=css& */ "./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _EditGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditGrid_vue_vue_type_template_id_11bb00f8___WEBPACK_IMPORTED_MODULE_0__["render"],
  _EditGrid_vue_vue_type_template_id_11bb00f8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "src/js/pages/EditGrid.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./src/js/pages/EditGrid.vue?vue&type=script&lang=js&":
/*!************************************************************!*\
  !*** ./src/js/pages/EditGrid.vue?vue&type=script&lang=js& ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./EditGrid.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css&":
/*!********************************************************************!*\
  !*** ./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css& ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader!../../../node_modules/css-loader??ref--7-1!../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../node_modules/postcss-loader/src??ref--7-2!../../../node_modules/vue-loader/lib??vue-loader-options!./EditGrid.vue?vue&type=style&index=0&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=style&index=0&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_style_index_0_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./src/js/pages/EditGrid.vue?vue&type=template&id=11bb00f8&":
/*!******************************************************************!*\
  !*** ./src/js/pages/EditGrid.vue?vue&type=template&id=11bb00f8& ***!
  \******************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_template_id_11bb00f8___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./EditGrid.vue?vue&type=template&id=11bb00f8& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./src/js/pages/EditGrid.vue?vue&type=template&id=11bb00f8&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_template_id_11bb00f8___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditGrid_vue_vue_type_template_id_11bb00f8___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);