<template>
    <div class="p-one-body"  v-loading="loading">

        <el-card class="box-card" shadow="none"  >


            <div v-if="gridSource === 'post'">
                <PostForm :edit='true'/>
            </div>

            <div v-else-if="gridSource === 'fluent_form'">

                <FluentForm :edit='true'  />
            </div>

            <div v-else-if="gridSource === 'ninja_table'">

                <NinjaTable   :edit='true'  />
            </div>



        </el-card>


    </div>
</template>
<script>
    import PostForm from "../components/card/PostForm";
    import FluentForm from "../components/card/FluentForm";
    import NinjaTable from "../components/card/NinjaTable";
    export default {
        name: 'EditGrid',
        props: ['type','data'],
        data() {
            return {
                active: 1,
                isPost: false,
                isFF: false,
                isNT: false,
                loading:false,
                gridData:'',
                gridSource:''
            };
        },
        methods: {

            getEditData($id) {

                 this.$adminPost({
                        route: "get_card_data_by_id",
                        id: $id,
                        action: 'plugin_run_two_grid',
                    })
                     .then(res => {
                         let settings = JSON.parse( res.data.basicSettings);
                         this.gridSource = settings.grid_source;

                     })

                     .fail(error => {


                     })
                     .always(() => {
                         this.loading = false;
                     });

            },
        },
        mounted() {
            this.getEditData(this.$route.params.id)

        },
        components: {

        },
        computed:{

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

