<template>
    <div >
        <!---->
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
                <el-button size="mini"  :loading="saving" type="primary" @click="submit('formData')">
                    Submit
                </el-button>
            </div>

        </div>
        <!---->
        <el-row >

            <el-col  class="cc-main-section-body">
                <div class=" cc-preview-section" v-loading="loadingPreview">
                    <component
                            is="fluent_template_grid_1"
                            :postData=formattedfluentData
                            :layoutData=formData
                            :key=componentKey
                    />

                </div>

            </el-col>

            <el-col class="cc-grid-settings cc-main-section-inner">
                <div class="">
                    <el-form :model="formData"  ref="formData" label-width="140px" class="cc-formdata">

                        <el-collapse v-model="activeNames" @change="">
                            <el-collapse-item title="Title" name="1">
                                <div>
                                    <!--    title-->

                                    <el-select  v-model="formData.title"  @change="refreshComponent" placeholder="Select">
                                        <el-option
                                                v-for="item in formData.fluentFormData.fieldData"
                                                :key="item"
                                                :label="item"
                                                :value="item">
                                        </el-option>
                                    </el-select>
                                    <p>Show</p>
                                    <el-switch  @change="refreshComponent" v-model="formData.title_status" label="Show" border>Show</el-switch>


                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Content" name="2">
                                <div>
                                    <el-select  v-model="formData.content" @change="" placeholder="Select">
                                        <el-option
                                                v-for="item in formData.fluentFormData.fieldData"
                                                :key="item"
                                                :label="item"
                                                :value="item">
                                        </el-option>
                                    </el-select>
                                    <p>Show</p>
                                    <el-switch  @change="refreshComponent" v-model="formData.content_status" label="Show" border>Show</el-switch>

                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Field List" name="3">
                                <div>

                                    <p>Border</p>
                                    <el-switch  @change="generateCSS" v-model="formData.field_border" label="Show" border>Show</el-switch>
                                    <p v-if="formData.field_border == true">Border Color</p>
                                    <el-color-picker @change="generateCSS" v-if="formData.field_border == true" v-model="formData.borderColor"></el-color-picker>

                                    <draggable   tag="el-collapse" class="cc-drag-able" v-model="formData.formattedFieldList" >



                                        <el-collapse-item class="drag-box" :title="element.key"  v-for="element in formData.formattedFieldList" :key="element.key">
                                            <el-form-item label="Key">
                                                <el-input readonly v-model="element.key" ></el-input>
                                            </el-form-item>
                                            <el-form-item label="Label">
                                                <el-input v-model="element.label"></el-input>
                                            </el-form-item>
                                            <el-form-item label="Show">
                                                <el-switch  @change="refreshComponent" v-model="element.status" label="Show" border>Show</el-switch>
                                            </el-form-item>
                                            <el-divider><i class="el-icon-rank"></i></el-divider>
                                        </el-collapse-item>
                                    </draggable>
                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Image" name="4">
                                <div>
                                    <p>Image</p>
                                    <!--                            image-->
                                    <el-select  @change="refreshComponent"  v-model="formData.img" placeholder="Select">
                                        <el-option
                                                v-for="item in formData.fluentFormData.fieldData"
                                                :key="item"
                                                :label="item"
                                                :value="item">
                                        </el-option>
                                    </el-select>
                                    <p>Show</p>
                                    <el-switch  @change="refreshComponent" v-model="formData.img_status" label="Show" border>Show</el-switch>


                                </div>
                            </el-collapse-item>
                            <el-collapse-item title="Button" name="5">
                                <div>
                                    <p>Button Link</p>
                                    <el-select  v-model="formData.button_link" @change="refreshComponent" placeholder="Select">
                                        <el-option
                                                v-for="item in formData.fluentFormData.fieldData"
                                                :key="item"
                                                :label="item"
                                                :value="item">
                                        </el-option>
                                    </el-select>
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
                            <el-collapse-item title="Layout" name="6">
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
                                            v-model="formData.fluentFormData.limit"
                                            type="number"
                                            @change="fetchData"
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
    import draggable from 'vuedraggable';
    import post_template_grid_1 from './templates/post_template_grid_1';
    import fluent_template_grid_1 from './templates/fluent_template_grid_1';

    export default {
        name: 'FluentForm',

        props:['fieldData','edit','id','gridData'],
        data() {
            return {
                activeNames:1,
                new_grid_key:0,
                fluentSubmissions:'',
                componentKey:true,
                formattedPostCount:0,
                loadingPreview:true,
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
                saving:false,
                formData: {

                    grid_template:'template-one',
                    grid_source:'fluent_form',
                    fluentFormData:{},
                    grid_name:'New Grid ',
                    title_status:true,
                    title: '',
                    content_status:false,
                    content:'',
                    img:'',
                    img_status:false,
                    columnNumber:'4',
                    limit: 4,
                    type: '',
                    view:'grid',
                    limit:4,
                    bgColor:'#f56c6c',
                    fontColor:'#fff',
                    id:this.id,
                    formattedFieldList:[],
                    selectedFields:'',
                    content_align:'center',
                    borderColor:'#fff',
                    field_border:false,
                    button_status:true,
                    button_text:'Read more',
                    button_newtab:false,
                    button_link:'',
                    item_border_radius:0,

                },
                gridNameDialogVisible:false

            }
        },
        methods: {
            submit(formName) {
                this.submitForm(formName);
            },

            getEditCardData($id) {



            },
            fetchData(){

                this.fetchFluentData();
                this.generateCSS()
            },
            // get all form data
            fetchFluentData(){
                this.loadingPreview = true;
                this.$adminGet({
                                   data:  this.formData.fluentFormData,
                                   action: 'plugin_run_two_grid',
                                   route: "get_fluent_data"
                               }).then((res)=>{
                                           this.fluentSubmissions = res.data;
                                       }
                    )
                    .always(()=>{
                        this.componentKey = !this.componentKey;
                        this.loadingPreview = false;

                    })

            },
            //submit form data
            submitForm(formName) {
                this.saving = true;
                console.log(JSON.stringify( this.formData));
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
                                            this.$showAjaxError( 'Try again' );
                                        }

                                    }
                    )
                    .always(()=>{
                        this.saving = false;
                    })
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
                let borderFieldList = '';
                if(this.formData.field_border == true || this.formData.field_border == 'true'){
                    borderFieldList = 'border:1px solid '+this.formData.borderColor+';padding:5px;'
                }
                let css =  `
                ${innerDisplayForList}
                .wp-cc-grid-item{
                      width: ${width};
                      text-align: ${this.formData.content_align};

                }
                .wp-cc-grid-div{
                      overflow:hidden;
                      background-color: ${this.formData.bgColor};
                       ${displayForList}
                        border-radius: ${this.formData.item_border_radius}px;

                }
                .wp-cc-grid-title,.wp-cc-grid-text,.wp-cc-grid-content,.wp-cc-grid a {
                    color: ${this.formData.fontColor}
                }
                 .wp-cc-grid  .cc-field-list li{
                    ${borderFieldList }
                 }
                 .wp-cc-grid  .btn {
                     border: 1px solid ${this.formData.fontColor};
                 }
                 .cc-hover-zoom:hover .wp-cc-grid-image img{

                       transition: transform 0.5s ease;transform: scale(1.35);
                }
                .cc-hover-zoom .wp-cc-grid-image img{
                 transition: transform 0.5s ease;
                }

                 `;
                jQuery('#plugin_run_one_admin_dynamic_style').html(css);

            },

            refreshComponent(){

                this.componentKey = !this.componentKey;
            },

            formattedFieldData(){

                let data = this.formData.fluentFormData.fieldData;
                console.log(data);
                if(!data){
                    return [];
                }

                var arr = [];
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    arr.push({
                                 key: data[i],
                                 label: '',
                                 status: true
                             });
                }
                // this.fieldList = arr;
                this.formData.formattedFieldList = arr;
                return arr;
            },
            //settings fluent selected fields

            setFluentData(){

                if(this.edit){

                    this.$adminPost({
                            route: "get_card_data_by_id",
                            id: this.$route.params.id,
                            action: 'plugin_run_two_grid',
                        }).then((res)=>{
                                this.formData = JSON.parse(res.data.basicSettings);
                                this.formData.id = this.$route.params.id;
                                this.fetchData();
                    }).fail(error => {
                        this.$showAjaxError(error);
                    }).always(()=>{

                    });

                    // this.formData = JSON.parse(this.gridData.basicSettings);

                }
                else{
                    // new grid
                    this.getNewGridKey();
                    let fieldData;
                    if(this.fieldData){
                        localStorage.setItem('fieldData',JSON.stringify(this.fieldData));
                        fieldData = this.fieldData;
                    }else{

                        fieldData = JSON.parse( localStorage.getItem('fieldData'));
                    }

                    this.formData.fluentFormData = {
                        formId  : this.$route.query.form_id,
                        fieldData : fieldData.fields,
                        limit : this.formData.limit
                    }

                }
            },

            getNewGridKey(){

                this.$adminGet({
                               action : 'plugin_run_two_grid',
                               route  : "get_new_grid_key"
                           }).then((res)=>{
                                       this.new_grid_key = res.data.id;
                                       this.formData.grid_name = 'New Grid #'+res.data.id;
                                   }
                    )
                    .fail(error => {
                        this.$showAjaxError(error);
                    })
            }

        },

        mounted() {

            this.setFluentData();
            this.fetchData();

            this.formattedFieldData();




        },
        computed:{

            formattedfluentData(){
                let data = this.fluentSubmissions;
                if(!data){
                    return [];
                }

                return data.filter(x => x.values)

            },

        },
        components: {
            draggable,
            post_template_grid_1,
            fluent_template_grid_1,
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
    .cc-main-section-inner{
        padding: 20px;
    }
    .cc-grid-settings{
        max-width: 25%;
        position: absolute;
        right: 0px;
        top: 0px;
        min-height: 500px;
        height:100%;
        overflow:auto;
        border: 1px solid #fff;
    }
    .cc-grid-settings, .el-collapse-item__header, .el-collapse-item__content{
        background-color: #545c63;
        color:#fff;
    }
    .cc-grid-settings  .el-input--suffix .el-input__inner {
        background-color: white;
    }
    .cc-grid-settings .el-checkbox__label{
        color:#fff;
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
    .cc-drag-able .el-form-item__content{
        margin-left: 50px!important;
    }.cc-drag-able .el-form-item label{
         min-width: 46px!important;
         color:#fff;
         max-width:50px;
     }
    .cc-drag-able .drag-box{
        border:1px solid #fff;
        padding:5px 10px;
        border-radius:5px;
        cursor: move;
        margin-bottom:10px;
        margin-top:10px;
    }.cc-drag-able .el-collapse-item__wrap,.cc-drag-able .el-collapse-item__header{
         border-bottom:none!important;
     }

</style>

