<?php

use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;

session_start();

class SignupController extends Controller
{
    public function indexAction()
    {
        // Redirect to View
    }
    public function addAction()
    {
        $val = $_POST['role'];
        if (!isset($_SESSION['logins'])) {
            $_SESSION['logins'] = 'user';
        }
        $signer  = new Hmac();
        $builder = new Builder($signer);
        $now        = new DateTimeImmutable();
        $issued     = $now->getTimestamp();
        $notBefore  = $now->modify('-1 minute')->getTimestamp();
        $expires    = $now->modify('+1 day')->getTimestamp();
        $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

        $builder
            ->setExpirationTime($expires)
            ->setIssuedAt($issued)
            ->setNotBefore($notBefore)
            ->setPassphrase($passphrase)
            ->setSubject($val);

        $tokenObject = $builder->getToken();
        $value = $tokenObject->getToken();

        $parser = new Parser();
        $token = $parser->parse($value);
        $claim = $token->getClaims()->getPayload();
        $_SESSION['logins'] = $claim['sub'];

        $_SESSION['logins'] = $_POST['role'];
        $this->response->redirect('index');
    }
}
