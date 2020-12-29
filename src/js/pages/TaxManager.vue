<template>
    <div class="cc-main-container">

        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h2>Manage Custom Taxonomies</h2>

                <el-button class="pull-right" round @click="taxFormVisible = true" type="primary">Add New</el-button>

                <el-dialog

                        :visible.sync="taxFormVisible"
                        title="Add New Taxonomy"
                        center>

                    <TaxForm @updated="refresh" />

                </el-dialog>
            </div>



            <el-tabs class="cc-inner-nav" tab-position="left" >
                <el-tab-pane label="Taxonomy List">
                    <TaxonomtList :key="reload"/>
                </el-tab-pane>

            </el-tabs>

        </el-card>



    </div>
</template>
<script>
import TaxForm from "../components/taxonomoy/TaxForm";
import TaxonomtList from "../components/taxonomoy/TaxonomyList";
    export default {
        name: 'Dashboard',
        data() {
            return {
                taxFormVisible: false,
                activeName: 'first',
                cpt:false,
                taxonomy:false,
                card:false,
                reload:false,
                form: {
                    cpt: false,
                    taxonmoy: false,
                    card: false,
                }
            };
        },
        methods: {
            handleClick(tab, event) {
                console.log(tab, event);
            },
            getData(){
                console.log('called');
                this.$adminGet({
                    route: "get_list_data",

                }).then((response)=>{
                        response.data = response.data.data;
                        this.tableData = response.data;
                        this.dialogTableVisible = false;

                    }
                )
            },
            refresh() {
                this.reload= !this.reload;
                this.taxFormVisible = false;
            }

        },
        mounted() {

        },
        components: {
            TaxForm,
            TaxonomtList

        },

    }
</script>
<style >

</style>

