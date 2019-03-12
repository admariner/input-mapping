<?php

namespace Keboola\InputMapping\Tests;

use Keboola\InputMapping\Reader\Options\InputTableOptions;
use Keboola\InputMapping\Reader\Options\InputTablesOptions;

class InputTablesOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTables()
    {
        $definitions = new InputTablesOptions([
            ['source' => 'test1'],
            ['source' => 'test2']
        ]);
        $tables = $definitions->getTables();
        self::assertCount(2, $tables);
        self::assertEquals(InputTableOptions::class, get_class($tables[0]));
        self::assertEquals(InputTableOptions::class, get_class($tables[1]));
        self::assertEquals('test1', $tables[0]->getSource());
        self::assertEquals('test2', $tables[1]->getSource());
    }
}