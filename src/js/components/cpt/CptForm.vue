<template>
    <div class="cc-main-container">

        <el-form :model="formData" :rules="rules" ref="formData" label-width="120px" class="demo-formData">


            <el-form-item label="CPT Id" prop="name" v-if="edit">
                <el-input :disabled="true" v-model="formData.post_type"></el-input>
            </el-form-item>

            <el-form-item label="CPT Id" prop="post_type" v-else>
                <el-input v-model="formData.post_type"></el-input>
            </el-form-item>

            <el-form-item label="Singular Name" prop="singular_name" required>
                <el-input v-model="formData.singular_name" placeholder="Singular Name">

                </el-input>
            </el-form-item>

            <el-form-item label="Plural Name" prop="plural_name" required>
                <el-input v-model="formData.plural_name" placeholder="Plural name">

                </el-input>
            </el-form-item>

            <el-form-item label="Public ">
                <el-switch
                        style="display: block"
                        v-model="formData.public"
                        active-color="#13ce66"
                        inactive-color="#ccc"
                        class="cc-admin-input"
                >
                </el-switch>
            </el-form-item>


            <el-form-item>
                <el-button type="primary" @click="submit('formData')">Submit</el-button>
                <el-button @click="resetForm('formData')">Reset</el-button>
            </el-form-item>
        </el-form>

    </div>
</template>
<script>
    // import AddCard from './AddCard';

    export default {
        name: 'CptForm',
        props:['edit','id'],
        data() {
            return {
                formData: {
                    post_type: '',
                    singular_name: '',
                    plural_name: '',
                    public: '',

                },
                rules: {

                    post_type: [
                        { required: true, message: 'Please enter cpt  name', trigger: 'change' }
                    ],
                    singular_name: [
                        { required: true, message: 'Please enter  singular name', trigger: 'change' }
                    ],
                    plural_name: [
                        { required: true, message: 'Please enter public name', trigger: 'change' }
                    ],

                }
            }
        },
        methods: {
            submit(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.submitForm(formName);
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            submitForm(formName) {
                this.$adminPost({
                    data: this.formData,
                    route: "update_cpt"
                }).then((res)=>{

                        if(res.success ==false){
                            this.success('Data "' +res+'"  error','error');
                            return;
                        }
                        if(this.edit){

                            this.success(this.formData.singular_name+'"  Updated','success');

                        }else{
                            this.success(this.formData.singular_name+'" Saved','success');
                            this.resetForm('formData')

                        }
                        this.$emit('updated', '1')
                    }
                )
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },

            getEditData(id){

                this.$adminPost({
                    route: "get_cpt_data_by_id",
                    cpt_id: id

                }).then((res)=>{

                    if(res.success!=true){
                        this.success(res,'error');
                    }
                    this.formData = res.data.data;

                    if(this.formData.public == 'true'){
                        this.formData.public = true;
                    }


                    }
                );
            },

            handleEdit(index, row) {
                this.editId = index;
                this.dialogTableVisible = true;

            },

            handleDelete(index, row) {

            },

            success(message , type) {
                this.$notify({
                    showClose : true,
                    message   : message,
                    type      : type,
                    offset    :40
                });
            },
        },
        mounted() {

            if(this.edit){
                this.getEditData(this.id);
            }
        },
        watch: {
            id: function(newVal, oldVal) { // watch it

                this.formData.post_type = newVal;
                this.getEditData(newVal);
            },
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

