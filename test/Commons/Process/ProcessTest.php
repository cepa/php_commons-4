<?php

/**
 * =============================================================================
 * @file       Commons/Process/ProcessTest.php
 * @author     Lukasz Cepowski <lukasz@cepowski.com>
 * 
 * @copyright  PHP Commons
 *             Copyright (C) 2009-2013 PHP Commons Contributors
 *             All rights reserved.
 *             www.phpcommons.com
 * =============================================================================
 */

namespace Commons\Process;

class ProcessTest extends \PHPUnit_Framework_TestCase
{

    protected $_phpbin = null;

    public function setUp()
    {
        parent::setUp();
        $pathes = explode(':', getenv('PATH'));
        foreach ($pathes as $path) {
            if (file_exists($path.'/php'))
            break;
        }
        $this->_phpbin = $path.'/php';
    }

    public function testConstructor()
    {
        
        $p = new Process("xxx");
        $this->assertEquals("xxx", $p->getCommand());
    }

    public function testSetGetCommand()
    {
        $p = new Process;
        $this->assertNull($p->getCommand());
        $p = $p->setCommand('abc');
        $this->assertTrue($p instanceof Process);
        $this->assertEquals('abc', $p->getCommand());
    }

    public function testSetGetStdin()
    {
        $p = new Process;
        $this->assertNull($p->getStdin());
        $p = $p->setStdin("some data");
        $this->assertTrue($p instanceof Process);
        $this->assertEquals("some data", $p->getStdin());
    }

    public function testSetGetCwd()
    {
        $p = new Process();
        $this->assertEquals(realpath('.'), $p->getCwd());
        $p = $p->setCwd("/tmp");
        $this->assertTrue($p instanceof Process);
        $this->assertEquals("/tmp", $p->getCwd());
    }

    public function testSetGetEnv()
    {
        $p = new Process();
        $env = $p->getEnv();
        $this->assertTrue(is_array($env));
        $this->assertEquals(0, count($env));

        $env = array('abc' => 123, 'def' => 456);
        $p = $p->setEnv($env);
        $this->assertTrue($p instanceof Process);
        $this->assertEquals(2, count($p->getEnv()));
    }

    public function testSetGetClearAddParams()
    {
        $p = new Process();
        $this->assertEquals(0, count($p->getParams()));

        $p = $p->setParams(array('aaa', 'bbb', 'ccc'));
        $this->assertTrue($p instanceof Process);
        $this->assertEquals(3, count($p->getParams()));

        $p = $p->clearParams();
        $this->assertTrue($p instanceof Process);
        $this->assertEquals(0, count($p->getParams()));

        $p = $p->addParam('xyz');
        $this->assertTrue($p instanceof Process);
        $this->assertEquals(1, count($p->getParams()));

        $a = $p->getParams();
        $this->assertEquals('xyz', $a[0]);
    }

    public function testGetFullCommand()
    {
        $p = new Process();
        $p
        ->setCommand('abc')
        ->addParam('def')
        ->addParam('ghi');
        $this->assertEquals('abc def ghi', $p->getFullCommand());
    }

    public function testLs()
    {
        $p = new Process("ls", '/');
        $p->run();
        $this->assertEquals(0, $p->getExitCode());
        $this->assertContains('root', $p->getStdout());
    }

    public function testEcho()
    {
        $p = new Process('echo "xxx yyy"');
        $p->run();
        $this->assertEquals(0, $p->getExitCode());
        $this->assertEquals("xxx yyy\n", $p->getStdout());
    }

    public function testPhpInfo()
    {
        $p = new Process($this->_phpbin.' -i');
        $p->run();
        $this->assertEquals(0, $p->getExitCode());
        $this->assertContains("phpinfo", $p->getStdout());
    }

    public function testPhpNotExistingFile()
    {
        $p = new Process($this->_phpbin." -l some.not.existing.file.php");
        $p->run();
        $this->assertEquals(1, $p->getExitCode());
        $mergedOutput = $p->getStdout().$p->getStderr();
        $this->assertContains('some.not.existing.file.php', $mergedOutput);
    }
    
    public function testExecute()
    {
        $stdout = Process::execute($this->_phpbin, array('-i'));
        $this->assertContains("phpinfo", $stdout);
    }
    
    public function testExecuteException()
    {
        $this->setExpectedException('Commons\\Process\\Exception');
        $stdout = Process::execute($this->_phpbin, array('-l', 'some.not.existing.file.php'));
        $this->assertContains("phpinfo", $stdout);
    }

}
