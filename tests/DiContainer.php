<?php

class DiContainer
{
    /**
     * @var \Application\Di\Di
     */
    protected static $diImpl;

    /**
     * @param \Application\Di\Di $diImpl
     */
    public static function setDiImpl($diImpl)
    {
        self::$diImpl = $diImpl;
    }

    /**
     * @return \Application\Di\Di
     */
    public static function getDiImpl()
    {
        return self::$diImpl;
    }
}
