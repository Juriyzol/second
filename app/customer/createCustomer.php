<?php


require_once(__DIR__ . '/vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Customer;


session_start();


function createCustomer() {
	
	

	

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

	
	$theResourceObj = Customer::create([
		"BillAddr" => [
			"Line1" => "123",
			"City" => "Mountain ",
			"Country" => "U2",
			"CountrySubDivisionCode" => "C2",
			"PostalCode" => "222"
		],
		"Notes" => "Here are otherls.22",
		"Title" => "Mr",
		"GivenName" => "James55552",
		"MiddleName" => "B2888",
		"FamilyName" => "Kingss233332",
		"Suffix" => "Jr",
		"FullyQualifiedName" => "King Groceries 2hhhh2",
		"CompanyName" => "King Groceriefffs 5522",
		"DisplayName" => "Kin Displayname22",
		"PrimaryPhone" => [
			"FreeFormNumber" => "(555) 555-555522"
		],
		"PrimaryEmailAddr" => [
			"Address" => "jdrew@my44ddsemaillll.com"
		]
	]);



	var_dump( $_POST );
	


	$resultingObj = $dataService->Add($theResourceObj);
	$error = $dataService->getLastError();
	if ($error) {
		// echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
		// echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
		// echo "The Response message is: " . $error->getResponseBody() . "\n";
	}
	else {
		/// echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
		// $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
		// echo $xmlBody . "\n";
	}
}


// createCustomer();





?>

































