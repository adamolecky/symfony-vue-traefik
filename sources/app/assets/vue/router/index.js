import Vue from "vue";
import VueRouter from "vue-router";
import Home from "../views/Home";
import List from "../views/List";

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    { path: "/home", component: Home },
    { path: "/list", component: List },
    { path: "*", redirect: "/home" }
  ]
});