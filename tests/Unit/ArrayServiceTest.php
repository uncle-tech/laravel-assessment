<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ArrayService;

class ArrayServiceTest extends TestCase
{
    protected function service()
    {
        return new ArrayService;
    }

    public function testMethodEntriesJoinsEachKeyValuePairIntoAnIndexedArrayWithTwoValues()
    {
        $this->assertEquals(
            [
                ['attr1', 'val1'],
                ['attr2', 'val2'],
                ['attr3', 'val3'],
            ],
            $this->service()->entries([
                'attr1' => 'val1',
                'attr2' => 'val2',
                'attr3' => 'val3',
            ])
        );
    }

    public function testMethodEntriesWorksWithAnyDepth()
    {
        $this->assertEquals(
            [
                ['attr1', 'val1'],
                ['attr2', 'val2'],
                ['attr3', [
                    ['innerAttr1', 'inner3Val1'],
                    ['innerAttr2', 'inner3Val2'],
                ]],
            ],
            $this->service()->entries([
                'attr1' => 'val1',
                'attr2' => 'val2',
                'attr3' => [
                    'innerAttr1' => 'inner3Val1',
                    'innerAttr2' => 'inner3Val2',
                ]
            ])
        );
    }
}
