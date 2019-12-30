<?php

namespace YubarajShrestha\NCHL\Exceptions;

use Exception;
use YubarajShrestha\NCHL\Nchl;

class NchlException extends Exception
{
    public $subject;

    /**
      * Report missing field.
      */
    public static function missingField(Nchl $subject, $field) {
        return (new static("Field `{$field}` is required"))->withSubject($subject);
    }

    /** @return YubarajShrestha\NCHL\Exceptions\NchlException */
    protected function withSubject() : NchlException {
        $this->subject;
        return $this;
    }
}
