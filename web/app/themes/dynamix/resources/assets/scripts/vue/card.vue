<template>
  <div class="main-comp">
      <div class="img-compare-wrp" v-if="loaded">
        <image-compare :before="before" :after="after" :padding="{ left: 0, right: 0 }">
          <i class="fa fa-angle-left" aria-hidden="true" slot="icon-left"></i>
          <i class="fa fa-angle-right" aria-hidden="true" slot="icon-right"></i>
        </image-compare>
    </div>
  </div>
</template>
<script>

    export default {
      name: "main-content",
      data: () => ({
          // reactive data property of the component.
          webpack: 'Powered by webpack!',
          loaded: false,
          before: '//localhost:3000/app/uploads/2018/09/home_beauty2_highlight1-1024x652.jpg',
          after: '//localhost:3000/app/uploads/2018/09/home_beauty2_highlight1-1024x652.jpg',
      }),
      mounted: function() {
        let self = this;
        console.log('test mounted', this.webpack);
        setTimeout(function () { 
          // self.$nextTick(function () {
            self.loaded = true;
          // })
        } , 200);
      },
    }
</script>
