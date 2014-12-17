<?php

namespace Application\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;
use Zend\Config\Config;

class TwigEnvironmentFactory
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @param Config $config
     * @param Translator $translator
     * @param Request $request
     */
    public function __construct(Config $config, Translator $translator, Request $request)
    {
        $this->config = $config;
        $this->translator = $translator;
        $this->request = $request;
    }

    public function factory()
    {
        $loader = new \Twig_Loader_Filesystem($this->config->twig->templates_path);
        $twig = new \Twig_Environment($loader, $this->config->twig->toArray());
        $this->addTranslatorFunction($twig, $this->translator);
        $this->addCreateUrlFunction($twig, $this->request, $this->config->web_application->base_domain);
        $this->addSiteUrlFunction($twig, $this->request, $this->config->web_application->site_base_url);
        $this->addAssetUrlFunction($twig, $this->request, $this->config->web_application->asset_base_url);
        return $twig;
    }

    protected function addTranslatorFunction(\Twig_Environment $twig, Translator $translator)
    {
        $function = new \Twig_SimpleFunction('translate', function ($key, array $params = []) use ($translator) {
            return $translator->trans($key, $params);
        });
        $twig->addFunction('translate', $function);
    }

    protected function addCreateUrlFunction(\Twig_Environment $twig, Request $httpRequest, $baseUrl)
    {
        $function = $this->createUrlFunction('create_url', $httpRequest, $baseUrl);
        $twig->addFunction('create_url', $function);
    }

    protected function addSiteUrlFunction(\Twig_Environment $twig, Request $httpRequest, $baseUrl)
    {
        $function = $this->createUrlFunction('site_url', $httpRequest, $baseUrl);
        $twig->addFunction('site_url', $function);
    }

    protected function addAssetUrlFunction(\Twig_Environment $twig, Request $httpRequest, $baseUrl)
    {
        $function = $this->createUrlFunction('asset_url', $httpRequest, $baseUrl);
        $twig->addFunction('asset_url', $function);
    }

    /**
     * @param $name
     * @param Request $httpRequest
     * @param $baseUrl
     * @return \Twig_SimpleFunction
     */
    protected function createUrlFunction($name, Request $httpRequest, $baseUrl)
    {
        if (substr($baseUrl, 0, 2) == '//') {
            $baseUrl = $httpRequest->getScheme() . ':' . $baseUrl;
        } else if (substr($baseUrl, 0, 4) != 'http' && substr($baseUrl, 0, 1) != '/') {
            $baseUrl = $httpRequest->getScheme() . '://' . $baseUrl;
        }

        return new \Twig_SimpleFunction($name, function () use ($baseUrl) {
            $arguments = func_get_args();
            $path = array_shift($arguments);
            $path = vsprintf($path, $arguments);
            if (substr($baseUrl, -1) == '/') {
                $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);
            }

            if (substr($path, 0, 1) != '/') {
                $path = '/' . $path;
            }

            return $baseUrl . $path;
        });
    }
}
