<?php get_header(); ?>
<div class="container">
 		
        <section id="main-content" class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="search-info">
        <!--Sử dụng query để hiển thị số kết quả tìm kiếm được tìm thấy
                Cũng như hiển thị từ khóa tìm kiếm. Từ khóa tìm kiếm cũng
                có thể hiển thị được với hàm get_search_query()-->
                <?php
                        $search_query = new WP_Query( 's='.$s.'&showposts=-1' );
                        $search_keyword = wp_specialchars( $s, 1);
                        $search_count = $search_query->post_count;
                        
                ?>
                </div>
 			<?php if ( have_posts() ) : echo "<div class='list-group'>";// var_dump( $search_query );
                        printf( __('<div class="alert alert-info">Tìm thấy <strong>%1$s</strong> kết quả cho từ khóa <strong>%2$s</strong>.</div>', 'cswd'), $search_count , $search_keyword);;while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content', get_post_format() ); ?>
	        <?php endwhile; ?>
                <?php cswd_pagination();?>
	        <?php echo "</div>"; ?>
	        <?php else : ?>
	                <?php printf( __('<div class="alert alert-danger">Không tìm thấy kết quả cho từ khóa <strong>%1$s</strong>.</div>', 'cswd'), $search_keyword);?>
	        <?php endif; ?>
        </section>
        <section id="sidebar" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
 			<?php get_sidebar(); ?>
        </section>
 
</div>
<?php get_footer(); ?>