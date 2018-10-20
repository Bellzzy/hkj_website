import Vue from 'vue'

Vue.filter('yesOrNo', function(val) {
	if('1' == val) {
		return '是'
	} else if('0' == val) {
		return '否';
	} else {
		return val;
	}
})
Vue.filter('dateFormat', (val, fm) => {
	if(!val) return;
	var date = new Date(val),
		o = {
			"M+" : date.getMonth()+1, //month
			"d+" : date.getDate(), //day
			"h+" : date.getHours(), //hour
			"m+" : date.getMinutes(), //minute
			"s+" : date.getSeconds(), //second
			"q+" : Math.floor((date.getMonth()+3)/3), //quarter
			"S" : date.getMilliseconds() //millisecond
		},
		format = fm || 'yyyy-MM-dd';
	if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
	(date.getFullYear()+"").substr(4- RegExp.$1.length));
	for(var k in o)if(new RegExp("("+ k +")").test(format))
	format = format.replace(RegExp.$1,
	RegExp.$1.length==1? o[k] :
	("00"+ o[k]).substr((""+ o[k]).length));
	return format;
})
