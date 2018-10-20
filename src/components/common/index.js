import Vue from 'vue'
import editor from './editor'
import input from './input'
// 注册全局组件
export default {
	install() {
		let components = [editor, input],
			i = components.length;
		while(i--) {
			Vue.component(components[i].name, components[i]);
		}
	}
}
