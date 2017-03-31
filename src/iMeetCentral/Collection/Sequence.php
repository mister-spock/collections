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
        return new self(iter\map($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function map_keys(callable $fn) {
        return new self(iter\mapKeys($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function reindex(callable $fn) {
        return new self(iter\reindex($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function filter(callable $fn) {
        return new self(iter\filter($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @param null $start_value
     * @return Sequence
     */
    public
    function reductions(callable $fn, $start_value = null) {
        return new self(iter\reductions($fn, $this->value, $start_value));
    }

    /**
     * @param array ...$iterables
     * @return Sequence
     */
    public static
    function zip(...$iterables) {
        return new self(call_user_func_array('iter\zip', $iterables));
    }

    /**
     * @param $keys
     * @param $values
     * @return Sequence
     */
    public static
    function zip_key_value($keys,  $values) {
        return new self(iter\zipKeyValue($keys, $values));
    }

    /**
     * @param array ...$iterables
     * @return Sequence
     */
    public static
    function chain(...$iterables) {
        return new self(call_user_func_array('iter\chain', $iterables));
    }

    /**
     * @param array ...$iterables
     * @return Sequence
     */
    public static
    function product(...$iterables) {
        return new self(call_user_func_array('iter\product', $iterables));
    }

    /**
     * @param int $start
     * @param int $length
     * @return Sequence
     */
    public
    function slice(int $start, int $length = INF) {
        return new self(iter\slice($this->value, $start, $length));
    }

    /**
     * @param int $num
     * @return Sequence
     */
    public
    function take(int $num) {
        return new self(iter\take($num, $this->value));
    }

    /**
     * @param int $num
     * @return Sequence
     */
    public
    function drop(int $num) {
        return new self(iter\drop($num, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function take_while(callable $fn) {
        return new self(iter\takeWhile($fn, $this->value));
    }

    /**
     * @param callable $fn
     * @return Sequence
     */
    public
    function drop_while(callable $fn) {
        return new self(iter\dropWhile($fn, $this->value));
    }

    /**
     * @return Sequence
     */
    public
    function keys() {
        return new self(iter\keys($this->value));
    }

    /**
     * @return Sequence
     */
    public
    function values() {
        return new self(iter\values($this->value));
    }

    /**
     * @return Sequence
     */
    public
    function flatten() {
        return new self(iter\flatten($this->value));
    }

    /**
     * @return Sequence
     */
    public
    function flip() {
        return new self(iter\flip($this->value));
    }

    /**
     * @param int $size
     * @return Sequence
     */
    public
    function chunk(int $size) {
        return new self(iter\chunk($this->value, $size));
    }
}