<?php

namespace Laminas\Session\Storage;

use ArrayIterator;
use Laminas\Session\Exception;
use Laminas\Stdlib\ArrayObject;
use ReturnTypeWillChange;

use function array_flip;
use function array_key_exists;
use function array_keys;
use function array_replace_recursive;
use function is_array;
use function microtime;
use function sprintf;

/**
 * Array session storage
 *
 * Defines an ArrayObject interface for accessing session storage, with options
 * for setting metadata, locking, and marking as isImmutable.
 *
 * @see ReturnTypeWillChange
 *
 * @template TKey of array-key
 * @template TValue
 * @template-extends ArrayObject<TKey, TValue>
 * @template-implements StorageInterface<TKey, TValue>
 */
class ArrayStorage extends ArrayObject implements StorageInterface
{
    /**
     * Is storage marked isImmutable?
     *
     * @var bool
     */
    protected $isImmutable = false;

    /**
     * Constructor
     *
     * Instantiates storage as an ArrayObject, allowing property access.
     * Also sets the initial request access time.
     *
     * @param array  $input
     * @param int    $flags
     * @param string $iteratorClass
     */
    public function __construct(
        $input = [],
        $flags = ArrayObject::ARRAY_AS_PROPS,
        $iteratorClass = ArrayIterator::class
    ) {
        parent::__construct($input, $flags, $iteratorClass);
        $this->setRequestAccessTime(microtime(true));
    }

    /**
     * Set the request access time
     *
     * @param  float        $time
     * @return $this
     */
    protected function setRequestAccessTime($time)
    {
        $this->setMetadata('_REQUEST_ACCESS_TIME', $time);

        return $this;
    }

    /**
     * Retrieve the request access time
     *
     * @return float
     */
    public function getRequestAccessTime()
    {
        return $this->getMetadata('_REQUEST_ACCESS_TIME');
    }

    /**
     * Set a value in the storage object
     *
     * If the object is marked as isImmutable, or the object or key is marked as
     * locked, raises an exception.
     *
     * @param array-key $offset
     * @param mixed $value
     * @return void
     * @throws Exception\RuntimeException
     */
    #[ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if ($this->isImmutable()) {
            throw new Exception\RuntimeException(
                sprintf('Cannot set key "%s" as storage is marked isImmutable', $offset)
            );
        }
        if ($this->isLocked($offset)) {
            throw new Exception\RuntimeException(
                sprintf('Cannot set key "%s" due to locking', $offset)
            );
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * Lock this storage instance, or a key within it
     *
     * @param  null|int|string $key
     * @return $this
     */
    public function lock($key = null)
    {
        if (null === $key) {
            $this->setMetadata('_READONLY', true);

            return $this;
        }
        if (isset($this[$key])) {
            $this->setMetadata('_LOCKS', [$key => true]);
        }

        return $this;
    }

    /**
     * Is the object or key marked as locked?
     *
     * @param  null|int|string $key
     * @return bool
     */
    public function isLocked($key = null)
    {
        if ($this->isImmutable()) {
            // isImmutable trumps all
            return true;
        }

        if (null === $key) {
            // testing for global lock
            return $this->getMetadata('_READONLY');
        }

        $locks    = $this->getMetadata('_LOCKS');
        $readOnly = $this->getMetadata('_READONLY');

        if ($readOnly && ! $locks) {
            // global lock in play; all keys are locked
            return true;
        } elseif ($readOnly && $locks) {
            return array_key_exists($key, $locks);
        }

        // test for individual locks
        if (! $locks) {
            return false;
        }

        return array_key_exists($key, $locks);
    }

    /**
     * Unlock an object or key marked as locked
     *
     * @param  null|int|string $key
     * @return $this
     */
    public function unlock($key = null)
    {
        if (null === $key) {
            // Unlock everything
            $this->setMetadata('_READONLY', false);
            $this->setMetadata('_LOCKS', false);

            return $this;
        }

        $locks = $this->getMetadata('_LOCKS');
        if (! $locks) {
            if (! $this->getMetadata('_READONLY')) {
                return $this;
            }
            $array = $this->toArray();
            $keys  = array_keys($array);
            $locks = array_flip($keys);
            unset($array, $keys);
        }

        if (array_key_exists($key, $locks)) {
            unset($locks[$key]);
            $this->setMetadata('_LOCKS', $locks, true);
        }

        return $this;
    }

    /**
     * Mark the storage container as isImmutable
     *
     * @return $this
     */
    public function markImmutable()
    {
        $this->isImmutable = true;

        return $this;
    }

    /**
     * Is the storage container marked as isImmutable?
     *
     * @return bool
     */
    public function isImmutable()
    {
        return $this->isImmutable;
    }

    /**
     * Set storage metadata
     *
     * Metadata is used to store information about the data being stored in the
     * object. Some example use cases include:
     * - Setting expiry data
     * - Maintaining access counts
     * - localizing session storage
     * - etc.
     *
     * @param  string                     $key
     * @param  mixed                      $value
     * @param  bool                       $overwriteArray Whether to overwrite or merge array values; by default, merges
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function setMetadata($key, $value, $overwriteArray = false)
    {
        if ($this->isImmutable) {
            throw new Exception\RuntimeException(
                sprintf('Cannot set key "%s" as storage is marked isImmutable', $key)
            );
        }

        if (! isset($this['__Laminas'])) {
            $this['__Laminas'] = [];
        }

        if (isset($this['__Laminas'][$key]) && is_array($value)) {
            if ($overwriteArray) {
                $this['__Laminas'][$key] = $value;
            } else {
                $this['__Laminas'][$key] = array_replace_recursive($this['__Laminas'][$key], $value);
            }
        } else {
            if ((null === $value) && isset($this['__Laminas'][$key])) {
                // unset($this['__Laminas'][$key]) led to "indirect modification...
                // has no effect" errors, so explicitly pulling array and
                // unsetting key.
                $array = $this['__Laminas'];
                unset($array[$key]);
                $this['__Laminas'] = $array;
                unset($array);
            } elseif (null !== $value) {
                $this['__Laminas'][$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Retrieve metadata for the storage object or a specific metadata key
     *
     * Returns false if no metadata stored, or no metadata exists for the given
     * key.
     *
     * @param  null|int|string $key
     * @return mixed
     */
    public function getMetadata($key = null)
    {
        if (! isset($this['__Laminas'])) {
            return false;
        }

        if (null === $key) {
            return $this['__Laminas'];
        }

        if (! array_key_exists($key, $this['__Laminas'])) {
            return false;
        }

        return $this['__Laminas'][$key];
    }

    /**
     * Clear the storage object or a subkey of the object
     *
     * @param  null|int|string            $key
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function clear($key = null)
    {
        if ($this->isImmutable()) {
            throw new Exception\RuntimeException('Cannot clear storage as it is marked immutable');
        }
        if (null === $key) {
            $this->fromArray([]);

            return $this;
        }

        if (! isset($this[$key])) {
            return $this;
        }

        // Clear key data
        unset($this[$key]);

        // Clear key metadata
        $this->setMetadata($key, null)
             ->unlock($key);

        return $this;
    }

    /**
     * Load the storage from another array
     *
     * Overwrites any data that was previously set.
     *
     * @return $this
     */
    public function fromArray(array $array)
    {
        $ts = $this->getRequestAccessTime();
        $this->exchangeArray($array);
        $this->setRequestAccessTime($ts);

        return $this;
    }

    /**
     * Cast the object to an array
     *
     * @param  bool $metaData Whether to include metadata
     * @return array<TKey, TValue>
     */
    public function toArray($metaData = false)
    {
        $values = $this->getArrayCopy();
        if ($metaData) {
            return $values;
        }
        if (isset($values['__Laminas'])) {
            unset($values['__Laminas']);
        }

        return $values;
    }
}
