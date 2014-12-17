<?php

namespace Application;

class ErrorCatcher
{
    protected $fatalCallback = null;
    protected $exceptionCallback = null;

    public function register()
    {
        set_error_handler(array($this, 'errorHandler'));
        set_exception_handler(array($this, 'handleException'));
        register_shutdown_function(array($this, 'handleFatalError'));
    }

    /**
     * @param null $onFatalCallback
     */
    public function setFatalCallback($onFatalCallback)
    {
        $this->fatalCallback = $onFatalCallback;
    }

    /**
     * @param $message
     */
    protected function onFatalCallback($message)
    {
        if ($this->fatalCallback != null) {
            call_user_func_array($this->fatalCallback, [$message]);
        }
    }

    /**
     * @param null $onWarningCallback
     */
    public function setExceptionCallback($onWarningCallback)
    {
        $this->exceptionCallback = $onWarningCallback;
    }

    /**
     * @param \Exception $exception
     */
    protected function onExceptionCallback(\Exception $exception)
    {
        if ($this->exceptionCallback != null) {
            call_user_func_array($this->exceptionCallback, [$exception]);
        }
    }

    /**
     * Bir hata oluştuğunda bu metod tetiklenir.
     *
     * @param $errNo
     * @param $errStr
     * @param $errFile
     * @param $errLine
     * @throws \ErrorException
     */
    public function errorHandler($errNo, $errStr, $errFile, $errLine)
    {
        throw new \ErrorException($errStr, $errNo, 0, $errFile, $errLine);
    }

    /**
     * Ölümcül bir hata oluştuğunda bu metod tetiklenir.
     *
     * @return mixed
     */
    public function handleFatalError()
    {
        $error = error_get_last();

        if ($error !== null) {
            $errNo = $error["type"];
            $errFile = $error["file"];
            $errLine = $error["line"];
            $errStr = $error["message"];

            $message = 'ERR NO : ' . $errNo . ' ' . $errStr . ' ' . $errFile . ':' . $errLine;
            $message = str_replace("\n", '', $message);
            $this->onFatalCallback($message);
        }
    }

    /**
     * @param \Exception $exception
     */
    public function handleException(\Exception $exception)
    {
        $this->onExceptionCallback($exception);
    }
}
