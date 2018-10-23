<template>
	<div class='main'>
		<div class='main-title'>当前位置：{{list[0] && list[0].tname}}</div>
		<ul>
			<li v-for='item,index in list' :key='index'>
				<div class='title' @click='toDeital(item.id)'>【{{item.tname}}】&nbsp; &nbsp;{{item.title}}</div>
				<div class='del' @click='del(item.id)'>删除</div>
			</li>
		</ul>	
	</div>
</template>
<script>
import qs from 'qs'
export default {
	data() {
		return {
			id: '',
			list: ''
		}
	},
	methods: {
		toDeital(id) {
			this.$router.push({
				path: 'main',
				query: {
					link: 'detail',
					id: id
				}
			})
		},
		getList() {
			this.axios.post('/manager/dbopt/contquery.asp').then(res => {
				let i = res.length,
					arr = []
				while(i--) {
					if(this.id == res[i].tid) {
						arr.unshift(res[i])
					}
				}
				this.list = arr;
			})
		},
		del(id) {
			this.axios.post('/manager/dbopt/contdelete.asp', qs.stringify({id: id}), {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(res => {
				if('ok' == res) {
					this.getList()
				} else {
					this.$message('删除失败')
				}
			})
		}
	},
	mounted() {
        this.id = this.$route.query.id;
        this.getList()
	}
}
</script>
<style lang="stylus" scoped>
	li
		height: 40px
		line-height: 40px
		background-color: #fff
		border-bottom: 1px dashed #e3e3e3
		margin-bottom: 9px
		cursor: pointer
		transition: color .3s
		font-size: 14px
		display: flex
		&:hover
			color: #f00
		.title
			flex: 9
		.del
			flex: 1
			text-align: right
</style>