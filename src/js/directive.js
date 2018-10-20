import Vue from 'vue'

// 图片预览
Vue.directive('view', {
    inserted(el, binding) {
        el.onclick = (e) => {
            let url = e.target.getAttribute('url');
            let $div = document.createElement('div');
            $div.setAttribute('id', 'img-view');
            document.body.appendChild($div);
            $div.innerHTML = `<i class="el-icon-error"></i>
                <span>滚动鼠标滚轮可以放大、缩小图片。</span>
                <img src="` + url + `" width="800"/>`
            $div.onclick = () => {
                $div.removeEventListener('DOMMouseScroll', scrollFunc);
                window.onmousewheel = document.onmousewheel = null;
                document.body.removeChild($div)
            }
            let i = 800;
            function scrollFunc(e) {
                e = e || window.event;
                if(e.wheelDelta) {
                    //IE/Opera/Chrome
                    if(parseInt(e.wheelDelta) > 0) {
                        if(i < document.body.clientWidth - 100) {
                            i += 20;
                        }
                    } else {
                        if(i > 100) {
                            i -= 20;
                        }
                    }
                } else if(e.detail) {
                    //Firefox
                    if(parseInt(e.wheelDelta) > 0) {
                        if(i < document.body.clientWidth - 50) {
                            i += 20;
                        }
                    } else {
                        if(i > 100) {
                            i -= 20;
                        }
                    }
                }
                $div.getElementsByTagName('img')[0].setAttribute('style','width: ' + i +'px')
            }
            $div.addEventListener('DOMMouseScroll', scrollFunc, false)
            window.onmousewheel = document.onmousewheel = scrollFunc
        }
    }
})

// 根据盒子高度自动拆分为高度，最后一个自动适应
function setHeight(el) {
    let $parent = el.parentNode,
        elHeight = $parent.clientHeight,
        otherHeight = 0,
        $children = $parent.children,
        childrenLen = $children.length;
    if('main' == $parent.className) {
        for(let i = 0; i < childrenLen; i++) {
            if(i == childrenLen - 1) {
                $children[i].style.height = (elHeight - otherHeight - 10 - 10 -20) + 'px'
            } else {
                otherHeight += $children[i].clientHeight;
            }
        }
    }
}
Vue.directive('split', {
    inserted(el) {
        // setHeight(el)
    },
    componentUpdated(el) {
        setTimeout(function() {
            // setHeight(el)
        })
    }
})
// 按钮权限控制
Vue.directive('role', {
    bind(el, binding) {
        let value = binding.value
        if(!value || !value.rt || !value.rt.query) return;
        let path = value.rt.query.link,
            type = value.type;
        let btnList = sessionStorage.getItem('BTNLIST');
        btnList = btnList ? JSON.parse(btnList) : [];
        let i = btnList.length;
        while(i--) {
            if(path == btnList[i].href && type == btnList[i].code) {
                return true
            }
        }
        el.parentNode.removeChild(el);
    }
})

