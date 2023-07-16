// // router.js
// import { createRouter, createWebHistory } from "vue-router";
// import Form from "../components/form.vue";

// // Import your components for routing
// import Dashboard from "../views/dashboard.vue";
// import Task from "../views/task.vue";

// const routes = [
//   {
//     path: "/",
//     name: "Login",
//     component: Form,
//   },
//   {
//     path: "/dashboard",
//     name: "Dashboard",
//     component: Dashboard,
//     meta: { requiresAuth: true },
//   },
//   {
//     path: "/task",
//     name: "Task",
//     component: Task,
//   },

//   // Add more routes as needed
// ];

// const router = createRouter({
//   history: createWebHistory(),
//   routes,
// });

// export default router;

import { createRouter, createWebHistory } from "vue-router";
import Login from "./views/login.vue";
import Home from "./views/Home.vue";
import About from "./views/About.vue";
import Dashboard from "./views/dashboard.vue";
import Task from "./views/task.vue";

const routes = [
  { path: "/", component: Login },
  { path: "/dashboard", component: Dashboard },
  { path: "/tasks", component: Task },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
