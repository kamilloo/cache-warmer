<?php

namespace Snowdog\DevTest\Command;

use Snowdog\DevTest\Core\Database;
use Snowdog\DevTest\Core\Migration;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class MigrateCommand
{

    /**
     * @var Migration
     */
    private $migration;
    /**
     * @var QuestionHelper
     */
    private $helper;
    /**
     * @var Database
     */
    private $database;

    public function __construct(Migration $migration, QuestionHelper $helper, Database $database)
    {
        $this->migration = $migration;
        $this->helper = $helper;
        $this->database = $database;
    }

    public function __invoke(InputInterface $input, OutputInterface $output)
    {
        $this->testConnection($input, $output);

        try {
            $executed = $this->migration->execute();
            foreach ($executed as $row) {
                $output->writeln('Migration for <info>' . $row[Migration::COMPONENT] . '</info> version <info>' . $row[Migration::VERSION] . '</info>');
            }
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }
    }

    private function testConnection(InputInterface $input, OutputInterface $output)
    {
        $hostQuestion = new Question('Please provide database host name: <comment>[localhost]</comment> ', 'localhost');
        $dbQuestion = new Question('Please provide database name: <comment>dev_test</comment> ', 'dev_test');
        $userQuestion = new Question('Please provide database user name: <comment>[root]</comment> ', 'root');
        $passwordQuestion = new Question('Please provide database password: ');

        $hostName = false;
        $dbName = false;
        $user = false;
        $password = false;

        while (true) {
            try {
                if ($hostName || $dbName || $user || $password) {
                    $this->database->persistConnectionSettings($hostName, $dbName, $user, $password);
                }

                $this->database->quote('SELECT 1;');
                $output->writeln('<info>Connected to database!</info>');
                break;
            } catch (\PDOException $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
            }

            $hostName = $this->helper->ask($input, $output, $hostQuestion);
            $dbName = $this->helper->ask($input, $output, $dbQuestion);
            $user = $this->helper->ask($input, $output, $userQuestion);
            $password = $this->helper->ask($input, $output, $passwordQuestion);
        }
    }
}