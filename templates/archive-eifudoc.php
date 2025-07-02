<?php
/**
 * Archive template for documents
 */

get_header(); ?>

<div class="document-archive">
    <h1><?php post_type_archive_title(); ?></h1>
    
    <?php if (have_posts()) : ?>
        <div class="document-grid">
            <?php while (have_posts()) : the_post(); ?>
                <div class="document-card">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <?php the_excerpt(); ?>
                    <div class="document-meta">
                        <?php
                        $file_size = get_post_meta(get_the_ID(), '_document_file_size', true);
                        if ($file_size) {
                            echo '<span class="file-size">' . esc_html($file_size) . '</span>';
                        }
                        ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php the_posts_pagination(); ?>
    <?php endif; ?>
</div>

<?php get_footer(); ?> 