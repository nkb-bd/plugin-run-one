<template>
    <div class="cc-main-container">

        <el-form :model="formData" :rules="rules" ref="formData" label-width="140px" class="cc-formdata">
            <!--                            card name-->
            <el-form-item label="Card name" prop="cardName">
                <el-input v-model="formData.cardName"></el-input>
            </el-form-item>

            <!--                            post type-->
            <el-form-item label="Post Type" prop="postType">
                <el-select  v-model="formData.postType" @change="fetchTaxtonomy" placeholder="Select">
                    <el-option
                            v-for="item in allPostType"
                            :key="item.name"
                            :label="item.singular_name"
                            :value="item.name">
                    </el-option>
                </el-select>
            </el-form-item>

            <!--                            category-->
            <el-form-item label="Category" prop="category">
                <el-select  v-model="formData.category"  placeholder="Select">
                    <el-option
                            v-for="item in allCategory"
                            :key="item.category_id"
                            :label="item.category_name"
                            :value="item.category_id">
                    </el-option>
                </el-select>
            </el-form-item>

            <!--                            taxonomy-->
            <el-form-item label="Taxonomy" prop="taxonomy">
                <el-select  v-model="formData.taxonomy" placeholder="Select">
                    <el-option
                            v-for="item in allTaxonomies"
                            :key="item.name"
                            :label="item.label"
                            :value="item.name">
                    </el-option>
                </el-select>
            </el-form-item>

            <!--                            image-->
            <el-form-item label="Card Image" prop="cardImage">
                <el-radio v-model="formData.cardImage" label="featured_image" border>Featured Image</el-radio>
                <el-radio v-model="formData.cardImage" label="color" border>Color</el-radio>
            </el-form-item>

            <!--                            image-->
            <el-form-item label="Card View" prop="view">
                <el-radio v-model="formData.view" label="list" border>List</el-radio>
                <el-radio v-model="formData.view" label="grid" border>Grid</el-radio>
            </el-form-item>


            <!--                            limit-->
            <el-form-item label="Card Limit " prop="limit">
                <el-input
                        v-model="formData.limit"
                        type="number"
                        :min="1">
                </el-input>
            </el-form-item>

            <el-form-item label="Background Color " prop="">
                <el-color-picker v-model="formData.color"></el-color-picker>
            </el-form-item>




            <el-form-item>
                <el-button type="primary" @click="submit('formData')">
                 Submit
                </el-button>
                <el-button @click="resetForm('formData')">Reset</el-button>
            </el-form-item>
        </el-form>

    </div>
</template>
<script>
    // import AddCard from './AddCard';

    export default {
        name: 'CardForm',

        props:['edit','id'],
        data() {
            return {
                formData: {
                    cardName: '',
                    postType: '',
                    taxonomy: '',
                    type: '',
                    cardImage:'',
                    view:'',
                    limit:1,
                    color:'',
                    id:this.id

                },
                allPostType:[],
                allCategory:[],
                allTaxonomies: [],
                rules: {
                    cardName: [
                        { required: true, message: 'Please input Card Name', trigger: 'blur' },
                    ],
                    postType: [
                        { required: true, message: 'Please Select Post Type', trigger: 'blur' },
                    ],
                    category: [
                        { required: false, message: 'Please Select category', trigger: 'blur' },
                    ],
                    taxonomy: [
                        { required: false, message: 'Please Select taxonomy', trigger: 'blur' },
                    ],
                    cardImage: [
                        { required: true, message: 'Please Select image type', trigger: 'blur' },
                    ],
                    limit: [
                        { required: true, message: 'Please Select card maximum card number', trigger: 'blur' },
                    ],
                    view: [
                        { required: true, message: 'Please Select view', trigger: 'blur' },
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
            getPostData(){
                // get post data
                this.$adminGet({
                    route: "get_post_data",
                }).then((data)=>{

                        data.data = data.data.data;
                        this.allPostType= data.data.post_types;
                        this.allCategory= data.data.categories;
                        this.allPostType.push (
                            {
                                name: 'any',
                                singular_name: 'Any Post Type',
                            }
                        );
                        this.allCategory.push (
                            {
                                category_id: 'any',
                                category_name: 'Any Category',
                            }
                        );

                    }
                )
            },
            getEditCardData($id) {


                this.$adminPost({
                    route: "get_post_data_by_id",
                    card_id: $id

                }).then((res)=>{

                        let data = res.data.data;
                        this.formData.cardName= data.card_name;
                        this.formData.limit = parseInt(data.limit);

                        let post_settings = JSON.parse( data.basicSettings);
                        this.formData.postType = post_settings.post_type;
                        this.formData.taxonomy = post_settings.taxonomies;
                        this.formData.category_id = post_settings.category;
                        this.formData.limit = parseInt(post_settings.limit);
                        this.formData.cardImage = post_settings.cardImage;
                        this.formData.color = post_settings.color;
                        this.formData.view = post_settings.view;

                    }
                );
            },
            fetchTaxtonomy(){

                this.$adminPost({

                    route: "get_taxonomies",
                    data : this.formData.postType,

                }).then((data)=>{
                        this.allTaxonomies =data.data.data;
                    }
                )
            },
            submitForm(formName) {

                //submit form data
                this.$adminPost({
                    data: this.formData,
                    route: "update_card"
                }).then(()=>{
                        if(this.edit){
                            console.log(this.id);
                            console.log('edit');
                            this.success('Card "' +this.formData.cardName+'"  Updated','success');

                        }else{
                            this.success('New Card "' +this.formData.cardName+'" Saved','success');

                        }
                        this.$emit('updated', '1')
                    }
                )
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
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
                this.getEditCardData(this.id );
            }

        },
        components: {

        },
        watch: {
            id: function(newVal, oldVal) { // watch it
                this.formData.id = newVal;
                this.getEditCardData(newVal);
            },
        },

    }
</script>
<style >

</style>

