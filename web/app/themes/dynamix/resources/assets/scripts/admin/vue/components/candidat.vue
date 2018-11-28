<template>
<div class="container-fluid">
  <el-row class="pt-3 mb-3">
    <el-col :span="24">
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">Dashboard</el-breadcrumb-item>
            <el-breadcrumb-item>Condidates</el-breadcrumb-item>
        </el-breadcrumb>
    </el-col>
  </el-row>
  <el-row>
    <el-col :span="24">
    
        <el-table
            :data="tableCondidate"
            v-loading="loading"
            style="width: 100%"
            :max-height="maxheight">
            <el-table-column
            fixed
            prop="id"
            label="ID"
            width="70">
            </el-table-column>
            <el-table-column
            fixed
            prop="meta[0].firstname"
            label="First Name"
            width="150">
            </el-table-column>
            <el-table-column
            prop="meta[0].lastname"
            label="Last Name"
            width="250">
            </el-table-column>
            <el-table-column
            prop="meta[0].phone"
            label="Phone Number"
            width="250">
            </el-table-column>
            <el-table-column
            prop="meta[0].message"
            label="Message"
            width="450">
            </el-table-column>
            <el-table-column
            fixed="right"
            label="Actions"
            width="280">
            <template slot-scope="scope">
                <el-button
                @click.native.prevent="deleteCondidate(scope.row)"
                type="danger" 
                round
                size="mini">
                Remove
                </el-button>
                <el-button
                @click.native.prevent="viewCondidate(scope.row)"
                type="primary" 
                round
                size="mini">
                View
                </el-button>
                <el-button
                @click.native.prevent="opencv(scope.row.meta[0].resumeurl)"
                type="primary" 
                round
                size="mini">
                Open Cv
                </el-button>
            </template>
            </el-table-column>
        </el-table>
    </el-col>
    <el-col :span="24" class="mt-2">

        <el-pagination
            :current-page.sync="currentPage"
            @current-change="handleCurrentChange"
            @size-change="handleSizeChange"
            :page-size="per_page"
            :page-sizes="[5, 20, 50, 100]"
            layout="total,sizes, prev, pager, next"
            :total="totatcondidate">
        </el-pagination>

    </el-col>
  </el-row>
  <!-- dialog -->
  <el-dialog :visible.sync="visible" title="Hello world">
      <el-row>
      test
      </el-row>
  </el-dialog>
</div>    
</template>
<script>
import axios from 'axios';
    export default {
      name: "Condidat",
      data: () => ({
          visible:false,
          tableCondidate: [],
          currentPage: 1,
          per_page : 5,
          totatcondidate: 0,
          loading: true,
          maxheight: window.innerHeight - 184,

      }),
      methods: {
        getcondidates(data={}){
            return axios.post(wpApiSettings.root+'dynamix/v1/condidates',data,{headers: { 'X-WP-Nonce': wpApiSettings.nonce }})  
        },
        deleteCondidate(datarow){
          this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
          }).then(() => {
              console.log(datarow);
              this.$message({
                showClose: true,
                type: 'success',
                message: 'Delete completed',
              });
          }).catch(() => {
            this.$message({
              showClose: true,
              type: 'info',
              message: 'Delete canceled',
            });          
          });
        },
        viewCondidate(datarow){
            this.visible = true;
            console.log(datarow);
        },
        opencv(url){
            window.open('/'+url,'_blank');
        },
        handleCurrentChange(val) {
            this.getcondidates({'offset': (val-1)*this.per_page}).then((response) => {
                this.tableCondidate = response.data.data;
                this.totatcondidate = response.data.lenght;
                // console.log(response.data);
            })
        },
        handleSizeChange(val) {
            this.per_page = val;
            this.getcondidates({'offset': 0,'per_page': this.per_page}).then((response) => {
                this.tableCondidate = response.data.data;
                this.totatcondidate = response.data.lenght;
                // console.log(response.data);
            })
        },
      },
      mounted: function() {
        // let self = this;
        this.getcondidates().then((response) => {
            this.tableCondidate = response.data.data;
            this.totatcondidate = response.data.lenght;
            // console.log(response.data);
            this.loading = false;
        })
      },
    }
</script>