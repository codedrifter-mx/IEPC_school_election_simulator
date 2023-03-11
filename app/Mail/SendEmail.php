<?php

namespace App\Mail;

class SendEmail
{

    /**
     * @param mixed $subject
     */
    public function __construct(mixed $subject)
    {
        $this->subject = $subject;
    }
}
