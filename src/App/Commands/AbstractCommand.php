<?php

namespace Console\App\Commands;

use Google_Exception;
use Symfony\Component\Console\Command\Command;
use Google_Client;
use Google_Service_Analytics;

abstract class AbstractCommand extends Command
{

    /**
     * @return Google_Service_Analytics
     * @throws Google_Exception
     */
    protected function initializeAnalytics()
    {
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.
        $KEY_FILE_LOCATION = __DIR__ . '/../../../service-account-credentials.json';

        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName("GA Setupper (GAS)");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.edit']);
        return new Google_Service_Analytics($client);
    }

}
