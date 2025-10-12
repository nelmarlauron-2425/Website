<?php
/* config/secrets.php */
declare(strict_types=1);

/**
 * Set to true on your machine to get verbose JSON errors (never enable on prod)
 */
const APP_DEBUG = true;

/**
 * Development MASTER OTP ( => 000000 ) to bypass email during LOCAL testing.
 * Set to false/null to disable.
 */
const DEV_MASTER_OTP = '000000';

// Put your real key here:
const SENDGRID_API_KEY = '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';

// Verified sender in your SendGrid account:
const APP_FROM_EMAIL = 'ardreaiuser@gmail.com';
const APP_FROM_NAME  = 'ArtTrack';
