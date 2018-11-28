<template>
<div class="container-fluid" v-loading.lock="fullscreenLoading" element-loading-background="rgba(255, 255, 255, 0.8)" :style="[fullscreenLoading ? {'min-height': 'calc(100vh - 82px)','max-height': 'calc(100vh - 82px)'} : {}]">     
    <el-row :gutter="15" class="pt-3 mb-3">
      <el-col :span="24">
          <el-breadcrumb separator-class="el-icon-arrow-right">
              <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
              <el-breadcrumb-item>Medias</el-breadcrumb-item>
          </el-breadcrumb>
      </el-col>
    </el-row>  
    <el-row :gutter="15" class="mb-3">
      <el-col :span="24">
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page.sync="currentPageMedias"
          :page-sizes="[10, 50, 100, 'All']"
          :page-size="per_page"
          layout="total, sizes, prev, pager, next, jumper"
          :total="totalmedias">
        </el-pagination>
      </el-col>
    </el-row>
    <el-row :gutter="0" class="media-imgs grid" ref="grid" v-masonry transition-duration="0.3s" item-selector=".grid-item">
      <el-col :span="8" :sm="24" :md="12" :lg="6" class="grid-item text-center" v-masonry-tile>
        <el-card :class="closedcard ? 'closed' : ''" class="d-block p-0 mr-1 mb-1" data-width="1" data-height="1" shadow="disabled">
          <div slot="header" class="clearfix d-flex bd-highlight px-2 py-1">
              <div class="mr-auto bd-highlight">
                  <h4>Add new</h4>
              </div>
              <div class="action bd-highlight">
                  <el-button class="py-1" type="text">
                    <more-horizontal-icon class=""></more-horizontal-icon>
                  </el-button>
              </div>
          </div>
          <el-upload
            class="upload-demo"
            drag
            :action="wpApiSettings.root+'dynamix/v1/addmedia'"
            :headers="{ 'X-WP-Nonce': wpApiSettings.nonce }"
            :on-success="handleSuccess"
            :on-preview="handlePreview"
            :on-remove="handleRemove"
            :file-list="fileList"
            :show-file-list="false"
            :before-upload="()=>{fullscreenLoading = true}"
            multiple>
            <i class="el-icon-upload"></i>
            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
            <div class="el-upload__tip" slot="tip">jpg/png files with a size less than 500kb</div>
          </el-upload>
        </el-card>
      </el-col>
      <el-col :span="8" :sm="24" :md="12" :lg="6" class="grid-item text-center" v-masonry-tile v-for="(media, index) in allmedias" :key="index">
        <el-card :class="!(closedmediacard.indexOf(media.id) === -1) ? 'closed' : ''" class="d-block p-0 mr-1 mb-1" data-width="1" data-height="1" shadow="hover">
          <div slot="header" class="clearfix d-flex bd-highlight px-2 py-1" :style="[!!(checkedmedia.find(item => item === media.id)) ? {'background': '#f5f7fa'} : {}]">
              <div class="mr-auto bd-highlight">
                <el-checkbox class="d-inline mr-1" @change="Checkmedia(media.id)" :key="media.id" :checked="!!(checkedmedia.find(item => item === media.id))"></el-checkbox><h4 class="d-inline">{{media.name}}-{{media.id}}</h4>
              </div>
              <div class="action bd-highlight">
                <el-tooltip content="Actions" placement="top">
                  <el-dropdown class="py-1" trigger="click">
                      <el-button type="text" class="py-0">
                        <more-horizontal-icon class=""></more-horizontal-icon>
                      </el-button>
                      <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>Action 1</el-dropdown-item>
                        <el-dropdown-item>Action 2</el-dropdown-item>
                        <el-dropdown-item>Action 3</el-dropdown-item>
                      </el-dropdown-menu>
                    </el-dropdown>
                  </el-tooltip>
                  <el-tooltip :content="!(closedmediacard.indexOf(media.id) === -1) ? 'Open Card' : 'Close Card'" placement="top">
                    <el-button class="py-1" type="text" @click="ToggleCard(media.id)">
                      <chevron-up-icon v-if="!media.closedcard"></chevron-up-icon>
                      <chevron-down-icon class="" v-if="media.closedcard"></chevron-down-icon>
                    </el-button>
                  </el-tooltip>
              </div>
          </div>
          <div class="clearfix">
            <figure class="effect-zoe">
              <img :src="media.url" class="img-fluid img-fancy" :alt="media.name" @click="viewimg = index;visible = true;" >
              <figcaption>
                <div class="row m-0">
                  <!-- <div class="col-sm-7 p-0">
                    <h2>{{media.name}}</h2>
                  </div> -->
                  <div class="col-sm-12 p-0">
                    <div class="icon-links pull-right text-center">
                      <el-button class="ml-1" size="mini" type="primary" circle>
                        <i class="fa fa-eye"></i>
                      </el-button>
                      <el-button class="ml-1" @click="imgtoedit = media;visibleeditor = true;" size="mini" type="info" circle>
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
          </div>
        </el-card>
      </el-col>
    </el-row>
    <!-- dialog -->
    <el-dialog width="80%" top="40px" :visible.sync="visible" :title="allmedias[viewimg] ? allmedias[viewimg].name : 'Image Preview'">
        <el-row style="margin: -30px -20px">
            <div class="swiper-container bg-light">
              <!-- Additional required wrapper -->
              <div class="swiper-wrapper" style="height: 550px">
                <!-- It is important to set "left" style prop on every slide -->

                <div class="swiper-slide"
                  v-for="(slide, index) in allmedias"
                  :key="index"
                  :data-hash="'/medias/slider_'+slide.id"
                >
                    <div class="swiper-zoom-container bg-light">
                        <img :src="slide.url" class="img-fluid">
                    </div>
                </div>
                
              </div>
              <!-- If we need pagination -->
              <div class="swiper-pagination"></div>

              <!-- If we need navigation buttons -->
              <nav class="">
                  <a class="prev text-right" href="javascript:void(0)">
                      <span class="icon-wrap"><i class="icon fa fa-angle-left"></i></span>
                  </a>
                  <a class="next text-left" href="javascript:void(0)">
                      <span class="icon-wrap"><i class="icon fa fa-angle-right"></i></span>
                  </a>
              </nav>
            </div>
        </el-row>
    </el-dialog>
    <!-- dialog -->
    <el-dialog width="98%" :close-on-press-escape="false" :close-on-click-modal="false" top="5px" :visible.sync="visibleeditor" title="Image Preview" class="img-editor">
      <el-container>
        <el-aside width="auto">
          <el-menu default-active="0" class="el-menu-vertical-demo" :collapse="true">
            <el-menu-item index="1" @click="imgCorp()">
              <crop-icon></crop-icon>
              <span slot="title">Crop Image</span>
            </el-menu-item>
            <el-menu-item index="2" @click="imtoedit.rotate.toggle = !imtoedit.rotate.toggle;">
              <rotate-cw-icon></rotate-cw-icon>
              <span slot="title">Rotate</span>
            </el-menu-item>
            <el-menu-item index="3" @click="imtoedit.flip.toggle = !imtoedit.flip.toggle;">
                <square-icon></square-icon>
              <span slot="title">Flip</span>
            </el-menu-item>
            <el-menu-item index="4" @click="imtoedit.text.toggle = !imtoedit.text.toggle;if(myedit.getDrawingMode() !== 'TEXT'){ myedit.stopDrawingMode();myedit.startDrawingMode('TEXT'); }">
                <type-icon></type-icon>
                <span slot="title">Type</span>
            </el-menu-item>
            <el-menu-item index="5" @click="imtoedit.showimgeditor = !imtoedit.showimgeditor">
                <sliders-icon></sliders-icon>
              <span slot="title">Filters</span>
            </el-menu-item>
          </el-menu>
        </el-aside>
        <el-container>
          <el-header height="auto">
            <div>
                <div class="clearfix d-flex bd-highlight justify-content-end">
                  <div class="mr-auto bd-highlight d-flex align-items-center" v-if="imtoedit.rotate.toggle" :style="[{'width':'33%'}]">
                      <el-slider 
                          style="width: 100%;"
                          v-model="imtoedit.rotatevalue"
                          show-input
                          :min="-360"
                          :max="360"
                          input-size="small"
                          @change="changeimgrotate">
                      </el-slider>
                  </div>
                  <div class="mr-auto bd-highlight d-flex align-items-center" v-if="imtoedit.flip.toggle"  :style="[{'width':'33%'}]">
                      <el-button size="medium" class="flip-x"  @click="myedit.flipX();">
                          <maximize-icon class="flip-x"></maximize-icon>
                      </el-button>
                      <el-button size="medium" class="flip-y" @click="myedit.flipY();">
                          <maximize-icon></maximize-icon>
                      </el-button>
                  </div>
                  <div class="text-menu mr-auto bd-highlight d-flex align-items-center" v-if="imtoedit.text.toggle">
                    <div class="color-overlay">
                      <el-popover
                        placement="bottom"
                        class="d-flex clearfix text-center"
                        v-model="imtoedit.text.togglecolor">
                        <div style="text-align: right; margin: 0">
                          <chrome-picker v-model="imtoedit.text.color"></chrome-picker>
                          <el-button size="mini" type="text" @click="imtoedit.text.togglecolor = false">cancel</el-button>
                          <el-button type="primary" size="mini" @click="imtoedit.text.togglecolor = false;myedit.changeTextStyle(imtoedit.activeObjectId, {'fill': imtoedit.text.color.hex8});">confirm</el-button>
                        </div>
                        <span class="dotcolor-32 my-1" slot="reference">
                          <span class="color" :style="[{'background-color': imtoedit.text.color.hex8}]"></span>
                        </span>
                      </el-popover>
                    </div>
                  </div>
                  <div class="action bd-highlight d-flex my-2">
                      <el-button-group class="d-flex align-items-center">
                          <el-tooltip content="Undo" placement="bottom">
                              <el-button size="small" type="primary" @click="myedit.undo();imtoedit.gfilters.map(x => {x.selected = myedit.hasFilter(x.val);});" :disabled="imtoedit.btnundodisabled">
                                <arrow-left-icon></arrow-left-icon>
                              </el-button>
                          </el-tooltip>
                          <el-tooltip content="Redo" placement="bottom">
                            <el-button size="small" type="primary" @click="myedit.redo();imtoedit.gfilters.map(x => {x.selected = myedit.hasFilter(x.val);});" :disabled="imtoedit.btnredodisabled">
                              <arrow-right-icon></arrow-right-icon>
                            </el-button>
                          </el-tooltip>
                          <el-tooltip content="Reset" placement="bottom">
                            <el-button size="small" type="primary" @click="myedit.clearObjects().then((status => {myedit.clearRedoStack();myedit.clearUndoStack();}));">
                              <check-icon></check-icon>
                            </el-button>
                          </el-tooltip>
                      </el-button-group>
                      <el-upload
                        class="ml-1 upload-demo d-flex align-items-center"
                        action=""
                        :on-change="imgeditPreview"
                        :multiple="false"
                        :auto-upload="false"
                        :limit="1">
                        <el-tooltip content="Upload Image" placement="bottom">
                          <el-button size="small" type="primary">
                              <upload-icon></upload-icon>
                          </el-button>
                        </el-tooltip>
                      </el-upload>
                      <div class="ml-1 d-flex align-items-center">
                        <el-tooltip content="Save Image" placement="bottom">
                            <el-button class="" size="small" type="primary">
                                <save-icon></save-icon>
                            </el-button>
                        </el-tooltip>
                      </div>
                  </div> 
                </div>
            </div>
          </el-header>
          <el-main>
            <div class="image-editor-wrap" style="height: 100%;">
              <div id="image-editor" class="image-editor-container right d-flex" style="height: 100%;max-height: 100%;overflow: auto;">
                <div class="image-editor-main-container flex-fill" style="height: 100%">
                  <div class="tui-image-editor d-flex justify-content-center align-items-center" ref="tuieditor" @keyup.enter="enterConfirm()" @keyup.esc="reseteditmode()" tabindex="1" style="height: 100%">
                  </div>
                </div>
                <div class="image-editor-controls flex-fill" :class="imtoedit.showimgeditor ? 'show' : ''">
                  <div class="px-3">
                    <el-collapse>
                          <el-collapse-item title="General Filters" name="1">
                              <el-row type="flex" justify="center">
                                <el-col :span="24" class="text-center">
                                  <div class="clearfix">
                                      <el-checkbox border size="small" @change="handleCheckFilterChange(gfilter)" v-for="(gfilter, index) in imtoedit.gfilters" :label="gfilter.val" :key="gfilter.val" v-model="imtoedit.gfilters[index].selected">{{gfilter.name}}</el-checkbox>
                                  </div>
                                </el-col>
                              </el-row>
                          </el-collapse-item>
                          <el-collapse-item title="RemoveWhite" name="2">
                              <el-row type="flex" justify="center">
                                  <el-col :span="24" class="text-center">
                                    <div class="clearfix">
                                      <div class="block">
                                        <span class="demonstration">
                                            <el-checkbox size="small" v-model="imtoedit.removewhite.toggle" @change="toggleimgremovewhite"></el-checkbox>Threshold & Distance
                                        </span>
                                        <el-slider 
                                            style="width: 100%;"
                                            v-model="imtoedit.removewhite.threshold"
                                            :min="0"
                                            :max="255"
                                            input-size="small"
                                            @change="imtoedit.removewhite.toggle = true;applyOrRemoveFilter(imtoedit.removewhite.toggle, 'removeWhite', {'threshold': imtoedit.removewhite.threshold,})">
                                        </el-slider>
                                        <el-slider 
                                            style="width: 100%;"
                                            v-model="imtoedit.removewhite.distance"
                                            :min="0"
                                            :max="255"
                                            input-size="small"
                                            @change="imtoedit.removewhite.toggle = true;applyOrRemoveFilter(imtoedit.removewhite.toggle, 'removeWhite', {'distance' : imtoedit.removewhite.distance, })">
                                        </el-slider>
                                      </div>
                                    </div>
                                  </el-col>
                                </el-row>
                          </el-collapse-item>
                          <el-collapse-item title="Color Parameter" name="3">
                              <el-row type="flex" justify="center">
                                  <el-col :span="24" class="text-center">
                                    <div class="clearfix">
                                        <div class="block">
                                            <span class="demonstration">
                                                <el-checkbox size="small" v-model="imtoedit.brightness.toggle" @change="toggleimgbrightness"></el-checkbox>Brightness
                                            </span>
                                            <el-slider 
                                                style="width: 100%;"
                                                v-model="imtoedit.brightness.value"
                                                :min="-255"
                                                :max="255"
                                                input-size="small"
                                                @change="imtoedit.brightness.toggle = true;applyOrRemoveFilter(imtoedit.brightness.toggle, 'brightness', {'brightness': imtoedit.brightness.value,})">
                                            </el-slider>
                                        </div>
                                        <div class="block">
                                            <span class="demonstration">
                                                <el-checkbox size="small" v-model="imtoedit.noise.toggle" @change="toggleimgnoise"></el-checkbox>Noise
                                            </span>
                                            <el-slider 
                                                style="width: 100%;"
                                                v-model="imtoedit.noise.value"
                                                :min="0"
                                                :max="1000"
                                                input-size="small"
                                                @change="imtoedit.noise.toggle = true;applyOrRemoveFilter(imtoedit.noise.toggle, 'noise', {'noise': imtoedit.noise.value,})">
                                            </el-slider>
                                        </div>
                                        <div class="block">
                                            <span class="demonstration">
                                                <el-checkbox size="small" v-model="imtoedit.gradientTransparency.toggle" @change="toggleimggradientTransparency"></el-checkbox>GradientTransparency
                                            </span>
                                            <el-slider 
                                                style="width: 100%;"
                                                v-model="imtoedit.gradientTransparency.value"
                                                :min="0"
                                                :max="255"
                                                input-size="small"
                                                @change="imtoedit.gradientTransparency.toggle = true;applyOrRemoveFilter(imtoedit.gradientTransparency.toggle, 'gradientTransparency', {'threshold': imtoedit.gradientTransparency.value,})">
                                            </el-slider>
                                        </div>
                                        <div class="block">
                                            <span class="demonstration">
                                                <el-checkbox size="small" v-model="imtoedit.pixelate.toggle" @change="toggleimgpixelate"></el-checkbox>Pixelate
                                            </span>
                                            <el-slider 
                                                style="width: 100%;"
                                                v-model="imtoedit.pixelate.value"
                                                :min="2"
                                                :max="20"
                                                input-size="small"
                                                @change="imtoedit.pixelate.toggle = true;applyOrRemoveFilter(imtoedit.pixelate.toggle, 'pixelate', {'blocksize': imtoedit.pixelate.value,})">
                                            </el-slider>
                                        </div>
                                    </div>
                                  </el-col>
                                </el-row>
                          </el-collapse-item>
                          <el-collapse-item title="Color Overlay" name="4">
                            <el-row type="flex" justify="center">
                                <el-col :span="24" class="text-center">
                                  <div class="d-flex bd-highlight">
                                      <div class="block flex-fill bd-highlight mr-1">
                                        <span class="demonstration">
                                            <el-checkbox size="small" v-model="imtoedit.Tint.toggle" @change="toggleimgTint"></el-checkbox>Tint
                                        </span>
                                        <div class="tex-center color-overlay">
                                          <el-popover
                                            placement="top"
                                            class="d-flex clearfix text-center"
                                            v-model="imtoedit.Tint.togglecolor">
                                            <div style="text-align: right; margin: 0">
                                              <chrome-picker v-model="imtoedit.Tint.color"></chrome-picker>
                                              <el-button size="mini" type="text" @click="imtoedit.Tint.togglecolor = false">cancel</el-button>
                                              <el-button type="primary" size="mini" @click="imtoedit.Tint.togglecolor = false;imtoedit.Tint.toggle = true;applyOrRemoveFilter(imtoedit.Tint.toggle, 'tint', {'color': imtoedit.Tint.color.hex8,'opacity': imtoedit.Tint.color.a});">confirm</el-button>
                                            </div>
                                            <span class="dotcolor-32" slot="reference">
                                              <span class="color" :style="[{'background-color': imtoedit.Tint.color.hex8}]"></span>
                                            </span>
                                          </el-popover>
                                        </div>
                                      </div>
                                      <div class="block flex-fill bd-highlight mr-1">
                                        <span class="demonstration">
                                            <el-checkbox size="small" v-model="imtoedit.Multiply.toggle" @change="toggleimgMultiply"></el-checkbox>Multiply
                                        </span>
                                        <div class="tex-center color-overlay">
                                          <el-popover
                                            placement="top"
                                            class="d-flex clearfix text-center"
                                            v-model="imtoedit.Multiply.togglecolor">
                                            <div style="text-align: right; margin: 0">
                                              <chrome-picker v-model="imtoedit.Multiply.color"></chrome-picker>
                                              <el-button size="mini" type="text" @click="imtoedit.Multiply.togglecolor = false">cancel</el-button>
                                              <el-button type="primary" size="mini" @click="imtoedit.Multiply.togglecolor = false;imtoedit.Multiply.toggle = true;applyOrRemoveFilter(imtoedit.Multiply.toggle, 'multiply', {'color': imtoedit.Multiply.color.hex8});">confirm</el-button>
                                            </div>
                                            <span class="dotcolor-32" slot="reference">
                                                <span class="color" :style="[{'background-color': imtoedit.Multiply.color.hex8}]"></span>
                                            </span>
                                          </el-popover>
                                        </div>
                                      </div>
                                      <div class="block flex-fill bd-highlight">
                                        <span class="demonstration">
                                            <el-checkbox size="small" v-model="imtoedit.Blend.toggle" @change="toggleimgBlend"></el-checkbox>Blend
                                        </span>
                                        <div class="tex-center color-overlay">
                                          <el-popover
                                            placement="left"
                                            class="d-flex clearfix text-center"
                                            v-model="imtoedit.Blend.togglecolor">
                                            <div style="text-align: right; margin: 0">
                                              <chrome-picker v-model="imtoedit.Blend.color"></chrome-picker>
                                              <el-select v-model="imtoedit.Blend.selectedtype" class="w100 my-1" size="small" filterable placeholder="Select">
                                                <el-option
                                                  v-for="item in imtoedit.Blend.type"
                                                  :key="item.name"
                                                  :label="item.name"
                                                  :value="item.name">
                                                </el-option>
                                              </el-select>
                                              <el-button size="mini" type="text" @click="imtoedit.Blend.togglecolor = false">cancel</el-button>
                                              <el-button type="primary" size="mini" @click="imtoedit.Blend.togglecolor = false;imtoedit.Blend.toggle = true;applyOrRemoveFilter(imtoedit.Blend.toggle, 'blend', {'color': imtoedit.Blend.color.hex8,'mode': imtoedit.Blend.selectedtype});">confirm</el-button>
                                            </div>
                                            <span class="dotcolor-32" slot="reference">
                                                <span class="color" :style="[{'background-color': imtoedit.Blend.color.hex8}]"></span>
                                            </span>
                                          </el-popover>
                                        </div>
                                      </div>
                                  </div>
                                </el-col>
                              </el-row>
                          </el-collapse-item>
                      </el-collapse>
                  </div>  
                </div>
              </div>
            </div>
          </el-main>
        </el-container>
      </el-container>
    </el-dialog>
</div>  
</template>
<script>
// var ImageEditor = require('tui-image-editor');
import * as MyImageEditor from '../libs/image-editor/imgeditor';
import axios from 'axios';
import Swiper from 'swiper';
import { Message } from 'element-ui';
import { Chrome } from 'vue-color';
import { 
  MoreHorizontalIcon,
  ChevronUpIcon,
  ChevronDownIcon,
  CropIcon,
  RotateCwIcon,
  ArrowLeftIcon,
  ArrowRightIcon,
  RefreshCcwIcon,
  Trash2Icon,
  UploadIcon,
  SaveIcon,
  CheckIcon,
  SlidersIcon,
  SquareIcon,
  MaximizeIcon,
  TypeIcon,
  } from 'vue-feather-icons';
// import $ from 'jquery';
export default {
  name: "Section",
  components: {
    MoreHorizontalIcon,
    ChevronUpIcon,
    ChevronDownIcon,
    CropIcon,
    RotateCwIcon,
    ArrowLeftIcon,
    ArrowRightIcon,
    RefreshCcwIcon,
    Trash2Icon,
    UploadIcon,
    SaveIcon,
    CheckIcon,
    SlidersIcon,
    SquareIcon,
    MaximizeIcon,
    TypeIcon,
    'chrome-picker': Chrome,
  },
  data: () => ({
      // reactive data property of the component.
        wpApiSettings: wpApiSettings,
        fullscreenLoading: true,
        allmedias : [],
        totalmedias: 0,
        per_page : 10,
        currentPageMedias : 1,
        visible : false,
        closedcard :false,
        closedmediacard : [],
        checkedmedia: [],
        checkedmedialist: [],
        viewimg: null,
        confirmdelete :false,
        fileList:[],
        swiper_medias: null,
        myedit:null,
        visibleeditor: false,
        imgtoedit:null,
        uplodedimg:null,
        showrotatemenu:false,
        showimgflipmenu:false,
        imtoedit:{
          activeObjectId : null,
          rotatevalue: 0,
          btnundodisabled: true,
          btnredodisabled: true,
          showimgeditor: false,
          crops:{
            toggle: false,
            value: 0,
          },
          rotate:{
            toggle: false,
            value: 0,
          },
          flip:{
            toggle: false,
            flipx: false,
            flipy: false,
          },
          gfilters:[
            {
              name: 'Grayscale' ,
              val: 'Grayscale',
              selected: false,
            },
            {
              name: 'Invert' ,
              val: 'Invert' ,
              selected: false,
            },
            {
              name: 'Sepia' ,
              val: 'Sepia' ,
              selected: false,
            },
            {
              name: 'Sepia2' ,
              val: 'Sepia2' ,
              selected: false,
            },
            {
              name: 'Blur' ,
              val: 'Blur' ,
              selected: false,
            },
            {
              name: 'Sharpen' ,
              val: 'Sharpen' ,
              selected: false,
            },
            {
              name: 'Emboss' ,
              val: 'Emboss' ,
              selected: false,
            },
          ],
          removewhite: {
            toggle: false,
            threshold: 60,
            distance: 10,
          },
          brightness:{
            toggle: false,
            value: 10,
          },
          noise:{
            toggle: false,
            value:100,
          },
          gradientTransparency: {
            toggle: false,
            value:100,
          },
          pixelate: {
            toggle: false,
            value:4,
          },
          Tint:{
            toggle:false,
            color: {
              hex8: "#00AAFFFF",
            },
            togglecolor: false,
          },
          Multiply:{
            toggle:false,
            color: {
              hex8: "#00AAFFFF",
            },
            togglecolor: false,
          },
          Blend:{
            toggle:false,
            color: {
              hex8: "#00AAFFFF",
            },
            type : [
              { name : 'add'},
              { name : 'diff'},
              { name : 'multiply'},
              { name : 'screen'},
              { name : 'lighten'},
              { name : 'darken'},
            ],
            selectedtype : 'add',
            togglecolor: false,
          },
          text: {
            toggle: false,
            togglecolor: false,
            color: {
              hex8: '#00aaff',
            },
          },
        },
  }),
  watch : {
    visible : function (val) {
      let self = this;
      if(val){
        this.$nextTick(function () {
          this.swiper_medias = new Swiper('.swiper-container', {
            init : false,
            navigation: {
              nextEl: '.next',
              prevEl: '.prev',
            },
            // hashNavigation: {
            //   replaceState: true,
            // },
            // autoHeight : true,
            grabCursor : true,
            pagination: {
              el: '.swiper-pagination',
              type: 'bullets',
              clickable : true,
            },
            spaceBetween: 0,
            slidesPerView :1,
            zoom: {
              maxRatio: 5,
            },
            on : {
              transitionEnd : function(){
                 self.viewimg = this.activeIndex;
              },
            },
          });
          self.swiper_medias.init();
          self.swiper_medias.slideTo(self.viewimg);
        })
      } else {
        if(self.swiper_medias instanceof Swiper){
          self.swiper_medias.destroy(true, false);
        }
      }
      // console.log('new: %s, old: %s', val, oldVal);
    },
    visibleeditor : function(val){
      let self = this;
      if(val){
        this.$nextTick(function () {
          self.imtoedit.gfilters.map(x => {x.selected = false;});
          self.imtoedit.rotatevalue = 0;
          // this.myedit = MyImageEditor.init({el: self.$refs.tuieditor,imgurl: 'https://cdn-images-1.medium.com/max/2000/1*7ZdX-pXxmBZuFtEZqeiWGA.jpeg'});
          this.myedit = MyImageEditor.init({el: self.$refs.tuieditor,imgurl: self.imgtoedit.url});
          // console.log(self.myedit);
          // Attach image editor custom events
          this.myedit.on({
            undoStackChanged: function(length) {
              if (length) {
                self.imtoedit.btnundodisabled = false;
              } else {
                self.imtoedit.btnundodisabled = true;
              }
            },
            redoStackChanged: function(length) {
              if (length) {
                self.imtoedit.btnredodisabled = false;
              } else {
                self.imtoedit.btnredodisabled = true;
              }
            },
            addText: function(pos) {
              self.myedit.addText('Double Click to Add Text', {
                  position: pos.originPosition,
                  styles: {
                    'fill': self.imtoedit.text.color.hex8,
                    'fontFamily': 'Raleway',
                  },
              }).then(objectProps => {
                  console.log(objectProps);
              });
            },
            objectActivated: function(obj) {
              self.imtoedit.activeObjectId = obj.id;
              if (obj.type === 'text') {
                self.imtoedit.text.toggle = true;
                self.imtoedit.text.toggle = true;
                self.imtoedit.text.toggle = true;
                self.imtoedit.text.color.hex8 = obj.fill;
              }
              // if (obj.type === 'rect' || obj.type === 'circle' || obj.type === 'triangle') {
              //     showSubMenu('shape');
              //     setShapeToolbar(obj);
              //     activateShapeMode();
              // } else if (obj.type === 'icon') {
              //     showSubMenu('icon');
              //     setIconToolbar(obj);
              //     activateIconMode();
              // } else if (obj.type === 'text') {
              //     showSubMenu('text');
              //     setTextToolbar(obj);
              //     activateTextMode();
              // }
            },
          });
        });
      } else {
          MyImageEditor.destroy();
      }
    },
    'imtoedit.rotatevalue' : function(val) {
      let self = this;
      // if(val){
        Message.closeAll();
        self.myedit.stopDrawingMode();
        self.myedit.setAngle(parseInt(val, 10)).catch(() => {});
      // }
    },
  },    
  methods: {
    getallmedias(data={}){
      return axios.post(wpApiSettings.root+'dynamix/v1/allmedias',data,{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
    },
    deletepost(id){
      return axios.delete(wpApiSettings.root+'wp/v2/media/'+id+'?force=true',{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
    },
    ToggleCard(id){
      let self = this ; 
      this.allmedias.map(media => {
        if(media.id == id){
          media.closedcard = !media.closedcard;
          if(self.closedmediacard.indexOf(id) === -1){
            self.closedmediacard.push(media.id);
          } else {
            self.closedmediacard.splice(self.closedmediacard.indexOf(media.id), 1)
          }
        }
      });
      self.reDraw();
    },
    Checkmedia(id){
      let self = this ;
      if(self.checkedmedia.find(item => item === id)) {
        self.checkedmedia.splice(self.checkedmedia.indexOf(id), 1);
        this.$store.dispatch('medias/spliceMedia', id)
      } else {
        self.checkedmedia.push(id);
        this.$store.dispatch('medias/pushMedia', id)
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
      self.allmedias = JSON.parse(JSON.stringify(response));
      this.allmedias.map(x => {
        x.closedcard = false;
      });
      this.reDraw();
    },
    handlePictureCardPreview(file) {
      console.log(file);
    },
    handleSizeChange(val) {
      // console.log(val);
      this.per_page = val;
      if(isNaN(val)){ this.per_page = this.totalmedias }
      this.getallmedias({'offset': 0,'per_page': this.per_page}).then((response) => {
          this.allmedias = response.data.data;
          this.totalmedias = response.data.lenght;
          this.currentPageMedias = response.data.page;
          this.allmedias.map(x => {
            x.closedcard = false;
          });
          this.reDraw();
      })
    },
    handleCurrentChange(val) {
      console.log(`current page: ${val}`);
      this.getallmedias({'offset': (val-1)*this.per_page,'per_page': this.per_page}).then((response) => {
          this.allmedias = response.data.data;
          this.totalmedias = response.data.lenght;
          this.currentPageMedias = response.data.page;
          this.allmedias.map(x => {
            x.closedcard = false;
          });
          this.reDraw();
      })
    },
    reDraw(){
      let self = this;
      // self.fullscreenLoading = true;
      setTimeout(function () { 
        self.$nextTick(function () {
          self.$redrawVueMasonry();
          self.fullscreenLoading = false;
        })
      } , 201);
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
            this.allmedias = response.data.data;
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
    imgCorp(){
      let self = this;
      // console.log(self.myedit.getDrawingMode());
      self.showrotatemenu = false;
      if (self.myedit.getDrawingMode() === 'NORMAL') {
        self.myedit.startDrawingMode('CROPPER');
        self.$message({
          showClose: true,
          message: 'Press Enter to Save Corps.',
          duration: 0,
        });
      } else {
        Message.closeAll();
        self.myedit.stopDrawingMode();
      }
    },
    enterConfirm (){
      let self = this;
        Message.closeAll();
        let rec = (self.myedit.getDrawingMode() === 'CROPPER' && self.myedit.getCropzoneRect()) ? self.myedit.getCropzoneRect() : false;
        self.myedit.stopDrawingMode();
        if (rec) {
          self.$confirm('This will permanently Corp the image. Continue?', 'Warning', {
            confirmButtonText: 'Yep',
            cancelButtonText: 'No',
            type: 'warning',
          }).then(() => {
            self.myedit.crop(rec).then(() => {
                self.myedit.stopDrawingMode();
                self.myedit.startDrawingMode('CROPPER');
                self.imtoedit.rotatevalue = 0;
            });
          }).catch(() => {
            self.myedit.stopDrawingMode();
            self.myedit.startDrawingMode('CROPPER');
            self.$message({
              showClose: true,
              type: 'info',
              message: 'Corp canceled',
            });
          });
        } else {
          self.myedit.stopDrawingMode();
        }
    },
    changeimgrotate(val){
      console.log(val);
      // this.myedit.rotate(val);
      // this.myedit.setAngle(parseInt(val, 10)).catch(() => {});
    },
    reseteditmode() {
      this.myedit.stopDrawingMode();
    },
    imgeditPreview(file) {
      console.log(file.raw);
      this.uplodedimg = file.raw;
      this.myedit.loadImageFromFile(file.raw).then(result => {
          console.log(result);
          this.myedit.clearUndoStack();
          this.myedit.stopDrawingMode();
      });
    },
    applyOrRemoveFilter(applying, type, options) {
      let self = this;   
      if (applying) {
          self.myedit.applyFilter(type, options).then(result => {
              if(result && result.action === "add") return true;
          });
        } else {
          self.myedit.removeFilter(type).then(result => {
              if(result && result.action === "remove") return false;
          });
        }
        // return false;
    },
    handleCheckFilterChange(valfilters){
      let self = this;
      self.applyOrRemoveFilter(valfilters.selected,valfilters.val,null);
      self.imtoedit.gfilters.map(x => {
        x.selected = self.myedit.hasFilter(x.val);
      });
    },
    toggleimgremovewhite(val){
      let self= this;
      self.imtoedit.removewhite.toggle = self.applyOrRemoveFilter(val, 'removeWhite', {
        threshold: parseInt(self.imtoedit.removewhite.threshold, 10),
        distance: parseInt(self.imtoedit.removewhite.distance, 10),
      });
    },
    toggleimgbrightness(val){
      let self= this;
      self.imtoedit.brightness.toggle = self.applyOrRemoveFilter(val, 'brightness', {
        brightness: parseInt(self.imtoedit.brightness.value, 10),
      });
    },
    toggleimgnoise(val){
      let self= this;
      self.imtoedit.brightness.toggle = self.applyOrRemoveFilter(val, 'noise', {
        noise: parseInt(self.imtoedit.noise.value, 10),
      });
    },
    toggleimggradientTransparency(val){
      let self= this;
      self.imtoedit.gradientTransparency.toggle = self.applyOrRemoveFilter(val, 'gradientTransparency', {
        threshold: parseInt(self.imtoedit.gradientTransparency.value, 10),
      });
    },
    toggleimgpixelate(val){
      let self= this;
      self.imtoedit.pixelate.toggle = self.applyOrRemoveFilter(val, 'pixelate', {
        blocksize: parseInt(self.imtoedit.pixelate.value, 10),
      });
    },
    toggleimgTint(val){
      let self= this;
      self.imtoedit.Tint.toggle = self.applyOrRemoveFilter(val, 'tint', {
        color: self.imtoedit.Tint.color.hex8,
        opacity: parseFloat(self.imtoedit.Tint.color.a, 10),
      });
    },
    toggleimgMultiply(val){
      let self= this;
      self.imtoedit.Multiply.toggle = self.applyOrRemoveFilter(val, 'multiply', {
        color: self.imtoedit.Multiply.color.hex8,
      });
    },
    toggleimgBlend(val){
      let self= this;
      self.imtoedit.Blend.toggle = self.applyOrRemoveFilter(val, 'blend', {
        color: self.imtoedit.Blend.color.hex8,
        mode: self.imtoedit.Blend.selectedtype,
      });
    },
  },
  computed: {
  },
  mounted: function() {
    // let self = this;
    this.$store.commit('increment');
    // console.log(store.state.count);
    // this.$store.dispatch('medias/getLocalMedias');
    // // this.checkedmedia = this.$store.state.medias.medias;
    // localStorage.getItem('medias').map(item => {
    //   self.checkedmedia.push(item.id);
    // })
    // console.log(this.$store.state.medias.medias);
    this.$root.$on('redrawVueMasonry', () => {
        this.reDraw();
    })
    this.getallmedias().then((response) => {
        this.allmedias = response.data.data;
        this.totalmedias = response.data.lenght;
        this.currentPageMedias = response.data.page;
        this.allmedias.map(x => {
          x.closedcard = false;
          // console.log(x);
        });
        this.reDraw();
    })
  },
  // updated: function () {
  //   this.$nextTick(function () {
  //     // Code that will run only after the
  //     this.reDraw();
  //   })
  // },
}
</script>