<?php
namespace Ac;

class Dc
{
    /**
     * default scheme
     */
    const SCHEME = 'generator';

    /**
     * @var bool
     */
    private static $isRegistered = false;

    /**
     * @var string
     */
    private $scheme;

    /**
     * Dc constructor.
     * @param string $scheme
     */
    public function __construct($scheme = self::SCHEME)
    {
        $this->scheme = $scheme;
        $this->register();
    }

    /**
     * Dc destructor
     */
    public function __destruct()
    {
        $this->unregister();
    }

    /**
     * @return bool
     */
    public function isRegistered()
    {
        return self::$isRegistered;
    }

    /**
     * @return bool
     */
    public function unregister()
    {
        if (self::$isRegistered) {
            self::$isRegistered = !stream_wrapper_unregister($this->scheme);
        }
        return !self::$isRegistered;
    }

    /**
     * @param \Generator $generator
     * @return false|resource
     */
    public function createStream(\Generator $generator)
    {
        if (!$this->isRegistered()) {
            throw new \BadMethodCallException(sprintf('"%s" scheme is not registered', $this->scheme));
        }

        $GLOBALS['__acdc__'] = $generator;
        $resource = fopen($this->scheme . '://__acdc__', 'r');
        unset($GLOBALS['__acdc__']);
        return $resource;
    }

    /**
     * @return bool
     */
    private function register()
    {
        if (!self::$isRegistered) {
            self::$isRegistered = stream_wrapper_register($this->scheme, GeneratorStreamWrapper::class);
        }
        return self::$isRegistered;
    }
}
