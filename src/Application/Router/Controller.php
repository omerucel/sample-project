<?php

namespace Application\Router;

use Application\Di\Di;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    /**
     * @var Di
     */
    protected $dependencyInjection;

    /**
     * @param Di $dependencyInjection
     */
    public function __construct(Di $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    /**
     * @return Di
     */
    public function getDi()
    {
        return $this->dependencyInjection;
    }

    /**
     * @param array $params
     * @return null
     */
    public function preDispatch(array $params = [])
    {
        return null;
    }

    /**
     * @param array $params
     * @return null
     */
    public function postDispatch(array $params = [])
    {
        return null;
    }

    /**
     * @param $url
     * @param int $code
     * @param array $headers
     * @return RedirectResponse
     */
    protected function redirect($url, $code = 302, $headers = array())
    {
        return new RedirectResponse($url, $code, $headers);
    }

    /**
     * @param array $result
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function toJson(array $result, $status = 200, $headers = array())
    {
        $response = $this->getDi()->get('http_response');
        $response->setContent(json_encode($result));
        $response->setStatusCode($status);

        $headers['Content-Type'] = 'application/json; charset=utf-8';
        $this->setHeaders($response, $headers);

        return $response;
    }

    /**
     * @param $result
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function toPlainText($result, $status = 200, $headers = array())
    {
        $response = $this->getDi()->get('http_response');
        $response->setContent($result)
            ->setStatusCode($status, '');

        $headers['Content-Type'] = 'text/plain; charset=utf-8';
        $this->setHeaders($response, $headers);

        return $response;
    }

    /**
     * @param $result
     * @param int $status
     * @param array $headers
     * @return Response
     */
    protected function toHtml($result, $status = 200, $headers = array())
    {
        $response = $this->getDi()->get('http_response');
        $response->setContent($result)
            ->setStatusCode($status, '');

        $headers['Content-Type'] = 'text/html; charset=utf-8';
        $this->setHeaders($response, $headers);

        return $response;
    }

    /**
     * @param Response $response
     * @param array $headers
     * @return Response
     */
    protected function setHeaders(Response $response, $headers = array())
    {
        $response->headers->set('X-App-Request-Id', $this->getDi()->get('config')->req_id);
        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }
    }
}
