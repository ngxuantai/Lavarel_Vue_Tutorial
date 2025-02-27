import { createWebHistory, createRouter } from "vue-router";
import Login from "@/assets/js/views/auth/login.vue";
import Register from "@/assets/js/views/auth/register.vue";
import NotFound from "@/assets/js/views/404.vue";

const routes = [
  {
    name: "login",
    path: "/login",
    component: Login,
  },
  {
    name: "register",
    path: "/register",
    component: Register,
  },
  {
    name: "home",
    path: "/",
    component: () => import("@/assets/js/views/home/index.vue"),
  },
  {
    name: "project",
    path: "/project",
    component: () => import("@/assets/js/views/project"),
  },
  {
    name: "NotFound",
    path: "/404",
    component: NotFound,
  },
  {
    path: "/:catchAll(.*)",
    redirect: "/404",
  },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from) => {
  let hasUser = JSON.parse(localStorage.getItem("USER_INFO"));
  if (to.meta.requiresAuth && !hasUser) {
    return {
      path: "/login",
    };
  }
});

export default router;
