<!-- 组件代码如下 -->
<template>
  <div style='line-height: 1'>
    <script id="editor" type="text/plain"></script>
  </div>
</template>
<script>
  export default {
    name: 'UE',
    data () {
      return {
        editor: null
      }
    },
    props: {
      defaultMsg: {
        type: String
      },
      config: {
        type: Object
      }
    },
    mounted() {
      const _this = this;
      this.editor = UE.getEditor('editor', this.config); // 初始化UE
      this.editor.addListener("ready", function () {
        if(_this.defaultMsg) {
          _this.editor.setContent(_this.defaultMsg); // 确保UE加载完成后，放入内容。
        }
      });
    },
    methods: {
      getUEContent() { // 获取内容方法
        return this.editor.getContent()
      },
      setContent(val) {
        this.editor.setContent(val)
      }
    },
    watch: {
      defaultMsg(n) {
        console.log(n)
        if(n) {
          this.editor.setContent(n)
        }
      }
    },
    destroyed() {
      this.editor.destroy();
    }
  }
</script>