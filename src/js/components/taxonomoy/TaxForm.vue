<template>
    <div class="cc-main-container">

        <el-form :model="formData" :rules="rules" ref="formData" label-width="120px" class="demo-formData">


            <el-form-item label="Taxonomy Id" prop="name" v-if="edit">
                <el-input :disabled="true" v-model="formData.taxonomy"></el-input>
            </el-form-item>

            <el-form-item label="Taxonomy Id" prop="taxonomy" v-else>
                <el-input v-model="formData.taxonomy"></el-input>
            </el-form-item>

            <el-form-item label="Singular Name" prop="singular_name" required>
                <el-input v-model="formData.singular_name" placeholder="Singular Name">

                </el-input>
            </el-form-item>


            <el-form-item label="Hierarchical ">
                <el-switch
                        style="display: block"
                        v-model="formData.hierarchical"
                        active-color="#13ce66"
                        inactive-color="#ccc"
                        class="cc-admin-input"
                >
                </el-switch>
            </el-form-item>

            <el-form-item label="Post">
                <el-select @change="selectedPost()"  v-model="formData.object" multiple placeholder="Select">
                    <el-option
                            v-for="item in postList"
                            :key="item.name"
                            :label="item.singular_name"
                            :value="item.name">
                    </el-option>
                </el-select>
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
        name: 'TaxForm',
        props:['edit','id'],
        data() {
            return {
                formData: {
                    taxonomy: '',
                    singular_name: '',
                    hierarchical: '',
                    public: false,
                    object: ''



                },
                postList:[],
                rules: {

                    taxonomy: [
                        { required: true, message: 'Please enter cpt  name', trigger: 'change' }
                    ],
                    singular_name: [
                        { required: true, message: 'Please enter  singular name', trigger: 'change' }
                    ],
                    hierarchical: [
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
                console.log(this.formData);
                this.$adminPost({
                    data: this.formData,
                    route: "update_tax"
                }).then(()=>{
                        if(this.edit){
                            this.success(this.formData.taxonomy+'"  Updated','success');
                        }else{
                            this.success(this.formData.taxonomy+'" Saved','success');
                            this.resetForm('formData')

                        }
                        this.$emit('updated', '1')
                    }
                )
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            selectedPost(){
                    // console.log(this.formData.object)
            },
            getEditData(id){
                this.$adminPost({
                    route: "get_tax_data_by_id",
                    id: id

                }).then((res)=>{

                    this.formData = res.data.data;
                    if(this.formData.object){
                        this.formData.object  = res.data.data.object;
                    }


                    }
                );
            },
            getPostData(){
                // get post data
                this.$adminGet({
                    route: "get_post_data",
                }).then((data)=>{

                        let post_data = data.data.data.post_types;
                        this.postList = post_data;

                    }
                )
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


            this.getPostData();

            if(this.edit){
                this.getEditData(this.id);
            }

        },
        watch: {
            id: function(newVal, oldVal) { // watch it

                this.formData.taxonomy = newVal;
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

