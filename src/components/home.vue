<template>
	<div class='main'>
		<!-- <UE :defaultMsg='content' :config='config' ref="ue"></UE> -->
	</div>
</template>
<script>
export default {
	data() {
		return {
			content: '',
			config: {
				initialFrameWidth: null,
				initialFrameHeight: 350,
				readonly: false
			},
		}
	},
	mounted() {
	}
}
</script>
