<template>
    <div class="p-one-body">

        <el-card class="box-card" shadow="none">
            <div slot="header" class="clearfix">

                <el-row>

                    <el-button class="pull-right"  size="small"  @click="formModalVisible = true" type="primary">Add New</el-button>

                    <el-dialog
                            :visible.sync="formModalVisible"
                            title="New Grid "
                            width="35%"
                            v-loading="loading"
                            center>
                        <div>

                            <el-form>
                                <el-form-item>

                                    <el-select style="width:100%;background:#fff;"  v-model="sourceName" @change="getDynamicData" placeholder="Grid Source">
                                        <el-option
                                                v-for="item in gridSource"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>

                                </el-form-item>

                                <el-form-item v-if="sourceName=='fluent-form'">

                                    <el-select style="width:100%;background:#fff;"  v-model="fluentFormId" @change="getFormFields" placeholder="Select Fluent Form">
                                        <el-option
                                                v-for="item in fluentFormList"
                                                :key="item.id"
                                                :label="item.title"
                                                :value="item.id">
                                        </el-option>
                                    </el-select>



                                    <el-checkbox :indeterminate="isIndeterminate" v-if="fluent_fields.length>0"  v-model="checkAll" @change="handleCheckAllFluentChange">Check all</el-checkbox>
                                    <div style="margin: 15px 0;"></div>

                                    <el-checkbox-group v-model="checkedFields" @change="handleCheckedFFChange">
                                        <el-checkbox v-for="data in fluent_fields" :label="data.name" :key="data.name">{{data.label}}</el-checkbox>
                                    </el-checkbox-group>

                                </el-form-item>

                                <el-form-item v-if="sourceName=='ninja-table'">

                                    <el-select style="width:100%;background:#fff;"  v-model="ninjaTableId" @change="getColumnNT" placeholder="Select Ninja Table">
                                        <el-option
                                                v-for="item in ninjaTableList"
                                                :key="item.ID"
                                                :label="item.post_title"
                                                :value="item.ID">
                                        </el-option>
                                    </el-select>



                                    <el-checkbox :indeterminate="isIndeterminate" v-if="ninja_table_column.length>0"  v-model="checkAll" @change="handleCheckAllColumnChange">Check all</el-checkbox>
                                    <div style="margin: 15px 0;"></div>

                                    <el-checkbox-group v-model="checkedColumns" @change="handleCheckedColumnChange">
                                        <el-checkbox v-for="data in ninja_table_column" :label="data.name" :key="data.name">{{data.name}}</el-checkbox>
                                    </el-checkbox-group>

                                </el-form-item>


                                <el-form-item  style="text-align:center;">
                                    <el-button :disabled="disableSubmit"   @click="goTolink" type="primary">Next</el-button>
                                </el-form-item>

                            </el-form>

                        </div>

                    </el-dialog>

                </el-row>
                <el-table :data="tableData" style="width: 100%"  v-loading="loading">


                        <el-table-column label="ID" width="60px">
                            <template slot-scope="scope">
                                <span style="margin-left: 10px">{{ scope.row.id }}</span>
                            </template>
                        </el-table-column>

                        <el-table-column label="Name" width="" prop="name">
                            <template slot-scope="scope">
                                    <div slot="reference" class="name-wrapper">
                                        {{ scope.row.card_name }}
                                    </div>
                            </template>
                        </el-table-column>

                        <el-table-column label="Action" width="200px" >
                            <template slot-scope="scope">

                                <el-button
                                        size="mini"
                                        @click="handleEdit(scope.row.id, scope.row)">Edit</el-button>
                                <el-button
                                        size="mini"
                                        type="danger"
                                        @click="handleDelete(scope.row.id, scope.row)">Delete</el-button>
                            </template>
                        </el-table-column>

                        <el-table-column label="Short Code" width="280">
                            <template slot-scope="scope" >
                                <div  class="shortcode-text">

                                    <code class="copy" style="font-size:12px;"
                                          :data-clipboard-text='`[PluginRunTwo_card id="${scope.row.id}"]`'>
                                        <i class="el-icon-document"></i>  [PluginRunTwo_card id="{{ scope.row.id }}" ]
                                    </code>


                                </div>
                            </template>
                        </el-table-column>

                        <el-table-column label="Preview"   >


                            <template slot-scope="scope">


                                <el-button
                                        size="mini"
                                        type="success"
                                        @click="preview( scope.row.id)"
                                >Preview

                                </el-button>




                            </template>
                        </el-table-column>
                    </el-table>
                </el-row>

                <el-dialog title="Edit Card" :visible.sync="dialogTableVisible">
                    <PostForm edit="true" :id="editId" @updated="refresh" />
                </el-dialog>

            </div>

        </el-card>

        <el-card>
            <div>
                {{testData}}
            </div>
        </el-card>

    </div>
</template>
<script>
    // import AddCard from './../AddCard';
    import PostForm from "./PostForm";
    import Clipboard from 'clipboard';
    const cityOptions = ['Shanghai', 'Beijing', 'Guangzhou', 'Shenzhen'];

    export default {
        name: 'CardList',
        data() {
            return {
                gridSource:[
                    {
                        label:'Post',
                        value:'post'
                    },
                    {
                        label:'Fluent Form',
                        value:'fluent-form'
                    },
                    {
                        label:'Ninja Table',
                        value:'ninja-table'
                    }
                ],
                sourceName:'post',
                formModalVisible: false,
                loading: true,
                tableData: [],
                dialogTableVisible : false,
                editId :'',
                testData: '',
                disableSubmit:false,
                fluentFormList:'',
                ninjaTableList:'',
                fluentFormId:'',
                ninjaTableId:'',
                fluent_fields:'',
                checkedFields:'',
                checkedColumns:'',
                ninja_table_column:'',

                checkAll: false,

                isIndeterminate: true
            };
        },
        methods: {
            refresh(){
                this.getData();
                this.dialogTableVisible = false;
            },
            getDynamicData(){
                let this2 = this;
                this.disableSubmit = true;
                this.loading=true;
                if(this.sourceName == 'post'){
                    this.loading=false;
                    this.disableSubmit = false;
                    return ;
                }
                if(this.sourceName == 'fluent-form'){

                    // get_fluentform_forms
                    this.$adminGet({
                                   route: "get_fluentform_forms",
                                       // action: 'plugin_run_two_grid',

                                   }).then((response)=>{

                                this2.fluentFormList =response.data

                            }
                    ).always(()=>{
                        this.loading=false
                    })
                }
                if(this.sourceName == 'ninja-table'){
                    // get_nina tables
                    this.$adminGet({
                           route: "get_ninja_tables",
                           action: 'plugin_run_two_grid',

                       }).then((response)=>{

                            this2.ninjaTableList =response.data

                        }
                    ).always(()=>{
                        this.loading=false
                    })
                }

            },
            getColumnNT(){
                this.$adminGet({
                                   form_Id: this.fluentFormId,
                                   action: 'plugin_run_two_grid',
                                   route: "get_ninja_tables_column",
                                   ninja_table_id:this.ninjaTableId
                               }).then((response)=>{
                                           this.ninja_table_column = response.data;
                                           this.handleCheckAllColumnChange();
                                       }
                ).always(()=>{
                    this.disableSubmit = false;
                })
            },
            getFormFields(){
                // get_fluentform_form_fields
                this.$adminGet({
                                   form_Id: this.fluentFormId,
                                   action: 'plugin_run_two_grid',
                                   route: "get_fluentform_form_fields",
                               }).then((response)=>{
                                   this.fluent_fields = response.data;
                                  this.handleCheckAllFluentChange()
                               }
                ).always(()=>{
                    this.disableSubmit = false;
                })
            },
            handleCheckAllFluentChange(val) {
                let options= this.fluent_fields.map(x => x.name)
                this.checkedFields = val ? options : [];
                this.isIndeterminate = false;
            },

            handleCheckedFFChange(value) {
                let checkedCount = value.length;
                this.checkAll = checkedCount === this.fluent_fields.length;
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.fluent_fields.length;

            },
            handleCheckAllColumnChange(val) {
                let options= this.ninja_table_column.map(x => x.name)
                this.checkedColumns = val ? options : [];
                this.isIndeterminate = false;
            },
            handleCheckedColumnChange(value) {
                let checkedCount = value.length;
                if(this.checkedColumns.length > 0 ){
                    this.disableSubmit = false;
                }
                this.checkAll = checkedCount === this.ninja_table_column.length;
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.ninja_table_column.length;

            },
            getData(){
                this.loading=true
                this.$adminGet({
                    route: "get_list_data",
                }).then((response)=>{
                        response.data = response.data.data;
                        return this.tableData = response.data;
                    }
                ).always(()=>{
                    this.loading=false
                })
            },
            getTestData(){

                this.$adminGet({
                    route: "get_fluentform_forms",
                }).then((response)=>{

                    console.log(response)

                    }
                )
            },
            handleEdit(index, row) {
                // this.editId = index;
                // this.dialogTableVisible = true;


                this.$router.push({ name: 'card_edit', params: { id:  index } });

            },
            handleDelete(index, row) {

                this.$confirm('Are you sure to delete?')
                    .then(_ => {

                        this.$adminPost({
                                            remove: index,
                                            route: "update_card",
                                            action: "plugin_run_two_grid",


                                        }).then((res)=>{

                                                    if(res.success!=true){
                                                        this.success(res,'error');
                                                    }
                                                    this.getData();
                                        }
                        );
                    })

            },
            preview(index) {
                    window.open(window.PluginRunTwoCardAdmin.siteurl+'/?plugin_run_two_card_card_preview='+index,'_blank')
            },
            goTolink(){
                let card_routes = {
                    'post':'post',
                    'ff':'fluent_form',
                    'nt':'ninja_table'
                };
                switch (this.sourceName) {
                    case "post":
                        this.$router.push({ name: 'new_card', params: { type: card_routes.post } });
                        break;
                    case "fluent-form":
                        if( this.checkedFields.length == 0 ){
                            this.$notify({
                                             showClose : true,
                                             message   : 'Select at least one field!',
                                             type      : 'error',
                                             offset    :40
                                         });
                            break ;
                        }
                        let query = {
                            form_id: this.fluentFormId,
                        };
                        let data={
                            fields: this.checkedFields
                        };
                        this.$router.push({ name: 'new_card',query: query ,params: { type: card_routes.ff , data : data} });
                        break;
                    case "ninja-table":

                        // checkedColumns
                        if( this.checkedColumns.length == 0 ){
                            this.$notify({
                                             showClose : true,
                                             message   : 'Select at least one column!',
                                             type      : 'error',
                                             offset    :40
                                         });
                            break ;
                        }
                        let query2 = {
                            table_id: this.ninjaTableId
                        };
                        let data2={
                            fields: this.checkedColumns
                        };

                        console.log(query2)
                        console.log('xx');
                        this.$router.push({ name: 'new_card',query: query2 ,params: { type: card_routes.nt , data : data2} });
                        break;
                    default:
                        this.$router.push({ name: 'new_card', params: { type: card_routes.post } });
                        break;

                }


                this.formModalVisible = false;

            }
        },
        computed : {

        },
        mounted() {
            console.log('ok')
            this.getData();
            this.getTestData();
            if(!window.wpf_clip_inited) {
                var clipboard = new Clipboard('.copy');
                clipboard.on('success', (e) => {
                    this.$message({
                                      message: 'Copied to Clipboard!',
                                      type: 'success',
                                      offset: 40
                                  });
                });
                window.wpf_clip_inited = true;
            }
        },
        components: {
            PostForm,

        },

    }
</script>
<style >
    .cc-main-container{
        padding: 20px;
    }
    .shortcode-text{
        border:1px solid #bec6cc;
        border-radius:5px;
        padding: 2px;
        background-color:#f5fdff;
        text-align:center;
    }
</style>

