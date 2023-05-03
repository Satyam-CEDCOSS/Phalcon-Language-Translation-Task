<?php

namespace MyApp\Listener;

use Phalcon\Di\Injectable;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application;
use Phalcon\Events\Event;

session_start();

class Aclistener extends Injectable
{
    public function beforeHandleRequest(Event $events, Application $app, Dispatcher $dis)
    {
       $di = $this->getDI();
        $acl = new Memory();

        $acl->addRole('manager');
        $acl->addRole('admin');
        $acl->addRole('user');
        $acl->addRole('');

        $acl->addComponent(
            '',
            [
                '',
            ]
        );

        $acl->addComponent(
            'add',
            [
                'allow',
                'contaction',
                'index',
                'role'
            ]
        );

        $acl->addComponent(
            'index',
            [
                'index'
            ]
        );

        $acl->addComponent(
            'order',
            [
                '',
                'add',
                'list',
                'index'
            ]
        );

        $acl->addComponent(
            'signup',
            [
                'index',
            ]
        );

        $acl->addComponent(
            'setting',
            [
                'index',
            ]
        );

        $acl->addComponent(
            'product',
            [
                '',
                'index',
                'add',
                'list'
            ]
        );

        $acl->allow('*', '', '');
        $acl->allow('admin', '*', '*');
        $acl->allow('manager', '*', '*');
        $acl->deny('manager', 'add', '*');
        $acl->allow('user', 'index', '*');
        $acl->allow('user', 'signup', '*');
        $acl->allow('', 'signup', '*');
        $acl->allow('user', 'product', ['','index']);
        $acl->allow('user', 'order', ['','index']);



        $controle = $dis->getControllerName();
        $action = $dis->getActionName();
        $type = $_SESSION['logins'];
        print_r($type);
        $check = $acl->isAllowed($type, $controle, $action);
        if (!$check) {
            echo $di->get('locale')->_('Access Denied');
            die;
        }
    }
}