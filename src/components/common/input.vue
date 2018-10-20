<template>
	<input type="" v-model='ivalue' @input='input'>
</template>
<script>
export default {
	name: 'zz-input',
	props: ['value'],
	data() {
		return {
			ivalue: ''
		}
	},
	methods: {
		input(e) {
			this.ivalue = e.target.value;
			this.$emit('input', e.target.value)
		}
	},
	mounted() {
		this.ivalue = this.value
	},
	watch: {
		value(n) {
			this.ivalue = n
		}
	}
}
</script>