<?php

namespace MyApp\Component;

use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

session_start();

class Locale extends Injectable
{
    /**
     * @return NativeArray
     */
    public function getTranslator(): NativeArray
    {
        // Ask browser what is the best language
        if (!$_SESSION['lang']) {
            $_SESSION['lang'] = 'en';
        }
        $language = $_SESSION['lang'];
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
