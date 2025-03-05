<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cookie = $_POST["cookie"];
  
  // Extract and modify age data in cookie
  $modifiedCookie = modifyCookieAge($cookie);
  
  // Submit modified cookie to Roblox to update account 
  $response = submitToRoblox($modifiedCookie);
  
  if ($response == "success") {
    echo "Age bypass complete. Your account is now under 13.";
  } else {
    echo "Error updating account. Please try again.";
  }
}

function modifyCookieAge($cookie) {
  // Decode the cookie from JSON format
  $cookieData = json_decode($cookie, true);
  
  // Modify the age in the cookie data
  $cookieData['age'] = 12;
  
  // Re-encode the modified cookie data as JSON
  $modifiedCookie = json_encode($cookieData);
  
  return $modifiedCookie;
}

function submitToRoblox($cookie) {
  // Roblox API endpoint to update account
  $url = "https://api.roblox.com/universes/update-account";
  
  // Initiate cURL session
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $cookie);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  
  // Execute cURL session and get response
  $response = curl_exec($ch);
  
  // Close cURL session
  curl_close($ch);
  
  return $response;
}
?>