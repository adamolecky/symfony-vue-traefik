import Vue from "vue";
import App from "./App";
import VueFormulate from '@braid/vue-formulate'
import axios from 'axios'
import VueAxios from 'vue-axios'
import router from "./router";

Vue.use(VueFormulate)
Vue.use(VueAxios, axios)

new Vue({
  components: { App },
  template: "<App/>",
  router
}).$mount("#app");