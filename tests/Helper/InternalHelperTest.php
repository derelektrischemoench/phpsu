<?php

namespace PHPSu\Tests\Helper;

use PHPSu\Exceptions\CommandExecutionException;
use PHPSu\Exceptions\EnvironmentException;
use PHPSu\Helper\ApplicationHelper;
use PHPSu\Tools\EnvironmentUtility;
use PHPUnit\Framework\TestCase;

class InternalHelperTest extends TestCase
{
    const GIT_PATH = __DIR__ . '/../../.git';

    public function testGetPhpsuVersionFromVendor()
    {
        $result = $this->callPrivateMethod('getPhpSuVersionFromVendor');
        $this->assertEmpty($result, 'Asserting phpsu-vendor version to be empty due to test context');
    }

    public function testGetPhpSuVersionFromGitFolder()
    {
        $this->assertFileExists(self::GIT_PATH . '/HEAD');
        if (file_exists(self::GIT_PATH . '/HEAD')) {
            $this->assertNotEmpty($this->callPrivateMethod('getPhpSuVersionFromGitFolder'));
        } else {
            $this->expectException(EnvironmentException::class);
            $this->callPrivateMethod('getPhpSuVersionFromGitFolder');
        }
    }

    private function callPrivateMethod(string $method)
    {
        $object = new ApplicationHelper();
        $reflection =  (new \ReflectionClass($object))->getMethod($method);
        $reflection->setAccessible(true);
        return $reflection->invoke($object);
    }
}
