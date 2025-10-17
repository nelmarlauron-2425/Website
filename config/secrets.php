<?php
declare(strict_types=1);

// Debug mode (set to false in production)
const APP_DEBUG = true;

// 🧩 IMPORTANT: Replace with your actual SendGrid API key
const SENDGRID_API_KEY = 'SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

// 🧩 Use a verified sender from your SendGrid account
//    (Go to SendGrid → Settings → Sender Authentication → Single Sender)
const APP_FROM_EMAIL = 'youremail@gmail.com';  // <-- must be verified in SendGrid
const APP_FROM_NAME  = 'ArtTrack Support';
