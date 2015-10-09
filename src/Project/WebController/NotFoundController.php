<?php

namespace Project\WebController;

class NotFoundController extends BaseController
{
    public function __call($name, $args = [])
    {
        $this->getLogger()->warning(
            'Page not found : ' . strtoupper($name) . ' ' . $this->getHttpRequest()->getUri() . ' '
            . json_encode($args)
        );
        $this->sendPlainText('Not found');
    }
}
