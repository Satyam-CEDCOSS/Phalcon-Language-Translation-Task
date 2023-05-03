<?php

namespace MyApp\Listener;

use Phalcon\Di\Injectable;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application;
use Phalcon\Events\Event;

session_start();

class Listener extends Injectable
{
    public function beforeproduct()
    {
        $id = $this->getDI();
        $data = $id->get('session')->get('setting');
        if ($data['title'] == "Tags") {
            $_POST['name'] = $_POST['name'] . " " . $_POST['tags'];
        }
        if ($_POST['stock'] == "") {
            $_POST['stock'] = $data['stock'];
        }
        if ($_POST['price'] == "") {
            $_POST['price'] = $data['price'];
        }
    }
    public function beforeorder()
    {
        $di = $this->getDI();
        $data = $di->get('session')->get('setting');
        if ($_POST['zipcode'] == '') {
            $_POST['zipcode'] = $data['zipcode'];
        }
    }
}
