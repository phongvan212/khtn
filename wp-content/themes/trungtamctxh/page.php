<?php get_header(); ?>
<?php
          setPostViews(get_the_ID());
?>
<div class="container">
 
        <section id="main-content" class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
                            <?php if(function_exists('bcn_display'))
                            {
                                bcn_display();
                            }?>
                </div>
 		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content', get_post_format() ); ?>
	        <?php endwhile; ?>
	        <?php else : ?>
	                <?php get_template_part( 'content', 'none' ); ?>
	        <?php endif; ?>
        </section>
        <section id="sidebar" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
 			<?php get_sidebar(); ?>
        </section>
 
</div>
<?php get_footer(); ?>