<?php
/**
 * rapidmail-subscribe plugin for Craft CMS 3.x
 *
 * Subscribe users to a RapidMail mailing list
 *
 * @link      http://www.paulschkade.net
 * @copyright Copyright (c) 2020 Paul Schkade
 */

namespace pausch\rapidmailsubscribe\models;

use pausch\rapidmailsubscribe\Rapidmailsubscribe;

use Craft;
use craft\base\Model;

/**
 * Rapidmailsubscribe Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Paul Schkade
 * @package   Rapidmailsubscribe
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $username = '';
    public $password = '';
    public $recipientlist_id = '';
    public $send_activationmail = false;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'string'],
            ['username', 'default', 'value' => ''],
            ['password', 'string'],
            ['password', 'default', 'value' => ''],
        ];
    }
}
