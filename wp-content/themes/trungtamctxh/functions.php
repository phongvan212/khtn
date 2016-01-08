<?php
/**
  @ Thiết lập các hằng dữ liệu quan trọng
  @ THEME_URL = get_stylesheet_directory() - đường dẫn tới thư mục theme
  @ CORE = thư mục /core của theme, chứa các file nguồn quan trọng.
  **/
  define( 'THEME_URL', get_stylesheet_directory() );
  define( 'CORE', THEME_URL . '/core' );

  /**
  @ Load file /core/init.php
  @ Đây là file cấu hình ban đầu của theme mà sẽ không nên được thay đổi sau này.
  **/
 
  require_once( CORE . '/init.php' );

  /**
 @ Thiết lập $content_width để khai báo kích thước chiều rộng của nội dung
 **/
 if ( ! isset( $content_width ) ) {
       /*
        * Nếu biến $content_width chưa có dữ liệu thì gán giá trị cho nó
        */
       $content_width = 620;
  }

  /**
  @ Thiết lập các chức năng sẽ được theme hỗ trợ
  **/
  if ( ! function_exists( 'cswd_theme_setup' ) ) {
        function cswd_theme_setup() {
 			/*
			* Thiết lập theme có thể dịch được
			*/
			$language_folder = THEME_URL . '/languages';
			load_theme_textdomain( 'cswd', $language_folder );

			/*
			* Tự chèn RSS Feed links trong <head>
			*/
			add_theme_support( 'automatic-feed-links' );

			/*
			* Thêm chức năng post thumbnail
			*/
			add_theme_support( 'post-thumbnails' );

			/*
			* Thêm chức năng title-tag để tự thêm <title>
			*/
			add_theme_support( 'title-tag' );

			/*
			* Thêm chức năng post format
			*/
			add_theme_support( 'post-formats',
			    array(
			       'image',
			       'video',
			       'gallery',
			       'quote',
			       'link'
			    )
			 );

			/*
			* Thêm chức năng custom background
			*/
			$default_background = array(
			   'default-color' => '#ffffff',
			);
			add_theme_support( 'custom-background', $default_background );

			/*
			* Tạo menu cho theme
			*/
			register_nav_menu ( 'primary-menu', __('Primary Menu', 'cswd') );

			/*
			* Tạo sidebar cho theme
			*/
			$sidebar = array(
			   'name' => __('Main Sidebar', 'cswd'),
			   'id' => 'main-sidebar',
			   'description' => 'Main sidebar for CSWD theme',
			   'class' => 'main-sidebar',
			   'before_title' => '<h3 class="widgettitle">',
			   'after_title' => '</h3>'
			);
			register_sidebar( $sidebar );
        }
        add_action ( 'init', 'cswd_theme_setup' );
  }
		/**
		@ Thiết lập hàm hiển thị logo
		@ cswd_logo()
		**/
		if ( ! function_exists( 'cswd_logo' ) ) {
		  function cswd_logo() {?>
		    <?php
		      global $ttptctxh_options;
		    ?>
		 
		    <?php if ( $ttptctxh_options['logo-on'] == 1 ) : ?>
		 
		      <div class="logo">
		        <img src="<?php echo $ttptctxh_options['logo-image']['url']; ?>">
		      </div>
		 
		    <?php else : ?>
		 
		      <div class="logo">
		 
		        <div class="site-name">
		          <?php if ( is_home() ) {
		            printf(
		              '<h1><a href="%1$s" title="%2$s">%3$s</a></h1>',
		              get_bloginfo( 'url' ),
		              get_bloginfo( 'description' ),
		              get_bloginfo( 'sitename' )
		            );
		          } else {
		            printf(
		              '<a href="%1$s" title="%2$s">%3$s</a>',
		              get_bloginfo( 'url' ),
		              get_bloginfo( 'description' ),
		              get_bloginfo( 'sitename' )
		            );
		          } // endif ?>
		        </div>
		        <div class="site-description"><?php bloginfo( 'description' ); ?></div>
		 
		      </div>
		 
		      <?php endif;
		  }
		}

	/**
	@ Thiết lập hàm hiển thị menu
	@ cswd_menu( $slug )
	**/
	if ( ! function_exists( 'cswd_menu' ) ) {
	  function cswd_menu( $slug ) {
	    $menu = array(
	      'theme_location' => $slug,
	      'container' => 'nav',
	      'container_class' => $slug,
	    );
	    wp_nav_menu( $menu );
	  }
	}

	/**
	@ Tạo hàm phân trang cho index, archive.
	@ Hàm này sẽ hiển thị liên kết phân trang theo dạng chữ: Newer Posts & Older Posts
	@ cswd_pagination()
	**/
	if ( ! function_exists( 'cswd_pagination' ) ) {
	  function cswd_pagination() {
	    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
	      return '';
	    }
	  ?>
	 
	  <nav class="pagination" role="navigation">
	    <?php if ( get_previous_post_link() ) : ?>
	      <span class="pre"><?php previous_posts_link( __('Trở lại', 'cswd') ); ?>&nbsp;&nbsp;&nbsp;</span>
	    <?php endif; ?>

	    <?php if ( get_next_post_link() ) : ?>
	      <span class="next"><?php next_posts_link( __('Xem tiếp', 'cswd') ); ?></span>
	    <?php endif; ?>

	  </nav><?php
	  }
	}

	/**
	@ Hàm hiển thị ảnh thumbnail của post.
	@ Ảnh thumbnail sẽ không được hiển thị trong trang single
	@ Nhưng sẽ hiển thị trong single nếu post đó có format là Image
	@ cswd_thumbnail( $size )
	**/
	if ( ! function_exists( 'cswd_thumbnail' ) ) {
	  function cswd_thumbnail( $size ) {
	    // Chỉ hiển thumbnail với post không có mật khẩu
	    if ( ! is_single() &&  has_post_thumbnail()  && ! post_password_required() || has_post_format( 'image' ) ) : ?>
	      <figure class="post-thumbnail"><?php the_post_thumbnail( $size ); ?></figure><?php
	    endif;
	  }
	}

	/**
	@ Hàm hiển thị tiêu đề của post trong .entry-header
	@ Tiêu đề của post sẽ là nằm trong thẻ <h1> ở trang single
	@ Còn ở trang chủ và trang lưu trữ, nó sẽ là thẻ <h2>
	@ cswd_entry_header()
	**/
	if ( ! function_exists( 'cswd_entry_header' ) ) {
	  function cswd_entry_header() {
	    if ( is_single()||is_page() ) : ?>
	 
	      <h2 class="entry-title">
	        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
	          <?php the_title(); ?>
	        </a>
	      </h2>
	      <?php printf( __('<i>Ngày đăng: %1$s &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lượt xem: %2$s</i>', 'cswd'),get_the_date(), getPostViews(get_the_ID()) );?>
	    <?php else : ?>
	        <a href="<?php the_permalink(); ?>" class="list-group-item" rel="bookmark" title="<?php the_title_attribute(); ?>">
	          <?php echo "<h4 class='item-title'>";?>
	          <?php the_title();?>
	          <?php echo "</h4>";?>
	          <?php printf( __('<i class="chungaythang">Ngày đăng: %1$s</i>', 'cswd'),
	          get_the_date() );?>
	        </a>
	      <?php
	    endif;
	  }
	}

	/**
	@ Hàm hiển thị thông tin của post (Post Meta)
	@ cswd_entry_meta()
	**/
	if( ! function_exists( 'cswd_entry_meta' ) ) {
	  function cswd_entry_meta() {
	    if ( ! is_page() ) :
	      echo '<div class="entry-meta">';
	 
	        // Hiển thị tên tác giả, tên category và ngày tháng đăng bài
	        /**printf( __('<span class="author">Posted by %1$s</span>', 'cswd'),
	          get_the_author() );**/
	 
	        printf( __('<h4 class="date-published">Ngày đăng: %1$s</h4>', 'cswd'),
	          get_the_date() );
	 
	        /**printf( __('<span class="category"> in %1$s</span>', 'cswd'),
	          get_the_category_list( ', ' ) );**/
	 
	        // Hiển thị số đếm lượt bình luận
	        /**if ( comments_open() ) :
	          echo ' <span class="meta-reply">';
	            comments_popup_link(
	              __('Leave a comment', 'cswd'),
	              __('One comment', 'cswd'),
	              __('% comments', 'cswd'),
	              __('Read all comments', 'cswd')
	             );
	          echo '</span>';
	        endif; **/
	      echo '</div>';
	    endif;
	  }
	}

	/*
	 * Thêm chữ Read More vào excerpt
	 */
	function cswd_readmore() {
	  return '...<div class="read-more"><a href="'. get_permalink( get_the_ID() ) . '">' . __('Xem thêm <i class="fa fa-long-arrow-right"></i>', 'cswd') . '</a></div>';
	}
	add_filter( 'excerpt_more', 'cswd_readmore' );
	 
	/**
	@ Hàm hiển thị nội dung của post type
	@ Hàm này sẽ hiển thị đoạn rút gọn của post ngoài trang chủ (the_excerpt)
	@ Nhưng nó sẽ hiển thị toàn bộ nội dung của post ở trang single (the_content)
	@ cswd_entry_content()
	**/
	if ( ! function_exists( 'cswd_entry_content' ) ) {
	  function cswd_entry_content() {
	 
	    if ( ! is_single() ) :
	      the_excerpt();
	    else :
	      the_content();
	 
	      /*
	       * Code hiển thị phân trang trong post type
	       */
	      $link_pages = array(
	        'before' => __('<p>Page:', 'cswd'),
	        'after' => '</p>',
	        'nextpagelink'     => __( 'Next page', 'cswd' ),
	        'previouspagelink' => __( 'Previous page', 'cswd' )
	      );
	      wp_link_pages( $link_pages );
	    endif;
	 
	  }
	}

	/**
	@ Hàm hiển thị tag của post
	@ cswd_entry_tag()
	**/
	if ( ! function_exists( 'cswd_entry_tag' ) ) {
	  function cswd_entry_tag() {
	    if ( has_tag() ) :
	      echo '<div class="entry-tag">';
	      printf( __('Tagged in %1$s', 'cswd'), get_the_tag_list( '', ', ' ) );
	      echo '</div>';
	    endif;
	  }
	}

	/**
	@ Chèn CSS và Javascript vào theme
	@ sử dụng hook wp_enqueue_scripts() để hiển thị nó ra ngoài front-end
	**/
	function cswd_styles() {
	  /*
	   * Hàm get_stylesheet_uri() sẽ trả về giá trị dẫn đến file style.css của theme
	   * Nếu sử dụng child theme, thì file style.css này vẫn load ra từ theme mẹ
	   */
	  wp_register_style( 'main-style', get_template_directory_uri() . '/style.css', 'all' );
	  wp_enqueue_style( 'main-style' );

	  wp_register_style('bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', 'all');
      wp_enqueue_style('bootstrap-style');

      wp_register_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', 'all');
      wp_enqueue_style('font-awesome');

		wp_register_script('jQuery', get_template_directory_uri() . '/js/jquery-2.1.4.min.js', array(), false, true);
    	wp_enqueue_script('jQuery');

        wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array(), false, true);
    	wp_enqueue_script('bootstrap');

    	wp_register_script('script', get_template_directory_uri() . '/js/script.js', array(), false, true);
    	wp_enqueue_script('script');
	}
	add_action( 'wp_enqueue_scripts', 'cswd_styles' );

	/** 
	Short-code lay 10 tin moi
	**/
	if(!function_exists('top_news')){
		function top_news(){
		query_posts('cat=11,12,13&showposts=5');
		if (have_posts()):
			echo "<div class='news_content'><div class='alert news-alert alert-primary'><h2 class='news_title'>Tin tức mới</h2></div>";
			echo "<hr/>";
		while (have_posts()) : the_post(); ?>
			<div class="news-item">
				<h2 class="h2 entry-title"><a href="<?php the_permalink(); ?>"><span class="entry-title-text"><?php the_title(); ?></span></a></h2>
				<div class="posted-on"><span class="posted-on-string"><?php printf(__('Ngày đăng: %1$s', 'cswd'),get_the_date()." ".get_the_time()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lượt xem:&nbsp;".getPostViews(get_the_ID())); ?></span></div>
				<?php cswd_thumbnail('thumbnail');?>
				<div class="entry-content clearfix">
					<?php the_excerpt();?>
				</div>
			</div>
		<?php endwhile;
		echo "</div>";
		endif;
		}
	}
	add_shortcode('sc_top_news', 'top_news');

	/** 
	Short-code lay Tin Theo Loai
	**/
	if(!function_exists('news_by_cat')){
		function news_by_cat($args, $content){
		if(!is_null($args['cat_id']))
		{
			if(!is_null($args['take_num']))
			{
				query_posts('cat='.$args['cat_id'].'&showposts='.$args['take_num']);
			}
			else
			{
				query_posts('cat='.$args['cat_id']);
			}
			if (have_posts()):
			echo "<div class='news_content'><div class='alert news-alert alert-primary'><h2 class='news_title'>".$args['cat_title']."</h2></div>";
			echo "<hr/>";
			while (have_posts()) : the_post(); ?>
				<div class="news-item">
				<h2 class="h2 entry-title"><a href="<?php the_permalink(); ?>"><span class="entry-title-text"><?php the_title(); ?></span></a></h2>
				<div class="posted-on"><span class="posted-on-string"><?php printf(__('Ngày đăng: %1$s', 'cswd'),get_the_date()." ".get_the_time()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lượt xem:&nbsp;".getPostViews(get_the_ID())); ?></span></div>
				<?php cswd_thumbnail('thumbnail');?>
				<div class="entry-content clearfix">
					<?php the_excerpt();?>
				</div>
			</div>
			<?php endwhile;
				echo "</div>";
			endif;
			}
		}
	}
	add_shortcode('sc_news_by_cat', 'news_by_cat');

	function getPostViews($postID){
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	        return "0";
	    }
	    return $count;
	}
	function setPostViews($postID) {
	    $count_key = 'post_views_count';
	    $count = get_post_meta($postID, $count_key, true);
	    if($count==''){
	        $count = 0;
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, '0');
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
	}
?>
