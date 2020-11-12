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
                <el-button size="mini" type="primary" @click="submit('formData')">
                    Submit
                </el-button>
            </div>

        </div>
        <el-row >
            <el-col  class="cc-main-section-body">
                <div class=" cc-preview-section" v-loading="loadingPreview">
                    <component
                            is="fluent_template_grid_1"
                            :postData=formattedNinjaTableData
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
                                                v-for="item in formData.ninjaTableData.columnData"
                                                :key="item.key"
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
                                                v-for="item in formData.ninjaTableData.columnData"
                                                :key="item.key"
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
                                                v-for="item in formData.ninjaTableData.columnData"
                                                :key="item.key"
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
                                                v-for="item in formData.ninjaTableData.columnData"
                                                :key="item.key"
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
                                            v-model="formData.limit"
                                            type="number"
                                            @change="fetchData"
                                            :min="1"
                                    >
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
        name: 'NinjaTable',

        props:['columnData','edit','id'],
        data() {
            return {
                activeNames:1,
                new_grid_key:0,
                ninjaTableData:'',
                selectedFields:this.getSelectedFields(),
                componentKey:true,
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

                formData: {
                    grid_source : 'ninja_table',
                    ninjaTableData:{},
                    grid_name : 'New Grid ',
                    title_status : true,
                    title : '',
                    content_status : false,
                    content : '',
                    img : '',
                    img_status : false,
                    columnNumber : '4',
                    type : '',
                    view : 'grid',
                    limit : 4,
                    bgColor : '#f56c6c',
                    fontColor : '#fff',
                    id : this.id,
                    formattedFieldList : [],
                    content_align : 'center',
                    borderColor : '#fff',
                    field_border : false,
                    button_status : true,
                    button_text : 'Read more',
                    button_newtab : false,
                    button_link : '',
                    item_border_radius : '0'


                },
                gridNameDialogVisible:false

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


            fetchData(){

                this.fetchNinjaTableData();
                this.generateCSS()
            },
            fetchNinjaTableData(){
                this.loadingPreview = true;
                // get all ninja table data
                this.$adminGet({
                                   data: this.formData.ninjaTableData,
                                   action: 'plugin_run_two_grid',
                                   route: "get_ninja_table_data"
                               }).then((res)=>{
                           this.ninjaTableData = res.data;
                       }
                    )
                    .always(()=>{
                        this.componentKey = !this.componentKey;
                        this.loadingPreview = false;
                        this.generateCSS();
                    })

            },
            //submit form
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
                                                this.notify('New Grid "' +this.formData.grid_name+'" Saved','success');
                                                this.$router.push({ name: 'card_edit', params: { id:  res.data.insert_id } });

                                            }else if (res.success === true){

                                                this.notify('Grid "' +this.formData.grid_name+'" Updated','success');

                                            }else{
                                                this.$showAjaxError(res);
                                            }

                                        }
                    )
                    .always(()=>{
                        this.saving = false;
                    })
            },
            notify(message , type) {
                this.$notify({
                                 showClose : true,
                                 message   : message,
                                 type      : type,
                                 offset    :40
                             });
            },

            notifyMessage(message , type) {
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
                if(this.formData.field_border == true){
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

            getTableData(){
                let tableId = localStorage.getItem('tableId');
                let columnData = localStorage.getItem('columnData');

                if(tableId == this.$route.query.table_id){
                    return {
                        tableId  : tableId,
                        columnData : JSON.parse(columnData),
                        limit : this.formData.contentLimit,
                    }
                }else{
                    console.log('error--! create fix here')
                }
            },
            getSelectedFields(){
                let columnData = JSON.parse(localStorage.getItem('columnData'));
                let data = columnData.fields;
                var arr = [];
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    arr.push({
                                 key: i ,
                                 value: data[i].replace(/\s+/g, '').toLowerCase() ,
                                 label: data[i],
                             });
                }
                this.selectedFields = arr;
                return arr;
            },

            refreshComponent(){
                this.componentKey = !this.componentKey;
            },

            formattedColumnData(){
                let data = this.selectedFields;
                var arr = [];
                var len = data.length;
                for (var i = 0; i < len; i++) {
                    arr.push({
                                 key: data[i].value ,
                                 label: '',
                                 status: true
                             });
                }
                this.fieldList = arr;
                this.formData.formattedFieldList = arr;
                return arr;
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
            setFormData(){
                if(this.edit){
                    this.$adminPost({
                        route: "get_card_data_by_id",
                        id: this.$route.params.id,
                        action: 'plugin_run_two_grid',
                    }).then((res)=>{

                            this.formData = JSON.parse(res.data.basicSettings);
                            this.formData.id = this.$route.params.id;
                            this.fetchNinjaTableData();

                        }
                    );

                }
                else{
                    // new grid
                    this.getNewGridKey();
                    console.log(this.columnData)

                    let columnData;
                    if(this.columnData){
                        localStorage.setItem('columnData', JSON.stringify (this.columnData))
                        columnData = this.columnData;
                    }else{

                        columnData = JSON.parse( localStorage.getItem('columnData'));
                    }
                    this.formData.ninjaTableData = {
                        tableId  : this.$route.query.table_id,
                        columnData : columnData.fields,
                        limit : this.formData.limit
                    };


                }
            }

        },

        mounted() {

            this.setFormData();
            //settings ninja selected column
            if(this.columnData){

                localStorage.removeItem('tableId')
                localStorage.removeItem('columnData')

                localStorage.setItem('tableId', this.$route.query.table_id)
                localStorage.setItem('columnData', JSON.stringify (this.columnData))


            }
            if(this.selectedFields){
                this.formData.title = this.selectedFields[0].value;
            }
            this.fetchNinjaTableData();
            this.getSelectedFields();
            this.generateCSS();
            this.formattedColumnData();
            this.getNewGridKey();

        },
        computed:{

          formattedNinjaTableData(){
              let data = this.ninjaTableData;

              if(!data){
                  return [];
              }
              var len = data.length;
              let arr = [];
              for (var i = 0; i < len; i++) {
              arr.push({
                            id: i,
                            values:JSON.parse(JSON.stringify(data[i].values))
                       });
              }
             return arr;
          },

        },
        components: {
            draggable,
            post_template_grid_1,
            fluent_template_grid_1,
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

