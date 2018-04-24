<?php

namespace Codeception\Module;

use Codeception\Module;
use Codeception\Lib\Interfaces\DependsOnModule;

/**
 * Class Database
 * @package Helper
 */
class Database extends Module implements DependsOnModule
{
    /**
     * @var \Codeception\Module\Db
     */
    protected $db;

    /**
     * @var string
     */
    protected $connection;

    public function _initialize()
    {
        $this->connection = $this->config['connection'] ?? 'mysql';
    }

    /**
     * @return array
     */
    public function _depends()
    {
        return [
            'Codeception\Module\Db' => 'Db module is required',
            'Codeception\Module\Laravel5' => 'This module is designet for Laravel'
        ];
    }

    /**
     * @return void
     */
    public function _inject(\Codeception\Module\Db $db)
    {
        $this->db = $db;
    }

    /**
     * Enable the Sql Query Logging
     */
    public function enableSqlQueryListener()
    {
        \DB::connection($this->connection)->enableQueryLog();
    }

    /**
     * @param int $expectedCount
     */
    public function assertSqlQueriesLessThan(int $expectedCount)
    {
        $this->assertLessThan($expectedCount, $this->databaseQueryCount());
    }

    /**
     * @param int $expectedCount
     */
    public function assertSqlQueriesLessThanOrEqual(int $expectedCount)
    {
        $this->assertLessThanOrEqual($expectedCount, $this->databaseQueryCount());
    }

    /**
     * @param int $expectedCount
     */
    public function assertSqlQueriesEquals(int $expectedCount)
    {
        $this->assertEquals($expectedCount, $this->databaseQueryCount());
    }

    /**
     * @param int $expected
     */
    public function assertSqlExecutionTimeLessThan($expected)
    {
        $this->assertLessThan($expected, $this->databaseExecutionTime());
    }

    /**
     * @param int $expected
     */
    public function assertSqlExecutionTimeLessThanOrEqual($expected)
    {
        $this->assertLessThanOrEqual($expected, $this->databaseExecutionTime());
    }

    /**
     * Debugging
     */
    public function debugSqlQueries()
    {
        dump(\DB::connection($this->connection)->getQueryLog());
    }

    /**
     * Get the database query count
     * @return int
     */
    private function databaseQueryCount(): int
    {
        return \count(\DB::connection($this->connection)->getQueryLog());
    }

    /**
     * Total execution time
     * @return float|int
     */
    private function databaseExecutionTime()
    {
        return array_sum(array_column(\DB::connection($this->connection)->getQueryLog(), 'time'));
    }

}