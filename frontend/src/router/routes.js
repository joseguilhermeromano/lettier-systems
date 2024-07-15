import DashboardLayout from "@/layout/dashboard/DashboardLayout.vue";
// GeneralViews
import NotFound from "@/pages/NotFoundPage.vue";

// Admin pages
const Login = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Login.vue");
const Dashboard = () =>
  import(/* webpackChunkName: "dashboard" */ "@/pages/Dashboard.vue");
const Profile = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Profile.vue");
const Users = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Users.vue");
const Students = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Students.vue");
const Teachers = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Teachers.vue");
const Classes = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Classes.vue");
const Courses = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Courses.vue");
const Guardians = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Guardians.vue");
const Icons = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Icons.vue");
const Maps = () => import(/* webpackChunkName: "common" */ "@/pages/Maps.vue");
const Typography = () =>
  import(/* webpackChunkName: "common" */ "@/pages/Typography.vue");
const TableList = () =>
  import(/* webpackChunkName: "common" */ "@/pages/TableList.vue");

const routes = [
  {
    path: "/",
    name: "login",
    component: Login,
  },
  {
    path: "/dashboard",
    component: DashboardLayout,
    redirect: "/dashboard",
    meta: { requiresAuth: true },
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard,
        meta: { requiresAuth: true },
      },
      {
        path: "profile",
        name: "profile",
        component: Profile,
        meta: { requiresAuth: true },
      },
      {
        path: "students",
        name: "Estudantes",
        component: Students,
        meta: { requiresAuth: true },
      },
      {
        path: "guardians",
        name: "Pais / Responsáveis",
        component: Guardians,
        meta: { requiresAuth: true },
      },
      {
        path: "teachers",
        name: "Professores",
        component: Teachers,
        meta: { requiresAuth: true },
      },
      {
        path: "classes",
        name: "Turmas",
        component: Classes,
        meta: { requiresAuth: true },
      },
      {
        path: "courses",
        name: "Cursos",
        component: Courses,
        meta: { requiresAuth: true },
      },
      {
        path: "users",
        name: "Usuários",
        component: Users,
        meta: { requiresAuth: true },
      },
    ],
  },
  { path: "*", component: NotFound },
];

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes;
