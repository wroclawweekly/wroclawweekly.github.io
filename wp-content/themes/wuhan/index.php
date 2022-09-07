<?php get_header(); ?>


	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
			<div class="post-top"><div class="post-bottom"><div class="entry"><div class="title">
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small>>>> <strong><?php the_category(', ') ?></strong> | Posted by <?php the_author() ?> on <?php the_time('F jS, Y') ?></small>
			
				</div>
				
				<?php the_content('Read the rest of this entry &raquo;'); ?>
				
				<p class="postmetadata"> <?php edit_post_link('Edit','','<strong>|</strong>'); ?><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p> 
				</div>
				
			</div></div>
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>

	<?php endif; ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>