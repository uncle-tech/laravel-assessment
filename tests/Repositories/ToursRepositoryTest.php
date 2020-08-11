<?php

namespace Tests\Repositories;

use Tests\TestCase;
use App\Services\UtilsService;

class ToursRepositoryTest extends TestCase
{
    protected function repository()
    {
        return app()->make('App\Contracts\ToursRepository');
    }

    public function testTheCreateMethodReceivesAnAssociativeArrayAndReturnsTheNewRecordId()
    {
        $result = $this->repository()->create([
            'start' => '2020-07-13',
            'end' => '2020-08-13',
            'price' => 199.90,
        ]);

        $this->assertTrue(\is_numeric($result) && $result > 0);
    }

    /**
     * Wrapper method
     */
    protected function equalDates($d1, $d2)
    {
        return (new UtilsService)->equalDates($d1, $d2);
    }

    public function testMethodFindGetATourByItsId()
    {
        $data = [
            'start' => '1998-12-10',
            'end' => '1999-06-10',
            'price' => 299.90,
        ];

        $id = $this->repository()->create($data);

        $tour = $this->repository()->find($id);

        $this->assertSame('1-1-1', \implode('-', [
            (int) $this->equalDates($data['start'], $tour->start),
            (int) $this->equalDates($data['end'], $tour->end),
            (int) ($data['price'] == $tour->price),
        ]));
    }

    public function testTheUpdateMethodReturnsTrueWhenSuccessful()
    {
        $id = $this->repository()->create([
            'start' => '2010-03-10',
            'end' => '2010-08-10',
            'price' => 99.90,
        ]);

        $newPrice = 50.00;
        $updated = $this->repository()->update($id, [
            'price' => $newPrice,
        ]);

        $tour = $this->repository()->find($id);

        $this->assertTrue($updated);
        $this->assertEquals($newPrice, $tour->price);
    }

    public function testTheDestroyMethodReturnsTrueWhenSuccessful()
    {
        $id = $this->repository()->create([
            'start' => '2020-09-08',
            'end' => '2021-10-09',
            'price' => 300.00,
        ]);

        $totalBefore = \count($this->repository()->all());

        $deleted = $this->repository()->destroy($id);

        $this->assertTrue($deleted);

        $this->assertSame(
            $totalBefore - 1,
            \count($this->repository()->all())
        );
    }

    public function testTheDestroyMethodReturnsFalseWhenCannotFindTheRecordByTheId()
    {
        $id = $this->repository()->create([
            'start' => '2010-05-08',
            'end' => '2011-05-18',
            'price' => 390.00,
        ]);

        $totalBefore = \count($this->repository()->all());

        $deleted = $this->repository()->destroy(99999);

        $this->assertFalse($deleted);

        $this->assertSame(
            $totalBefore,
            \count($this->repository()->all())
        );
    }
}
