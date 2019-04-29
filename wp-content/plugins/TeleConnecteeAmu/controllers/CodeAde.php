<?php
/**
 * Created by PhpStorm.
 * User: Rohrb
 * Date: 29/04/2019
 * Time: 09:53
 */

class CodeAde extends ControllerG
{
    private $view;
    private $model;

    /**
     * CodeAde constructor.
     */
    public function __construct(){
        $this->view = new ViewCodeAde();
        $this->model = new CodeAdeManager();
    }

    /**
     * Insert a row into code_ade
     */
    public function insertCode(){
        $this->view->displayFormAddCode();

        $action = $_POST['addCode'];
        $code = filter_input(INPUT_POST, 'codeAde');
        $title = filter_input(INPUT_POST, 'titleAde');
        $type = filter_input(INPUT_POST, 'typeCode');

        if($action == "Valider"){
            if($this->model->addCode($type, $title, $code)){
                echo "Ajout réalisé";
            }
            else{
                echo "Raté mon gros pépère";
            }
        }
    }

    /**
     * Display all codes from the databass
     */
    public function displayAllCodes(){
        $results = $this->model->getAllCode();
        $this->view->displayAllCode($results);
    }

    /**
     * Delete code
     * @param $id
     */
    public function deleteMyCode($id){
        if(isset($id)){
            $this->model->deleteCode($id);
            $this->view->refreshPage();
        }
    }

    /**
     * Modify the code
     */
    public function modifyMyCode(){
        $url = filter_input(INPUT_GET, 'url');

        if (empty($url)) {
            $url = 'Home';
        }

        $urlExpl = explode('/', $url);
        echo $url;
        $result = $this->model->getCode($this->getMyIdUrl(38));
        $this->view->displayModifyCode($result);
    }
}