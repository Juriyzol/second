<?php


require_once(__DIR__ . '/vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Customer;


session_start();


function createCustomer() {
	
	
	// var_dump( $_POST['Line1'] );
	
	

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
			"Line1" => $_POST['Line1'],
			"City" => $_POST['City'],
			"Country" => $_POST['Country'],
			"CountrySubDivisionCode" => $_POST['CountrySubDivisionCode'],
			"PostalCode" => $_POST['PostalCode']
		],
		"Notes" => $_POST['Notes'],
		"Title" => $_POST['Title'],
		"GivenName" => $_POST['GivenName'],
		"MiddleName" => $_POST['MiddleName'],
		"FamilyName" => $_POST['FamilyName'],
		"Suffix" => $_POST['Suffix'],
		"FullyQualifiedName" => $_POST['FullyQualifiedName'],
		"CompanyName" => $_POST['CompanyName'],
		"DisplayName" => $_POST['DisplayName'],
		"PrimaryPhone" => [
			"FreeFormNumber" => "(555) 555-555522"
		],
		"PrimaryEmailAddr" => [
			"Address" => "jdrew@my44ddsemaillll.com"
		]
	]);


	$resultingObj = $dataService->Add($theResourceObj);
	$error = $dataService->getLastError();
	if ($error) {
		echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
		echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
		echo "The Response message is: " . $error->getResponseBody() . "\n";
	}
	else {
		echo "Created Id={$resultingObj->Id}. Reconstructed response body:\n\n";
		$xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($resultingObj, $urlResource);
		echo $xmlBody . "\n";
	}
}


createCustomer();







/*

require_once(__DIR__ . '/vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;

session_start();

function makeAPICall()
{

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
     *
    $accessToken = $_SESSION['sessionAccessToken'];

    /*
     * Update the OAuth2Token of the dataService object
     *
    $dataService->updateOAuth2Token($accessToken);
	
	
    $companyInfo = $dataService->getCompanyInfo();
    $address = "QBO API call Successful!! Response Company name: " . $companyInfo->CompanyName . " Company Address: " . $companyInfo->CompanyAddr->Line1 . " " . $companyInfo->CompanyAddr->City . " " . $companyInfo->CompanyAddr->PostalCode;
    print_r($address);
    return $companyInfo;
}

$result = makeAPICall();

*/








?>

































