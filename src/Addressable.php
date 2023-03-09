<?php

namespace ZEM\Shrinkwrap;

/**
 * To be applied to Eloquent models that need to be "addressable", meaning their
 * serialized form will be moved to a dictionary and replaced with a string when
 * using the facility ("serializer") provided by this package.
 */
trait Addressable
{

    public function toArray (): mixed
    {
        if (!Facility::$active) return parent::toArray();

        if ($this === Facility::$root) return parent::toArray();

        $address = $this->getAddress();

        if (!isset(Facility::$dict[$address])) {
            Facility::$dict[$address] = parent::toArray();
        }

        return $address;
    }

    /**
     * Generate a string digest based on the appends, hidden fields and
     * currently loaded relations (keys of) of the model.
     * @return string
     */
    protected function getConfigHash (): string
    {
        $appends   = $this->getAppends();
        $hidden    = $this->getHidden();
        $relations = array_keys($this->getArrayableRelations());
        return sha1(serialize(compact('appends', 'hidden', 'relations')));
    }

    public function getAddress (): string
    {
        return Address::create(get_class($this), $this->getKey(), $this->getConfigHash());
    }
}
