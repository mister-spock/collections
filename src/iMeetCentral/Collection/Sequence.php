<?php
namespace iMeetCentral\Collection;

use iter;

/**
 * Default implementation of AbstractSequence.
 * Can only be iterated over once since the underlying implementation uses generators.
 *
 * @package iMeetCentral
 */
class Sequence extends AbstractSequence {

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function map(callable $fn) {
        return new static(iter\map($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function map_keys(callable $fn) {
        return new static(iter\mapKeys($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function reindex(callable $fn) {
        return new static(iter\reindex($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function filter(callable $fn) {
        return new static(iter\filter($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @param null $start_value
     * @return Sequence
     */
    public
    function reductions(callable $fn, $start_value = null) {
        return new static(iter\reductions($fn, $this->value, $start_value));
    }

    /**
     * @param array ...$iterables
     * @return Sequence
     */
    public static
    function zip(...$iterables) {
        return new static(call_user_func_array('iter\zip', $iterables));
    }

    /**
     * @param $keys
     * @param $values
     * @return Sequence
     */
    public static
    function zip_key_value($keys,  $values) {
        return new static(iter\zipKeyValue($keys, $values));
    }

    /**
     * @param array ...$iterables
     * @return Sequence
     */
    public static
    function chain(...$iterables) {
        return new static(call_user_func_array('iter\chain', $iterables));
    }

    /**
     * @param array ...$iterables
     * @return Sequence
     */
    public static
    function product(...$iterables) {
        return new static(call_user_func_array('iter\product', $iterables));
    }

    /**
     * @param int $start
     * @param int $length
     * @return Sequence
     */
    public
    function slice(int $start, int $length = INF) {
        return new static(iter\slice($this->value, $start, $length));
    }

    /**
     * @param int $num
     * @return Sequence
     */
    public
    function take(int $num) {
        return new static(iter\take($num, $this->value));
    }

    /**
     * @param int $num
     * @return Sequence
     */
    public
    function drop(int $num) {
        return new static(iter\drop($num, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function take_while(callable $fn) {
        return new static(iter\takeWhile($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function drop_while(callable $fn) {
        return new static(iter\dropWhile($fn, $this->value));
    }

    /**
     * @return Sequence
     */
    public
    function keys() {
        return new static(iter\keys($this->value));
    }

    /**
     * @return Sequence
     */
    public
    function values() {
        return new static(iter\values($this->value));
    }

    /**
     * @return Sequence
     */
    public
    function flatten() {
        return new static(iter\flatten($this->value));
    }

    /**
     * @return Sequence
     */
    public
    function flip() {
        return new static(iter\flip($this->value));
    }

    /**
     * @param int $size
     * @return Sequence
     */
    public
    function chunk(int $size) {
        return new static(iter\chunk($this->value, $size));
    }
}