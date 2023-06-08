<!DOCTYPE html>
<html>
<head>
    <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> <?php } ?> <?php wp_title(); ?></title>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="icon" type="image/png" href="<?php get_bloginfo('stylesheet_directory')."/images/favicon.png"; ?>" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <?php wp_head(); ?>
</head>

<body<?php body_class(); ?>>
    <div id="header">
        <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
    </div>
    <div id="container">
