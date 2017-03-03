<?php

namespace api\modules\api\v1\exceptions;

/**
 * Class UserNotFound
 *
 * @package api\modules\api\v1\exceptions
 */
class UserNotFound extends \Exception
{
    /**
     * UserNotFound constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(
        $message = '',
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
