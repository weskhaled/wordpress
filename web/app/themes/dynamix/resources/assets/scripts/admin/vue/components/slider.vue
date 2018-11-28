<template>
<div class="container-fluid">
    <el-row>
        <el-carousel trigger="click" :autoplay="false" type="card" height="350px">
            <el-carousel-item v-for="item in sliders" :key="item.id">
                <div class="sliderovrerlay text-center">
                <div class="inner">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a :href="'/wp-admin/post.php?post='+item.id+'&action=edit'" class="btn btn-primary">
                            <i class="el-icon-view"></i>
                        </a>
                        <a href="javascript:void(0);" @click="vdialogedit = true" class="btn btn-info">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger">
                            <i class="el-icon-delete"></i>
                        </a>
                    </div>
                </div>
                </div>
                <div class="slider-post text-center" :style="{'background':'url('+item.featured_image_src+')'}">
                    <h3 v-show="false" v-html="item.slug"></h3>
                    <div class="p-2" v-html="item.content.rendered"></div>
                </div>
            </el-carousel-item>
        </el-carousel>
    </el-row>
    <!-- dialog -->
    <el-dialog :visible.sync="vdialogedit" title="Hello world">
        <el-row>
            Hello
        </el-row>
    </el-dialog>
</div>    
</template>
<script>
import axios from 'axios';
    export default {
      name: "Slider",
      data: () => ({
          // reactive data property of the component.
          sliders: [],
          vdialogedit: false,
      }),
      methods: {
          getsliders(){
            return axios.get(wpApiSettings.root+'wp/v2/slider',{},{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
          },
      },
      mounted: function() {
        // let self = this;
        const loading = this.$loading({
          lock: true,
          text: 'Loading',
          spinner: 'el-icon-loading',
          background: 'rgba(0, 0, 0, 0.7)',
        });
        this.getsliders().then((response) => {
            this.sliders = response.data;
            loading.close();
        })
        .catch((e) => {
            console.error(e)
        });
      },
    }
</script>