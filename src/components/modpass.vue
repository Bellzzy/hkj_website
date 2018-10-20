<template>
	<div class='main'>
		<div class='main-title'>当前位置：</div>
		<div class='item'>
			<div class='item-title'>标题：</div>
			<div class='item-body'><zz-input v-model='npwd' placeholder='请输入新密码' type='password'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>&nbsp;</div>
			<div class='item-body'>
				<button @click='submit'>提交</button>
			</div>
		</div>
	</div>
</template>
<script>
import qs from 'qs'
export default {
	data() {
		return {
			npwd: '',
			onSubmit: false
		}
	},
	methods: {
		submit() {
			if(this.onSubmit) return;
			let data = {
				npwd: this.npwd,
				user: sessionStorage.getItem('HKJGROUPMANAGERUSER')
			}
			if(data.npwd.length < 6) {
				alert('密码长度不能小于6位数')
				return
			}
			if(!data.user) {
				return
			}
			this.onSubmit = true
			this.axios.post('/manager/dbopt/modpass.asp', qs.stringify(data), {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(res => {
				if('ok' == res) {
					alert('密码修改成功，请重新登录.')
					sessionStorage.clear();
					this.$router.push({
						path: '/'
					})
				} else {
					alert('修改失败')
				}
				this.onSubmit = false;
			}).catch(err => {
				this.onSubmit = false;
			})
		}
	}
}
</script>