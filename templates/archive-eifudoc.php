<?php
/**
 * Custom archive template for IFU Documents
 */

get_header(); ?>

<div class="ifu-archive-wrapper">
    <header class="ifu-archive-header">
        <h1><?php echo esc_html__('IFU Documents', 'eifu-test'); ?></h1>
        <form class="ifu-archive-filter" method="get" action="">
            <input type="search" name="s" placeholder="<?php esc_attr_e('Search documents...', 'eifu-test'); ?>" value="<?php echo get_search_query(); ?>" />
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'document_category',
                'hide_empty' => false,
            ));
            if ($categories && !is_wp_error($categories)) {
                echo '<select name="document_category">';
                echo '<option value="">' . esc_html__('All Categories', 'eifu-test') . '</option>';
                foreach ($categories as $cat) {
                    $selected = (isset($_GET['document_category']) && $_GET['document_category'] == $cat->slug) ? 'selected' : '';
                    echo '<option value="' . esc_attr($cat->slug) . '" ' . $selected . '>' . esc_html($cat->name) . '</option>';
                }
                echo '</select>';
            }
            ?>
            <button type="submit"><?php esc_html_e('Filter', 'eifu-test'); ?></button>
        </form>
    </header>

    <?php if (have_posts()) : ?>
        <section class="ifu-document-list" aria-label="<?php esc_attr_e('IFU Document List', 'eifu-test'); ?>">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('ifu-document-item'); ?> itemscope itemtype="https://schema.org/CreativeWork">
                    <header>
                        <h2 class="ifu-document-title" itemprop="name">
                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h2>
                    </header>
                    <div class="ifu-document-excerpt" itemprop="description">
                        <?php the_excerpt(); ?>
                    </div>
                    <div class="ifu-document-meta">
                        <?php
                        $file_size = get_post_meta(get_the_ID(), '_document_file_size', true);
                        if ($file_size) {
                            echo '<span class="ifu-file-size">' . esc_html($file_size) . '</span>';
                        }
                        // Download links for each language
                        $eng_usa_checked = get_post_meta(get_the_ID(), '_document_eng_usa_checked', true);
                        $eng_usa_url = get_post_meta(get_the_ID(), '_document_eng_usa_url', true);
                        $eng_ce_checked = get_post_meta(get_the_ID(), '_document_eng_ce_checked', true);
                        $eng_ce_url = get_post_meta(get_the_ID(), '_document_eng_ce_url', true);
                        $eng_base_choice = get_post_meta(get_the_ID(), '_document_eng_base_choice', true); // 'usa' or 'ce'
                        $checked_langs = get_post_meta(get_the_ID(), '_document_languages', true);
                        if (!is_array($checked_langs)) $checked_langs = array();
                        $langs = function_exists('MGBdev\\WC_Eifu_Docs\\eifu_get_supported_languages') ? \MGBdev\WC_Eifu_Docs\eifu_get_supported_languages() : array();
                        echo '<ul class="ifu-download-list">';
                        // English-USA
                        if ($eng_usa_checked && $eng_usa_url) {
                            $url = rtrim($eng_usa_url, '/') . '_ENG-USA.pdf';
                            echo '<li><a href="' . esc_url($url) . '" target="_blank" class="ifu-download-link">' . esc_html__('English-USA', 'eifu-test') . '</a></li>';
                        }
                        // English-CE
                        if ($eng_ce_checked && $eng_ce_url) {
                            $url = rtrim($eng_ce_url, '/') . '_ENG-CE.pdf';
                            echo '<li><a href="' . esc_url($url) . '" target="_blank" class="ifu-download-link">' . esc_html__('English-CE', 'eifu-test') . '</a></li>';
                        }
                        // Other languages
                        $base_url = '';
                        if ($eng_usa_checked && $eng_ce_checked) {
                            $base_url = ($eng_base_choice === 'ce') ? $eng_ce_url : $eng_usa_url;
                        } elseif ($eng_usa_checked) {
                            $base_url = $eng_usa_url;
                        } elseif ($eng_ce_checked) {
                            $base_url = $eng_ce_url;
                        }
                        if ($base_url && $checked_langs) {
                            foreach ($checked_langs as $code) {
                                $label = isset($langs[$code]) ? $langs[$code] : $code;
                                $download_url = rtrim($base_url, '/') . '_' . $code . '.pdf';
                                echo '<li><a href="' . esc_url($download_url) . '" target="_blank" class="ifu-download-link">' . esc_html($label) . ' (' . esc_html($code) . ')</a></li>';
                            }
                        }
                        echo '</ul>';
                        ?>
                    </div>
                    <div class="ifu-document-taxonomies">
                        <?php
                        $cats = get_the_term_list(get_the_ID(), 'document_category', '', ', ');
                        $tags = get_the_term_list(get_the_ID(), 'document_tag', '', ', ');
                        if ($cats) {
                            echo '<span class="ifu-document-categories">' . esc_html__('Categories:', 'eifu-test') . ' ' . $cats . '</span> ';
                        }
                        if ($tags) {
                            echo '<span class="ifu-document-tags">' . esc_html__('Tags:', 'eifu-test') . ' ' . $tags . '</span>';
                        }
                        ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>
        <nav class="ifu-pagination" aria-label="<?php esc_attr_e('Pagination', 'eifu-test'); ?>">
            <?php the_posts_pagination(); ?>
        </nav>
    <?php else : ?>
        <p><?php esc_html_e('No IFU Documents found.', 'eifu-test'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?> 