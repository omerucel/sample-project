<?php

namespace Project\WebController;

class Homepage extends BaseController
{
    public function get()
    {
        $this->render('site/index.twig');
    }
}
