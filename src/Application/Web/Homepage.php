<?php

namespace Application\Web;

class Homepage extends BaseController
{
    public function get()
    {
        return $this->render('site/index.twig');
    }
}
