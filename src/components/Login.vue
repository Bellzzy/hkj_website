<template>
	<div class="login">
		<form class='login-body' @submit.prevent='submit'>
			<div class='body'>
				<h1>后台管理系统</h1>
				<input placeholder='请输入账户' v-model='login.usn' class='login-icon_input'></input>
				<input type='password' placeholder='请输入密码' v-model='login.pwd' class='login-icon_input'></input>
				<button type='primary' native-type='submit' class='login-icon_btn'>登&nbsp;&nbsp;录</button>
			</div>
		</form>
	</div>
</template>
<script>
import qs from 'qs'
export default {
	data() {
		return {
			onLoading: false,
			login: {
				usn: '',
				pwd: ''
			}
		}
	},
	methods: {
		submit(e) {
			if(this.onLoading) return;
			let usn = this.login.usn,
				pwd = this.login.pwd;
			if(/^\s*$/g.test(usn) || 'undefined' == typeof(usn)) {
				this.$message.error('帐户不能为空.');
				return;
			}
			if(/^\s*$/g.test(pwd) || 'undefined' == typeof(pwd)) {
				this.$message.error('密码不能为空.');
				return;
			}
			this.axios.post('/manager/dbopt/login.asp', qs.stringify(this.login), {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(res => {
				if('ok' == res) {
					sessionStorage.setItem('HKJGROUPMANAGERUSER', this.login.usn)
					this.$router.push({path:'/main', query: {link: 'home'}})
				} else {
					this.$message.error('登录失败')
				}
				this.onLoading = false;
			}).catch(() => {
				this.onLoading = false;
			})
			return false;
		}
	},
	mounted() {
	}
}
</script>
<style lang="stylus">
.login
	height: 100vh
	background: linear-gradient(to bottom right, #ffc784 , #1cbba7)
	background-size: cover
	text-align: center
	&:before 
		content: ' '
		height: 100%
		vertical-align: middle
		visibility: hidden
		display: inline-block
	.login-body
		width: 400px
		height: 400px
		vertical-align: middle
		display: inline-block
		text-align: left
		.body
			background-color: #fff
			padding: 0 30px 30px 30px
			border-radius: 5px
			box-shadow:  0 10px 30px rgba(0,0,0,.5)
			h1 
				text-align: center
				font-weight: 500
				font-size: 18px !important
				height: 60px
				line-height: 60px
				margin: 0
			input
				display: block
				width: 100%
				height: 40px
				border: 1px solid #c3c3c3
				border-radius: 4px
				outline: none
				transition: all .3s
				margin-bottom: 20px
				padding-left: 20px
				box-sizing: border-box
				color: #606266
				font-size: 12px
				&:focus
					border-color: #1cbba7
			button
				height: 40px
				display: block
				width: 100%
				background-color: #1cbba7
				border: none
				border-radius: 4px
				color: #fff
				transition: all .3s
				cursor: pointer
				outline: none
				&:hover
					background-color: #158f7f
</style>