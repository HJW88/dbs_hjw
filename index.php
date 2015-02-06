<?php

/**
 * MVC is a design pattern. A Design pattern is a code structure that allows for common coding frameworks to be replicated quickly. You might think of a design pattern as a skeleton or framework on which your application will be built.
 *
 *the index.html file is our single point of access. As such, it provides the ideal space for declaring variables and site wide configurations.
 */

/*** define the site path ***/
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

/*** include the init.php file ***/
include 'includes/init.php';

/*** load the router ***/
$registry->router = new router($registry);

/*** set the controller path ***/
$registry->router->setPath(__SITE_PATH . '/controller');

/*** load up the template ***/
$registry->template = new template($registry);

/*** load the controller ***/
$registry->router->loader();

error_log("Hi");
