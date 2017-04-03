<?php

use iMeetCentral\Collection\Exception\SequenceException;
use iMeetCentral\Collection\Sequence;
use PHPUnit\Framework\TestCase;

class SequenceTest extends TestCase {

    /**
     * @dataProvider mapDataProvider
     */
    public
    function testMap($fn, $input, $expected) {
        $seq = new Sequence($input);

        $this->assertEquals($seq->map($fn)->to_array(), $expected);
    }

    public
    function mapDataProvider() {
        return [
            [function($num) { return $num + 1; }, [1, 2, 3, 4], [2, 3, 4, 5]],
            [function($num) { return $num * $num; }, [1, 2, 3, 4], [1, 4, 9, 16]],
            [function($num) { return $num * 0; }, [1, 2, 3, 4], [0, 0, 0, 0]],
        ];
    }

    /**
     * @dataProvider filterDataProvider
     */
    public
    function testFilter($fn, $input, $expected) {
        $seq = new Sequence($input);

        $this->assertEquals($seq->filter($fn)->to_array(), $expected);
    }

    public
    function filterDataProvider() {
        return [
            [function($num) { return $num < 3; }, [1, 2, 3, 4], [1, 2]],
            [function($num) { return $num === 'apples'; }, ['apples', 'bananas', 'oranges'], ['apples']],
        ];
    }

    /**
     * @dataProvider takeDataProvider
     */
    public
    function testTake($num, $input, $expected) {
        $seq = new Sequence($input);

        $this->assertEquals($seq->take($num)->to_array(), $expected);
    }

    public
    function takeDataProvider() {
        return [
            [0, [1, 2, 3, 4], []],
            [2, ['apples', 'bananas', 'oranges'], ['apples', 'bananas']],
        ];
    }

    /**
     * @dataProvider dropDataProvider
     */
    public
    function testDrop($num, $input, $expected) {
        $seq = new Sequence($input);

        $this->assertEquals($seq->drop($num)->to_array(), $expected);
    }

    public
    function dropDataProvider() {
        return [
            [2, [1, 2, 3, 4], [3, 4]],
            [1, ['apples', 'bananas', 'oranges'], ['bananas', 'oranges']],
        ];
    }

    public
    function testRewind() {
        $this->expectException(SequenceException::class);
        $seq = new Sequence([1]);
        $seq->rewind();
    }

    public
    function testReuse() {
        $this->expectException(Exception::class);

        $seq = new Sequence([1]);
        $seq->to_array();
        $seq->to_array();
    }

}