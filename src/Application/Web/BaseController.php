<?php

namespace Application\Web;

use Application\Router\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;

class BaseController extends Controller
{
    /**
     * @param $template
     * @param array $params
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function render($template, array $params = [], $status = 200, array $headers = [])
    {
        return $this->toHtml($this->getTwig()->render($template, $params), $status, $headers);
    }

    /**
     * @return \Twig_Environment
     */
    protected function getTwig()
    {
        return $this->getDi()->get('twig');
    }

    /**
     * @return \Swift_Mailer
     */
    protected function getSwiftMailer()
    {
        return $this->getDi()->get('swiftmailer');
    }

    /**
     * @return \PDO
     */
    protected function getPdo()
    {
        return $this->getDi()->get('pdo');
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->getDi()->get('session');
    }

    /**
     * @return Request
     */
    protected function getHttpRequest()
    {
        return $this->getDi()->get('http_request');
    }

    /**
     * @return Response
     */
    protected function getHttpResponse()
    {
        return $this->getDi()->get('http_response');
    }

    /**
     * @return Translator
     */
    protected function getTranslator()
    {
        return $this->getDi()->get('translator');
    }

    /**
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->getDi()->get('logger');
    }
}
