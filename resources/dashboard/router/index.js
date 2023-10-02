import { h, resolveComponent } from "vue";
import { createRouter, createWebHashHistory } from "vue-router";
import store from "../store/index";
import DefaultLayout from "../layouts/DefaultLayout";
// this part about front end
import Home from "../../sit/views/HomeView.vue";
import About from "../../sit/views/AboutView.vue";
import Reports from "../../sit/views/ReportsView.vue";
import Achievemnet from "../../sit/views/AchieVemnet.vue";
import Action from "../../sit/views/ActionView.vue";
import Contact from "../../sit/views/ContactView.vue";
import Motivate from "../../sit/views/MotivateView.vue";
import News from "../../sit/views/NewsView.vue";
import Event from "../../sit/views/EventView.vue";
import Heroes from "../../sit/views/HeroesView.vue";
const routes = [
  {
    path: "/dashboard/login",
    name: "تسجيل الدخول",
    component: () => import("../views/auth/Login.vue"),
    beforeEnter: (to, from, next) => {
      if (!store.getters.isAdminLogin) {
        next();
      }
      next({ name: "الرئيسيه" });
    },
  },
  {
    path: "/dashboard",
    name: "الرئيسيه",
    component: DefaultLayout,
    children: [
      {
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("لوحه التحكم")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        path: "",
        name: "لوحه التحكم",
        component: () =>
          import(/* webpackChunkName: "dashboard" */ "../views/Dashboard.vue"),
      },
      // ***************************************** END PERMISSIONS PART ***********************************

      {
        path: "permission",
        name: "الاذونات",
        component: () => import("../views/permission/Permission.vue"),
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الاوذونات")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
      },
      // ***************************************** END PERMISSIONS PART ***********************************

      // ***************************************** START ROLES PART ***********************************
      {
        path: "role",
        name: "الصلاحيات",
        component: () => import("../views/role/Role.vue"),
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الصلحيات")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
      },
      {
        path: "role/:id",
        name: "تفاصيل الصلاحيه",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الصلاحيه")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/role/RoleDetails.vue"),
      },
      // ***************************************** END ROLES PART ***********************************

      // ***************************************** START USERS PART ***********************************
      {
        path: "users",
        name: "المستخدمين",
        component: () => import("../views/user/User.vue"),
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل المستخدمين")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
      },
      {
        path: "users/:id",
        name: "تفاصيل المستخدم",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل المستخدم")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/user/UserDetails.vue"),
      },
      {
        path: "profile",
        name: "معلوماتي",
        // beforeEnter: (to, from, next) => {
        //   if (store.getters.isAdminLogin) {
        //     if (store.getters.getPermissionsData.includes("تفاصيل المستخدم")) {
        //       return next();
        //     } else {
        //       Toast.fire({
        //         icon: "warning",
        //         title: "ليس من صلحياتك الدخول",
        //       });
        //       return from();
        //     }
        //   }
        //   next({ name: "تسجيل الدخول" });
        // },
        component: () => import("../views/profile.vue"),
      },
      // ***************************************** END USER PART ***********************************

      // ***************************************** START EVENTS PART ***********************************
      {
        path: "events",
        name: "الفعاليات",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الاحداث")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/event/Event.vue"),
      },
      {
        path: "events/:id",
        name: "تفاصيل الفعاليه",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الحدث")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/event/EventDetails.vue"),
      },
      // ***************************************** END EVENTS PART ***********************************

      // ***************************************** START NEWS PART ***********************************
      {
        path: "news",
        name: "الاخبار",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الاخبار")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/news/News.vue"),
      },
      {
        path: "news/:id",
        name: "تفاصيل الخبر",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الخبر")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/news/NewsDetails.vue"),
      },
      // ***************************************** END NEWS PART ***********************************

      // ***************************************** START ACHIVEMENT PART ***********************************
      {
        path: "coverage",
        name: "التغطيات",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل التغطيات")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/coverage/Coverages.vue"),
      },
      {
        path: "coverage/:id",
        name: "تفاصيل التغطيه",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل التغطيه")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/coverage/CoveragesDetails.vue"),
      },
      // ***************************************** END COVERAGES PART ***********************************

      // ***************************************** START ACHIVEMENT PART ***********************************
      {
        path: "achivement",
        name: "الانجازات",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الانجازات")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/achivement/Achivement.vue"),
      },
      {
        path: "achivement/:id",
        name: "تفاصيل الانجاز",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الانجاز")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/achivement/AchivementDetails.vue"),
      },
      // ***************************************** END ACHIVEMENT PART ***********************************

      // ***************************************** START STATISTIC PART ***********************************
      {
        path: "statistic",
        name: "الإحصائيات",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الإحصائيات")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/statistic/Statistic.vue"),
      },
      {
        path: "statistic/:id",
        name: "تفاصيل الإحصائيه",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الاحصائيه")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/statistic/StatisticDetails.vue"),
      },
      // ***************************************** END STATISTIC PART ***********************************

      // ***************************************** START HEROS PART ***********************************
      {
        path: "hero",
        name: "الابطال",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الابطال")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/hero/Hero.vue"),
      },
      {
        path: "hero/:id",
        name: "تفاصيل البطل",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل البطل")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/hero/HeroDetails.vue"),
      },
      // ***************************************** END HEROS PART ***********************************

      // ***************************************** START SPONSER PART ***********************************
      {
        path: "sponser",
        name: "الداعمين",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الداعمين")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/sponser/Sponser.vue"),
      },
      {
        path: "sponser/:id",
        name: "تفاصيل الداعم",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الداعم")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/sponser/SponserDetails.vue"),
      },

      // ***************************************** END SPONSER PART ***********************************
      // ***************************************** START contact us PART ***********************************
      {
        path: "contact-us",
        name: "الرسائل ",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل الرسائل")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/contact_us/ContactUs.vue"),
      },
      {
        path: "contact-us/:id",
        name: "تفاصيل الرساله",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل الرساله")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/contact_us/ContactUsDetails.vue"),
      },

      // ***************************************** END contact us PART ***********************************

      // ***************************************** START event Recordings PART ***********************************
      {
        path: "event-recording",
        name: "التسجيلات ",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (
              store.getters.getPermissionsData.includes(
                "كل التسجيلات الخاصه بالاحداث"
              )
            ) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/eventRecordings/EventRecordings.vue"),
      },
      {
        path: "event-recording/:id",
        name: "تفاصيل التسجيل",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("رؤيه التسجيل")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () =>
          import("../views/eventRecordings/EventRecordingsDetails.vue"),
      },
      // ***************************************** END event Recordings PART ***********************************

      // ***************************************** START reports PART ***********************************
      {
        path: "director",
        name: "المديرين ",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل المديرين")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/director/Director.vue"),
      },
      {
        path: "director-details/:id",
        name: "تفاصيل المدير",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل المدير")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/director/DirectorDetails.vue"),
      },

      // ***************************************** END Report PART ***********************************
      // ***************************************** START reports PART ***********************************
      {
        path: "report",
        name: "التقارير ",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("كل التقارير")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/report/Report.vue"),
      },
      {
        path: "report/:id",
        name: "تفاصيل التقرير",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("تفاصيل التقرير")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/report/ReportDetails.vue"),
      },

      // ***************************************** END Report PART ***********************************
      // ***************************************** start seting PART ***********************************
      {
        path: "seting",
        name: "اعدادات الموقع",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("اعدادات الموقع")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/seting/SetingDetails.vue"),
      },

      // ***************************************** END seting PART ***********************************
      // ***************************************** start about us PART ***********************************
      {
        path: "about-us",
        name: "معلومات عنا",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            if (store.getters.getPermissionsData.includes("صفحه عنا")) {
              return next();
            } else {
              Toast.fire({
                icon: "warning",
                title: "ليس من صلحياتك الدخول",
              });
              return from();
            }
          }
          next({ name: "تسجيل الدخول" });
        },
        component: () => import("../views/aboutUs/AboutUsDetails.vue"),
      },

      // ***************************************** END about us PART ***********************************
      {
        path: "/:notfound",
        name: "الصفحه غير موجوده",
        beforeEnter: (to, from, next) => {
          if (store.getters.isAdminLogin) {
            next();
          }
          next({ name: "تسجيل الدخول" });
        },
        component: import("../views/pages/Page404"),
      },
    ],
  },
  // this part about front end
  {
    path: "/",
    name: "Home",
    component: Home,
    meta: {
      title: "الصفحة الرئيسية",
      photo: " HomeVector.svg",
    },
  },

  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    // component: () =>
    //   import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
    component: About,
    meta: {
      title: "عن الاتحاد",
      photo: "Ithad.svg",
    },
  },

  {
    path: "/achievemnet",
    name: "achievemnet",
    component: Achievemnet,
    meta: {
      title: "البطولات",
      photo: "Botolat.svg",
    },
  },
  {
    path: "/motivate",
    name: "motivat",
    component: Motivate,
    meta: {
      title: "المركز الاعلامي",
      photo: "I3lam.svg",
    },
  },
  {
    path: "/motivat/:ico",
    name: "motivatcover",
    component: Motivate,
    meta: {
      title: "المركز الاعلامي",
      photo: "I3lam.svg",
    },
  },

  {
    path: "/action",
    name: "action",
    component: Action,
    meta: {
      title: "الفعاليات",
      photo: " fa3lyat.svg",
    },
  },
  {
    path: "/report",
    name: "report",
    component: Reports,
    meta: {
      title: "التقارير",
      photo: " reports.svg",
    },
  },
  {
    path: "/event",
    name: "event",
    component: Event,
    meta: {
      title: " ",
      photo: "  ",
    },
  },
  {
    path: "/news",
    name: "news",
    component: News,
    meta: {
      title: " ",
      photo: "  ",
    },
  },
  {
    path: "/heroes",
    name: "heroes",
    component: Heroes,
    meta: {
      title: " ",
      photo: "  ",
    },
  },
  {
    path: "/contact",
    name: "contact",
    component: Contact,
    meta: {
      title: " ",
      photo: "  ",
    },
  },
];

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 };
  },
});
router.beforeEach((to, from, next) => {
  let AdminToken = window.localStorage.getItem("AdminToken");
  if (AdminToken && !store.getters.isAdminLogin) {
    axios
      .get("/api/admin/auth/me", {
        headers: {
          Authorization: "Bearer " + AdminToken,
        },
      })
      .then((result) => {
        if (result.data.status == true) {
          store.commit("login", {
            access_token: AdminToken,
            data: result.data,
          });
          next();
        } else if (result.data.status == null) {
          Toast.fire({
            icon: "error",
            title: result.data.error,
          });
        }
      })
      .catch((error) => {
        Toast.fire({
          icon: "error",
          title: error,
        });
      });
  } else {
    return next();
  }
});

export default router;
