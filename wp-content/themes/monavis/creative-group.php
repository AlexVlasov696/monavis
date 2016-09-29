<?php /*Template Name:Creative Group */ ?><!DOCTYPE html><html><head><?php get_header(); ?></head><body><section class="slider head-slider"><div id="monCarousel" data-ride="carousel" class="carousel slide"><ol class="carousel-indicators"><?php global $wpdb; ?><?php $slides_count = $wpdb->get_var('SELECT COUNT(*) FROM wp_posts AS p WHERE p.post_type="slide" AND p.post_status = "publish"'); ?><?php for($i=0; $i<$slides_count; $i++): ?><?php if($i==0): ?><li data-target="#monCarousel" data-slide-to="<?php print($i); ?>" class="active"></li><?php else: ?><li data-target="#monCarousel" data-slide-to="<?php print($i); ?>"></li><?php endif; ?><?php endfor; ?></ol><div role="listbox" class="carousel-inner"><?php $slider = new WP_Query( array ( 'post_type' => 'slide')); ?><?php if ( $slider->have_posts() ): ?><?php while ( $slider->have_posts() ): ?><?php $slider->the_post(); ?><?php $image_id = get_post_thumbnail_id(); ?><?php $image_src = getImage('slide', '1920x600', $image_id); ?><div style="background-image:url(<?php print $image_src; ?>" class="item"><img src="<?php print $image_src; ?>" class="visible-xs background-img"><div class="container"><h2><?php the_excerpt(); ?></h2></div></div><?php endwhile; ?><?php endif; ?><?php wp_reset_query(); ?></div><a href="#monCarousel" role="button" data-slide="prev" class="left carousel-control hidden-xs"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a><a href="#monCarousel" role="button" data-slide="next" class="right carousel-control hidden-xs"><span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span><span class="sr-only">Next</span></a></div></section><section class="header"><div class="container"><div class="row"><div class="col-md-9 header-menu"><div role="navigation" class="navbar navbar-default"><div class="navbar-header"><button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a href="/" class="navbar-brand"><span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt=""></span></a></div><div class="navbar-collapse collapse"><ul class="nav navbar-nav"><?php if (class_exists('wpMenu', false)): ?><?php $wpM = new wpMenu('top-menu'); ?><?php $firstMenuLevel = $wpM->getMenu(0); ?><?php foreach($firstMenuLevel as $menu_item_0): ?><li class="<?php print($menu_item_0->class." ".$menu_item_0->megaclass); ?>"><a href="<?php print($menu_item_0->link); ?>" title="<?php print($menu_item_0->title); ?>"><?php print($menu_item_0->title); ?></a></li><?php endforeach; ?><?php endif; ?></ul></div></div></div><div class="col-md-3 header-sidebar text-right"><?php $fb = get_option('ma_fb'); ?><?php if(!empty($fb)): ?><a href="<?php print($fb); ?>" class="social-link facebook"><i class="fa fa-facebook"></i></a><?php endif; ?><?php $vk = get_option('ma_vk'); ?><?php if(!empty($vk)): ?><a href="<?php print($vk); ?>" class="social-link vk"><i class="fa fa-vk"></i></a><?php endif; ?><?php $pi = get_option('ma_pi'); ?><?php if(!empty($pi)): ?><a href="<?php print($pi); ?>" class="social-link pinterest"><i class="fa fa-pinterest"></i></a><?php endif; ?><?php $im = get_option('ma_im'); ?><?php if(!empty($im)): ?><a href="<?php print($im); ?>" class="social-link instagram"><i class="fa fa-instagram"></i></a><?php endif; ?></div><div class="col-md-12 hidden-sm bottom-line-col"><div class="bottom-line"></div></div></div></div></section><section class="content"><div class="container"><div class="row"><div class="col-md-12 main-content"><?php global $themename; ?><div class="row page-head"><div class="col-md-12"><?php if (class_exists('wpBreadcrumbs', false)): ?><?php $BC = new wpBreadcrumbs('<i class="fa fa-home"></i>','<i class="fa fa-angle-right"></i>',$post_types = array('decoration'=>'decoration-type','product'=>'product_cat','master'=>'master-type','project'=>'design-type')); ?><?php $breadcrumbs = $BC->getBreadcrumbs(); ?><?php if(count($breadcrumbs) > 0): ?><div class="breadcrumbs hidden-xs"><h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="page-title"><a href="<?php print($breadcrumbs[0]['link']); ?>" itemprop="url"><span class="icon"><?php print($breadcrumbs[0]['icon']); ?></span><span itemprop="title"><?php print($breadcrumbs[0]['text']); ?></span></a><?php unset($breadcrumbs[0]); ?><?php foreach($breadcrumbs as $breadcrumb): ?><?php if($breadcrumb['text']): ?><span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><?php if(!empty($breadcrumb['link'])): ?><a href="<?php print($breadcrumb['link']); ?>" itemprop="url"><span class="icon"><?php print($breadcrumb['icon']); ?></span><span itemprop="title"><?php print($breadcrumb['text']); ?></span></a><?php else: ?><span class="icon"><?php print($breadcrumb['icon']); ?></span><span itemprop="title"><?php print($breadcrumb['text']); ?></span><?php endif; ?></span><?php endif; ?><?php endforeach; ?></h1></div><?php endif; ?><?php endif; ?><?php if(is_tax('product_cat')): ?><?php $cid = get_queried_object_id(); ?><?php $args = array('orderby' => 'name','order' => 'ASC','hide_empty' => true, 'exclude' => array(),'number' => '','fields' => 'all','parent'  => $cid,'hierarchical' => false,'child_of' => $cid, 'offset' => ''); ?><?php $terms = get_terms('product_cat', $args); ?><?php $display_type = get_woocommerce_term_meta( $cid, 'display_type', true ); ?><?php if(empty($terms) || sizeof($terms)<1 || $display_type == 'products'): ?><div class="product-filters"><div class="product-filter"><a href="#" data-filter="*" class="btn btn-default"><?php print(__('All products', $themename)); ?></a></div><div class="product-filter"><a href="#" data-filter=".sale" class="btn btn-default"><?php print(__('Sale products', $themename)); ?></a></div></div><?php endif; ?><?php endif; ?><div class="double-border-bottom"></div></div></div></div><div class="col-md-12 page-line"><div class="page-container pull-left"><div class="page-heading"><h3><?php print(get_the_title()); ?></h3></div><div class="page-content"><div class="page-text"><p><?php print(get_the_content()); ?><?php wp_reset_query(); ?><?php query_posts( array ( 'post_type' => 'team')); ?><?php if (have_posts()): ?><?php while (have_posts()): ?><?php the_post(); ?><?php $team_position = get_post_meta($post->ID,'ma_team_position', true); ?><?php $image_id = get_post_thumbnail_id(); ?><?php $image_src = getImage('group', '200x200', $image_id); ?><div class="row creative-group"><div class="col-md-4 creative-group-info"><div class="row"><div class="col-md-6 text-center"><h3 class="creative-group-name"><?php print(get_the_title()); ?></h3><div class="creative-group-position"><h4><?php print($team_position); ?></h4></div></div><div class="col-md-6 creative-group-photo"><img src="<?php print($image_src); ?>" alt="<?php print(get_the_title()); ?>" class="img-responsive"></div></div></div><div class="col-md-8 creative-group-text"><p><?php print(get_the_content()); ?></p></div></div><?php endwhile; ?><?php endif; ?><?php wp_reset_query(); ?></p></div></div></div></div></div></div></section><?php get_footer(); ?></body></html>