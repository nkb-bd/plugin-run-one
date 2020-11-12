<template>
    <div >



            <ul class="wp-cc-grid" id="wp-cc-one-grid-id">

                <li v-for="posts in postData" class="wp-cc-grid-item">
                    <div class="wp-cc-grid-div cc-hover-zoom" >

                        <div class="wp-cc-grid-image "  v-if="layoutData.img_status!=false">
                            <img :src="posts.formatted_thumbnail">
                        </div>
                        <div class="wp-cc-grid-content">
                            <h2 class="wp-cc-grid-title" >
                                {{posts.post_title}}
                            </h2>

                            <div class="wp-cc-grid-meta cv-meta-icon-show">
                                <span class="cv-author-meta wp-cc-grid-meta-item">
                                    <span class="cv-author-thumb">

                                         <img :src="posts.formatted_author_image">
                                    </span>
                                        <span class="wp-cc-grid-author-name" itemprop="author">by
                                            <a :href="posts.formatted_author_link" target="_blank">
                                                {{posts.formatted_author_name}}
                                            </a>
                                        </span>
                                </span>
                                <span class="wp-cc-grid-comments-wrap wp-cc-grid-meta-item">
                                   {{posts.formatted_date}}
                                </span>
                            </div>




                            <div class="wp-cc-grid-text">
                                {{posts.formatted_content}}
                            </div>
                            <div class="wp-cc-grid-btn" v-if="layoutData.button_status==true">
                                <a target="_blank" :href="posts.formatted_link"  class="btn wp-cc-grid-btn">
                                    {{layoutData.button_text}}
                                </a>

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
                console.log(date)
                return date;
            }
        },
        mounted() {
        },
        watch: {
            layoutData:{
                handler: function (val, oldVal) {


                },
                deep: true,
                immediate: true

            }
        },

    }

</script>
<style>

</style>
