<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */

/**
 *
 * The index.php file is the single point of access.
 * As such, it provides the ideal space for declaring variables
 * and site wide configurations.
 *
 */

/*** define the site path ***/
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

/*** include the init.php file
 * this init.php contains all credential to DB and some basic settings.
 ***/
include 'includes/init.php';

/*** load the router object to registry ***/
$registry->router = new router($registry);

/*** set the controller path ***/
$registry->router->setPath(__SITE_PATH . '/controller');

/*** load up the template object ***/
$registry->template = new template($registry);

/*** load the controller ***/
$registry->router->loader();
