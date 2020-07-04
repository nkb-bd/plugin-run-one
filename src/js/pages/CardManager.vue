<template>
    <div class="cc-main-container">

        <el-card class="box-card">

            <div slot="header" class="clearfix">
                <h2>Manage Cards created from Post Types</h2>

                <el-button class="pull-right" round @click="cardFormVisible = true" type="primary">Add New</el-button>
                <el-button class="pull-right" round  @click="formModalVisible = true" type="primary">Add New</el-button>

                <router-link to="/new_card">Add new 2</router-link>
                <el-dialog

                        :visible.sync="cardFormVisible"
                        title="Add New Card"
                        center>

                    <CardForm />

                </el-dialog>
                <el-dialog

                        :visible.sync="formModalVisible"
                        title="New Grid "
                        width="35%"
                        center>


                           <div>
                               <el-form>
                               <el-form-item>

                                   <el-select style="width:100%;background:#fff;"  v-model="sourceName" placeholder="Grid Source">
                                       <el-option
                                               v-for="item in gridSource"
                                               :key="item.value"
                                               :label="item.label"
                                               :value="item.value">
                                       </el-option>
                                   </el-select>
                               </el-form-item>




                               <el-form-item  style="text-align:center;">
                                   <el-button    @click="" type="primary">Next</el-button>
                               </el-form-item>

                               </el-form>

                           </div>

                </el-dialog>


            </div>


            <el-tabs class="cc-inner-nav" tab-position="left">
                <el-tab-pane label="Card List">
                    <CardList />

                </el-tab-pane>

            </el-tabs>

        </el-card>



    </div>
</template>
<script>
    import CardList from "../components/card/CardList";
    import CardForm from "../components/card/CardForm";

    export default {
        name: 'Dashboard',
        data() {
            return {
                gridSource:[
                    {
                        label:'Post',
                        value:'post'
                    },
                    {
                        label:'Fluent Form',
                        value:'fluent-from'
                    },
                    {
                        label:'Ninja Table',
                        value:'ninja-table'
                    }
                ],
                sourceName:'',
                cardFormVisible: false,
                formModalVisible: false,
                activeName: 'first',
                cpt:false,
                taxonomy:false,
                card:false,
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
            onSubmit() {
                console.log('submit!');
            }

        },
        mounted() {

        },
        components: {
            CardForm,
            CardList

        },

    }
</script>
<style >

    .shortcode-text{
        border:1px solid #bec6cc;
        border-radius:5px;
        padding: 2px;
        background-color:#f5fdff;
    }
    .cc-admin-input{
       padding: 10px;
    }
    .el-input--suffix .el-input__inner{
        background-color:transparent;
    }
</style>

