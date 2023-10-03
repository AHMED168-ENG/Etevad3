import { createStore } from "vuex";
import router from "../router/index";
export default createStore({
  state: {
    AdminToken: "",
    isAdminLogin: false,
    Admin: {},
    permissions: [],
    seting: {},
  },
  getters: {
    // start admin part
    getSeting(state) {
      return state.seting;
    },
    getAdminTocken(state) {
      return state.AdminToken;
    },
    getAdminData(state) {
      return state.Admin;
    },
    getPermissionsData(state) {
      return state.permissions;
    },
    isAdminLogin(state) {
      return state.isAdminLogin;
    },
    // end admin part
  },
  mutations: {
    // start admin part
    async login(state, payload) {
      state.AdminToken = payload.access_token;
      axios.defaults.headers.common[
        "Authorization"
      ] = `Bearer ${payload.access_token}`;
      window.localStorage.setItem("AdminToken", payload.access_token);
      state.isAdminLogin = true;
      state.Admin = payload.data.user;
      state.permissions = payload.data.permissions;
    },
    async setSeting(state, payload) {
      state.seting = payload.seting;
    },
    logout(state) {
      state.AdminToken = "";
      window.localStorage.removeItem("AdminToken");
      state.isAdminLogin = false;
      state.Admin = {};
      state.permissions = [];
    },
    // end admin part
    toggleSidebar(state) {
      state.sidebarVisible = !state.sidebarVisible;
    },
    toggleUnfoldable(state) {
      state.sidebarUnfoldable = !state.sidebarUnfoldable;
    },
    updateSidebarVisible(state, payload) {
      state.sidebarVisible = payload.value;
    },
  },
  actions: {},
  modules: {},
});
