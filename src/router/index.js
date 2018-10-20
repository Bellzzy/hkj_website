import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
    	path: '/',
		name: '登录',
    	component: () => import('@/components/Login.vue')
    }, {
    	path: '/main',
    	name: '主页',
    	component: () => import('@/components/Main.vue')
    }
  ]
})
