<template>
        <div class="">
        <div class="cc_one_section_header">
            <!-- title -->
            <div class="cc_one_section_title">
                <div class="cc_section_actions">
                    {{formData.grid_name}}
                    <i style="cursor: pointer"  @click="gridNameDialogVisible=true" class="el-icon-edit">
                        Edit
                    </i>
                    <el-dialog title="Grid Name" :visible.sync="gridNameDialogVisible" width="30%">

                        <el-input v-model="formData.grid_name"></el-input>

                        <span slot="footer" class="dialog-footer">
                            <el-button type="primary" @click="gridNameDialogVisible = false">Update</el-button>
                          </span>
                    </el-dialog>

                </div>
            </div>



            <div class="cc_one_section_actions">
                <router-link to="/card_manager/card_list">
                    <el-button size="mini" type="default">
                        Back
                    </el-button>
                </router-link>
            </div>

            <div class="cc_one_section_actions">
                <el-button size="mini" :loading="saving" type="primary" @click="submit('formData')">
                    Submit
                </el-button>
            </div>

        </div>
        <el-row >
            <el-col  class="cc-main-section-body">
                <div class=" cc-preview-section" v-loading="loadingPreview">

                    <component
                            is="post_template_grid_1"
                            :postData=postData
                            :layoutData=formData
                            :key=componentKey
                    />
                </div>



            </el-col>

            <el-col class="cc-grid-settings cc-main-section-inner">
                <div class="">
                    <el-form :model="formData"  ref="formData" label-width="140px" class="cc-formdata">

                        <el-collapse v-model="activeNames" @change="">
                            <el-collapse-item title="Post Type" name="1">
                                <div>
                                    <!--    post type-->
                                    <el-select  v-model="formData.postType" @change="refreshPreview" placeholder="Select">
                                        <el-option
                                                v-for="item in allPostType"
                                                :key="item.name"

                                                :label="item.singular_name"
                                                :value="item.name">
                                        </el-option>
                                    </el-select>
                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Category" name="2">
                                <div>
                                    <el-select multiple  v-model="formData.category" @change="refreshPreview" placeholder="Select">
                                        <el-option
                                                v-for="item in allCategory"
                                                :key="item.category_id"
                                                :label="item.category_name"
                                                :value="item.category_id">
                                        </el-option>
                                    </el-select>
                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Taxonomy" name="3">
                                <div>
                                    <!--                            taxonomy-->
                                    <el-select  v-model="formData.taxonomy" placeholder="Select">
                                        <el-option
                                                v-for="item in allTaxonomies"
                                                :key="item.name"
                                                :label="item.label"
                                                :value="item.name">
                                        </el-option>
                                    </el-select>
                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Image" name="4">
                                <div>
                                    <p>Featured Image</p>
                                    <!--                            image-->
                                    <el-switch  @change="refreshComponent" v-model="formData.img_status" label="Show" border>Show</el-switch>



                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Button" name="5">
                                <div>

                                    <p>Button Text</p>
                                    <el-input
                                            v-model="formData.button_text"
                                            type="text"
                                            @change="refreshComponent"
                                    >
                                    </el-input>

                                    <p>Show</p>
                                    <el-switch  @change="refreshComponent" v-model="formData.button_status" label="Show" border>Show</el-switch>
                                    <p>Open in New Tab</p>
                                    <el-checkbox v-model="formData.button_newtab">Yes</el-checkbox>

                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Layout" name="5">
                                <div>
                                    <p>Layout Type</p>
                                    <!--                            type-->
                                    <el-select  v-model="formData.view" @change="generateCSS" placeholder="Select">
                                        <el-option
                                                v-for="item in layoutType"
                                                :key="item.value"
                                                :label="item.label"
                                                :disabled="item.disabled"
                                                :value="item.value">
                                        </el-option>
                                    </el-select>

                                    <p>Column</p>
                                    <el-select @change="generateCSS"  v-model="formData.columnNumber" placeholder="Select">
                                        <el-option
                                                key="1"
                                                label="1"
                                                value="1">
                                        </el-option>
                                        <el-option
                                                key="2"
                                                label="2"
                                                value="2">
                                        </el-option>
                                        <el-option
                                                key="3"
                                                label="3"
                                                value="3">
                                        </el-option>
                                        <el-option
                                                key="4"
                                                label="4"
                                                value="4">
                                        </el-option>
                                    </el-select>
                                    <p>Limit</p>
                                    <!--                            limit-->
                                    <el-input
                                            v-model="formData.limit"
                                            type="number"
                                            @change="refreshPreview"
                                            :min="1">
                                    </el-input>
                                    <p>Content Limit</p>
                                    <!--                            limit-->
                                    <el-input
                                            v-model="formData.content_limit"
                                            type="number"
                                            @change="refreshPreview"
                                            :min="1">
                                    </el-input>
                                    <p>Background Color</p>

                                    <el-color-picker @change="generateCSS" v-model="formData.bgColor"></el-color-picker>
                                    <p>Font Color</p>

                                    <el-color-picker @change="generateCSS" v-model="formData.fontColor"></el-color-picker>
                                    <p>Align</p>
                                    <el-select @change="generateCSS" v-model="formData.content_align"  placeholder="Select">
                                        <el-option label="Left" value="left"></el-option>
                                        <el-option label="Center" value="center"></el-option>
                                        <el-option label="Right" value="right"></el-option>
                                    </el-select>
                                    <p>Border Radius</p>
                                    <el-input
                                            v-model="formData.item_border_radius"
                                            type="number"
                                            @change="generateCSS"
                                            :min="0"
                                    >
                                    </el-input>

                                </div>
                            </el-collapse-item>

                        </el-collapse>
                    </el-form>
                </div>
            </el-col>

        </el-row>



    </div>

</template>
<script>

    import post_template_grid_1 from './templates/post_template_grid_1';

    export default {
        name: 'PostForm',

        props:['edit','id'],
        data() {
            return {
                activeNames:1,
                postData:'',
                componentKey:true,
                formattedPostCount:0,
                html_data:'',
                loadingPreview:false,
                layoutType:[
                    {
                        label:'List',
                        value:'list',

                    },
                    {
                        label:'Grid',
                        value:'grid',

                    },
                    {
                        label:'Masonary',
                        value:'masonary',
                        disabled: true
                    },
                    {
                        label:'Carousel',
                        value:'carousel',
                        disabled: true
                    }
                ],
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
                gridNameDialogVisible:false,
                saved: false,
                saving:false,
                formData: {
                    grid_source:'post',
                    grid_template:'template-one',
                    grid_name: 'New Grid',
                    postType: 'post',
                    columnNumber:'4',
                    content_limit: 30,
                    limit: 4,
                    taxonomy: '',
                    type: '',
                    img_status:true,
                    view:'grid',
                    limit:4,
                    bgColor:'#f56c6c',
                    fontColor:'#fff',
                    id:this.id,
                    content_align:'center',
                    item_border_radius:0,
                    button_text:'Read more',
                    button_newtab:false,
                    button_status: true

                },
                allPostType:[],
                allCategory:[],
                allTaxonomies: [],

            }
        },
        methods: {
            submit(formName) {
                this.submitForm(formName);
            },
            getPostData(){

                // get post type data
                this.$adminGet({
                    route: "get_post_data",
                }).then((data)=>{

                        data.data = data.data.data;
                        this.allPostType= data.data.post_types;
                        this.allCategory= data.data.categories;


                    }
                )
            },
            getEditCardData($id) {




                    // this.formData.taxonomy = post_settings.taxonomies;
                        // this.formData.category_id = post_settings.category;
                        // this.formData.limit = parseInt(post_settings.limit);
                        // this.formData.cardImage = post_settings.cardImage;
                        // this.formData.color = post_settings.color;
                        // this.formData.view = post_settings.view;

            },
            refreshPreview(){

                this.fetchTaxtonomy();
                this.fetchWpPostData();
                this.generateCSS();

                this.refreshComponent();
            },
            fetchTaxtonomy(){

                this.$adminPost({
                    route: "get_taxonomies",
                    data : this.formData.postType,
                }).then((data)=>{
                        this.allTaxonomies = data.data.data;
                    }
                )
            },
            fetchWpPostData(){
                this.loadingPreview = true;
                // get all wp posts
                this.$adminGet({
                               data: this.formData,
                               action: 'plugin_run_two_grid',
                               route: "get_wp_posts"
                           }).then((res)=>{
                           this.postData = res.data;
                       }
                    )
                    .always(()=>{
                        this.loadingPreview = false;
                        this.componentKey = !this.componentKey;
                    })

            },
            submitForm(formName) {

                this.saving = true;
                this.$adminPost({
                    data: JSON.stringify(this.formData),
                    action: 'plugin_run_two_grid',
                    route: "update_card"
                }).then((res)=>{



                        if( !this.edit &&  res.data.insert_id !== undefined){
                            this.formData.id = res.data.insert_id;

                            this.success('New Grid "' +this.formData.grid_name+'" Saved','success');
                            this.$router.push({ name: 'card_edit', params: { id:  res.data.insert_id } });
                        }else if (res.success === true){

                            this.success('Grid "' +this.formData.grid_name+'" Updated','success');

                        }else{
                            this.$showAjaxError(res);
                        }



                        //this.$emit('updated', '1')
                    }
                )
                .always(()=>{
                    this.saving =false;
                })
            },
            setPostData(){

                if(this.edit){
                    this.$adminPost({
                                        route: "get_card_data_by_id",
                                        id: this.$route.params.id,
                                        action: 'plugin_run_two_grid',
                                    }).then((res)=>{
                                                this.formData = JSON.parse(res.data.basicSettings);
                                                this.formData.id = this.$route.params.id;

                                }) .always(() => {
                                    this.refreshComponent();
                                    this.fetchWpPostData();
                                    this.generateCSS();
                                });



                }
                else{
                    // new grid
                    this.getNewGridKey();
                    this.fetchWpPostData()



                }


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
            generateCSS() {
                // let [header, ribbon, features, footer, price, border] = styleVars;
                let width ,displayForList,innerDisplayForList= '';
                if(this.formData.view =='list'){
                    width = '100%';
                    displayForList = 'display: flex;'
                    innerDisplayForList ='.wp-cc-grid-content{flex:2;} .wp-cc-grid-image {flex:1}'
                }else if(this.formData.view =='grid' || this.formData.view =='carousel'){
                    width = (100 / this.formData.columnNumber) + '%';
                    displayForList='';innerDisplayForList='';
                }

                let css =  `
                ${innerDisplayForList}
                .wp-cc-grid-item{
                      width: ${width};
                       text-align: ${this.formData.content_align};

                }

                .wp-cc-grid-div{
                      background-color: ${this.formData.bgColor};
                       ${displayForList}
                       border-radius: ${this.formData.item_border_radius}px;
                        overflow:hidden;
                }
                .wp-cc-grid-title,.wp-cc-grid-text,.wp-cc-grid-content,.wp-cc-grid a {
                    color: ${this.formData.fontColor}
                }
                 .wp-cc-grid  .btn {
                     border: 1px solid ${this.formData.fontColor};
                 }
                 `;
                jQuery('#plugin_run_one_admin_dynamic_style').html(css);

            },
            getNewGridKey(){
                // get all ninja table data
                this.$adminGet({
                                   action: 'plugin_run_two_grid',
                                   route: "get_new_grid_key"
                               }).then((res)=>{
                                           this.new_grid_key = res.data.id;
                                           this.formData.grid_name = 'New Grid #'+res.data.id;
                                       }
                    )
                    .fail(error => {
                        this.$showAjaxError(error);
                    })
            },
            refreshComponent(){
                this.componentKey = !this.componentKey;
            }

        },
        mounted() {

            this.getPostData();
            this.setPostData();
            this.generateCSS();

        },
        computed:{
          formattedPostData(){


              let data = this.postData;
              let post_type = this.formData.postType;
              let total = 0;
              if(!data){
                  return [];
              }

              return data.filter((x) => {

                  if(x.post_type == post_type){
                      total++;
                      this.formattedPostCount = total;
                      return x;
                  }

              });

          }
        },
        components: {
            post_template_grid_1
        },


    }
</script>
<style >
.cc-main-section-inner{
    padding: 20px;
}
.cc-grid-settings{
    max-width: 25%;
    position: absolute;
    right: 0px;
    top: 0px;
    min-height: 500px;

    border: 1px solid #fff;
}
.cc-grid-settings, .el-collapse-item__header, .el-collapse-item__content{
    background-color: #545c63;
    color:#fff;
}
.cc-grid-settings  .el-input--suffix .el-input__inner {
        background-color: white;
    }
    .cc-grid-settings .el-radio.is-bordered{
        background: white;
        width:100%;
        margin-left: 0px!important;
    }
    .cc_section_actions{
        display: flex;
        align-items: center;
    }
.cc_one_section_header{
    display: flex;
    align-items: center;
    padding: 10px 15px;}
    .cc-preview-section{

    }
    .cc-preview-section{
        max-height: 800px;
        min-height: 400px;
        overflow:auto;
    }
    .cc-main-section-body{
        min-height: 100vh;
    }

/* Overwrite the default to keep the scrollbar always visible */

::-webkit-scrollbar {
    -webkit-appearance: none;
    width: 7px;
}

::-webkit-scrollbar-thumb {
    border-radius: 4px;
    background-color: rgba(0,0,0,.5);
    -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
}

</style>

