<!DOCTYPE html>
<head>
    <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> <?php } ?> <?php wp_title(); ?></title>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>?revalidate" type="text/css" media="all" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="header">
        <h1 class="site-title">
            <?php if(!is_front_page()): ?><a href="<?php bloginfo('url'); ?>" title="go to startpage"><?php endif; ?>
            <?php bloginfo('name'); ?>
            <?php if(is_home()): ?></a><?php endif; ?>
        </h1>
        <div id="antennaspace"><!-- space for antennas --></div>
        <a class="button" id="eyecare" href="#">desaturate</a>
        
        <input type="checkbox" id="menuToggle">
        <label for="menuToggle" class="menu-icon">
           <div class="toggler">
               <span aria-hidden="true" class="menu-deco"></span>
               <span aria-hidden="true" class="menu-deco"></span>
               <span aria-hidden="true" class="menu-deco"></span>
           </div>
        </label>
        <ul class="menu">
            <li><a href="<?php bloginfo('url'); ?>/#header">start</a></li>
            <li><a href="<?php bloginfo('url'); ?>/#section-activities">activities</a></li>
            <li><a href="<?php bloginfo('url'); ?>/#section-publications">publications</a></li>
            <li><a href="<?php bloginfo('url'); ?>/#section-people-and-governance">people and governance</a></li>
        </ul>
    </div>
    <div id="container">
