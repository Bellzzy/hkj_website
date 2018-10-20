export default {
	getSetting() {
		return {
			message: '该项不能为空.',
			required: true,
			tigger: 'change',
			validator() {}
		}
	},
	// 为空校验
	null(value) {
		let regExp = /^\s*$/g;
		if(regExp.test(value) || 'undefined' == typeof(value) || null == value) {
			return '该项不能为空'
		}
	},
	// 车牌校验
	carNumber(value) {
		let regExp = /^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领A-Z]{1}[A-Z]{1,2}[A-Z0-9]{4}[A-Z0-9挂学警港澳]{1}$/
		return !regExp.test(value) && '车牌格式有误';
	},
	// 包含0的正整数校验
	int(value) {
		let regExp = /^([1-9]\d*|0{1})$/
		return !regExp.test(value) && '该项为正整数';
	},
	// 最多4位小数的价格校验
	price(value) {
		let regExp = /^(0{1}|[1-9]\d*)(?:\.\d{1,4})?$/;
		return !regExp.test(value) && '价格格式有误,最多保留4位小数';
	},
	// 手机号校验
	phone(value) {
		let regExp = /^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|147)\d{8}$/;
		return !regExp.test(value) && '手机号码格式有误';
	},
	// 联系电话校验
	tel(value) {
		let regExp = /^((0\d{2,3}-\d{7,8})|((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|147)\d{8})$/;
		return !regExp.test(value) && '联系电话格式有误';
	},
	// 身份证校验
	card(value) {
		let regExp = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/;
		return !regExp.test(value) && '身份证格式有误';
	},
	// 时分校验
	hours(value) {
		let regExp = /^(([0,1]\d{1})|2[0,1,2,3]{1}|\d{1}):[0,1,2,3,4,5]\d{1}$/;
		return !regExp.test(value) && '时分输入格式有误';
	},
	// 不带冒号时分校验
	hoursNocolon(value) {
		let regExp = /^(([0,1]\d{1})|2[0,1,2,3]{1}|\d{1})[0,1,2,3,4,5]\d{1}$/;
		return !regExp.test(value) && '请输入不带冒号的时分格式';
	},
	// 百分数验证
	percentage(value) {
		let regExp = /^\d+\%$/
		return !regExp.test(value) && '请输入百分数'
	},
	/*
	初始化校验
	arg为需要校验项的数组集合，需要优先校验项放在最后
	*/
	init(arg) {
		let set = this.getSetting();
		set.validator = (rule, value, callback) => {
			let i = arg.length,
				err;
			while(i--) {
				err = this[arg[i]](value);
				if(err) break;
			}
			if(err) {
				rule.message = err;
				callback(new Error(''))
			} else {
				callback();
			}
		}
		return [Object.assign({}, set)];
	},
	/*
	为必填校验
	 */
	noRequired(arg) {
		let set = this.getSetting();
		set.required = false;
		set.validator = (rule, value, callback) => {
			if(value) {
				let i = arg.length,
					err;
				while(i--) {
					err = this[arg[i]](value);
					if(err) break;
				}
				if(err) {
					rule.message = err;
					callback(new Error(''))
				} else {
					callback();
				}
			} else {
				callback();
			}
		}
		return [Object.assign({}, set)];
	},
	// 自定义校验
	custome(params) {
		return [Object.assign({}, this.getSetting(), params)]
	}
}
