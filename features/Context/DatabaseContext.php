<?php

declare(strict_types=1);

namespace Context;

use Behat\Behat\Context\Context;
use App\Kernel;
use Behat\Behat\Hook\Call\BeforeScenario;
use Behat\Behat\Hook\Call\AfterScenario;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Testwork\Hook\Call\AfterSuite;

/**
 * Dumps database on the first scenario execution and reload the dump for every other scenario execution.
 */
class DatabaseContext implements Context
{
    /** @var Kernel */
    private $kernel;

    /** @var string Contains the dump path */
    public static $dump = '/tmp/chal-dump.sql';

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    /** @var array Contains database credentials. Will be automatically loaded on the first run. */
    private $parameters;

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        if (empty($this->parameters)) {
            $this->parameters = $this->getParameters();
        }

        if (!file_exists(self::$dump)) {
            $this->dumpDatabase();
        }
    }

    /**
     * @AfterScenario
     */
    public function reloadDumpAfterScenario(AfterScenarioScope $scope)
    {
        if ($scope->getScenario()->hasTag('untouchedDatabase')) {
            return;
        }

        // Database is reloaded a last time at the end of the suite,
        // to allow to run multiple suites without resetting the database between each execution
        $this->reloadDump();
    }

    /**
     * @AfterSuite
     */
    public static function deleteDatabaseDump()
    {
        if (file_exists(self::$dump)) {
            unlink(self::$dump);
        }
    }

    private function dumpDatabase()
    {
        exec(sprintf('mysqldump %s >%s', self::getCommandArguments(), self::$dump));
    }

    private function reloadDump()
    {
        exec(sprintf('mysql %s <%s', self::getCommandArguments(), self::$dump));
    }

    /**
     * @return string mysql command arguments containing host/port/user/password/name
     */
    private function getCommandArguments()
    {
        $passwordArgument = '';

        if (!empty($this->parameters['password'])) {
            $passwordArgument = '-p'.$this->parameters['password'];
        }

        return sprintf(
            '-h%s -P%s -u%s %s %s',
            $this->parameters['host'],
            $this->parameters['port'],
            $this->parameters['username'],
            $passwordArgument,
            $this->parameters['dbname']
        );
    }

    private function getParameters(): array
    {
        $doctrineConnection = $this
            ->kernel
            ->getContainer()
            ->get('doctrine')
            ->getEntityManager()
            ->getConnection()
        ;

        return [
            'host' => $doctrineConnection->getHost() ?? 'localhost',
            'password' => $doctrineConnection->getPassword(),
            'username' => $doctrineConnection->getUsername(),
            'port' => $doctrineConnection->getPort() ?? '3306',
            'dbname' => $doctrineConnection->getParams()['dbname'],
        ];
    }
}
