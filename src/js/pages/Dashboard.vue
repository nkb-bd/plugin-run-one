<template>
    <div class="cc-main-container">

            <el-tabs type="border-card" v-model="activeName">
                <el-tab-pane label="Manage Settings" name="first">

                    <el-form ref="form" :model="formData" label-width="120px">

                        <el-form-item label="CPT Manager" >
                            <el-switch
                                    style="display: block"
                                    v-model="formData.cpt_manager"
                                    active-color="#13ce66"
                                    class="cc-admin-input"
                                    inactive-color="#ccc"
                            >
                            </el-switch>
                        </el-form-item>

                        <el-form-item label="Taxonomy Manager">
                            <el-switch
                                    style="display: block"
                                    v-model="formData.taxonomy_manager"
                                    active-color="#13ce66"
                                    inactive-color="#ccc"
                                    class="cc-admin-input"
                            >
                            </el-switch>
                        </el-form-item>
                        <el-form-item label="Grid Managner">
                            <el-switch
                                    style="display: block"
                                    v-model="formData.card_manager"
                                    active-color="#13ce66"
                                    inactive-color="#ccc"
                                    class="cc-admin-input"
                                  >
                            </el-switch>
                        </el-form-item>

                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">Update</el-button>
                        </el-form-item>
                    </el-form>

                </el-tab-pane>
                <el-tab-pane label="About" name="second">
                    <p>Plugin run two </p>
                    <ol >
                        <li>Grid Manager</li>
                        <ul style="margin-left: 10px;list-style: inside;">
                            <li>Create grid from post, fluent forms and ninja table</li>
                            <li>Change grid layout skin & color</li>
                            <li>Select fluent forms or ninja table fields or reorder them</li>
                            <li>Change background color , border radius</li>
                        </ul>
                        <li>CPT Manager</li>
                        <li>Taxonomy Manager</li>
                    </ol>
                </el-tab-pane>
            </el-tabs>


    </div>
</template>
<script>

    export default {
        name: 'Dashboard',
        data() {
            return {
                activeName: 'first',
                formData: {
                    cpt_manager: false,
                    taxonomy_manager: false,
                    card_manager: false,
                }
            };
        },
        methods: {
            onSubmit(){

                this.$adminPost({
                    data: JSON.stringify(this.formData),
                    route: "update_modules"
                }).then(()=>{
                    this.success('Modules  Updated','success');
                    this.$emit('updateMenu',1);

                    }
                )
            },
            success(message , type) {
                this.$notify({
                    showClose : true,
                    message   : message,
                    type      : type,
                    offset    :40
                });
            },
            // getData(){
            //     console.log('called');
            //     this.$adminGet({
            //         route: "get_list_data",
            //
            //     }).then((response)=>{
            //             response.data = response.data.data;
            //             this.tableData = response.data;
            //             this.dialogTableVisible = false;
            //
            //         }
            //     )
            // },

        },
        mounted() {
            this.$adminGet({
                route: "get_modules_db"
            }).then((res)=>{
                    let modules = JSON.parse(res.data.data);
                    this.formData ={
                        cpt_manager: (modules['cpt_manager']===true),
                        taxonomy_manager: (modules['taxonomy_manager']===true),
                        card_manager: (modules['card_manager'] == true),
                    }

                }
            )
        },
        components: {

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
    .el-form-item label{
        min-width: 120px;
    }
</style>

