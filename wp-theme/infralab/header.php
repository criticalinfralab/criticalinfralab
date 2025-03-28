<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> <?php } ?> <?php wp_title(); ?></title>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?revalidate151024" type="text/css" media="all">
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="header">
        <h1 class="site-title">
            <?php if(!is_front_page()): ?><a href="<?php bloginfo('url'); ?>" title="Go to the landing page"><?php endif; ?>
            <?php bloginfo('name'); ?>
            <?php if(is_home()): ?></a><?php endif; ?>
        </h1>
        <div id="antennaspace"><!-- space for antennas --></div>
        <span class="button" id="eyecare" href="#">desaturate</span>
    </div>
    <div id="container">
