<?php
declare(strict_types=1);

namespace PHPSu\Process;

use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CommandExecutor
{
    /**
     * @param string[] $commands
     * @param OutputInterface $logOutput
     * @param OutputInterface $statusOutput
     * @return void
     */
    public function executeParallel(array $commands, OutputInterface $logOutput, OutputInterface $statusOutput)
    {
        $manager = new ProcessManager();
        foreach ($commands as $name => $command) {
            $logOutput->writeln(sprintf('<fg=yellow>%s:</> <fg=white;options=bold>running command: %s</>', $name, $command), OutputInterface::VERBOSITY_VERBOSE);
            $process = Process::fromShellCommandline($command, null, null, null, null);
            $process->setName($name);
            $manager->addProcess($process);
        }
        $callback = new StateChangeCallback($statusOutput);
        $manager->addStateChangeCallback($callback);
        $manager->addTickCallback($callback->getTickCallback());
        $manager->addOutputCallback(new OutputCallback($logOutput));
        $manager->mustRun();
    }

    public function passthru(string $command): int
    {
        $process = Process::fromShellCommandline($command, null, null, null, null);
        $process->setTty(true);
        $process->run();
        return $process->getExitCode();
    }

    public function runCommand(string $command): Process
    {
        $process = Process::fromShellCommandline($command, null, null, null, null);
        $process->run();
        return $process;
    }
}
