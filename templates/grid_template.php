<!--template for card creator grid view-->
<h2 class="center-p"> <?php echo $data['grid_name'] ?></h2>
<div class="content-wrapper pr-one-<?php echo $data['view'] ?>">



<?php
    $loop = new \WP_Query( $args );
    $i = 0;
    while ( $loop->have_posts() ) : $loop->the_post();
        $i++;
        if($i>$limit){
            break;
        }

        
        $featured_img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
        $content = get_the_content();
        $link = get_permalink( get_the_ID());
        $trimmed_content = wp_trim_words( $content, 50, NULL );
        $cat = get_the_category(get_the_ID());
    ?>
    <div class="plugin-one-card" style="background-color:<?php echo $background_color ?>">
        <a href="<?php echo $link?> " class="plugin-one-card__card-link"></a>
        <?php
        if ( $featured_img ) {
            $img_link =   $featured_img[0];

        ?>
        <img src="<?php echo  $img_link ?>" alt="<?php echo the_title();?>" class="plugin-one-card__image">
        <?php  }?>
        <div class="plugin-one-card__text-wrapper">
            <h2 class="plugin-one-card__title"><?php echo the_title();?></h2>
            <div class="plugin-one-card__post-date"><?php echo get_the_date(); ?></div>
            <div class="plugin-one-card__post-date">
                <?php
//                $category = get_category($cat_id);
//                echo $category->name;
                ?>
            </div>
            <div class="plugin-one-card__details-wrapper">
                <p class="plugin-one-card__excerpt">
                    <?php echo $trimmed_content ?>
                </p>
                <a href="<?php echo $link?>" class="plugin-one-card__read-more">Read more</a>
            </div>
        </div>
    </div>
    <?php
    endwhile;
    wp_reset_postdata();
    if($i==0){
        echo 'No Post Found in this post type! ';
    }
    ?>

</div>
