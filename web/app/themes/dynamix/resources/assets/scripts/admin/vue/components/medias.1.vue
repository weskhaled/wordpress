<template>
<div class="container-fluid">
    <el-row :gutter="5">
      <el-col :span="24">
          <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="Général" name="first">
                <el-row :gutter="5">
                  <el-col :span="24">
                    <el-upload
                      class="upload-demo"
                      :action="wpApiSettings.root+'dynamix/v1/logo'"
                      :on-preview="handlePreview"
                      :on-remove="handleRemove"
                      :on-success="handleSuccess"
                      :file-list="fileList"
                      :multiple="false"
                      :headers="{ 'X-WP-Nonce': wpApiSettings.nonce }"
                      list-type="picture-card">
                      <el-button size="small" type="primary">Click to upload</el-button>
                      <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div>
                    </el-upload>
                  </el-col>
                </el-row>  
            </el-tab-pane>
            <el-tab-pane label="Configs" name="second">Configs</el-tab-pane>
            <el-tab-pane label="SEO" name="fourth">SEO</el-tab-pane>
            <el-tab-pane label="Medias" name="medias">
              <el-row :gutter="15" class="mb-3">
                <el-col :span="24">
                  <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPageMedias"
                    :page-sizes="[100, 200, 300, 400]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="50000">
                  </el-pagination>
                </el-col>
              </el-row>
              <el-row :gutter="5" data-fancybox-trigger="gallery" class="media-imgs grid" ref="grid" v-masonry transition-duration="0.3s" item-selector=".grid-item">
                <el-col :span="6" :sm="12" :md="8" :lg="6" v-masonry-tile class="mb-1 grid-item" v-for="(media, index) in allmedias" :key="index">
                    <figure class="effect-zoe">
                      <img :src="media.url" class="img-fluid img-fancy" :alt="media.name">
                      <figcaption>
                        <div class="row m-0">
                          <div class="col-sm-7 p-0">
                            <h2>{{media.name}}</h2>
                          </div>
                          <div class="col-sm-5 p-0">
                            <div class="icon-links pull-right text-center">
                              <el-button class="ml-1" size="mini" type="primary" circle>
                                <i class="fa fa-eye"></i>
                              </el-button>
                              <el-button class="ml-1" @click="visible = true;viewimg = media" size="mini" type="info" circle>
                                <i class="fa fa-edit"></i>
                              </el-button>
                              <el-button class="ml-1" @click="ConfirmDelete(media)" size="mini" type="danger" circle>
                                <i class="pg-trash"></i>
                              </el-button>
                            </div>
                          </div>
                        </div>
                      </figcaption>			
                    </figure>
                </el-col>
              </el-row>

            </el-tab-pane>
          </el-tabs>
      </el-col>
    </el-row>
    <!-- dialog -->
    <el-dialog :visible.sync="visible" :title="viewimg.name">
        <el-row>
          <div class="text-center">
            <img :src="viewimg.url" class="img-fluid">
          </div>
        </el-row>
    </el-dialog>
</div>  
</template>
<script>
import axios from 'axios';
// import Masonry from 'masonry-layout';
// import $ from 'jquery';
    export default {
      name: "Section",
        data: () => ({
          // reactive data property of the component.
           activeName: 'first',
           fileList: [],
           wpApiSettings: wpApiSettings,
           allmedias : [],
           currentPageMedias : 1,
           visible : false,
           viewimg: {},
           confirmdelete :false,
      }),
      methods: {
        getslogo(){
          return axios.get(wpApiSettings.root+'dynamix/v1/mods',{},{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
        },
        deletepost(id){
          return axios.delete(wpApiSettings.root+'wp/v2/media/'+id+'?force=true',{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
        },
        getallmedias(){
          return axios.post(wpApiSettings.root+'dynamix/v1/allmedias',{},{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
        },
        handleClick(tab) {
          if(tab.name == 'medias'){
            this.reDraw();
          }
        },
        handleRemove(file, fileList) {
          console.log(file, fileList);
        },
        handlePreview(file) {
          console.log(file);
        },
        handleSuccess(response) {
          let self = this;
          console.log(response);
          let imgs = response.image;
          imgs.forEach(function (value, i) {
            console.log('%d: %s', i, value);
            self.fileList.push({'name': i, 'url':value});
          });
        },
        handlePictureCardPreview(file) {
          console.log(file);
        },
        handleSizeChange(val) {
          console.log(`${val} items per page`);
        },
        handleCurrentChange(val) {
          console.log(`current page: ${val}`);
        },
        reDraw(){
          this.$nextTick(function () {
            this.$redrawVueMasonry();
          })
        },
        ConfirmDelete(media) {
          console.log(media);
          this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
          }).then(() => {
            this.deletepost(media.id).then((response) => {
              console.log(response);
              // this.allmedias = response.data;
              this.getallmedias().then((response) => {
                this.allmedias = response.data;
                this.reDraw();
              })
              this.$message({
              showClose: true,
              type: 'success',
              message: 'Delete completed',
            });
            })
          }).catch(() => {
            this.$message({
              showClose: true,
              type: 'info',
              message: 'Delete canceled',
            });          
          });
        },
        renderlayout(){
          console.log('test');
          this.$redrawVueMasonry();
        },
      },
      mounted: function() {
        this.$root.$on('message', () => {
          // console.log('about event',data);
          if( this.activeName == 'medias'){
            this.reDraw();
          }
        })
        // this.$parent.$on('isCollapse', this.renderlayout());
        this.getslogo().then((response) => {
            this.fileList.push({'name': 'logo','url':response.data.upload_logo});
        }),
        this.getallmedias().then((response) => {
            this.allmedias = response.data;
            this.reDraw();
        })
      },
      updated: function () {
        this.$nextTick(function () {
          // Code that will run only after the
          this.reDraw();
        })
      },
    }
</script>