<?php

namespace pausch\rapidmailsubscribe\models;

use craft\base\Model;

class SubscribeResponse extends Model
{
    public $action = 'subscribe';
    public $success = '';
    public $errorCode = '';
    public $message = '';
    public $values = null;
    public $response = null;
}
