<template>
    <div class="cc-main-container">
        <el-card class="box-card" shadow="hover">
            <el-table :data="tableData" style="width: 100%">


                <el-table-column label="ID" width="">
                    <template slot-scope="scope">
                        <span style="margin-left: 10px">{{ scope.row.post_type }}</span>
                    </template>
                </el-table-column>

                <el-table-column label="Singular Name" width="" prop="name">
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            {{ scope.row.singular_name }}
                        </div>
                    </template>
                </el-table-column>

                <el-table-column label="Plural Name" width="" prop="name">
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            {{ scope.row.plural_name }}
                        </div>
                    </template>
                </el-table-column>

                <el-table-column label="Action">


                    <template slot-scope="scope">
                        <el-button
                                size="mini"
                                @click="handleEdit(scope.row.post_type, scope.row)">Edit</el-button>
                        <el-button
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.row.post_type, scope.row)">Delete</el-button>
                    </template>
                </el-table-column>




            </el-table>
            </el-row>
        </el-card>

        <el-dialog

                :visible.sync="cptFormVisible"
                title="Edit Custom Post Type"
                center>

            <CptForm edit="true" :id="editId" @updated="refresh" />

        </el-dialog>

    </div>
</template>
<script>
    // import AddCard from './AddCard';
    import CptForm from "./CptForm";

    export default {
        name: 'CptList',
        data() {
            return {
                tableData: [],
                cptFormVisible : false,
                editId :'',
                deleteId :'',
                search: '',
            };
        },
        methods: {
            refresh(){

                this.getData();
                this.cptFormVisible= false;
            },
            getData(){
                this.$adminGet({
                    route: "get_cpt_list_data",

                }).then((response)=>{

                        this.tableData = response.data.data;
                        this.dialogTableVisible = false;

                    }
                )
            },
            handleEdit(index, row) {

                this.editId = index;
                this.cptFormVisible = true;

            },
            handleDelete(index, row) {

                this.$confirm('Are you sure to delete?')
                    .then(_ => {

                        this.$adminPost({
                            remove: index,
                            route: "update_cpt",


                        }).then((res)=>{

                                if(res.success!=true){
                                    this.success(res,'error');
                                }
                                this.getData();
                                // this.success('Deleted','danger');

                            }
                        );
                    })

            },
            success(message , type) {
                this.$notify({
                    showClose : true,
                    message   : message,
                    type      : type,
                    offset    :40
                });
            }
        },
        mounted() {
            this.getData();
        },
        components: {
            CptForm
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
    }
</style>

