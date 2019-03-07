<?php

require_once(__DIR__ . '/vendor/autoload.php');
use QuickBooksOnline\API\DataService\DataService;


use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Customer;

use QuickBooksOnline\API\Facades\Account;



$config = include('config.php');



session_start();

$dataService = DataService::Configure(array(
    'auth_mode' => 'oauth2',
    'ClientID' => $config['client_id'],
    'ClientSecret' =>  $config['client_secret'],
    'RedirectURI' => $config['oauth_redirect_uri'],
    'scope' => $config['oauth_scope'],
    'baseUrl' => "development"
));

$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
$authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();


// Store the url in PHP Session Object;
$_SESSION['authUrl'] = $authUrl;

//set the access token using the auth object
if (isset($_SESSION['sessionAccessToken'])) {

    $accessToken = $_SESSION['sessionAccessToken'];
    $accessTokenJson = array('token_type' => 'bearer',
        'access_token' => $accessToken->getAccessToken(),
        'refresh_token' => $accessToken->getRefreshToken(),
        'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
        'expires_in' => $accessToken->getAccessTokenExpiresAt()
    );
    $dataService->updateOAuth2Token($accessToken);
    $oauthLoginHelper = $dataService -> getOAuth2LoginHelper();
    $CompanyInfo = $dataService->getCompanyInfo();
}




echo '<br/><br/><br/>';


/*

echo '<br/><br/><br/>';



$theResourceObj = Account::create([
  "AccountType" => "Accounts Receivable",
  "Name" => "third Account test"
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



echo '<br/><br/><br/>';

$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
$dataService->throwExceptionOnError(true);
$account = $dataService->FindbyId('account', 156);
$error = $dataService->getLastError();
if ($error) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
}
else {
    echo "Created Id={$account->Id}. Reconstructed response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($account, $urlResource);
    echo $xmlBody . "\n";
}
*/




?>






<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon icon shortcut" type="image/png" href="https://plugin.intuitcdn.net/sbg-web-shell-ui/6.3.0/shell/harmony/images/QBOlogo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="views/common.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script>

        var url = '<?php echo $authUrl; ?>';

        var OAuthCode = function(url) {

            this.loginPopup = function (parameter) {
                this.loginPopupUri(parameter);
            }

            this.loginPopupUri = function (parameter) {

                // Launch Popup
                var parameters = "location=1,width=800,height=650";
                parameters += ",left=" + (screen.width - 800) / 2 + ",top=" + (screen.height - 650) / 2;

                var win = window.open(url, 'connectPopup', parameters);
                var pollOAuth = window.setInterval(function () {
                    try {

                        if (win.document.URL.indexOf("code") != -1) {
                            window.clearInterval(pollOAuth);
                            win.close();
                            location.reload();
                        }
                    } catch (e) {
                        console.log(e)
                    }
                }, 100);
            }
        }


        var apiCall = function() {
            this.getCompanyInfo = function() {
                /*
                AJAX Request to retrieve getCompanyInfo
                 */
                $.ajax({
                    type: "GET",
                    url: "apiCall.php",
                }).done(function( msg ) {
                    $( '#apiCall' ).html( msg );
                });
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }        
		
		
		var createCustomerCall = function() {			
			
            this.createCustomer = function( inputs ) {

				// console.log( inputs[0].value ); 
				
                /*
                AJAX Request to retrieve getCompanyInfo
				*/				
				$.post(
					"createCustomer.php",
					{
						"Line1": inputs[0].value,
						"City": inputs[1].value,
						"Country": inputs[2].value,
						"CountrySubDivisionCode": inputs[3].value,
						"PostalCode": inputs[4].value,						
						"Notes": inputs[5].value,					
						"Title": inputs[6].value,					
						"GivenName": inputs[7].value,					
						"MiddleName": inputs[8].value,					
						"FamilyName": inputs[9].value,					
						"Suffix": inputs[10].value,					
						"FullyQualifiedName": inputs[11].value,					
						"CompanyName": inputs[12].value,					
						"DisplayName": inputs[13].value,					
					},				
				function(msg) {
					$( '#createCustomer' ).html( msg );
				});								
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }


		var readCustomerCall = function() {			
			
            this.readCustomer = function( id ) {
				
                /*
                AJAX Request to retrieve getCompanyInfo
				*/
				$.post(
					"readCustomer.php",
					{
						"id": id,				
					},				
				function(msg) {
					$( '#customerRead' ).html( msg );
				});	
				
            }

            this.refreshToken = function() {
                $.ajax({
                    type: "POST",
                    url: "refreshToken.php",
                }).done(function( msg ) {

                });
            }
        }


        var oauth = new OAuthCode(url);
        var apiCall = new apiCall();
        var createCustomerCall = new createCustomerCall();
        var readCustomerCall = new readCustomerCall();
		
		
		/**
		 * Обработчики событий
		 **/
		$( document ).ready(function() {
			
			document.getElementById("customerCreateForm").addEventListener("submit", function(event){
				
				event.preventDefault();					
				var inputs = this.elements;

				createCustomerCall.createCustomer( inputs );
			});			
			
			
			document.getElementById("customerReadForm").addEventListener("submit", function(event){
				
				event.preventDefault();					
				var input = this.elements[0];
				
				// console.log(input.value);
				
				readCustomerCall.readCustomer( input.value );
			});
			
		});		
    </script>
</head>
<body>

<div class="container">

    <h1>
        <a href="http://developer.intuit.com">
            <img src="views/quickbooks_logo_horz.png" id="headerLogo">
        </a>

    </h1>

    <hr>

    <div class="well text-center">

       
        <h2>Connect to QuickBooks flow and API Request</h2>

        <br>

    </div>

    <p>If there is no access token or the access token is invalid, click the <b>Connect to QuickBooks</b> button below.</p>
    <pre id="accessToken">
        <style="background-color:#efefef;overflow-x:scroll"><?php
    $displayString = isset($accessTokenJson) ? $accessTokenJson : "No Access Token Generated Yet";
    echo json_encode($displayString, JSON_PRETTY_PRINT); ?>
    </pre>
    <a class="imgLink" href="#" onclick="oauth.loginPopup()"><img src="views/C2QB_green_btn_lg_default.png" width="178" /></a>
    <hr />


    <h2>Make an API call</h2>
    <p>If there is no access token or the access token is invalid, click either the <b>Connect to QucikBooks</b> button above.</p>
    <pre id="apiCall"></pre>
    <button  type="button" class="btn btn-success" onclick="apiCall.getCompanyInfo()">Get Company Info</button>    
	
	<hr />	
	
	
	<br/><br/>
	<br/><br/>
	<h2>Make customer</h2>

	<!-- <form name="test" id="customerCreateForm" onsubmit="createCustomerCall.createCustomer(e)"> -->
	<form name="customerCreateForm" id="customerCreateForm">
		<p>
			<b>BillAddr:</b><br>
			
			<input type="text" name="Linel" placeholder="Linel" size="40">
			<input type="text" name="City" placeholder="City" size="40">
			<input type="text" name="Country" placeholder="Country" size="40">
			<input type="text" name="CountrySubDivisionCode" placeholder="CountrySubDivisionCode" size="40">
			<input type="text" name="PostalCode" placeholder="PostalCode" size="40">
		</p>
		<p>
			<b>Customer data:</b><Br>
			<input type="text" name="Notes" placeholder="Notes" size="40">
			<input type="text" name="Title" placeholder="Title" size="40">
			<input type="text" name="GivenName" placeholder="GivenName" size="40">
			<input type="text" name="MiddleName" placeholder="MiddleName" size="40">
			<input type="text" name="FamilyName" placeholder="FamilyName" size="40">			
			<input type="text" name="Suffix" placeholder="Suffix" size="40">
			<input type="text" name="FullyQualifiedName" placeholder="FullyQualifiedName" size="40">
			<input type="text" name="CompanyName" placeholder="CompanyName" size="40">
			<input type="text" name="DisplayName" placeholder="DisplayName" size="40">
		</p>
		<p>
			<input type="submit" value="Send">
			<input type="reset" value="Clear">
		</p>
	</form>

	<pre id="createCustomer"></pre>
	
    <hr />



	<br/><br/>
	<h2>See customer by ID</h2>

	<!-- <form name="test" id="customerCreateForm" onsubmit="createCustomerCall.createCustomer(e)"> -->
	<form name="customerReadForm" id="customerReadForm">
		<p>
			<b>Set customer ID:</b><br>
			
			<input type="number" name="customerID" placeholder="set customer ID" size="40">
		</p>
		<p>
			<input type="submit" value="Get customer">
			<input type="reset" value="Clear">
		</p>
	</form>

	<pre id="customerRead"></pre>
	
    <hr />







	<br/><br/>
	<br/><br/>	<br/><br/>
	<br/><br/>	<br/><br/>
	<br/><br/>	<br/><br/>
	<br/><br/>
</div>
</body>
</html>





























