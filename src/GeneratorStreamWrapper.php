<?php
namespace Ac;

class GeneratorStreamWrapper
{
    /**
     * @var \Generator|null
     */
    private $generator;

    /**
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param string $openedPath
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$openedPath)
    {
        $variableName = parse_url($path, PHP_URL_HOST);

        if (empty($GLOBALS[$variableName])) {
            return false;
        }

        $this->generator = $GLOBALS[$variableName];
        return $this->generator instanceof \Generator;
    }

    /**
     * @param $count
     * @return string
     */
    function stream_read($count)
    {
        $result = $this->generator->current();
        $this->generator->next();
        return $result;
    }

    /**
     * @return bool
     */
    function stream_eof()
    {
        return !$this->generator->valid();
    }
}
