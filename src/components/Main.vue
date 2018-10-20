<template>
	<div id="app">
		<div class='menu'>
			<img :src='"http://www.hkjgroup.cn/manager/static/images/headimg/head_img_"+imgIndex+".jpg"' class='headimg' />
			<h1>{{usn}}</h1>
			<div class='opt'>
				<span @click='signout'>退出登录</span>
				<span @click='menuSelect("modpass")'>修改密码</span>
			</div>
			<ul>
				<li @click='menuSelect("detail", "add")' :class='{"selected": "add" == selectedId}'>
					+添加文章
				</li>
				<li @click='menuSelect("list", item.tid)' v-for='(item,index) in menuList' :key='index' :class='{"selected": item.tid == selectedId}'>
					<i class='icon'></i>{{item.tname}}
				</li>
			</ul>
		</div>
		<component :is='component'></component>
	</div>
</template>

<script>
// @ is an alias to /src
import Vue from 'vue'
const loadingComponent = {
	template: `
		<div class='loading'><i /><i /><i /><i /><i /></div>
	`
}

export default {
	name: "home",
	data() {
		return {
			component: loadingComponent,
			menuList: [],
			selectedId: '',
			imgIndex: 1,
			usn: ''
		}
	},
	methods: {
		signout() {
			sessionStorage.clear();
			this.$router.push({
				path: '/'
			})
		},
		menuSelect(link, id) {
			this.selectedId = id
			let query = {
				link: link
			}
			if('number' == typeof(id)) {
				query.id = id
			}
			this.$router.push({
				path: 'main',
				query: query
			})
		},
		loadComponent(link) {
			link = link || 'list';
			let errorComponent = {
					template: `
						<div class='main error'>
							<div class='info'><h1>404</h1>找不到页面：`
							+ link + 
							`<br>请检查网络链接是否正常和地址路径是否正确。<br><br>
								<el-button type='primary' size='medium' @click='reload'>重新加载</el-button>
								<el-button type='success' size='medium' @click='back'>返回上一页</el-button>
							</div>
						</div>
					`,
					methods: {
						reload() {
							location.reload();
						},
						back() {
							this.$router.go(-1);
						}
					}
				};
			this.component = loadingComponent;
			
			import('@/components/' + link).then(res => {
				this.component = res.default;
			}).catch(err => {
				this.component = errorComponent;
			});
		},

		getMenu() {
			this.axios.post('/manager/dbopt/typequery.asp').then(res => {
				this.menuList = res;
				this.$root.cateList = res
			})
		}
	},
	mounted() {
		this.activePath = this.$route.query.link;
		this.loadComponent(this.$route.query.link);
		this.getMenu()
		this.usn = sessionStorage.getItem('HKJGROUPMANAGERUSER');
		setInterval(() => {
			this.imgIndex = Math.floor(Math.random() * 30)
		}, 60000)
	},
	watch: {
		$route(n) {
			let link = n.query.link;
			this.activePath = link;
			this.loadComponent(link)
		}
	}
};
</script>
