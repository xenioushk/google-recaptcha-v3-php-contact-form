<?php

function getRecaptchaValidationStatus($captcha = "")
{

  $validationStatus = [
    'status' => 0,
    'msg' => 'Invalid captcha! Unable to send message.'
  ];

  if (empty($captcha)) return $validationStatus;

  $ip = $_SERVER['REMOTE_ADDR'];

  $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . GRC_SECRET_KEY . '&response=' . $captcha;
  $response = file_get_contents($url);
  $responseKeys = json_decode($response);

  if (isset($responseKeys->score) && !empty($responseKeys->score) && $responseKeys->score >= 0.5) {
    $validationStatus = [
      'status' => 1,
      'msg' => 'Message sent successfully.'
    ];
  }

  return $validationStatus;
}
