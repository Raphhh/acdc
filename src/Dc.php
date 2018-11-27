<?php
namespace Ac;

class Dc
{
    /**
     * default scheme
     */
    const SCHEME = 'generator';

    /**
     * default host
     */
    const HOST = '__acdc__';

    /**
     * @var bool
     */
    private static $isRegistered = false;

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $host;

    /**
     * Dc constructor.
     * @param string $scheme
     * @param string $host
     */
    public function __construct($scheme = self::SCHEME, $host = self::HOST)
    {
        $this->scheme = $scheme;
        $this->host = $host;
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

        $GLOBALS[$this->host] = $generator;
        $resource = fopen($this->scheme . '://' .  $this->host, 'r');
        unset($GLOBALS[$this->host]);
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
