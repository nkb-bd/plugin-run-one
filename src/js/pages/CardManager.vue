<template>
    <div class="cc-main-container">

        <el-card class="box-card">

            <el-row class="tac">
<!--                hiding inner menu in new grid form-->
                <el-col v-if="this.$router.currentRoute.name=='card_list'"  :span="4">
                    <el-menu
                            default-active="1"
                            class="p-one-el-menu-vertical-inner"
                            background-color="#545c64"
                            text-color="#fff"
                            active-text-color="#ffd04b">


                        <router-link :to="{name:'card_list'}">
                            <el-menu-item index="1">
                                Grid List
                            </el-menu-item>
                        </router-link>




                    </el-menu>
                </el-col>


                    <router-view></router-view>

            </el-row>


        </el-card>



    </div>
</template>
<script>
    import CardList from "../components/card/CardList";

    export default {
        name: 'Dashboard',
        data() {
            return {
                showSidemenu:true,
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
                        this.$router.push({ name: 'new_card', params: { type: card_routes.ff } });
                        break;
                    case "ninja-table":
                        this.$router.push({ name: 'new_card', params: { type: card_routes.nt } });
                        break;
                    default:
                        this.$router.push({ name: 'new_card', params: { type: card_routes.post } });
                        break;

                }


                this.formModalVisible = false;

            }


        },
        mounted() {

        },
        components: {
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
    .el-header {
        background-color: #B3C0D1;
        color: #333;
        line-height: 60px;
    }
    .p-one-el-menu-vertical-inner a {
        color: #fff;
    }
    .p-one-el-menu-vertical-inner .is-active{
        background-color: #24282d!important;
    }
    .box-card{
        border-radius:0px;
    }
    .pull-right{
        float: right;
    }
    .pull-left{
        float: left;
    }
</style>

