import { createApp } from "vue";
import App from "../App.vue";
import DashboardRouter from "../dashboard/router/index";
import store from "../dashboard/store";
import CoreuiVue from "@coreui/vue";
import CIcon from "@coreui/icons-vue";
import { iconsSet as icons } from "../dashboard/assets/icons";
import DocsExample from "../dashboard/components/DocsExample.vue";
import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment";
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
import CKEditor from "@ckeditor/ckeditor5-vue";

window.Swal = Swal;
window.Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

window.axios = axios;
window.moment = moment;
const app = createApp(App);
app.component("VPagination", VPagination);
app.use(store);
app.use(DashboardRouter);
app.use(CKEditor);
app.use(CoreuiVue);
app.provide("icons", icons);
app.component("CIcon", CIcon);
app.component("DocsExample", DocsExample);

app.mount("#app");
