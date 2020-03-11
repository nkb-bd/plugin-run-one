<template>
    <div class="cc-main-container">

        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h2>Manage Custom Post Types</h2>

                <el-button class="pull-right" round @click="cptFormVisible = true" type="primary">Add New</el-button>

                <el-dialog

                        :visible.sync="cptFormVisible"
                        title="Add New Custom Post Type"
                        center>

                    <CptForm  @updated="refresh" />


                </el-dialog>
            </div>



            <el-tabs type="nav" class="cc-inner-nav" tab-position="left" style="height: auto;">

                <el-tab-pane label="CPT List">
                    <CptList :key="reload" />
                </el-tab-pane>


                <el-tab-pane label="Export">
                    <CptExport/>
                </el-tab-pane>

            </el-tabs>

        </el-card>



    </div>
</template>
<script>

    import CptForm from "../components/cpt/CptForm";
    import CptList from "../components/cpt/CptList";
    import CptExport from "../components/cpt/CptExport";

    export default {
        name: 'Dashboard',
        data() {
            return {
                activeName: 'first',
                reload:false,
                cptFormVisible: false,
                cpt:false,
                taxonomy:false,
                card:false,
                form: {
                    cpt: false,
                    taxonmoy: false,
                    card: false,
                },
                tableData: [],
                search: '',
            };
        },
        methods: {
            handleClick(tab, event) {
            },
            getData(){
                this.$adminGet({
                    route: "get_cpt_list_data",

                }).then((response)=>{
                        response.data = response.data.data;
                        this.tableData = response.data;
                        this.dialogTableVisible = false;

                    }
                )
            },
            onSubmit() {
                console.log('submit!');
            },
            refresh(){

                this.getData();
                this.reload= !this.reload;
                this.cptFormVisible= false;
            },

        },
        mounted() {

        },
        components: {
            CptForm,
            CptList,
            CptExport

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
    .cc-admin-input{
       padding: 10px;
    }

</style>

