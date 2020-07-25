# rapidmail-subscribe plugin for Craft CMS 3.x

Subscribe users to a RapidMail mailing list

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require dyrden/craft-rapidmail-subscribe

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for rapidmail-subscribe.

## rapidmail-subscribe Overview

Rapidmail Subscribe let's you subscribe members to Rapidmail recipient lists. Currently no other features of the Rapidmail API are supported.

## Configuring rapidmail-subscribe

This plugin comes with a settings page. You need to enter an API username and password which you can setup in the [Rapidmail API settings](https://my.rapidmail.de/api/v3/userlist.html).

## Subscribing a member to an audience

In it's simplest form, you can subscribe a user with a simple form with just an email input field:

```
<form class="newsletter-form" action="" method="post">
    {{ csrfInput() }}
    <input type="hidden" name="action" value="rapidmail-subscribe/recipients/subscribe">
    
    <div>
        <label for="emailInput">
            Email:
        </label>
        <input id="emailInput" type="text" name="email" />
    </div>

    <input type="submit" name="" value="Subscribe"/>
</form>
```

You can add all other fields supported by the [Rapidmail API](https://developer.rapidmail.wiki/documentation.html?urls.primaryName=Recipients#/Recipients/post_recipients)

Brought to you by [Paul Schkade](http://www.paulschkade.net)
