<?php
	if(is_single()||is_page())
	{
		?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	        <header class="entry-header">
	 			<?php cswd_entry_header(); ?>
	        </header>
	        <div class="entry-content">
	 			<?php cswd_entry_content(); ?>
	        	<?php ( is_single() ? cswd_entry_tag() : '' ); ?>
	        </div>
		</article>
	<?php } 
	else {
		cswd_entry_header();
	}
	?>
