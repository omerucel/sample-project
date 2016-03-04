<?php

namespace Project\WebController;

class Homepage extends BaseController
{
    public function homepage()
    {
        $lang = $this->getHttpRequest()->get('lang', 'tr_TR');
        $this->getTranslator()->setLocale($lang);
        $message = $this->getTranslator()->trans('Hello World');
        $this->render('site/index.twig', array('message' => $message, 'lang' => $lang));
    }
}
