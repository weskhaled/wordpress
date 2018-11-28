<template>
<div class="container-fluid">
  <el-row class="pt-3 mb-3">
    <el-col :span="24">
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
            <el-breadcrumb-item>Index</el-breadcrumb-item>
        </el-breadcrumb>
    </el-col>
  </el-row>
  <el-row :gutter="15">
    <el-col :span="8">
        <el-card shadow="never">
         Always
        </el-card>
    </el-col>
    <el-col :span="8">
        <el-card shadow="never">
         Always
        </el-card>
    </el-col>
    <el-col :span="8">
        <el-card shadow="never">
         Always
        </el-card>
    </el-col>
  </el-row>
  <el-row :gutter="15" class="mt-3">
    <el-col :span="12">
      <el-card class="box-card" shadow="hover">
        <div slot="header" class="clearfix d-flex bd-highlight px-3 py-1">
            <div class="mr-auto bd-highlight">
                <h4 style="margin: 0;line-height: 40px;">Card name</h4>
            </div>
            <div class="action bd-highlight">
                <el-button class="" type="text">Operation button</el-button>
            </div>
        </div>
        <div class="p-0">
            <apexcharts id="vuechart-example" height="400px" width="100%" type="area" :options="chartOptions" :series="series"></apexcharts>
        </div>
      </el-card>
    </el-col>
    <el-col :span="12">
        <el-card class="box-card" shadow="hover">
        <div slot="header" class="clearfix d-flex bd-highlight px-3 py-1">
            <div class="mr-auto bd-highlight">
                <h4 style="margin: 0;line-height: 40px;">Card name</h4>
            </div>
            <div class="action bd-highlight">
                <el-button class="" type="text">Operation button</el-button>
            </div>
        </div>
        <div class="p-0">
            <apexcharts id="vuechart-example" height="400px" width="100%" type="area" :options="chartOptions" :series="series"></apexcharts>
        </div>
        </el-card>
    </el-col>
  </el-row>
  <!-- dialog -->
  <el-dialog :visible.sync="visible" title="Hello world">
      <el-row>
        <el-carousel :interval="4000" type="card" height="250px">
            <el-carousel-item v-for="item in sliders" :key="item.id">
                <div class="slider-post text-center" :style="{'background':'url('+item.photo+')'}">
                    <h3 v-html="item.name"></h3>
                </div>
            </el-carousel-item>
        </el-carousel>
      </el-row>
  </el-dialog>
</div>    
</template>
<script>
import axios from 'axios';
import VueApexCharts from 'vue-apexcharts';
    export default {
      name: "Index",
      components: {
        apexcharts: VueApexCharts,
      },
      data: () => ({
          visible:false,
          value7:'',
          // reactive data property of the component.
          sliders: [],
          chartOptions: {
            chart: {
              id: 'vuechart-example',
              width: '100%',
            },
            xaxis: {
                type: 'datetime',
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
          },
          series: [{
                name: 'north',
                data: [{
                        x: 1996,
                        y: 322,
                    },
                    {
                        x: 1997,
                        y: 324,
                    },
                    {
                        x: 1998,
                        y: 329,
                    },
                    {
                        x: 1999,
                        y: 342,
                    },
                    {
                        x: 2000,
                        y: 348,
                    },
                    {
                        x: 2001,
                        y: 334,
                    },
                    {
                        x: 2002,
                        y: 325,
                    },
                    {
                        x: 2003,
                        y: 316,
                    },
                    {
                        x: 2004,
                        y: 318,
                    },
                    {
                        x: 2005,
                        y: 330,
                    },
                    {
                        x: 2006,
                        y: 355,
                    },
                    {
                        x: 2007,
                        y: 366,
                    },
                    {
                        x: 2008,
                        y: 337,
                    },
                    {
                        x: 2009,
                        y: 352,
                    },
                    {
                        x: 2010,
                        y: 377,
                    },
                    {
                        x: 2011,
                        y: 383,
                    },
                    {
                        x: 2012,
                        y: 344,
                    },
                    {
                        x: 2013,
                        y: 366,
                    },
                    {
                        x: 2014,
                        y: 389,
                    },
                    {
                        x: 2015,
                        y: 334,
                    },
                ],
            }, {
                name: 'south',
                data: [

                    {
                        x: 1996,
                        y: 162,
                    },
                    {
                        x: 1997,
                        y: 90,
                    },
                    {
                        x: 1998,
                        y: 50,
                    },
                    {
                        x: 1999,
                        y: 77,
                    },
                    {
                        x: 2000,
                        y: 35,
                    },
                    {
                        x: 2001,
                        y: -45,
                    },
                    {
                        x: 2002,
                        y: -88,
                    },
                    {
                        x: 2003,
                        y: -120,
                    },
                    {
                        x: 2004,
                        y: -156,
                    },
                    {
                        x: 2005,
                        y: -123,
                    },
                    {
                        x: 2006,
                        y: -88,
                    },
                    {
                        x: 2007,
                        y: -66,
                    },
                    {
                        x: 2008,
                        y: -45,
                    },
                    {
                        x: 2009,
                        y: -29,
                    },
                    {
                        x: 2010,
                        y: -45,
                    },
                    {
                        x: 2011,
                        y: -88,
                    },
                    {
                        x: 2012,
                        y: -132,
                    },
                    {
                        x: 2013,
                        y: -146,
                    },
                    {
                        x: 2014,
                        y: -169,
                    },
                    {
                        x: 2015,
                        y: -184,
                    },
                ],
            }],
      }),
      methods: {
          getsliders(){
            return axios.get(wpApiSettings.root+'wp/v2/slider',{},{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
          },
      },
      mounted: function() {
        let self = this;
        this.getsliders().then((response) => {
            response.data.forEach(function (item,key) {
                self.sliders[key] = {};
                self.sliders[key].name = item.slug;
                self.sliders[key].photo = item.featured_image_src;
            });
        })
        .catch((e) => {
            console.error(e)
        });
        // console.log(this.$apexcharts.exec('vuechart-example',{},true));
        // this.$apexcharts.exec('vuechart-example', 'redrawPaths');
        this.$nextTick(function () {
          // self.$apexcharts.exec('vuechart-example', 'updateSeries')
          setTimeout(function () { 
           self.$apexcharts.exec('vuechart-example', 'render')
          } , 5000);
        })
      },
    }
</script>