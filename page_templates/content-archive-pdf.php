<?php
/**
 * The template used for displaying PDF posts on an archive page.
 */

?>

<?php
  $attachments = get_attached_media('application/pdf');
  $attachment_post_ids = array_map(function($attachment) {
    return $attachment->ID;
  }, $attachments);

  $current_attachment = max($attachment_post_ids);
  $attachment_url = str_replace('src', 'wp-content', wp_get_attachment_url($current_attachment));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post clearfix post-pdf'); ?>>
  <?php do_action( 'colormag_before_post_content' ); ?>

  <div class="article-thumb featured-image">
    <?php if (has_post_thumbnail()): ?>
      <a href="<?php echo $attachment_url; ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('colormag-featured-image'); ?></a>
    <?php else: ?>
      <a href="<?php echo $attachment_url; ?>" title="<?php the_title(); ?>"><img class="attachment-colormag-featured-image size-colormag-featured-image wp-post-image" src="wp-content/uploads/2017/08/PDF_icon.jpg"></a>
    <?php endif; ?>
  </div>

  <div class="article-content clearfix">
    <?php
      if (get_post_format()) {
        get_template_part('inc/post-formats');
      }
    ?>

    <?php metlifeColoredCategory(); ?>

    <header class="entry-header">
      <h1 class="entry-title">
        <a href="<?php echo $attachment_url; ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
      </h1>
    </header>

    <?php custom_entry_meta_info('page'); ?>

    <div class="entry-content clearfix">
      <p><?php the_excerpt(); ?></p>
      <a class="more-link" title="<?php the_title(); ?>" href="<?php echo $attachment_url; ?>"><span><?php _e( 'Download', 'colormag' ); ?></span></a>
    </div>
  </div>

  <?php do_action( 'colormag_after_post_content' ); ?>
</article>

