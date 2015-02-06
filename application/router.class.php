<?php
/**
 * Date: 06/02/15
 * Time: 19:51
 * Author: HJW88
 */


/**
 * Class router
 * The router class is responsible for loading up the correct controller.
 *
 * The basic router rule: ?rt={controller}/action
 */
class router
{
    /*
    * @the registry
    */
    private $registry;

    /*
    * @the controller path
    */
    private $path;

    private $args = array();

    public $file;

    public $controller;

    public $action;

    function __construct($registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param $path
     * @throws Exception
     */
    function setPath($path)
    {

        /*** check if path i sa directory ***/
        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        /*** set the path ***/
        $this->path = $path;
    }


    /**
     *
     */
    public function loader()
    {
        /*** check the route ***/
        $this->getController();

        /*** if the file is not there diaf ***/
        if (is_readable($this->file) == false) {
            $this->file = $this->path . '/error404.html';
            $this->controller = 'error404';
        }

        /*** include the controller ***/
        include $this->file;

        /*** a new controller class instance ***/
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        /*** check if the action is callable ***/
        if (is_callable(array($controller, $this->action)) == false) {
            $action = 'index';
        } else {
            $action = $this->action;
        }
        /*** run the action ***/
        $controller->$action();
    }


    /**
     * rt parameter in url is used to load controller,
     * the url is in this form ?rt={controller}/action
     */
    private function getController()
    {

        /*** get the route from the url ***/
        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];

        if (empty($route)) {
            $route = 'index';
        } else {
            /*** get the parts of the route ***/
            $parts = explode('/', $route);
            $this->controller = $parts[0];
            if (isset($parts[1])) {
                $this->action = $parts[1];
            }
        }

        /*** default action is index ***/
        if (empty($this->controller)) {
            $this->controller = 'index';
        }

        /*** Get action ***/
        if (empty($this->action)) {
            $this->action = 'index';
        }

        /*** set the file path ***/
        $this->file = $this->path . '/' . $this->controller . 'Controller.php';
    }


}


