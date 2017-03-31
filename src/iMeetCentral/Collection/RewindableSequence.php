<?php
namespace iMeetCentral\Collection;

use Generator;
use iter, iter\rewindable;

/**
 * Rewindable implementation of AbstractSequence.
 * This can be reiterated over unlike the standard Sequence.
 *
 * @package iMeetCentral
 */
class RewindableSequence extends AbstractSequence {

    /**
     * @param $iterable
     * @return Generator
     */
    protected
    function to_generator($iterable) {
        return iter\rewindable\map(function($item) { return $item; }, $iterable);
    }

    /**
     * @param callable $fn
     * @return RewindableSequence
     */
    public
    function map(callable $fn) {
        return new self(iter\rewindable\map($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return RewindableSequence
     */
    public
    function map_keys(callable $fn) {
        return new self(iter\rewindable\mapKeys($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return RewindableSequence
     */
    public
    function reindex(callable $fn) {
        return new self(iter\rewindable\reindex($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return RewindableSequence
     */
    public
    function filter(callable $fn) {
        return new self(iter\rewindable\filter($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @param null $start_value
     * @return RewindableSequence
     */
    public
    function reductions(callable $fn, $start_value = null) {
        return new self(iter\rewindable\reductions($fn, $this->value, $start_value));
    }

    /**
     * @param array ...$iterables
     * @return RewindableSequence
     */
    public static
    function zip(...$iterables) {
        return new self(call_user_func_array('iter\rewindable\zip', $iterables));
    }

    /**
     * @param $keys
     * @param $values
     * @return RewindableSequence
     */
    public static
    function zip_key_value($keys,  $values) {
        return new self(iter\rewindable\zipKeyValue($keys, $values));
    }

    /**
     * @param array ...$iterables
     * @return RewindableSequence
     */
    public static
    function chain(...$iterables) {
        return new self(call_user_func_array('iter\rewindable\chain', $iterables));
    }

    /**
     * @param array ...$iterables
     * @return RewindableSequence
     */
    public static
    function product(...$iterables) {
        return new self(call_user_func_array('iter\rewindable\product', $iterables));
    }

    /**
     * @param int $start
     * @param int $length
     * @return RewindableSequence
     */
    public
    function slice(int $start, int $length = INF) {
        return new self(iter\rewindable\slice($this->value, $start, $length));
    }

    /**
     * @param int $num
     * @return RewindableSequence
     */
    public
    function take(int $num) {
        return new self(iter\rewindable\take($num, $this->value));
    }

    /**
     * @param int $num
     * @return RewindableSequence
     */
    public
    function drop(int $num) {
        return new self(iter\rewindable\drop($num, $this->value));
    }

    /**
     * @param callable $fn
     * @return RewindableSequence
     */
    public
    function take_while(callable $fn) {
        return new self(iter\rewindable\takeWhile($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return RewindableSequence
     */
    public
    function drop_while(callable $fn) {
        return new self(iter\rewindable\dropWhile($fn, $this->value));
    }

    /**
     * @return RewindableSequence
     */
    public
    function keys() {
        return new self(iter\rewindable\keys($this->value));
    }

    /**
     * @return RewindableSequence
     */
    public
    function values() {
        return new self(iter\rewindable\values($this->value));
    }

    /**
     * @return RewindableSequence
     */
    public
    function flatten() {
        return new self(iter\rewindable\flatten($this->value));
    }

    /**
     * @return RewindableSequence
     */
    public
    function flip() {
        return new self(iter\rewindable\flip($this->value));
    }

    /**
     * @param int $size
     * @return RewindableSequence
     */
    public
    function chunk(int $size) {
        return new self(iter\rewindable\chunk($this->value, $size));
    }

    public
    function rewind() {
        $this->value->rewind();
    }
}