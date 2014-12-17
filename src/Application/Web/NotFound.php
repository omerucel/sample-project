<?php

namespace Application\Web;

class NotFound extends BaseController
{
    public function __call($name, $args = [])
    {
        $this->getLogger()->warning(
            'Page not found : ' . strtoupper($name) . ' ' . $this->getHttpRequest()->getUri() . ' '
            . json_encode($args)
        );
        return $this->render('/web/404.twig');
    }
}
