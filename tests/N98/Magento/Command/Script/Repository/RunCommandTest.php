<?php

namespace N98\Magento\Command\Script\Repository;

use N98\Magento\Command\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RunCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = $this->getApplication();
        $config = $application->getConfig();
        $config['script']['folders'][] = __DIR__ . '/_scripts';
        $application->setConfig($config);

        $application->add(new RunCommand());
        $command = $this->getApplication()->find('script:repo:run');

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                'command' => $command->getName(),
                'script'  => 'hello-world',
            )
        );

        // Runs sys:info -> Check for any output
        $this->assertContains('Vendors', $commandTester->getDisplay());
        $this->assertContains('Magento', $commandTester->getDisplay());
        $this->assertContains(__DIR__ . '/_scripts/hello-world.magerun', $commandTester->getDisplay());
    }
}
