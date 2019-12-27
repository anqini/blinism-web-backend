<?php  
   global $post ;
   $count = 0;
   $paged = get_query_var('paged');
   $query_args = array('post_type' => 'post' , 'showposts' => $num , 'order_by' => $sort , 'order' => $order, 'paged'=>$paged);
   if( $cat ) $query_args['category_name'] = $cat;
   $query = new WP_Query($query_args) ; 
   ?>   
<?php if($query->have_posts()):  ?>   

<!--Sidebar Page Container-->
<div class="sidebar-page-container">
    <div class="auto-container">
        <div class="row clearfix">
            
            <!--Content Side-->
            <div class="content-side col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <!--Our Blog-->
                <div class="blog-grid">
                    <div class="row clearfix">
                        <?php while($query->have_posts()): $query->the_post();
							global $post ; 
							$post_meta = _WSH()->get_meta();
						?>
                        <!--News Block Two-->
                        <div class="news-block-two col-md-6 col-sm-6 col-xs-12">
                            <div class="inner-box">
                                <div class="image">
                                    <?php the_post_thumbnail('pickton_370x210'); ?>
                                    <div class="tag"><?php the_category(', '); ?></div>
                                </div>
                                <div class="lower-content">
                                    <div class="post-date"><?php echo get_the_date(); ?></div>
                                    <h3><a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>"><?php the_title(); ?></a></h3>
                                    <div class="text"><?php echo wp_kses_post(pickton_trim(get_the_content(), $text_limit));?></div>
                                    <a href="<?php echo esc_url(get_the_permalink(get_the_id()));?>" class="read-more"><?php esc_html_e('Read More', 'pickton'); ?></a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile;?>
                    </div>
                    
                    <!--Styled Pagination-->
                    <div class="styled-pagination text-center">
                        <?php pickton_the_pagination(array('total'=>$query->max_num_pages, 'next_text' => '<i class="fa fa-angle-right"></i>', 'prev_text' => '<i class="fa fa-angle-left"></i>')); ?>
                    </div>
                    <!--End Styled Pagination-->
                    
                </div>
            </div>
            
            <!--Sidebar Side-->
            <div class="sidebar-side col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <aside class="sidebar default-sidebar with-border">
                	<?php if ( is_active_sidebar( $sidebar_slug ) ) : ?>
						<?php dynamic_sidebar( $sidebar_slug ); ?>
                	<?php endif; ?>
                </aside>
            </div>
            <!--End Sidebar Side-->
            
        </div>
    </div>
</div>

<?php endif; wp_reset_postdata(); ?>