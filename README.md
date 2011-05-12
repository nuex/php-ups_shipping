# ups_shipping

PHP Implementation of the UPS Shipping XML API

## USAGE

    require_once('ups_shipping.php');
  
    $opts = array(
      'ups_access_license_number' => UPS_ACCESS_LICENSE_NUMBER,
      'ups_userid' => UPS_USER_ID,
      'ups_password' => UPS_PASSWORD,
      'ups_account_number' => UPS_ACCOUNT_NUMBER,
      'postal_code' => '40515',
      'city' => 'Lexington',
      'state' => 'KY',
      'country' => 'US',
      'street_address1' => '300 Test Ln.',
      'to_state' => 'KY',
      'to_city' => 'Lexington',
      'to_country' => 'US',
      'to_postal_code' => '40515',
      'to_residence' => true,
      'to_name' => 'John Doe',
      'to_street_address1' => '444 Park Place',
      'shipper_name' => 'Extreme Fruit Preserves',
      'packages' => array(
        array(
          'width' => 5,
          'weight' => 6,
          'height' => 11.25,
          'length' => 7.5
        ),
        array(
          'width' => 12,
          'height' => 12,
          'weight' => 12,
          'length' => 9
        )
      )
    );
  
    $confirm_response = ups_shipping::confirm($opts);
  
    if ($confirm_response['success']) {
      $accept_response = ups_shipping::accept($confirm_response);
      if ($accept_response['success']) {

        // write shipping labels
        foreach ($accept_response['packages'] as $package) {
          $f = fopen('/tmp/labels/' . $package['tracking_number'] . '.gif', 'w');
          fwrite($f, base64_decode($package['image']));
          fclose($f);
        }

      } else {
        die('Accept Request Failed');
      }
    } else {
      die('Confirm Request Failed');
    }
