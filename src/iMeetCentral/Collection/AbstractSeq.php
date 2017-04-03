<?php
namespace iMeetCentral\Collection;

use Generator;
use iMeetCentral\Collection\Exception\SeqException;
use InvalidArgumentException;
use iter;
use Iterator;
use Traversable;

/**
 * A wrapper sequence class using generators and nikic\itr
 * for underlying operations. See nikic\itr for method descriptions.
 *
 * @package iMeetCentral
 */
abstract class AbstractSeq implements Iterator {

    /* @var $value Iterator */
    protected $value;

    public
    function __construct($value) {
        if (!($value instanceof Traversable || is_array($value))) {
            throw new InvalidArgumentException('Value provided to collection must be Traversable or an array');
        }
        $this->value = $this->to_generator($value);
    }

    /**
     * @param $iterable
     * @return Generator
     */
    protected
    function to_generator($iterable) {
        return iter\map(function($item) { return $item; }, $iterable);
    }

    /**
     * @param callable $fn
     * @return AbstractSeq
     */
    abstract public
    function map(callable $fn);

    /**
     * @param callable $fn
     * @return AbstractSeq
     */
    abstract public
    function map_keys(callable $fn);

    /**
     * @param callable $fn
     * @return AbstractSeq
     */
    abstract public
    function reindex(callable $fn);

    /**
     * @param callable $fn
     * @return AbstractSeq
     */
    abstract public
    function filter(callable $fn);

    /**
     * @param callable $fn
     * @param null $start_value
     * @return AbstractSeq
     */
    abstract public
    function reductions(callable $fn, $start_value = null);

    /**
     * @param int $start
     * @param int $length
     * @return AbstractSeq
     */
    abstract public
    function slice(int $start, int $length = INF);


    /**
     * @param int $num
     * @return AbstractSeq
     */
    abstract public
    function take(int $num);

    /**
     * @param int $num
     * @return AbstractSeq
     */
    abstract public
    function drop(int $num);

    /**
     * @param callable $fn
     * @return AbstractSeq
     */
    abstract public
    function take_while(callable $fn);

    /**
     * @param callable $fn
     * @return AbstractSeq
     */
    abstract public
    function drop_while(callable $fn);

    /**
     * @return AbstractSeq
     */
    abstract public
    function keys();

    /**
     * @return AbstractSeq
     */
    abstract public
    function values();

    /**
     * @return AbstractSeq
     */
    abstract public
    function flatten();

    /**
     * @return AbstractSeq
     */
    abstract public
    function flip();

    /**
     * @param int $size
     * @return AbstractSeq
     */
    abstract public
    function chunk(int $size);

    /**
     * @param callable $fn
     * @param null $start_value
     * @return mixed
     */
    public
    function reduce(callable $fn, $start_value = null) {
        return iter\reduce($fn, $this->value, $start_value);
    }

    /**
     * @param callable $fn
     * @return bool
     */
    public
    function any(callable $fn) {
        return iter\any($fn, $this->value);
    }

    /**
     * @param callable $fn
     * @return bool
     */
    public
    function all(callable $fn) {
        return iter\all($fn, $this->value);
    }

    /**
     * @param callable $fn
     * @return mixed|null
     */
    public
    function search(callable $fn) {
        return iter\search($fn, $this->value);
    }

    /**
     * @param callable $fn
     */
    public
    function apply(callable $fn) {
        iter\apply($fn, $this->value);
    }

    /**
     * @param string $separator
     * @return string
     */
    public
    function join(string $separator) {
        return iter\join($separator, $this->value);
    }

    /**
     * @return int
     */
    public
    function count() {
        return iter\count($this->value);
    }

    /**
     * @param callable $fn
     * @return mixed
     */
    public
    function recurse(callable $fn) {
        return iter\recurse($fn, $this->value);
    }

    /**
     * @return array
     */
    public
    function to_array() {
        return iter\toArray($this->value);
    }

    /**
     * @return array
     */
    public
    function to_array_with_keys() {
        return iter\toArrayWithKeys($this->value);
    }

    /**
     * @return bool
     */
    public
    function is_iterable() {
        return iter\isIterable($this->value);
    }

    /**
     * @param $fn
     * @return AbstractSeq
     */
    public
    function flat_map($fn) {
        return $this->map($fn)->flatten();
    }

    /** Iterator Methods **/
    public
    function current() {
        return $this->value->current();
    }

    public
    function next() {
        $this->value->next();
    }

    public
    function key() {
        return $this->value->key();
    }

    public
    function valid() {
        return $this->value->valid();
    }

    public
    function rewind() {
        throw new SeqException('Cannot rewind a NonRewindableSeq. Use Seq
            if you require that functionality.');
    }
    /** /Iterator Methods **/
}