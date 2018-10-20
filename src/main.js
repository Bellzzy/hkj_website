// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
// import ElementUI from 'element-ui'
import commonComponents from './components/common'

// import '../static/UE/ueditor.config.js'
// import '../static/UE/ueditor.all.min.js'
// import '../static/UE/lang/zh-cn/zh-cn.js'
// import '../static/UE/ueditor.parse.min.js'

// import 'element-ui/lib/theme-chalk/index.css'
// import './assets/common.styl'
import './assets/main.styl'
// 指令
import './js/directive.js'
// 通用方法
import './js/util.js'
// 过滤器
import './js/filter.js'
// 表单校验
import validate from './js/validate.js'

Vue.prototype.__Valid = validate;

Vue.config.productionTip = false
Vue.config.silent = true

// Vue.use(ElementUI);
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
    usn: ''
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