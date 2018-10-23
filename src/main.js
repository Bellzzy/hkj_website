// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import commonComponents from './components/common'
import './assets/main.styl'
// 过滤器
import './js/filter.js'
Vue.prototype.$message = function(msg) {
  let $dom = document.createElement('div');
  $dom.setAttribute('id', 'msg')
  $dom.innerHTML = msg;
  document.body.appendChild($dom)
  let timer = setTimeout(() => {
    document.body.removeChild($dom)
    timer = null
  }, 2000)
};

Vue.config.productionTip = false
Vue.config.silent = true

Vue.use(commonComponents);
Vue.use(VueAxios, axios);

/* eslint-disable no-new */
const vm = new Vue({
  el: '#app',
  router,
  components: { App },
  data: {
  	events: new Vue(),
    // 文章分类
    cateList: [],
    // 当前登录用户，用户判断是否登录
    usn: '',
  },
  template: '<App/>'
})

// axios响应拦截
axios.interceptors.response.use(res => {
  return res.data
}, err => {
  return Promise.reject(err);
});
/*
全局路由勾子
*/
router.beforeEach((to, from, next) => {
    if(!/^(\/|\/login)$/.test(to.path)) {
        // 判断是否登录
        if(sessionStorage.getItem('HKJGROUPMANAGERUSER')) {
            next();
        } else {
            next('/');
        }
    } else {
        next();
    }
})