<?php

namespace Application\DiService;

use Application\Di\Di;
use Application\Di\DiService;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;

class TranslatorService implements DiService
{
    /**
     * @param Di $diImpl
     * @return mixed
     */
    public function getService(Di $diImpl)
    {
        $configs = $diImpl->get('config');
        $translator = new Translator('tr_TR');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', include($configs->base_path . '/translations/tr.php'), 'tr_TR');
        return $translator;
    }

    /**
     * @return bool
     */
    public function isShared()
    {
        return true;
    }
}
