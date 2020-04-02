<template>
    <div class="cc-main-container">

        <el-card class="box-card" shadow="hover">
            <div slot="header" class="clearfix">


                <el-table :data="tableData" style="width: 100%">


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

                        <el-table-column label="Short Code" width="250">
                            <template slot-scope="scope" >
                                <div  class="shortcode-text">
                                    [pluginrunone_card id="{{ scope.row.id }}" ]

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
                                <br>
                                <span style="margin-left: 10px;font-size: 10px;">{{ scope.row.created_at }}</span>


                            </template>
                        </el-table-column>
                    </el-table>
                </el-row>

                <el-dialog title="Edit Card" :visible.sync="dialogTableVisible">
                    <CardForm edit="true" :id="editId" @updated="refresh" />
                </el-dialog>

            </div>

        </el-card>

    </div>
</template>
<script>
    // import AddCard from './../AddCard';
    import CardForm from "./CardForm";

    export default {
        name: 'CardList',
        data() {
            return {
                tableData: [],
                dialogTableVisible : false,
                editId :'',
            };
        },
        methods: {
            refresh(){
                this.getData();
                this.dialogTableVisible = false;
            },
            getData(){
                this.$adminGet({
                    route: "get_list_data",
                }).then((response)=>{
                        response.data = response.data.data;
                        return this.tableData = response.data;
                    }
                )
            },
            handleEdit(index, row) {
                this.editId = index;
                this.dialogTableVisible = true;

            },
            preview(index) {
                    window.open(window.pluginRunOneCardAdmin.siteurl+'/?plugin_run_one_card_card_preview='+index,'_blank')
            }
        },
        computed : {

        },
        mounted() {
            this.getData();
        },
        components: {
            CardForm,

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

