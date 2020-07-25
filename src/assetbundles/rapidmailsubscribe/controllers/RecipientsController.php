<?php
/**
 * RapidMail Subscribe plugin for Craft CMS 3.x
 *
 * @copyright Copyright (c) 2020 Paul Schkade
 */

namespace pausch\rapidmailsubscribe\controllers;

use Craft;
use craft\web\Controller;
use craft\errors\DeprecationException;

use pausch\rapidmailsubscribe\Rapidmailsubscribe as Plugin;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class RecipientsController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = true;

    // Public Methods
    // =========================================================================

    private $validParamKeys = [
        "email" => '',
        "recipientlist_id" => '',
        "firstname" => '',
        "lastname" => '',
        "gender" => '',
        "title" => '',
        "zip" => '',
        "birthdate" => '',
        "foreign_id" => '',
        "mailtype" => '',
        "extra1" => '',
        "extra2" => '',
        "extra3" => '',
        "extra4" => '',
        "extra5" => '',
        "extra6" => '',
        "extra7" => '',
        "extra8" => '',
        "extra9" => '',
        "extra10" => '',
        "extrabig1" => '',
        "extrabig2" => '',
        "extrabig3" => '',
        "extrabig4" => '',
        "extrabig5" => '',
        "extrabig6" => '',
        "extrabig7" => '',
        "extrabig8" => '',
        "extrabig9" => '',
        "extrabig10" => '',
        "created_ip" => '',
        "created_host" => '',
        "activated" => ''
    ];


    private $validOptKeys = [
        "track_stats" => '',
        "send_activationmail" => '',
        "test_mode" => '',
        "get_extra_big_fields" => '',
    ];

    /**
     * Controller action for subscribing an email to a list
     *
     * @return null|Response
     * @throws BadRequestHttpException
     * @throws DeprecationException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSubscribe()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        // get post variables
        $redirect = $request->getParam('redirect', '');

        $params = array_intersect_key($request->getBodyParams(), $this->validParamKeys);
        $opts = array_intersect_key($request->getBodyParams(), $this->validOptKeys);

        // call service method
        $result = Plugin::$plugin->rapidmailSubscribeService->subscribe($params, $opts);

        // if this was an ajax request, return json
        if ($request->getAcceptsJson()) {
            return $this->asJson($result);
        }

        // if a redirect variable was passed, do redirect
        if ($redirect !== '' && $result['success']) {
            return $this->redirectToPostedUrl();
        }

        // set route variables and return
        Craft::$app->getUrlManager()->setRouteParams([
            'variables' => ['rapidmailSubscribe' => $result]
        ]);

        return null;
    }

}
