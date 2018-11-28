<template>
<div class="container-fluid">
    <el-row :gutter="15" class="pt-3 mb-3">
      <el-col :span="24">
          <el-breadcrumb separator-class="el-icon-arrow-right">
              <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
              <el-breadcrumb-item>Sections</el-breadcrumb-item>
          </el-breadcrumb>
      </el-col>
    </el-row> 
    <el-row :gutter="5">
      <el-col :span="24">
          <el-tabs v-model="activeName" @tab-click="handleClickTab">
            <el-tab-pane label="Header" name="header">
                <el-row :gutter="5">
                  <el-col :span="24">
                  
                  </el-col>
                </el-row>  
            </el-tab-pane>
            <el-tab-pane label="About" name="about">Configs</el-tab-pane>
            <el-tab-pane label="Expertise" name="expertise">SEO</el-tab-pane>
            <el-tab-pane label="Partener" name="partener">
              <el-row :gutter="15" class="mb-3">
                <el-col :span="24">
                
                </el-col>
              </el-row>
            </el-tab-pane>
            <el-tab-pane label="Contact" name="contact">SEO</el-tab-pane>
          </el-tabs>
      </el-col>
    </el-row>
</div>  
</template>
<script>
import axios from 'axios';
// import Masonry from 'masonry-layout';
// import $ from 'jquery';
    export default {
      name: "Medias",
        data: () => ({
          // reactive data property of the component.
           activeName: 'first',
           fileList: [],
           wpApiSettings: wpApiSettings,
      }),
      methods: {
        getslogo(){
          return axios.get(wpApiSettings.root+'dynamix/v1/mods',{},{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
        },
        handleClickTab(tab) {
          if(tab.name == 'medias'){
            console.log(tab);
          }
        },
      },
      mounted: function() {
      },
    }
</script>