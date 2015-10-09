<?php

namespace OU;

class ErrorCatcher
{
    /**
     * @var DI
     */
    protected $di;
    protected $fatalCallback = null;
    protected $exceptionCallback = null;

    public function __construct(DI $di)
    {
        $this->di = $di;
    }

    public function register()
    {
        set_error_handler(array($this, 'errorHandler'));
        set_exception_handler(array($this, 'exceptionHandler'));
        register_shutdown_function(array($this, 'fatalErrorHandler'));
    }

    /**
     * @param null $onFatalCallback
     */
    public function setFatalCallback($onFatalCallback)
    {
        $this->fatalCallback = $onFatalCallback;
    }

    /**
     * @return null
     */
    protected function onFatalCallback()
    {
        if ($this->fatalCallback != null) {
            call_user_func_array($this->fatalCallback, []);
        }
    }

    /**
     * @param null $exceptionCallback
     */
    public function setExceptionCallback($exceptionCallback)
    {
        $this->exceptionCallback = $exceptionCallback;
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
    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if ($error !== null) {
            $errNo = $error["type"];
            $errFile = $error["file"];
            $errLine = $error["line"];
            $errStr = $error["message"];

            $message = '[' . $errNo . '] ' . $errStr . ' ' . $errFile . ':' . $errLine;
            $message = str_replace("\n", '', $message);
            $this->di->get('logger_helper')->getLogger()->emergency($message);
            $this->onFatalCallback();
        }
    }

    /**
     * @param \Exception $exception
     */
    public function exceptionHandler(\Exception $exception)
    {
        $this->di->get('logger_helper')->getLogger()->error($exception);
        $this->onExceptionCallback($exception);
    }
}
