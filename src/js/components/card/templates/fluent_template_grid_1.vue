<template>
    <div >



            <ul class="wp-cc-grid" id="wp-cc-one-grid-id">

                <li v-for="posts in postData" class="wp-cc-grid-item">
                    <div class="wp-cc-grid-div cc-hover-zoom" >

                        <div class="wp-cc-grid-image "  v-if="layoutData.img_status==true||layoutData.img_status=='true'">

                            <img :src="posts.values[layoutData.img]" alt="">

                        </div>
                        <div class="wp-cc-grid-content">

                            <h2 class="wp-cc-grid-title" v-if="layoutData.title_status == true || layoutData.title_status == 'true'">

                                {{posts.values[layoutData.title]}}
                            </h2>

                            <div class="wp-cc-grid-meta cv-meta-icon-show"  v-if="posts.formatted_date">

                                <span class="wp-cc-grid-comments-wrap wp-cc-grid-meta-item">
                                   {{posts.formatted_date}}
                                </span>
                            </div>




                            <div class="wp-cc-grid-text" v-if="layoutData.content_status == true || layoutData.content_status == 'true'">
                                {{posts.values[layoutData.content]}}
                            </div>
                            <div class="wp-cc-grid-text" >

                                <ul class="cc-field-list">
                                    <li  v-for="item in fieldList"
                                         :key="item.key" v-if="item.status==true || item.status=='true'">

                                        <span> {{item.label}} </span>
                                        <span> {{posts.values[item.key]}} </span>

                                    </li>
                                </ul>
                                {{posts.values[layoutData.content]}}
                            </div>

                            <div class="wp-cc-grid-btn" v-if="layoutData.button_status==true">
                                <a :target="layoutData.button_newtab ? '_blank' :''" :href="posts.values[layoutData.button_link]"  class="btn wp-cc-grid-btn">{{layoutData.button_text}}</a>

                            </div>
                        </div>
                    </div>
                </li>


            </ul>
    </div>
</template>
<script>
    export default {
        name: 'post_template_grid_1',
        props:['postData','layoutData'],
        data(){
            return{
                itemCss:'',
                itemInnerCss:'',

            }
        },
        methods:{
            setStyle(val){


            },
            dateFormatted(date){

                return date;
            }
        },
        mounted() {


        },
        computed:{
            fieldList(){
                let data = this.layoutData.formattedFieldList
                return data.filter(x=>x);
            }
        },
        watch: {
            layoutData:{
                handler: function (val, oldVal) {

                    this.setStyle(val)


                },


                deep: true,
                immediate: true

            }
        },

    }

</script>
<style>

</style>
