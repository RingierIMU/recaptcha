<?php

namespace Greggilbert\Recaptcha\Service;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptchaInvisible extends CheckRecaptchaV2
{
    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'captchainvisible';
    }
}
