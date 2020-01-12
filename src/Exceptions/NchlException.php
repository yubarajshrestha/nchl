<?php

namespace YubarajShrestha\NCHL\Exceptions;

use Exception;
use YubarajShrestha\NCHL\Nchl;

class NchlException extends Exception
{
    /**
     * @var Nchl
     */
    public $subject;

    /**
     * @param $field
     *
     * @return NchlException
     */
    public static function missingField(Nchl $subject, $field)
    {
        return (new static("Field `{$field}` is required"))->withSubject($subject);
    }

    /**
     * @param $field
     *
     * @return NchlException
     */
    public static function certificateError(Nchl $subject, $field)
    {
        return (new static($field))->withSubject($subject);
    }

    /**
     * @param $field
     *
     * @return NchlException
     */
    public static function propertyMissing(Nchl $subject, $field)
    {
        return (new static($field))->withSubject($subject);
    }

    public static function clientError($subject, $field)
    {
        return (new static($field))->withSubject($subject);
    }

    /**
     * @return NchlException
     */
    protected function withSubject(): self
    {
        $this->subject;

        return $this;
    }
}
