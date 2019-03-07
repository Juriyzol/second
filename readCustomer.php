<?php

require_once(__DIR__ . '/vendor/autoload.php');


use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Customer;


session_start();


function readCustomer() {
	
	
	// var_dump( $_POST["id"] );
	

    // Create SDK instance
    $config = include('config.php');
    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => $config['client_id'],
        'ClientSecret' =>  $config['client_secret'],
        'RedirectURI' => $config['oauth_redirect_uri'],
        'scope' => $config['oauth_scope'],
        'baseUrl' => "development"
    ));

    /*
     * Retrieve the accessToken value from session variable
     */
    $accessToken = $_SESSION['sessionAccessToken'];

    /*
     * Update the OAuth2Token of the dataService object
     */
    $dataService->updateOAuth2Token($accessToken);


	
	$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
	$dataService->throwExceptionOnError(true);
	$customer = $dataService->FindbyId('customer', $_POST["id"]);
	$error = $dataService->getLastError();
	if ($error) {
		echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
		echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
		echo "The Response message is: " . $error->getResponseBody() . "\n";
	}
	else {
		echo "Created Id={$customer->Id}. Reconstructed response body:\n\n";
		$xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($customer , $urlResource);
		echo $xmlBody . "\n";
	}
}


readCustomer();





















