<?php 
/* remove action to show the listing custom fields on author page classifieds listing */
remove_action('pre_get_posts','tmpl_classified_manager_pre_get_posts');

remove_action('templ_post_title','tevolution_listing_after_title',12);
/* remove add to favourite from below title */
remove_action('templ_post_title','tevolution_favourite_html',11);

global $htmlvar_name;
do_action('classified_before_post_loop');


						/*do_action before the post image */
						do_action('classified_before_category_page_image');           
						
						/* Here to fetch the image */
						do_action('classified_category_page_image');
						
						/*do action after the post image */
						do_action('classified_after_category_page_image'); 
						
						do_action('classified_before_post_entry');?>
						<div class="entry">

							<div class="sort-title">
                     			<?php do_action('tmpl_open_entry'); do_action('classified_before_post_title');         /* do action for before the post title.*/ ?>
                     			<div class="classified-title">
									<?php /* do action for display the single post title */ do_action('templ_post_title'); ?>
									<div class="show-mobile">
										<?php /* do action for display the date */ do_action('templ_classified_post_date'); ?>
									</div>
                                </div>

                                <div class="classified-info">
									<?php /*do action for display the post info */ do_action('classified_post_info'); ?>
								</div>

								<!-- Start Post Content -->
								<?php
									/* do action for before the post content. */
								   do_action('classified_before_post_content');
								   do_action('templ_taxonomy_content');
								   /* do action for after the post content. */
								   do_action('classified_after_post_content');
								?>
								<!-- End Post Content -->

								<!-- Show custom fields where show on listing = yes -->
								<?php
									do_action('classified_after_taxonomies');
									/* Here to show the add to favourites,comments and pinpoint  */
									do_action('classified_after_post_entry');
									do_action('tmpl_before_entry_end');
								?>
                     		</div>
                     		<div class="sort-date show-desktop">
                     			<?php /* do action for display the date */ do_action('templ_classified_post_date'); ?>
                     		</div>
                     		<div class="sort-price show-desktop">
                     			<?php /* do action for display the price */ do_action('templ_classified_post_title'); ?>
                     		</div>
                     		<?php  /* do action for after the post title.*/ do_action('classified_after_post_title'); ?>

						</div>
<?php do_action('classified_after_post_loop'); ?>