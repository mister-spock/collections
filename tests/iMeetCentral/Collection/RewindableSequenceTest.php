<?php

use iMeetCentral\Collection\RewindableSequence as Sequence;
use PHPUnit\Framework\TestCase;

class RewindableSequenceTest extends TestCase {

    public
    function testRewind() {
        $seq = new Sequence([1, 2, 3, 4]);
        $seq->to_array();

        $seq->rewind();

        $this->assertEquals($seq->to_array(), [1, 2, 3, 4]);
    }

    public
    function testReuse() {
        $seq = new Sequence([1]);

        $seq->to_array();
        $seq->to_array();

        $this->assertEquals($seq->to_array(), [1]);
    }

}