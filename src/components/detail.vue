<template>
	<div class='main'>
		<div class='main-title'>当前位置：</div>
		<div class='item'>
			<div class='item-title'>标题：</div>
			<div class='item-body col-1'><zz-input type='text' v-model='detail.title'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>文章类别</div>
			<div class='item-body'>
				<select v-model='detail.tid'>
					<option v-for='item,index in $root.cateList' :key='index' :value='item.tid'>{{item.tname}}</option>
				</select>
			</div>
		</div>
		<div class='item'>
			<div class='item-title'>文章作者</div>
			<div class='item-body'><zz-input type='text' v-model='detail.author'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>文章来源</div>
			<div class='item-body'><zz-input type='text' v-model='detail.source'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>文章编辑</div>
			<div class='item-body'><zz-input type='text' v-model='detail.editor'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>添加时间</div>
			<div class='item-body'><zz-input type='text' v-model='detail.addtime'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>显示权重</div>
			<div class='item-body'><zz-input type='text' v-model='detail.weights'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>封面图片</div>
			<div class='item-body col-1'><zz-input type='text' v-model='detail.imgs'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>相关视频</div>
			<div class='item-body col-1'><zz-input type='text' v-model='detail.videos'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>内容概述</div>
			<div class='item-body col-1'><zz-input type='text' v-model='detail.gs'></zz-input></div>
		</div>
		<div class='item'>
			<div class='item-title'>内容正文</div>
		</div>
		<UE :defaultMsg='detail.conts' :config='config' ref="ue"></UE>
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
		let self = this
		return {
			id: '',
			detail: {
				addtime: self.$root.$options.filters.dateFormat(new Date()),
				author: '好康健国际集团',
				editor: '好康健国际集团',
				source: '好康健国际集团',
				weights: 1,
				qs: ''
			},
			config: {
				initialFrameWidth: null,
				initialFrameHeight: 350,
				readonly: false
			},
			onSubmit: false
		}
	},
	methods: {
		getDetail() {
			if(!this.id) return
			this.axios.post('/manager/dbopt/contquerydet.asp', qs.stringify({id: this.id}), {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(res => {
				this.detail = res[0]
			})
		},
		submit() {
			if(this.onSubmit) return
			this.detail.conts = this.$refs.ue.getUEContent();
			let url = '/manager/dbopt/contupdate.asp';
			if(!this.id) {
				url = '/manager/dbopt/contadd.asp'
			}
			if(!this.detail.title) {
				this.$message('请输入标题')
				return
			}
			if(!this.detail.tid) {
				this.$message('请选择文章分类')
				return
			}
			if(!this.detail.addtime) {
				this.$message('请添加发布时间')
				return
			}
			if(this.detail.weights.length == 0) {
				this.$message('权重不能为空。')
				return
			}
			this.onSubmit = true
			this.axios.post(url, qs.stringify(this.detail), {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(res => {
				if('ok' == res) {
					if(this.id) {
						this.getDetail()
					} else {
						this.$router.push({
							path: 'main',
							query: {
								link: 'list',
								id: this.detail.tid
							}
						})
					}
				} else {
					this.$message('保存失败')
				}
				this.onSubmit = false;
			}).catch(err => {
				this.onSubmit = false;
			})
		}
	},
	mounted() {
        this.id = this.$route.query.id;
        this.getDetail()
	}
}
</script>