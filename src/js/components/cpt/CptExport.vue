<template>
    <div class="cc-main-container">
        <el-row :gutter="20">
            <h4>Export</h4>

            <el-col :span="24">
                <el-select @change="exportCpt()" v-model="cpt_key" placeholder="Select">
                    <el-option
                            v-for="item in cptData"
                            :key="item.post_type"
                            :label="item.singular_name"
                            :value="item.post_type">
                    </el-option>
                </el-select>
            </el-col>



        </el-row>




        <div >
            <h4>Select a post type</h4>

            <pre class="prettyprint" v-if="html_data.length">
            {{html_data}}
            </pre>
        </div>

    </div>
</template>
<script>
    import CptForm from "./CptForm";
    import prettyPrint from 'code-prettify';


    export default {
        name: 'CptExport',
        data() {
            return {
                dialogVisible : false,
                cptData:[],
                cpt_key:'',
                html_data:''
            };
        },
        methods: {
            exportCpt(){

                if(this.cpt_key!=''){

                    this.$adminGet({
                        route: "cpt_export",
                        id: this.cpt_key

                    }).then((response)=>{

                            this.html_data = response;


                        }
                    )
                    this.dialogVisible =true;
                }

            },
            getData(){
                this.$adminGet({
                    route: "get_cpt_list_data",

                }).then((response)=>{

                        this.cptData = response.data.data;


                    }
                )
            },

        },
        mounted() {
            this.$nextTick(function() {
                // prettyPrint.prettyPrint();
            });
            this.getData();
        },
        components: {

        },

    }
</script>
<style >
    .cc-main-container{
        padding: 20px;
    }
    .prettyprint{
        color:#e1f3d8;
    }

    .shortcode-text{
        border:1px solid #bec6cc;
        border-radius:5px;
        padding: 2px;
        background-color:#f5fdff;
    }
</style>

