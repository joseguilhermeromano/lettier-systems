import VueRouter from "vue-router";
import routes from "./routes";

// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkExactActiveClass: "active",
  scrollBehavior: (to) => {
    if (to.hash) {
      return { selector: to.hash };
    } else {
      return { x: 0, y: 0 };
    }
  },
});

router.beforeEach((to, from, next) => {
  const loggedIn = true;
  console.log(to);
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!loggedIn) {
      next("/login");
    } else {
      console.log("caiu aqui...");
      next();
    }
  } else {
    next();
  }
});

export default router;
