<?php

use iMeetCentral\Collection\Exception\SeqException;
use iMeetCentral\Collection\NonRewindableSeq as Seq;
use PHPUnit\Framework\TestCase;

class RewindableSeqTest extends TestCase {

    public
    function testRewind() {
        $this->expectException(SeqException::class);
        $seq = new Seq([1]);
        $seq->rewind();
    }

    public
    function testReuse() {
        $this->expectException(Exception::class);

        $seq = new Seq([1]);
        $seq->to_array();
        $seq->to_array();
    }

}