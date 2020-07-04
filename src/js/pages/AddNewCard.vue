<template>
    <div class="cc-main-container">

        <el-card class="box-card">
            <div slot="header" class="clearfix">
                <h2>Add New Card</h2>

                <el-button class="pull-right" round @click="cardFormVisible = true" type="primary">Add New</el-button>
                <el-button class="pull-right" round to="/new_card" type="primary">Add New2</el-button>

                <router-link to="/card_manager">Back</router-link>
                <el-dialog

                        :visible.sync="cardFormVisible"
                        title="Add New Card"
                        center>

                    <CardForm />

                </el-dialog>

            </div>
            <el-steps :active="active" finish-status="success" align-center>
                <el-step title="Step 1" description="Some description">
                    <h1>Hello</h1>
                </el-step>
                <el-step title="Step 2" description="Some description">
                    <h1>Hello</h1>

                </el-step>
                <el-step title="Step 3" description="Some description">
                    <h1>Hello</h1>

                </el-step>
                <el-step title="Step 4" description="Some description">
                    <h1>Hello</h1>

                </el-step>
            </el-steps>
            <el-button  style="margin: ;: 12px; float:right;" @click="next">Next step</el-button>
        </el-card>


    </div>
</template>
<script>

    export default {
        name: 'AddNewCard',
        data() {
            return {
                active:0
            };
        },
        methods: {

            next() {
                if (this.active++ > 2) this.active = 0;
            }
        },
        mounted() {

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

