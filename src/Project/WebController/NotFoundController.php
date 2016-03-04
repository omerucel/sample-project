<?php

namespace Project\WebController;

class NotFoundController extends BaseController
{
    public function notFound()
    {
        $this->getLogger()->warning(
            'Page not found : ' . $this->getHttpRequest()->getMethod() . ' ' . $this->getHttpRequest()->getUri(),
            array('params' => $_REQUEST)
        );
        $this->sendPlainText('Not found', 404);
    }
}
