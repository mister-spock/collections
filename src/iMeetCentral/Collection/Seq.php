<?php
namespace iMeetCentral\Collection;

use Generator;
use iter, iter\rewindable;

/**
 * Rewindable implementation of AbstractSeq.
 * This can be reiterated over unlike the standard Seq.
 *
 * @package iMeetCentral
 */
class Seq extends AbstractSeq {

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
     * @return Seq
     */
    public
    function map(callable $fn) {
        return new static(iter\rewindable\map($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Seq
     */
    public
    function map_keys(callable $fn) {
        return new static(iter\rewindable\mapKeys($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Seq
     */
    public
    function reindex(callable $fn) {
        return new static(iter\rewindable\reindex($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Seq
     */
    public
    function filter(callable $fn) {
        return new static(iter\rewindable\filter($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @param null $start_value
     * @return Seq
     */
    public
    function reductions(callable $fn, $start_value = null) {
        return new static(iter\rewindable\reductions($fn, $this->value, $start_value));
    }

    /**
     * @param array ...$iterables
     * @return Seq
     */
    public static
    function zip(...$iterables) {
        return new static(call_user_func_array('iter\rewindable\zip', $iterables));
    }

    /**
     * @param $keys
     * @param $values
     * @return Seq
     */
    public static
    function zip_key_value($keys,  $values) {
        return new static(iter\rewindable\zipKeyValue($keys, $values));
    }

    /**
     * @param array ...$iterables
     * @return Seq
     */
    public static
    function chain(...$iterables) {
        return new static(call_user_func_array('iter\rewindable\chain', $iterables));
    }

    /**
     * @param array ...$iterables
     * @return Seq
     */
    public static
    function product(...$iterables) {
        return new static(call_user_func_array('iter\rewindable\product', $iterables));
    }

    /**
     * @param int $start
     * @param int $length
     * @return Seq
     */
    public
    function slice(int $start, int $length = INF) {
        return new static(iter\rewindable\slice($this->value, $start, $length));
    }

    /**
     * @param int $num
     * @return Seq
     */
    public
    function take(int $num) {
        return new static(iter\rewindable\take($num, $this->value));
    }

    /**
     * @param int $num
     * @return Seq
     */
    public
    function drop(int $num) {
        return new static(iter\rewindable\drop($num, $this->value));
    }

    /**
     * @param callable $fn
     * @return Seq
     */
    public
    function take_while(callable $fn) {
        return new static(iter\rewindable\takeWhile($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Seq
     */
    public
    function drop_while(callable $fn) {
        return new static(iter\rewindable\dropWhile($fn, $this->value));
    }

    /**
     * @return Seq
     */
    public
    function keys() {
        return new static(iter\rewindable\keys($this->value));
    }

    /**
     * @return Seq
     */
    public
    function values() {
        return new static(iter\rewindable\values($this->value));
    }

    /**
     * @return Seq
     */
    public
    function flatten() {
        return new static(iter\rewindable\flatten($this->value));
    }

    /**
     * @return Seq
     */
    public
    function flip() {
        return new static(iter\rewindable\flip($this->value));
    }

    /**
     * @param int $size
     * @return Seq
     */
    public
    function chunk(int $size) {
        return new static(iter\rewindable\chunk($this->value, $size));
    }

    public
    function rewind() {
        $this->value->rewind();
    }
}