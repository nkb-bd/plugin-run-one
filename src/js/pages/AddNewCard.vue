<template>
    <div class="p-one-body">

        <el-card class="box-card" shadow="none" >



            <div v-if="loadComponent == 'post'">
                <PostForm/>
            </div>
            <div v-else-if="loadComponent == 'fluent_form'">
                <FluentForm :fieldData = data />

            </div>
            <div v-else-if="loadComponent == 'ninja_table'">

                <NinjaTable  :columnData = data />
            </div>



        </el-card>


    </div>
</template>
<script>
    import PostForm from "../components/card/PostForm";
    import FluentForm from "../components/card/FluentForm";
    import NinjaTable from "../components/card/NinjaTable";
    export default {
        name: 'AddNewCard',
        props: ['type','data'],
        data() {
            return {
                active: 1,
                isPost: false,
                isFF: false,
                isNT: false
            };
        },
        methods: {


        },
        mounted() {


        },
        components: {

        },
        computed:{
           loadComponent(){
               return this.type;
           }
        },
        components : {
            PostForm, FluentForm, NinjaTable
        }



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
    .el-form-item label{
        min-width: 120px;
    }
    .el-card__body{
        padding: 0;
    }
    .p-one-text-center{
        text-align: center;
    }
    .p-one-section-body{
        padding:20px;
    }
    .p-one-sectoin-header{
        padding:20px 0px;
        background: antiquewhite;
    }
    h2{
        margin: 0px;
    }
</style>

