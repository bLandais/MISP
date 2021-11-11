<?php
require_once __DIR__ . '/../../../Lib/Tools/RandomTool.php';

use PHPUnit\Framework\TestCase;

class RandomToolTest extends TestCase
{

    public function testGenerateRandomStrings()
    {
        // Verify that two randomly generated strings are not equals
        $randomTool = new RandomTool();
        $size = 12;
        $firstRandom = $randomTool->random_str(false, $size);
        $this->assertEquals($size, strlen($firstRandom));
        $secondRandom = $randomTool->random_str(false, $size);
        $this->assertEquals($size, strlen($secondRandom));
        $this->assertNotEquals($firstRandom, $secondRandom,
            'strings should be different');

        $firstRandom = $randomTool->random_str(true, $size);
        $this->assertEquals($size, strlen($firstRandom));
        $secondRandom = $randomTool->random_str(true, $size);
        $this->assertEquals($size, strlen($secondRandom));
        $this->assertNotEquals($firstRandom, $secondRandom,
        'strings should be different');
    }

    public function testGenerateWithOneCharInCharset()
    {
        $randomTool = new RandomTool();
        $this->expectException(LogicException::class);
        $this->expectExceptionMessageMatches('/.*Argument 3 -.*at least 2.*/');
        $randomTool->random_str(false, 10, 'a');
    }

    public function testGenerateWithSameCharInCharset()
    {
        $randomTool = new RandomTool();
        $this->expectException(LogicException::class);
        $this->expectExceptionMessageMatches('/.*Argument 3 -.*at least 2.*/');
        $randomTool->random_str(false, 10, 'bbbbb');
    }


    public function testGenerateWithInvalidLength()
    {
        $randomTool = new RandomTool();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('random_str - Argument 2 - expected an integer');
        $randomTool->random_str(false, 'invalid');

        $empty = $randomTool->random_str(false, 0);
        $this->assertEquals('', $empty);
    }

    public function testGenerateWithInvalidCryptoType()
    {
        $randomTool = new RandomTool();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('random_str - Argument 1 - expected a boolean');
        $randomTool->random_str('mt_rand', '20');
        $randomTool->random_str(12, '20');
    }

    public function testGenerateWithInvalidCharsetType()
    {
        $randomTool = new RandomTool();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('random_str - Argument 3 - expected a string');
        $randomTool->random_str(false, 10, 10);
        $randomTool->random_str(false, 10, true);
    }


}
