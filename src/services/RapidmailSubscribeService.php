<?php
/**
 * rapidmail-subscribe plugin for Craft CMS 3.x
 *
 * Subscribe users to a RapidMail mailing list
 *
 * @link      http://www.paulschkade.net
 * @copyright Copyright (c) 2020 Paul Schkade
 */

namespace pausch\rapidmailsubscribe\services;

use pausch\rapidmailsubscribe\models\SubscribeResponse;
use pausch\rapidmailsubscribe\Rapidmailsubscribe;

use Craft;
use craft\base\Component;
use Rapidmail\ApiClient\Client;
use Rapidmail\ApiClient\Exception\ApiClientException;

/**
 * RapidmailSubscribeService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Paul Schkade
 * @package   Rapidmailsubscribe
 * @since     1.0.0
 */
class RapidmailSubscribeService extends Component
{

    // Public Methods
    // =========================================================================

    public function subscribe($params, $opts = null): SubscribeResponse
    {
        $validParams = array_merge(
            // use recipientlist_id from settings as default
            ['recipientlist_id' => Rapidmailsubscribe::$plugin->getSettings()->recipientlist_id],
            // sanitize form params
            $params);

        $validOpts = array_merge(
            // use send_activationmail from settings as default
            ['send_activationmail' => Rapidmailsubscribe::$plugin->getSettings()->send_activationmail ? 'yes' : 'no'],
            // sanitize form params
            $opts);

        // check required settings
        $username = Rapidmailsubscribe::$plugin->getSettings()->username;
        $password = Rapidmailsubscribe::$plugin->getSettings()->password;

        if (!isset($username) || !isset($password)) {
            return new SubscribeResponse([
                'success' => false,
                'errorCode' => '1000',
                'message' => Craft::t('rapidmail-subscribe', 'API username or password not supplied. Check your settings.'),
                'values' => null,
            ]);
        }

        try {
            $client = new Client($username, $password);
            $recipientsService = $client->recipients();

            if (!isset($validParams['recipientlist_id'])) {
                return new SubscribeResponse([
                    'success' => false,
                    'errorCode' => '4000',
                    'message' => Craft::t('rapidmail-subscribe', 'recipientlist_id not provided'),
                    'values' => null,
                ]);
            }
            if (!isset($validParams['email'])) {
                return new SubscribeResponse([
                    'success' => false,
                    'errorCode' => '5000',
                    'message' => Craft::t('rapidmail-subscribe', 'email not provided'),
                    'values' => null,
                ]);
            }

            $recipientsService->create(
                // Dataset: Represents the recipient dataset you're creating
                $validParams,
                // Flags: Configures system behavior, like sending activation mails
                $validOpts
            );

            return new SubscribeResponse([
                'success' => true,
                'errorCode' => 200,
                'message' => Craft::t('rapidmail-subscribe', 'Subscribed successfully'),
                'values' => array_merge(['email' => $validParams['email'], $opts ?? []]),
            ]);
        } catch (ApiClientException $e) {
            if ($e->getCode() === 401) {
                return new SubscribeResponse([
                    'success' => false,
                    'errorCode' => '2000',
                    'message' => Craft::t('rapidmail-subscribe', 'Unauthorized access. Check if username and password are correct'),
                    'values' => null,
                ]);
            }

            if ($e->getCode() === 409) {
                return new SubscribeResponse([
                    'success' => false,
                    'errorCode' => '2000',
                    'message' => Craft::t('rapidmail-subscribe', 'This email is already registered.'),
                    'values' => null,
                ]);
            }

            return new SubscribeResponse([
                'success' => false,
                'errorCode' => '2000',
                'message' => 'An API exception occurred: ' . $e->getMessage(),
                'values' => null,
            ]);
        }
    }
}
