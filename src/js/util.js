import Vue from 'vue'

// 默认分页数
Vue.prototype.__rows = 50;
// alert弹窗页面查看内容时cc-form的cols及rules控制
Vue.prototype.__alertView = function(cols) {
  let i = cols.length,
    j;
  while(i--) {
    j = cols[i].length;
    while(j--) {
      cols[i][j].input = false;
      cols[i][j].date = false;
      cols[i][j].textarea = false;
      if(cols[i][j].base || cols[i][j].dic || cols[i][j].radio || cols[i][j].select) {
      	cols[i][j].disabled = true;
      }
    }
  }
}
// 根据对象obj的各键的值。
Vue.prototype.__setValue = function(obj, values) {
  for(let item in obj) {
    obj[item] = values[item]
  }
}

// 封装菜单树， ids为需要展示的集合
Vue.prototype.__menuTree = function(ids) {
	let data = sessionStorage.getItem('allMenuList');
	data = data ? JSON.parse(data) : [];
	if(ids) {
		data = this.__getSelectMenu(ids);
	}
	let i = data.length, 
		obj = {}, 			// 1级菜单对象
		obj2 = {}, 			// 2级菜单对象
		level3Arr = [];		// 3级菜单集合
	while(i--) {
		if(-1 == data[i].parentId) {
			data[i].list = []
			obj[data[i].id] = data[i]
		} else {
			if(0 == data[i].type) {
				data[i].list = []
				obj2[data[i].id] = data[i];
			} else {
				level3Arr.push(data[i])
			}
		}
	}
	i = level3Arr.length;
	while(i--) {
		if(obj2[level3Arr[i].parentId]) {
			obj2[[level3Arr[i].parentId]].list.push(level3Arr[i])
		}
	}
	for(let item in obj2) {
		let temp = obj2[item]
		if(obj[temp.parentId]) {
			obj[temp.parentId].list.push(temp)
		}
	}
	let arr = [];
	for(let item in obj) {
		arr.unshift(obj[item])
	}
	arr.sort(function(a, b) {
		return a.orderNum > b.orderNum
	})
	return arr;
}
Vue.prototype.__getSelectMenu = function(ids) {
	let data = sessionStorage.getItem('allMenuList');
	data = data ? JSON.parse(data) : [];
	let i = data.length,
		arrs = [],
		set = new Set(ids);
	while(i--) {
		// 获得完整的id集合
		if(set.has(data[i].id)) {
			if(-1 != data[i].parentId) {
				arrs.push(data[i].parentId);
				let j = data.length;
				while(j--) {
					if(data[i].parentId == data[j].id) {
						arrs.push(data[j].parentId)
					}
				}
			}
		}
	}
	arrs = arrs.concat(ids);
	set = new Set(arrs);
	i = data.length;
	let arr = [];
	while(i--) {
		if(set.has(data[i].id)) {
			arr.push(data[i])
		}
	}
	return arr;
}
// 重置，清除搜索条件 
Vue.prototype.__reset = function(obj) {
	for(let item in obj) {
		obj[item] = '';
	}
}
// 确认提示框
Vue.prototype.__confirm = function(vm, msg, title, settings) {
	let sets = Object.assign(settings || {}, {
		cancelButtonClass: 'el-button--medium',
		confirmButtonClass: 'el-button--medium',
		dangerouslyUseHTMLString: true,
	})
    return vm.$confirm('<p class="text_normal bold">'+ (msg || '确认要删除该数据？') + '</p>', title, sets);
}