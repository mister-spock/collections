<?php

use iMeetCentral\Collection\Exception\SeqException;
use iMeetCentral\Collection\NonRewindableSeq as NRSeq;
use PHPUnit\Framework\TestCase;

class RewindableSeqTest extends TestCase {

    public
    function testFrom() {
        $testArray   = [1, 2, 3, 4, 5];
        $resultArray = NRSeq::from($testArray)
            ->filter('is_int')
            ->map(function(int $num) { return $num; })
            ->to_array();

        $this->assertEquals($testArray, $resultArray);
    }

    public
    function testRewind() {
        $this->expectException(SeqException::class);
        $seq = new NRSeq([1]);
        $seq->rewind();
    }

    public
    function testReuse() {
        $this->expectException(Exception::class);

        $seq = new NRSeq([1]);
        $seq->to_array();
        $seq->to_array();
    }

}