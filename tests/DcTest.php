<?php
namespace Ac;

use Ac\fixtures\FixturesFactory;

class DcTest extends \PHPUnit_Framework_TestCase
{
    public function testWithFgets()
    {
        $fixturesFactory = new FixturesFactory();
        $generator = $fixturesFactory->createCSV(2);

        $acdc = new Dc();
        $resource = $acdc->createStream($generator);

        $this->assertInternalType('resource', $resource);
        $this->assertSame('"0A","0B","0C","0D","0E"' . "\n", fgets($resource));
        $this->assertSame('"1A","1B","1C","1D","1E"' . "\n", fgets($resource));
        $this->assertFalse(fgets($resource));
    }

    public function testWithFgetsWithLength()
    {
        $fixturesFactory = new FixturesFactory();
        $generator = $fixturesFactory->createCSV(2);

        $acdc = new Dc();
        $resource = $acdc->createStream($generator);

        $this->assertInternalType('resource', $resource);
        $this->assertSame('"0A",', fgets($resource, 6));
        $this->assertSame('"0B",', fgets($resource, 6));
        $this->assertSame('"0C",', fgets($resource, 6));
        $this->assertSame('"0D",', fgets($resource, 6));
        $this->assertSame('"0E"' . "\n", fgets($resource, 6));
        $this->assertSame('"1A",', fgets($resource, 6));
        $this->assertSame('"1B",', fgets($resource, 6));
        $this->assertSame('"1C",', fgets($resource, 6));
        $this->assertSame('"1D",', fgets($resource, 6));
        $this->assertSame('"1E"'  . "\n", fgets($resource, 6));
        $this->assertFalse(fgets($resource));
    }

    public function testWithFgetc()
    {
        $fixturesFactory = new FixturesFactory();
        $generator = $fixturesFactory->createCSV(2);

        $acdc = new Dc();
        $resource = $acdc->createStream($generator);

        $this->assertInternalType('resource', $resource);
        $this->assertSame('"', fgetc($resource));
        $this->assertSame('0', fgetc($resource));
        $this->assertSame('A', fgetc($resource));
        $this->assertSame('"', fgetc($resource));
    }

    public function testUnregistered()
    {
        $fixturesFactory = new FixturesFactory();
        $generator = $fixturesFactory->createCSV(2);

        $acdc = new Dc();
        $acdc->unregister();
        $this->assertFalse($acdc->isRegistered());
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('"generator" scheme is not registered');
        $acdc->createStream($generator);
    }
}
