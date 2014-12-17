<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;

class SwiftmailerService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $configs = $diImpl->get('config')->swiftmailer;
        $transport = \Swift_SmtpTransport::newInstance($configs->host, $configs->port)
            ->setUsername($configs->username)
            ->setPassword($configs->password);
        return \Swift_Mailer::newInstance($transport);
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
