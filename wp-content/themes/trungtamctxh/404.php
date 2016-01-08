<?php get_header(); ?>
 
<div class="container">
 
        <section id="main-content" class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
		 <?php
		        echo "<div class='alert alert-danger'>";
		        echo "<h1>404 Không tìm thấy!</h1>";
		        echo "<h4>Trang bạn yêu cầu không tồn tại. Vui lòng thử lại.</h4>";
		 		echo "</div>";
		?>
        </section>
        <section id="sidebar" class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <?php get_sidebar(); ?>
        </section>
 
</div>
 
<?php get_footer(); ?>