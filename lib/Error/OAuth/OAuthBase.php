<?php

namespace Stripe_Legacy\Error\OAuth;

class OAuthBase extends \Stripe_Legacy\Error\Base
{
    public function __construct(
        $code,
        $description,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null
    ) {
        parent::__construct($description, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->code = $code;
    }

    public function getErrorCode()
    {
        return $this->code;
    }
}
