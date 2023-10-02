"use strict";
(self["webpackChunk_coreui_coreui_free_vue_admin_template"] = self["webpackChunk_coreui_coreui_free_vue_admin_template"] || []).push([["resources_dashboard_views_role_RoleDetails_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/dashboard/views/role/RoleDetails.vue?vue&type=script&lang=js":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/dashboard/views/role/RoleDetails.vue?vue&type=script&lang=js ***!
  \************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "roleDetails",
  data: function data() {
    return {
      allPermissions: [],
      role: {
        data: {
          id: "",
          name: "",
          permissions: []
        },
        errors: []
      }
    };
  },
  methods: {
    // ================= start part update role =======================
    updateRole: function updateRole() {
      var _this = this;
      axios.put("/api/admin/role/update/" + this.role.data.id, this.role.data).then(function (result) {
        if (result.data.status == true) {
          Toast.fire({
            icon: "success",
            title: "تم تحديث بيانات الصلاحيه بنجاح"
          });
          _this.role.errors = {};
        } else if (result.data.status == null) {
          Toast.fire({
            icon: "error",
            title: result.data.error
          });
        } else {
          _this.role.errors = result.data.errors;
        }
      })["catch"](function (error) {
        Toast.fire({
          icon: "error",
          title: error
        });
      });
    },
    // ================= end part update role =======================
    // ================= start part get role  =======================
    getRole: function getRole() {
      var _this2 = this;
      axios.get("/api/admin/role/show/" + this.$route.params.id).then(function (res) {
        if (res.data.status == true) {
          _this2.role.data = res.data.role;
          _this2.role.data.permissions = res.data.role.permissions.map(function (ele) {
            return ele.name;
          });
        } else if (res.data.status == null) {
          Toast.fire({
            icon: "error",
            title: res.data.error
          });
        }
      })["catch"](function (error) {
        Toast.fire({
          icon: "error",
          title: error
        });
      });
    },
    // ================= end part get role  =======================
    // ================= start part get permisions with pagination =======================
    getPermissions: function getPermissions() {
      var _this3 = this;
      axios.get("/api/admin/permission/all?").then(function (res) {
        if (res.data.status == true) {
          _this3.allPermissions = res.data.permissions.map(function (ele) {
            return ele.name;
          });
        } else if (res.data.status == null) {
          Toast.fire({
            icon: "error",
            title: res.data.error
          });
        }
      })["catch"](function (error) {
        Toast.fire({
          icon: "error",
          title: error
        });
      });
    } // ================= end part get permisions with pagination =======================
  },
  created: function created() {
    this.getPermissions();
    this.getRole();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/dashboard/views/role/RoleDetails.vue?vue&type=template&id=4ac67a47":
/*!****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/dashboard/views/role/RoleDetails.vue?vue&type=template&id=4ac67a47 ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "role"
};
var _hoisted_2 = {
  "class": "row row-sm"
};
var _hoisted_3 = {
  "class": "col-xl-12"
};
var _hoisted_4 = {
  "class": "card mg-b-20"
};
var _hoisted_5 = {
  "class": "card-body"
};
var _hoisted_6 = {
  "class": "table-responsive"
};
var _hoisted_7 = {
  "class": "card-body"
};
var _hoisted_8 = {
  "class": "form-body"
};
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h4", {
  "class": "form-section"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "ft-home"
}), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" بيانات الصلاحيه ")], -1 /* HOISTED */);
var _hoisted_10 = {
  "class": "form-contole"
};
var _hoisted_11 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "form-controle"
}, "اسم الصلاحيه", -1 /* HOISTED */);
var _hoisted_12 = {
  key: 0,
  "class": "invalid-feedback"
};
var _hoisted_13 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("hr", null, null, -1 /* HOISTED */);
var _hoisted_14 = {
  "class": "form-contole"
};
var _hoisted_15 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "class": "form-controle"
}, "اذونات الصلاحيه", -1 /* HOISTED */);
var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("hr", null, null, -1 /* HOISTED */);
var _hoisted_17 = {
  "class": "row"
};
var _hoisted_18 = ["id", "value", "checked"];
var _hoisted_19 = ["for"];
var _hoisted_20 = {
  key: 0,
  "class": "invalid-feedback"
};
var _hoisted_21 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_22 = {
  "class": "form-actions"
};
var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "la la-check-square-o"
}, null, -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_SmartTable = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("SmartTable");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_SmartTable), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    "class": "form",
    onSupmit: _cache[3] || (_cache[3] = function (e) {
      return e.prroleDefault();
    })
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_8, [_hoisted_9, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [_hoisted_11, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    readonly: "",
    type: "text",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return _ctx.role.data.name = $event;
    }),
    "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)(['form-control', _ctx.role.errors.title ? 'is-invalid' : ''])
  }, null, 2 /* CLASS */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.role.data.name]]), _ctx.role.errors.title ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_12, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.role.errors.title[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), _hoisted_13, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [_hoisted_15, _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.allPermissions, function (permission, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
      key: index,
      "class": "col-md-3"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
      type: "checkbox",
      "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
        return _ctx.role.data.permissions = $event;
      }),
      id: index,
      value: permission,
      checked: _ctx.role.data.permissions.includes(permission) ? 'checked' : 'checked'
    }, null, 8 /* PROPS */, _hoisted_18), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, _ctx.role.data.permissions]]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
      "for": index
    }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(permission), 9 /* TEXT, PROPS */, _hoisted_19)]);
  }), 128 /* KEYED_FRAGMENT */))]), _ctx.role.errors.permissions ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.role.errors.permissions[0]), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])]), _hoisted_21, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "submit",
    "class": "btn btn-primary btn-block",
    onClick: _cache[2] || (_cache[2] = function () {
      return $options.updateRole && $options.updateRole.apply($options, arguments);
    })
  }, [_hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" حفظ ")])])], 32 /* HYDRATE_EVENTS */)])])])])])])]);
}

/***/ }),

/***/ "./resources/dashboard/views/role/RoleDetails.vue":
/*!********************************************************!*\
  !*** ./resources/dashboard/views/role/RoleDetails.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _RoleDetails_vue_vue_type_template_id_4ac67a47__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./RoleDetails.vue?vue&type=template&id=4ac67a47 */ "./resources/dashboard/views/role/RoleDetails.vue?vue&type=template&id=4ac67a47");
/* harmony import */ var _RoleDetails_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./RoleDetails.vue?vue&type=script&lang=js */ "./resources/dashboard/views/role/RoleDetails.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_projects_EtehadV2_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_projects_EtehadV2_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_RoleDetails_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_RoleDetails_vue_vue_type_template_id_4ac67a47__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/dashboard/views/role/RoleDetails.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/dashboard/views/role/RoleDetails.vue?vue&type=script&lang=js":
/*!********************************************************************************!*\
  !*** ./resources/dashboard/views/role/RoleDetails.vue?vue&type=script&lang=js ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_RoleDetails_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_RoleDetails_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./RoleDetails.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/dashboard/views/role/RoleDetails.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/dashboard/views/role/RoleDetails.vue?vue&type=template&id=4ac67a47":
/*!**************************************************************************************!*\
  !*** ./resources/dashboard/views/role/RoleDetails.vue?vue&type=template&id=4ac67a47 ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_RoleDetails_vue_vue_type_template_id_4ac67a47__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_RoleDetails_vue_vue_type_template_id_4ac67a47__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./RoleDetails.vue?vue&type=template&id=4ac67a47 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/dashboard/views/role/RoleDetails.vue?vue&type=template&id=4ac67a47");


/***/ })

}]);