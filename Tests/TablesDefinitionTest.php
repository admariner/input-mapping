<?php

namespace Keboola\InputMapping\Tests;

use Keboola\InputMapping\Reader\Definition\TableDefinition;
use Keboola\InputMapping\Reader\Definition\TablesDefinition;

class TablesDefinitionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTables()
    {
        $definitions = new TablesDefinition([
            ['source' => 'test1'],
            ['source' => 'test2']
        ]);
        $tables = $definitions->getTables();
        self::assertCount(2, $tables);
        self::assertEquals(TableDefinition::class, get_class($tables[0]));
        self::assertEquals(TableDefinition::class, get_class($tables[1]));
        self::assertEquals('test1', $tables[0]->getSource());
        self::assertEquals('test2', $tables[1]->getSource());
    }
}
