<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ModuleConfigTest extends TestCase
{
    /**
     * @dataProvider moduleProvider
     */
    public function test_module_alias_matches_folder(string $folder, string $expected): void
    {
        $path = dirname(__DIR__, 2)."/Modules/{$folder}/module.json";
        $this->assertFileExists($path);
        $config = json_decode(file_get_contents($path), true);
        $this->assertSame($expected, $config['alias']);
    }

    public static function moduleProvider(): array
    {
        return [
            ['Core', 'core'],
            ['Inventory', 'inventory'],
            ['Pos', 'pos'],
            ['Crm', 'crm'],
        ];
    }
}
