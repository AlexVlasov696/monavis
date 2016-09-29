<!DOCTYPE html><html><head><?php get_header(); ?></head><body><section class="slider head-slider"><div id="monCarousel" data-ride="carousel" class="carousel slide"><ol class="carousel-indicators"><?php global $wpdb; ?><?php $slides_count = $wpdb->get_var('SELECT COUNT(*) FROM wp_posts AS p WHERE p.post_type="slide" AND p.post_status = "publish"'); ?><?php for($i=0; $i<$slides_count; $i++): ?><?php if($i==0): ?><li data-target="#monCarousel" data-slide-to="<?php print($i); ?>" class="active"></li><?php else: ?><li data-target="#monCarousel" data-slide-to="<?php print($i); ?>"></li><?php endif; ?><?php endfor; ?></ol><div role="listbox" class="carousel-inner"><?php $slider = new WP_Query( array ( 'post_type' => 'slide')); ?><?php if ( $slider->have_posts() ): ?><?php while ( $slider->have_posts() ): ?><?php $slider->the_post(); ?><?php $image_id = get_post_thumbnail_id(); ?><?php $image_src = getImage('slide', '1920x600', $image_id); ?><div style="background-image:url(<?php print $image_src; ?>" class="item"><img src="<?php print $image_src; ?>" class="visible-xs background-img"><div class="container"><h2><?php the_excerpt(); ?></h2></div></div><?php endwhile; ?><?php endif; ?><?php wp_reset_query(); ?></div><a href="#monCarousel" role="button" data-slide="prev" class="left carousel-control hidden-xs"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a><a href="#monCarousel" role="button" data-slide="next" class="right carousel-control hidden-xs"><span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next</span></a></div></section><section class="header"><div class="container"><div class="row"><div class="col-md-9 header-menu"><div role="navigation" class="navbar navbar-default"><div class="navbar-header"><button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a href="/" class="navbar-brand"><span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt=""></span></a></div><div class="navbar-collapse collapse"><ul class="nav navbar-nav"><?php if (class_exists('wpMenu', false)): ?><?php $wpM = new wpMenu('top-menu'); ?><?php $firstMenuLevel = $wpM->getMenu(0); ?><?php foreach($firstMenuLevel as $menu_item_0): ?><li class="<?php print($menu_item_0->class." ".$menu_item_0->megaclass); ?>"><a href="<?php print($menu_item_0->link); ?>" title="<?php print($menu_item_0->title); ?>"><?php print($menu_item_0->title); ?></a></li><?php endforeach; ?><?php endif; ?></ul></div></div></div><div class="col-md-3 header-sidebar text-right"><?php $fb = get_option('ma_fb'); ?><?php if(!empty($fb)): ?><a href="<?php print($fb); ?>" class="social-link facebook"><i class="fa fa-facebook"></i></a><?php endif; ?><?php $vk = get_option('ma_vk'); ?><?php if(!empty($vk)): ?><a href="<?php print($vk); ?>" class="social-link vk"><i class="fa fa-vk"></i></a><?php endif; ?><?php $pi = get_option('ma_pi'); ?><?php if(!empty($pi)): ?><a href="<?php print($pi); ?>" class="social-link pinterest"><i class="fa fa-pinterest"></i></a><?php endif; ?><?php $im = get_option('ma_im'); ?><?php if(!empty($im)): ?><a href="<?php print($im); ?>" class="social-link instagram"><i class="fa fa-instagram"></i></a><?php endif; ?></div><div class="col-md-12 hidden-sm bottom-line-col"><div class="bottom-line"></div></div></div></div></section><section class="content"><div class="container"><div class="row"><div class="col-md-12 main-content single-project"><?php global $themename; ?><div class="row page-head"><div class="col-md-12"><?php if (class_exists('wpBreadcrumbs', false)): ?><?php $BC = new wpBreadcrumbs('<i class="fa fa-home"></i>','<i class="fa fa-angle-right"></i>',$post_types = array('decoration'=>'decoration-type','product'=>'product_cat','master'=>'master-type','project'=>'design-type')); ?><?php $breadcrumbs = $BC->getBreadcrumbs(); ?><?php if(count($breadcrumbs) > 0): ?><div class="breadcrumbs hidden-xs"><h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="page-title"><a href="<?php print($breadcrumbs[0]['link']); ?>" itemprop="url"><span class="icon"><?php print($breadcrumbs[0]['icon']); ?></span><span itemprop="title"><?php print($breadcrumbs[0]['text']); ?></span></a><?php unset($breadcrumbs[0]); ?><?php foreach($breadcrumbs as $breadcrumb): ?><?php if($breadcrumb['text']): ?><span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php if(!empty($breadcrumb['link'])): ?><a href="<?php print($breadcrumb['link']); ?>" itemprop="url"><span class="icon"><?php print($breadcrumb['icon']); ?></span><span itemprop="title"><?php print($breadcrumb['text']); ?></span></a><?php else: ?><span class="icon"><?php print($breadcrumb['icon']); ?></span><span itemprop="title"><?php print($breadcrumb['text']); ?></span><?php endif; ?></span><?php endif; ?><?php endforeach; ?></h1></div><?php endif; ?><?php endif; ?><?php if(is_tax('product_cat')): ?><?php $cid = get_queried_object_id(); ?><?php $args = array('orderby' => 'name','order' => 'ASC','hide_empty' => true, 'exclude' => array(),'number' => '','fields' => 'all','parent'  => $cid,'hierarchical' => false,'child_of' => $cid, 'offset' => ''); ?><?php $terms = get_terms('product_cat', $args); ?><?php $display_type = get_woocommerce_term_meta( $cid, 'display_type', true ); ?><?php if(empty($terms) || sizeof($terms)<1 || $display_type == 'products'): ?><div class="product-filters"><div class="product-filter"><a href="#" data-filter="*" class="btn btn-default"><?php print(__('All products', $themename)); ?></a></div><div class="product-filter"><a href="#" data-filter=".sale" class="btn btn-default"><?php print(__('Sale products', $themename)); ?></a></div></div><?php endif; ?><?php endif; ?><div class="double-border-bottom"></div></div></div><div class="row"><?php if (have_posts()): ?><?php while (have_posts()): ?><?php the_post(); ?><div class="gallery-line"><div class="col-md-8 gallery-big-picture"><?php $thumbnail_id = get_post_thumbnail_id(); ?><?php $thumbnail_src = getImage('group', '200x200', $thumbnail_id); ?><?php $big_image_src = getImage('project_big', '800x380', $thumbnail_id); ?><?php $full_image_src = getPostImage(); ?><?php if(!empty($thumbnail_id )): ?><a href="<?php print($full_image_src); ?>" data-options="thumbnail:'<?php print($thumbnail_src); ?>'" class="lightbox decoration-big-picture"><img src="<?php print($big_image_src); ?>" alt="<?php print(get_the_title()); ?>" class="img-responsive"></a><?php endif; ?></div><div class="col-md-4 gallery-small-pictures"><?php if(easy_image_gallery_get_image_ids()): ?><?php $gallery = easy_image_gallery_get_image_ids(); ?><div data-mcs-theme="dark" class="gallery-small-pictures-scroll mCustomScrollbar"><div class="row"><?php foreach ($gallery as $image): ?><?php $image_src = getImage('project', '170x85', $image); ?><?php $thumbnail_src = getImage('group', '200x200', $image); ?><?php $full_src = wp_get_attachment_image_src($image, 'full'); ?><div class="col-md-6 gallery-small-pictures-col"><?php if(!empty($full_src)): ?><a href="<?php print($full_src[0]); ?>" data-options="thumbnail:'<?php print($thumbnail_src); ?>'" rel="ilightbox[gallery<?php print(get_the_ID()); ?>]" class="lightbox"><img src="<?php print($image_src); ?>" alt="<?php print(get_the_title()); ?>" class="img-responsive"></a><?php else: ?><a><img src="<?php print($image_src); ?>" alt="<?php print(get_the_title()); ?>" class="img-responsive"></a><?php endif; ?></div><?php endforeach; ?></div></div><?php endif; ?></div></div><div class="page-line col-md-12 interior-info"><div class="page-container pull-left"><div class="page-heading"><h3><?php print(get_the_title()); ?></h3><div class="btn-container page-heading-order"><a href="<?php print(get_post_type_archive_link('project')); ?>" class="btn btn-primary"><span><?php print __('All projects',$themename); ?></span><i class="fa fa-chevron-circle-right"></i></a></div></div><div class="page-content pull-left"><div class="page-text"><?php the_content(); ?></div></div></div></div><?php $related = get_metadata('post', $post->ID, 'ma_related_products', true); ?><?php endwhile; ?><?php wp_reset_query(); ?><?php if(!empty($related)): ?><?php query_posts(array('post__in' => $related,'post_type'=> 'decoration')); ?><?php if (have_posts()): ?><?php $carousel_title = __('Recommended decoration',$themename); ?><?php $button_text = __('Order design', $themename); ?><?php $button_link = '#orderDesignModal'; ?><div class="col-md-12 double-border-container"><div class="double-border-bottom"></div></div><div class="page-line col-md-12 interior-carousel"><div class="page-container pull-left"><div class="page-heading"><?php if(!empty($carousel_title)): ?><h3><?php print($carousel_title); ?></h3><?php endif; ?><?php if(!empty($button_text)): ?><div class="btn-container page-heading-order"><?php if(substr($button_link, 0, 1) == '#'): ?><a data-toggle="modal" data-target="<?php print($button_link); ?>" class="btn btn-primary"><span><?php print($button_text); ?></span><i class="fa fa-chevron-circle-right"></i></a><?php else: ?><a href="<?php print($button_link); ?>" class="btn btn-primary"><span><?php print($button_text); ?></span><i class="fa fa-chevron-circle-right"></i></a><?php endif; ?></div><?php endif; ?></div><div class="page-content pull-left"><div class="page-text"><div class="carousel carousel-block"><div class="carousel-frame"><ul class="carousel-slider"><?php while (have_posts()): ?><?php the_post(); ?><?php $image_id = get_post_thumbnail_id(); ?><?php $image_src = getImage('interior', '260x150', $image_id); ?><li class="carousel-slide"><div class="carousel-slide-container"><img src="<?php print($image_src); ?>" alt="<?php print(get_the_title()); ?>" class="img-responsive"><a href="<?php print(get_the_permalink()); ?>" class="carousel-slide-info"><span><?php print(get_the_title()); ?></span></a></div></li><?php endwhile; ?></ul></div></div></div></div></div></div><?php endif; ?><?php wp_reset_query(); ?><?php endif; ?><?php endif; ?></div></div></div></div></section><?php global $themename; ?><div tabindex="-1" role="dialog" aria-labelledby="orderDesignModalLabel" id="orderDesignModal" class="modal fade mc-question-modal"><div role="document" class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">&times;</span></button><h4 id="orderDesignModalLabel" class="modal-title"><?php print(__('Order design', $themename)); ?></h4></div><div class="modal-body mc-question-modal-body"><?php print(do_shortcode('[gravityform id="5" name="designOrder" title="false" description="false" ajax="true" field_values="post_name='.$post_title.'"]')); ?></div></div></div></div><?php get_footer(); ?></body></html>