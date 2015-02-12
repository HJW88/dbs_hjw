<?php
/**
 * Date: 12/02/15
 * Time: 20:02
 * Author: HJW88
 */

/**
 * Class etController
 * This controller maintains the Event and Themes.
 * This two models are similar
 */
class etController extends BaseController
{

    public function index()
    {

    }


    public function edit()
    {
        echo json_encode($_GET);

    }

    public function delete(){

    }


    public function add()
    {
        if (userController::isAdmin()) {

            switch ($_SERVER['REQUEST_METHOD']) {

                case 'GET':
                    $title = 'Add New Event Or Theme';
                    $this->showHeader($title);
                    $this->showForm($title, 'et/add');
                    $this->showFooter();
                    break;

                case 'POST':

                    if (ETModel::getETByTypeName($_POST['type'],$_POST['name'])){
                        $this->setSesstion('alert','warning','This Event Or Theme already exists');
                        $this->redirectTo('admin');
                        break;
                    }
                    echo json_encode($_POST);

                    if (ETModel::addETRecord($_POST['type'], $_POST['name'], $_POST['description'])) {
                        $this->setSesstion('alert', 'success', 'Event Or Theme Add Success');
                    } else {
                        $this->setSesstion('alert', 'alert', 'Event Or Theme Add Failed');
                    }

                    $this->redirectTo('admin');
                    break;

            }


        } else {
            $this->setSesstion('alert', 'alert', 'Permission Denney');
            $this->redirectTo('user');
        }
    }


    public function dorelated(){
        if (userController::isAdmin() && isset($_GET['id']) && isset($_GET['productID']) && isset($_GET['action']) && isset($_GET['type'])){

            if (ETModel::doETProductRelated($_GET['type'],$_GET['id'],$_GET['productID'], $_GET['action'])){
                $this->setSesstion('alert','success','Related Event or Theme updated');
            }

        } else {
            $this->setSesstion('alert','alert','Permission Denney');

        }
        $this->redirectTo('product/view&id='.$_GET['productID'].'#'.$_GET['type']);
    }



    protected function showForm($title, $action, $instance = null)
    {

        $form = new formViewController($title, $action);

        $form->addFromNormalInput('input', 'hidden', 'id', '', '', $instance ? $instance['id'] : null);

        $form->addFromNormalInput('input', 'text', 'name', 'Name', 'Name', $instance ? $instance['name'] : null);
        $form->addFromNormalInput('textarea', 'text', 'description', 'Description', 'Description', $instance ? $instance['description'] : null);

        if ($instance){
            $form->addFromNormalInput('input','hidden','type','',$instance['type']);
        } else {
            $form->addFormSelection('select', 'type', 'Type', array('event' => 'Event', 'theme' => 'Theme'));
        }
        $form->showForm();

    }


}