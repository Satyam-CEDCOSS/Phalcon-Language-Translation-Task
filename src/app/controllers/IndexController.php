<?php

use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

session_start();

class IndexController extends Controller
{
    public function indexAction()
    {
        $sql = 'SELECT * FROM Products';
        $query = $this->modelsManager->createQuery($sql);
        $cars = $query->execute();
        $this->view->option = "<option value=''>-Select-</option>";
        foreach ($cars as $value) {
            $this->view->option .= "<option value=" . $value->name . ">" . $value->name . "</option>";
        }
        $this->session->set('option', $this->view->option);

        $this->view->t = $this->getAction();
    }
    public function getAction(): NativeArray
    {
        // Ask browser what is the best language
        $_SESSION['lang'] = $_POST['lang'];
        if ($_POST['lang']) {
            $language = $_POST['lang'];
        }
        $messages = [];
        
        $translationFile = APP_PATH . '/messages/'.$language.'.php';

        if (true !== file_exists($translationFile)) {
            $translationFile = APP_PATH . '/messages/'.$language.'.php';
        }

        include $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);

        return $factory->newInstance(
            'array',
            [
                'content' => $messages,
            ]
        );
    }
}
