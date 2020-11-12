<!--template for card creator grid view-->

<?php
$GridCssId = 'pr_one_grid_'.$id;
?>
<div class="pr-one-wrapper" id="<?php echo $GridCssId ?>">
    <h2 class="center-p"> <?php echo $data['grid_name'] ?></h2>
    <div class="content-wrapper <?php echo ''; ?>">
   
    
        <style>
          <?php
            if( $data['view']  =='list'){
                $width = '100';
                $displayForList = 'display: flex;';
                $innerDisplayForList ='.wp-cc-grid-content{flex:2;} .wp-cc-grid-image {flex:1}';
            }else if($data['view'] =='grid' || $data['view'] =='carousel'){
                
                $width = (100 / (intval ($data['columnNumber'])));
                $displayForList='';$innerDisplayForList='';
            }
          
            ?>
            <?php echo $innerDisplayForList ?>
          
            #<?php echo $GridCssId ?> .wp-cc-grid .cc-field-list.has-border li {
                border:1px solid <?php echo $data['borderColor']; ?>;
                padding: 5px;
            }
            #<?php echo $GridCssId ?> .cc-field-list.has-border li:not(:last-child){
                border-bottom:none;
            }
            #<?php echo $GridCssId ?> .wp-cc-grid-item{
                width: <?php echo $width ?>%;
                text-align: <?php echo $data['content_align']?>;
    
            }

            #<?php echo $GridCssId ?> .wp-cc-grid-div{
                background-color: <?php echo $data['bgColor'] ?>;
                <?php echo $displayForList ?>
                border-radius: <?php echo $data['item_border_radius']?>px;
                overflow:hidden;
            }
            #<?php echo $GridCssId ?> .wp-cc-grid-title,.wp-cc-grid-text, #<?php echo $GridCssId ?> .cc-field-list li , .wp-cc-grid-content,  #<?php echo $GridCssId ?> .wp-cc-grid a {
                color: <?php echo $data['fontColor']?>;
            }
            #<?php echo $GridCssId ?> .wp-cc-grid  .btn {
                border: 1px solid <?php echo $data['fontColor']?>;
            }
           
        </style>
        <ul class="wp-cc-grid" >
    
        <?php

           
            foreach ($data['gridItems'] as $item) {
                ?>

                <li class="wp-cc-grid-item">
                    <div class="wp-cc-grid-div cc-hover-zoom">
                        <?php if (!empty($item['img'])){?>
                        <div class="wp-cc-grid-image ">
                            <img src="<?php echo $item['img'] ?>">
                        </div>
                        <?php } ?>
                        <div class="wp-cc-grid-content">
                            <h2 class="wp-cc-grid-title">
                                <?php echo $item['title'] ?>
                            </h2>

                            <div class="wp-cc-grid-meta cv-meta-icon-show">
                    
                                <?php if (!empty( $item['author'] )) : ?>
                                    <span class="cv-author-meta wp-cc-grid-meta-item">
                                        <span class="cv-author-thumb">
                                            
                                             <?php echo !empty( $item['author_avatar'] ) ? '<img src="' . $item["author_avatar"] . '">' : '' ?>
                                        </span>
                                        <span class="wp-cc-grid-author-name" itemprop="author">by
                                            <a href="<?php echo $item['author_link'] ?>" target="_blank">
                                                <?php echo $item['author'] ?>
                                            </a>
                                        </span>
                                    </span>
                                <?php endif; ?>
                    
                                <?php if (!empty( $item['date'] )) : ?>
                                    <span class="wp-cc-grid-comments-wrap wp-cc-grid-meta-item">
                                        <?php echo $item['date'] ?>
                                    </span>
                                <?php endif; ?>

                            </div>
                
                
                            <?php if (!empty( $item['content'] )) : ?>
                                <div class="wp-cc-grid-text">
                                    <?php echo $item['content'] ?>
                                </div>
                            <?php endif; ?>
                            <?php
                
                            if (!empty( $item['formattedFields'] )) :?>
                                <div class="wp-cc-grid-text">

                                    <ul class="cc-field-list <?php echo ($data['field_border'] === true) ? 'has-border' : '' ?>">
                                        <?php foreach ($item['formattedFields'] as $fieldItem):
                                            if (!empty( $fieldItem['value'] )) {
                                                ?>

                                                <li>

                                                    <span> <?php echo $fieldItem['label'] ?>  </span>
                                                    <span> <?php echo $fieldItem['value'] ?> </span>

                                                </li>
                                            <?php } endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                
                            <?php if (!empty( $data['button_text'] ) && $data['button_status'] === true) : ?>
                                <div class="wp-cc-grid-btn">
                                    <a href="<?php echo $item['item_link'] ?>"
                                       target="<?php echo ($data['button_newtab']) === true ? '_blank' : ''; ?>"
                                       class="btn wp-cc-grid-btn">
                            
                                        <?php echo $data['button_text'] ?>
                                    </a>

                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </li>
    
    
                <?php
            }
        ?>

        </ul>
    
    </div>

</div>
