<?php

use iMeetCentral\Collection\Exception\SeqException;
use iMeetCentral\Collection\Seq;
use PHPUnit\Framework\TestCase;

class SeqTest extends TestCase {

    public
    function testFrom() {
        $testArray   = [1, 2, 3, 4, 5];
        $resultArray = Seq::from($testArray)
            ->filter('is_int')
            ->map(function(int $num) { return $num; })
            ->to_array();

        $this->assertEquals($testArray, $resultArray);
    }

    /**
     * @dataProvider mapDataProvider
     */
    public
    function testMap($fn, $input, $expected) {
        $seq = new Seq($input);

        $this->assertEquals($expected, $seq->map($fn)->to_array());
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
        $seq = new Seq($input);

        $this->assertEquals($expected, $seq->filter($fn)->to_array());
    }

    public
    function filterDataProvider() {
        return [
            [function($num) { return $num < 3; }, [1, 2, 3, 4], [1, 2]],
            [function($str) { return $str === 'apples'; }, ['apples', 'bananas', 'oranges'], ['apples']],
        ];
    }

    /**
     * @dataProvider takeDataProvider
     */
    public
    function testTake($num, $input, $expected) {
        $seq = new Seq($input);

        $this->assertEquals($expected, $seq->take($num)->to_array());
    }

    public
    function takeDataProvider() {
        return [
            [0, [1, 2, 3, 4], []],
            [2, ['apples', 'bananas', 'oranges'], ['apples', 'bananas']],
        ];
    }

    /**
     * @dataProvider sliceDataProvider
     */
    public
    function testSlice($start, $num, $input, $expected) {
        $seq = new Seq($input);

        $this->assertEquals($expected, $seq->slice($start, $num)->to_array());
    }

    public
    function sliceDataProvider() {
        return [
            [2, 2, [1, 2, 3, 4], [3, 4]],
            [1, 1, ['apples', 'bananas', 'oranges'], ['bananas']],
        ];
    }

    /**
     * @dataProvider takeWhileDataProvider
     */
    public
    function testTakeWhile($fn, $input, $expected) {
        $seq = new Seq($input);

        $this->assertEquals($expected, $seq->take_while($fn)->to_array());
    }

    public
    function takeWhileDataProvider() {
        return [
            [function($num) { return $num < 3; }, [1, 4, 3, 2], [1]],
            [function($str) { return substr($str, 0, 1) === 'a'; }, ['apples', 'apricots', 'oranges'], ['apples', 'apricots']],
        ];
    }

    public
    function testCombos() {
        $seq = new Seq([1, 2, 3, 4]);
        $seq = $seq->map(function($num) {
                return $num + 1;
            })
            ->filter(function($num) {
                return $num < 4;
            })
            ->slice(0, 1);

        $this->assertEquals([2], $seq->to_array());
    }

    /**
     * @dataProvider dropDataProvider
     */
    public
    function testDrop($num, $input, $expected) {
        $seq = new Seq($input);

        $this->assertEquals($expected, $seq->drop($num)->to_array());
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
        $seq = new Seq([1, 2, 3, 4]);
        $seq->to_array();

        $seq->rewind();

        $this->assertEquals([1, 2, 3, 4], $seq->to_array());
    }

    public
    function testReuse() {
        $seq = new Seq([1]);

        $seq->to_array();
        $seq->to_array();

        $this->assertEquals([1], $seq->to_array());
    }

}