<?php

//
// Implementation of UPS Shipping Package XML
//
// Copyright 2011 Chase Allen James <chaseajames@gmail.com>
//
class ups_shipping {

const URL = 'https://onlinetools.ups.com/ups.app/xml/';
const TESTING_URL = "https://wwwcie.ups.com/ups.app/xml/";
const XPCI_VERSION = '1.0';

public static $RETURN_CODES = array(
  'print_and_mail' => '2',
  '1_attempt' => '3',
  '3_attempt' => '5',
  'electronic_return_label' => '8',
  'print_return_label' => '9'
);

public static $NAFTA_OPTIONS = array(
  'unknown' => '01',
  'various' => '02'
);

public static $REQUIRED_OPTIONS = array(
  'ups_account_number',
  'shipper_name',
  'street_address1',
  'city',
  'to_name',
  'to_street_address1',
  'to_city',
  'to_country',
);

public static $CREDIT_CARD_TYPES = array(
  'american_express' => '01',
  'discover' => '03',
  'mastercard' => '04',
  'optima' => '05',
  'visa' => '06',
  'bravo' => '07',
  'diners_club' => '08'
);

public static $SHIPMENT_CHARGE_TYPES = array(
  'transportation' => '01',
  'duties_and_taxes' => '02'
);

public static $SERVICE_TYPES = array(
  'next_day_air' => '01',
  '2nd_day_air' => '02',
  'ground' => '03',
  'express' => '07',
  'expedited' => '08',
  'standard' => '11',
  '3_day_select' => '12',
  'next_day_air_saver' => '13',
  'next_day_air_early_am' => '14',
  'express_plus' => '54',
  '2nd_day_air_am' => '59',
  'saver' => '65',
  'today_standard' => '82',
  'today_dedicated_courier' => '83',
  'today_intercity' => '84',
  'today_express' => '85',
  'today_express_saver' => '86'
);

public static $COD_TYPES = array(
  'tagless' => '3'
);

public static $FUND_CODES = array(
  'cash' => '1',
  'check' => '9' // Cashier's check or money order
);

public static $QV_CODES = array(
  'return' => '2',
  'in_transit' => '5',
  'ship' => '6',
  'exception' => '7',
  'delivery' => '8'
);

public static $SUBJECT_CODES = array(
  'shipment_reference_number_1' => '01',
  'shipment_reference_number_2' => '02',
  'package_reference_number_1' => '03',
  'package_reference_number_2' => '04',
  'subject_text' => '08'
);

public static $FORM_CODES = array(
  'invoice' => '01',
  'sed' => '02',
  'co' => '03',
  'nafta' => '04',
  'partial_invoice' => '05'
);

public static $OPTION_CODES = array(
  'available_to_customs_upon_request' => '01',
  'same_as_exporter' => '02',
  'attached_list' => '03',
  'unknown' => '04'
);

public static $GOOD_UNITS = array(
  'barrel' => 'BA',
  'bundle' => 'BE',
  'bag' => 'BG',
  'bunch' => 'BH',
  'box' => 'BOX',
  'bolt' => 'BT',
  'butt' => 'BU',
  'canister' => 'CI',
  'centimeter' => 'CM',
  'container' => 'CO',
  'crate' => 'CR',
  'case' => 'CS',
  'carton' => 'CT',
  'cylinder' => 'CY',
  'dozen' => 'DOZ',
  'each' => 'EA',
  'envelope' => 'EN',
  'feet' => 'FT',
  'kilogram' => 'KG',
  'kilograms' => 'KGS',
  'pound' => 'LB',
  'pounds' => 'LBS',
  'liter' => 'L',
  'meter' => 'M',
  'number' => 'NMB',
  'packet' => 'PA',
  'pallet' => 'PAL',
  'piece' => 'PC',
  'pieces' => 'PCS',
  'proof_liters' => 'PF',
  'package' => 'PKG',
  'pair' => 'PR',
  'pairs' => 'PRS',
  'roll' => 'RL',
  'set' => 'SET',
  'square_meters' => 'SME',
  'square_yards' => 'SYD',
  'tube' => 'TU',
  'yard' => 'YD',
  'other' => 'OTH'
);

public static $ORIGIN_OF_GOOD_CODES = array(
  'shipper_is_producer' => 'Yes',
  'knowledge_of_originating_good' => 'No[1]',
  'producer_represents_knowledge_of_originating_good' => 'No[2]',
  'signed_certificate' => 'No[3]'
);

public static $WEIGHT_UNITS = array(
  'kgs' => 'KGS',
  'lbs' => 'LBS'
);

public static $LENGTH_UNITS = array(
  'in' => 'IN',
  'cm' => 'CM'
);

public static $SCHEDULE_B_UNITS = array(
  'barrels' => 'BBL',
  'carat' => 'CAR',
  'content_kilogram' => 'CKG',
  'square_centimeters' => 'CM2',
  'content_ton' => 'CTN',
  'curie' => 'CUR',
  'clean_yield_kilogram' => 'CYK',
  'dozen' => 'DOZ',
  'dozen_pieces' => 'DPC',
  'dozen_pairs' => 'DPR',
  'fiber_meter' => 'FBM',
  'gross_containers' => 'GCN',
  'gram' => 'GM',
  'gross' => 'GRS',
  'hundred' => 'HUN',
  'kilogram' => 'KG',
  'one_thousand_cubic_meters' => 'KM3',
  'kilogram_total_sugars' => 'KTS',
  'liter' => 'L',
  'meter' => 'M',
  'square_meters' => 'M2',
  'cubic_meters' => 'M3',
  'millicurie' => 'MC',
  'number' => 'NO',
  'pieces' => 'PCS',
  'proof_liter' => 'PFL',
  'pack' => 'PK',
  'pairs' => 'PRS',
  'running_bales' => 'RBA',
  'square' => 'SQ',
  'ton' => 'T',
  'thousand' => 'THS',
  'no_quantity_required' => 'X'
);

public static $EXPORT_TYPES = array(
  'domestic' => 'D',
  'foreign' => 'F',
  'foreign_military' => 'M'
);

public static $TERMS_OF_SHIPMENT = array(
  'cost_and_freight' => 'CFR',
  'cost_insurance_freight' => 'CIF',
  'carriage_and_insurance_paid' => 'CIP',
  'carriage_paid' => 'CPT',
  'delivered_at_frontier' => 'DAF',
  'delivery_duty_paid' => 'DDP',
  'delivered_ex_quay' => 'DEQ',
  'delivered_ex_ship' => 'DES',
  'free_alongside_ship' => 'FAS',
  'free_carrier' => 'FCA',
  'free_on_board' => 'FOB'
);

public static $EXPORT_REASONS = array(
  'sale' => 'SALE',
  'gift' => 'GIFT',
  'sample' => 'SAMPLE',
  'return' => 'RETURN',
  'repair' => 'REPAIR',
  'intercompany_data' => 'INTERCOMPANYDATA'
);

public static $BOND_CODES = array(
  'not_in_bond' => '70',
  'warehouse_withdrawal_for_ie' => '36',
  'warehouse_withdrawal_for_t_and_e' => '37',
  't_and_e' => '62',
  'ie_from_a_ftz' => '67',
  't_and_e_from_a_ftz' => '68'
);

public static $MODES_OF_TRANSPORT = array(
  'air' => 'Air',
  'air_containerized' => 'AirContainerized',
  'auto' => 'Auto',
  'fixed_transport_installations' => 'FixedTransportInstallations',
  'mail' => 'Mail',
  'passenger_handcarried' => 'PassengerHandcarried',
  'pedestrian' => 'Pedestrian',
  'rail' => 'Rail',
  'rail_containerized' => 'RailContainerized',
  'road_other' => 'RoadOther',
  'sea_barge' => 'SeaBarge',
  'sea_containerized' => 'SeaContainerized',
  'sea_noncontainerized' => 'SeaNoncontainerized',
  'truck' => 'Truck',
  'truck_containerized' => 'TruckContainerized'
);

public static $LICENSE_EXCEPTION_CODES = array(
  'agr' => 'AGR',
  'apr' => 'APR',
  'avs' => 'AVS',
  'bag' => 'BAG',
  'civ' => 'CIV',
  'ctp' => 'CTP',
  'enc' => 'ENC',
  'gbs' => 'GBS',
  'gft' => 'GFT',
  'gov' => 'GOV',
  'kmi' => 'KMI',
  'lvs' => 'LVS',
  'nlr' => 'NLR',
  'rpl' => 'RPL',
  'tmp' => 'TMP',
  'tspa' => 'TSPA',
  'tsr' => 'TSR',
  'tsu' => 'TSU'
);

public static $IMPORT_CONTROL_CODES = array(
  'print_and_mail' => '01',
  'one_attempt' => '02',
  'three_attempt' => '03',
  'electronic_label' => '04',
  'print_label' => '05'
);

public static $DELIVERY_CONFIRMATION_CODES = array(
  'signature_required' => '1',
  'adult_signature_required' => '2'
);

public static $PACKAGE_TYPES = array(
  'unknown' => '00',
  'letter' => '01',
  'package' => '02',
  'tube' => '03',
  'pak' => '04',
  'small_express' => '2a',
  'medium_express' => '2b',
  'large_express' => '2c',
  'twofive_kg_box' => '24',
  'onezero_kg_box' => '25',
  'pallet' => '30'
);

public static $LABEL_CODES = array(
  'gif' => 'GIF',
  'epl' => 'EPL',
  'zpl' => 'ZPL',
  'starpl' => 'STARPL',
  'spl' => 'SPL'
);

//
// API FUNCTIONS
//

// Usage:
//
//  $opts = array(
//    'ups_access_license_number' => UPS_ACCESS_LICENSE_NUMBER,
//    'ups_userid' => UPS_USER_ID,
//    'ups_password' => UPS_PASSWORD,
//    'ups_account_number' => UPS_ACCOUNT_NUMBER,
//    'postal_code' => '40515',
//    'city' => 'Lexington',
//    'state' => 'KY',
//    'country' => 'US',
//    'street_address1' => '300 Test Ln.',
//    'to_state' => 'KY',
//    'to_city' => 'Lexington',
//    'to_country' => 'US',
//    'to_postal_code' => '40515',
//    'to_residence' => true,
//    'to_name' => 'John Doe',
//    'to_street_address1' => '444 Park Place',
//    'shipper_name' => 'Extreme Fruit Preserves',
//    'packages' => array(
//      array(
//        'width' => 5,
//        'weight' => 6,
//        'height' => 11.25,
//        'length' => 7.5
//      ),
//      array(
//        'width' => 12,
//        'height' => 12,
//        'weight' => 12,
//        'length' => 9
//      )
//    )
//
//  $confirm_response = ups_shipping::confirm($opts);
//
//  if ($confirm_response['success']) {
//    $accept_response = ups_shipping::accept($confirm_response);
//    if ($accept_response['success']) {
//
//      // write shipping labels
//      foreach ($accept_response['packages'] as $package) {
//        $f = fopen('/tmp/labels/' . $package['tracking_number'] . '.gif', 'w');
//        fwrite($f, base64_decode($package['image']));
//        fclose($f);
//      }
//    } else {
//      die('Accept Request Failed');
//    }
//  } else {
//    die('Confirm Request Failed');
//  }
function confirm($opts) {
  self::validate_options($opts, self::$REQUIRED_OPTIONS);
  $xml = self::access_request($opts) . self::confirm_request($opts);
  $raw_response = self::http_client_post_xml('ShipConfirm', $xml, $opts);
  $response = self::parse_confirm_response($raw_response, $opts);
  return $response;
}

// Usage:
//
//   $response = ups_shipping::confirm($opts);
//   if ($response['success']) {
//     $accept_response = ups_shipping::accept($response, $opts);
//     if ($accept_response['success']) print_r($accept_response, true);
//   } else {
//      print_r($response['error']);
//   }
function accept($response, $opts) {
  $xml = self::access_request($opts) . self::accept_request($response, $opts);
  $raw_response = self::http_client_post_xml('ShipAccept', $xml, $opts);
  $response = self::parse_accept_response($raw_response, $opts);
  return $response;
}

//
// INTERNAL FUNCTIONS
//

function access_request($opts) {
  $doc = new DOMDocument('1.0');
  $access_request = $doc->appendChild(
    new DOMElement('AccessRequest'));
  $access_request->setAttributeNode(
    new DOMAttr('xml:lang', 'en-US'));
  $access_request->appendChild(
    new DOMElement('AccessLicenseNumber', $opts['ups_access_license_number']));
  $access_request->appendChild(
    new DOMElement('UserId', $opts['ups_userid']));
  $access_request->appendChild(
    new DOMElement('Password', $opts['ups_password']));
  return $doc->saveXML();
}

function confirm_request($opts) {
  $doc = new DOMDocument('1.0');  
  $confirm_request = $doc->appendChild(
    new DOMElement('ShipmentConfirmRequest'));

  $request = $confirm_request->appendChild(
    new DOMElement('Request'));

  $request->appendChild(
    new DOMElement('RequestAction', 'ShipConfirm'));

  $validate = ((isset($opts['validate']) && !$opts['validate']) ? 'nonvalidate' : 'validate');

  $request->appendChild(
    new DOMElement('RequestOption', $validate));

  if (isset($opts['customer_context'])) {
    $transaction_reference = $request->appendChild(
      new DOMElement('TransactionReference'));
    $transaction_reference->appendChild(
      new DOMElement('CustomerContext', substr($opts['customer_context'], 0, 512)));
  }

  $shipment = $confirm_request->appendChild( 
    new DOMElement('Shipment'));

  if (isset($opts['description'])) {
    $shipment->appendChild(
      new DOMElement('Description', substr($opts['description'], 0, 35)));
  }

  if (isset($opts['return_code'])) {
    $return_service = $shipment->appendChild(
      new DOMElement('ReturnService'));
    $return_service->appendChild(
      new DOMElement('Code', self::$RETURN_CODES[$opts['return_code']]));
  }

  if (isset($opts['documents_only']) && $opts['documents_only']) {
    $shipment->appendChild(
      new DOMElement('DocumentsOnly'));
  }

  $shipper = $shipment->appendChild(
    new DOMElement('Shipper'));

  $shipper->appendChild(
    new DOMElement('Name', substr($opts['shipper_name'], 0, 35)));

  if (isset($opts['attention_name'])) {
    $shipper->appendChild(
      new DOMElement('AttentionName', substr($opts['attention_name'], 0, 35)));
  }

  $shipper->appendChild(
    new DOMElement('ShipperNumber', substr($opts['ups_account_number'], 0, 6)));

  if (isset($opts['tax_id'])) {
    $shipper->appendChild(
      new DOMElement('TaxIdentificationNumber', substr($opts['tax_id'], 0, 15)));
  }

  if (isset($opts['phone_number'])) {
    $shipper->appendChild(
      new DOMElement('PhoneNumber', substr($opts['phone_number'], 0, 15)));
  }

  if (isset($opts['fax_number'])) {
    $shipper->appendChild(
      new DOMElement('FaxNumber', substr($opts['fax_number'], 0, 14)));
  }

  if (isset($opts['email_address'])) {
    $shipper->appendChild(
      new DOMElement('EmailAddress', substr($opts['email_address'], 0, 50)));
  }

  $address = $shipper->appendChild(
    new DOMElement('Address'));

  $address->appendChild(
    new DOMElement('AddressLine1', substr($opts['street_address1'], 0, 35)));

  if (isset($opts['street_address2'])) {
    $address->appendChild(
      new DOMElement('AddressLine2', substr($opts['street_address2'], 0, 35)));
  }

  if (isset($opts['street_address3'])) {
    $address->appendChild(
      new DOMElement('AddressLine3', substr($opts['street_address3'], 0, 35)));
  }
  
  if (isset($opts['city'])) {
    $address->appendChild(
      new DOMElement('City', substr($opts['city'], 0, 30)));
  }

  if (isset($opts['state'])) {
    $address->appendChild(
      new DOMElement('StateProvinceCode', substr($opts['state'], 0, 5)));
  }

  if (isset($opts['postal_code'])) {
    $address->appendChild(
      new DOMElement('PostalCode', substr($opts['postal_code'], 0, 10)));
  }

  $address->appendChild(
    new DOMElement('CountryCode', substr($opts['country'], 0, 2)));

  $ship_to = $shipment->appendChild(
    new DOMElement('ShipTo'));

  $ship_to->appendChild(
    new DOMElement('CompanyName', substr($opts['to_name'], 0, 35)));

  if (isset($opts['to_attention_name'])) {
    $ship_to->appendChild(
      new DOMElement('AttentionName', substr($opts['to_attention_name'], 0, 35)));
  }

  if (isset($opts['to_tax_id'])) {
    $ship_to->appendChild(
      new DOMElement('TaxIdentificationNumber', substr($opts['to_tax_id'], 0, 15)));
  }

  if (isset($opts['to_phone'])) {
    $ship_to->appendChild(
      new DOMElement('PhoneNumber', substr($opts['to_phone'], 0, 15)));
  }

  if (isset($opts['to_fax'])) {
    $ship_to->appendChild(
      new DOMElement('FaxNumber', substr($opts['to_fax'], 0, 15)));
  }

  if (isset($opts['to_email'])) {
    $ship_to->appendChild(
      new DOMElement('EmailAddress', substr($opts['to_email'], 0, 50)));
  }

  $to_address = $ship_to->appendChild(
    new DOMElement('Address'));

  $to_address->appendChild(
    new DOMElement('AddressLine1', substr($opts['to_street_address1'], 0, 35)));

  if (isset($opts['to_street_address2'])) {
    $to_address->appendChild(
      new DOMElement('AddressLine2', substr($opts['to_street_address2'], 0, 35)));
  }

  if (isset($opts['to_street_address3'])) {
    $to_address->appendChild(
      new DOMElement('AddressLine3', substr($opts['to_street_address3'], 0, 35)));
  }

  if (isset($opts['to_city'])) {
    $to_address->appendChild(
      new DOMElement('City', substr($opts['to_city'], 0, 30)));
  }

  if (isset($opts['to_state'])) {
    $to_address->appendChild(
      new DOMElement('StateProvinceCode', substr($opts['to_state'], 0, 5)));
  }

  if (isset($opts['to_postal_code'])) {
    $to_address->appendChild(
      new DOMElement('PostalCode', substr($opts['to_postal_code'], 0, 10)));
  }

  $to_address->appendChild(
    new DOMElement('CountryCode', substr($opts['to_country'], 0, 2)));

  if (isset($opts['to_residence']) && $opts['to_residence']) {
    $to_address->appendChild(
      new DOMElement('ResidentialAddress'));
  }

  if (isset($opts['to_location_id'])) {
    $to_address->appendChild(
      new DOMElement('LocationID', substr($opts['to_location_id'], 0, 10)));
  }

  if (isset($opts['ship_from_country'])) {

    $ship_from = $shipment->appendChild(
      new DOMElement('ShipFrom'));

    $ship_from->appendChild(
      new DOMElement('CompanyName', substr($opts['ship_from_company_name'], 0, 35)));

    if (isset($opts['attention_name'])) {
      $ship_from->appendChild(
        new DOMElement('AttentionName', substr($opts['attention_name'], 0, 35)));
    }

    if (isset($opts['tax_id'])) {
      $ship_from->appendChild(
        new DOMElement('TaxIdentificationNumber', substr($opts['tax_id'], 0, 15)));
    }

    $ship_from->appendChild(
      new DOMElement('PhoneNumber', substr($opts['phone_number'], 0, 15)));

    if (isset($opts['fax_number'])) {
      $ship_from->appendChild(
        new DOMElement('FaxNumber', substr($opts['fax_number'], 0, 15)));
    }

    $ship_from_address = $ship_from->appendChild(
      new DOMElement('Address'));
    
    $ship_from_address->appendChild(
      new DOMElement('AddressLine1', substr($opts['ship_from_street_address1'], 0, 35)));

    if (isset($opts['to_street_address2'])) {
      $ship_from_address->appendChild(
        new DOMElement('AddressLine2', substr($opts['ship_from_street_address2'], 0, 35)));
    }

    if (isset($opts['ship_from_street_address3'])) {
      $ship_from_address->appendChild(
        new DOMElement('AddressLine3', substr($opts['ship_from_street_address3'], 0, 35)));
    }
  
    if (isset($opts['ship_from_city'])) {
      $ship_from_address->appendChild(
        new DOMElement('City', substr($opts['ship_from_city'], 0, 30)));
    }

    if (isset($opts['ship_from_state'])) {
      $ship_from_address->appendChild(
        new DOMElement('StateProvinceCode', substr($opts['ship_from_state'], 0, 5)));
    }

    if (isset($opts['ship_from_postal_code'])) {
      $ship_from_address->appendChild(
        new DOMElement('PostalCode', substr($opts['ship_from_postal_code'], 0, 10)));
    }

    $ship_from_address->appendChild(
      new DOMElement('CountryCode', substr($opts['ship_from_country'], 0, 2)));

  } // end ShipFrom conditional

  if (isset($opts['sold_to_option'])) {

    $sold_to = $shipment->appendChild(
      new DOMElement('SoldTo'));

    $sold_to->appendChild(
      new DOMElement('Option', substr(self::$NAFTA_OPTIONS[$opts['sold_to_option']], 0, 10)));

    $sold_to->appendChild(
      new DOMElement('CompanyName', substr($opts['sold_to_company_name'], 0, 35)));

    if (isset($opts['sold_to_attention_name'])) {
      $sold_to->appendChild(
        new DOMElement('AttentionName', substr($opts['sold_to_attention_name'], 0, 35)));
    }

    if (isset($opts['sold_to_tax_id'])) {
      $sold_to->appendChild(
        new DOMElement('TaxIdentificationNumber', substr($opts['sold_to_tax_id'], 0, 15)));
    }

    $sold_to->appendChild(
      new DOMElement('PhoneNumber', substr($opts['sold_to_phone_number'], 0, 15)));

    if (isset($opts['sold_to_fax_number'])) {
      $sold_to->appendChild(
        new DOMElement('FaxNumber', substr($opts['fax_number'], 0, 15)));
    }

    $sold_to_address = $sold_to->appendChild(
      new DOMElement('Address'));
    
    $sold_to_address->appendChild(
      new DOMElement('AddressLine1', substr($opts['sold_to_street_address1'], 0, 35)));

    if (isset($opts['sold_to_street_address2'])) {
      $sold_to_address->appendChild(
        new DOMElement('AddressLine2', substr($opts['sold_to_street_address2'], 0, 35)));
    }

    if (isset($opts['sold_to_street_address3'])) {
      $sold_to_address->appendChild(
        new DOMElement('AddressLine3', substr($opts['sold_to_street_address3'], 0, 35)));
    }
    
    if (isset($opts['sold_to_city'])) {
      $sold_to_address->appendChild(
        new DOMElement('City', substr($opts['sold_to_city'], 0, 30)));
    }

    if (isset($opts['sold_to_state'])) {
      $sold_to_address->appendChild(
        new DOMElement('StateProvinceCode', substr($opts['sold_to_state'], 0, 5)));
    }

    if (isset($opts['sold_to_postal_code'])) {
      $sold_to_address->appendChild(
        new DOMElement('PostalCode', substr($opts['sold_to_postal_code'], 0, 10)));
    }

    $sold_to_address->appendChild(
      new DOMElement('CountryCode', substr($opts['sold_to_country'], 0, 2)));

  } // end SoldTo conditional

  // If there is no ShipmentChargeType, use PaymentInformation, otherwise
  // use ItemizedPaymentInformation.
  if (!isset($opts['shipment_charge_type'])) {

    $payment_information = $shipment->appendChild(
      new DOMElement('PaymentInformation'));

    if(!isset($opts['billing']) || ($opts['billing'] == 'prepaid')) {

      $prepaid = $payment_information->appendChild(
        new DOMElement('Prepaid'));

      $bill_shipper = $prepaid->appendChild(
        new DOMElement('BillShipper'));

      if(!isset($opts['credit_card'])) {
        $bill_shipper->appendChild(
          new DOMElement('AccountNumber', substr($opts['ups_account_number'], 0, 6)));
      }

      if(isset($opts['credit_card'])) {

        $credit_card = $bill_shipper->appendChild(
          new DOMElement('CreditCard'));

        $credit_card->appendChild(
          new DOMElement('Type', substr($opts['credit_card']['type'], 0, 2)));

        $credit_card->appendChild(
          new DOMElement('Number', substr($opts['credit_card']['number'], 0, 16)));

        $credit_card->appendChild(
          new DOMElement('ExpirationDate', substr($opts['credit_card']['expiration'], 0, 6)));

        if(isset($opts['credit_card']['cvv'])) {
          $credit_card->appendChild(
            new DOMElement('SecurityCode', substr($opts['credit_card']['cvv'], 0, 4)));
        }

        if(isset($opts['credit_card']['street_address1'])) {
          $credit_card_address = $credit_card->appendChild(
            new DOMElement('Address'));

          $credit_card_address->appendChild(
            new DOMElement('AddressLine1', substr($opts['credit_card']['street_address1'], 0, 35)));

          if(isset($opts['credit_card']['street_address2'])) {
            $credit_card_address->appendChild(
              new DOMElement('AddressLine2', substr($opts['credit_card']['street_address2'], 0, 35)));
          }

          if(isset($opts['credit_card']['street_address3'])) {
            $credit_card_address->appendChild(
              new DOMElement('AddressLine3', substr($opts['credit_card']['street_address3'], 0, 35)));
          }

          $credit_card_address->appendChild(
            new DOMElement('City', substr($opts['credit_card']['city'], 0, 30)));

          $credit_card_address->appendChild(
            new DOMElement('StateProvinceCode', substr($opts['credit_card']['state'], 0, 5)));

          $credit_card_address->appendChild(
            new DOMElement('PostalCode', substr($opts['credit_card']['postal_code'], 0, 10)));

          $credit_card_address->appendChild(
            new DOMElement('CountryCode', substr($opts['credit_card']['country'], 0, 2)));
            
        } // end credit card Address

      } // end CreditCard

    // end PrePaid conditional
    } else if ($opts['billing'] == 'third_party') {

      $bill_third_party = $payment_information->appendChild(
        new DOMElement('BillThirdParty'));

      $bill_third_party_shipper = $bill_third_party->appendChild(
        new DOMElement('BillThirdPartyShipper'));

      $bill_third_party_shipper->appendChild(
        new DOMElement('AccountNumber', substr($opts['third_party_shipper']['ups_account_number'], 0, 6)));

      $third_party = $bill_third_party_shipper->appendChild(
        new DOMElement('ThirdParty'));

      $third_party_address = $third_party->appendChild(
        new DOMElement('Address'));

      if(isset($opts['third_party_shipper']['postal_code'])) {
        $third_party_address->appendChild(
          new DOMElement('PostalCode', substr($opts['third_party_shipper']['postal_code'], 0, 6)));
      }

      $third_party_address_country = (isset($opts['third_party_shipper']['country']) ? $opts['third_party_shipper']['country'] : 'US');

      $third_party_address->appendChild(
        new DOMElement('CountryCode', substr($third_party_address_country, 0, 2)));

    // end ThirdPartyShipper
    } elseif ($opts['billing'] == 'receiver') {

      $freight_collect = $payment_information->appendChild(
        new DOMElement('FreightCollect'));

      $bill_receiver = $freight_collect->appendChild(
        new DOMElement('BillReceiver'));

      $bill_receiver->appendChild(
        new DOMElement('AccountNumber', substr($opts['bill_receiver']['ups_account_number'], 0, 6)));

      if (isset($opts['bill_receiver']['postal_code'])) {
        $bill_receiver_address = $bill_receiver->appendChild(
          new DOMElement('Address'));

        $bill_reciever_address->appendChild(
          new DOMElement('PostalCode', substr($opts['bill_receiver']['postal_code'], 0, 10)));
      }
    // end FreightCollect
    } elseif ($opts['billing'] == 'consignee_billed') {
      $payment_information->appendChild(
        new DOMElement('ConsigneeBilled'));
    }

  // end PaymentInformation
  } else {
    $itemized_payment_information = $shipment->appendChild(
      new DOMElement('ItemizedPaymentInformation'));

    $shipment_charge = $itemized_payment_information->appendChild(
      new DOMElement('ShipmentCharge'));

    $shipment_charge_type = (isset($opts['shipment_charge_type']) ? $opts['shipment_charge_type'] : 'transportation');
    $shipment_charge->appendChild(
      new DOMElement('Type', self::$SHIPMENT_CHARGE_TYPES[$shipment_charge_type]));

    if ($opts['billing'] == 'shipper') {

      $bill_shipper = $shipment_charge->appendChild(
        new DOMElement('BillShipper'));

      if(!isset($opts['credit_card'])) {

        $bill_shipper->appendChild(
          new DOMElement('AccountNumber', substr($opts['ups_account_number'], 0, 6)));

      } else {

        $credit_card = $bill_shipper->appendChild(
          new DOMElement('CreditCard'));

        $credit_card->appendChild(
          new DOMElement('Type', substr($opts['credit_card']['type'], 0, 2)));

        $credit_card->appendChild(
          new DOMElement('Number', substr($opts['credit_card']['number'], 0, 16)));

        $credit_card->appendChild(
          new DOMElement('ExpirationDate', substr($opts['credit_card']['expiration'], 0, 6)));

        if(isset($opts['credit_card']['cvv'])) {
          $credit_card->appendChild(
            new DOMElement('SecurityCode', substr($opts['credit_card']['cvv'], 0, 4)));
        }

        if(isset($opts['credit_card']['street_address1'])) {
          $credit_card_address = $credit_card->appendChild(
            new DOMElement('Address'));

          $credit_card_address->appendChild(
            new DOMElement('AddressLine1', substr($opts['credit_card']['street_address1'], 0, 35)));

          if(isset($opts['credit_card']['street_address2'])) {
            $credit_card_address->appendChild(
              new DOMElement('AddressLine2', substr($opts['credit_card']['street_address2'], 0, 35)));
          }

          if(isset($opts['credit_card']['street_address3'])) {
            $credit_card_address->appendChild(
              new DOMElement('AddressLine3', substr($opts['credit_card']['street_address3'], 0, 35)));
          }

          $credit_card_address->appendChild(
            new DOMElement('City', substr($opts['credit_card']['city'], 0, 30)));

          $credit_card_address->appendChild(
            new DOMElement('StateProvinceCode', substr($opts['credit_card']['state'], 0, 5)));

          $credit_card_address->appendChild(
            new DOMElement('PostalCode', substr($opts['credit_card']['postal_code'], 0, 10)));

          $credit_card_address->appendChild(
            new DOMElement('CountryCode', substr($opts['credit_card']['country'], 0, 2)));
            
        } // end credit card Address

      } // end CreditCard

    // end BillShipper
    } elseif ($opts['billing'] == 'receiver') {

      $bill_receiver = $shipment_charge->appendChild(
        new DOMElement('BillReceiver'));

      $bill_receiver->appendChild(
        new DOMElement('AccountNumber', substr($opts['bill_receiver']['ups_account_number'], 0, 6)));

      if (isset($opts['bill_receiver']['postal_code'])) {

        $bill_receiver_address = $bill_receiver->appendChild(
          new DOMElement('Address'));

        $bill_reciever_address->appendChild(
          new DOMElement('PostalCode', substr($opts['bill_receiver']['postal_code'], 0, 10)));
      }
    // end BillReceiver
    } elseif (in_array($opts['billing'], array('third_party_shipper', 'third_party_consignee'))) {

      $bill_third_party = $shipment_charge->appendChild(
        new DOMElement('BillThirdParty'));

      if (isset($opts['third_party_shipper'])) {

        $bill_third_party_shipper = $bill_third_party->appendChild(
          new DOMElement('BillThirdPartyShipper'));

        $bill_third_party_shipper->appendChild(
          new DOMElement('AccountNumber', substr($opts['third_party_shipper']['ups_account_number'], 0, 6)));

        $third_party = $bill_third_party_shipper->appendChild(
          new DOMElement('ThirdParty'));

        $third_party_address = $third_party->appendChild(
          new DOMElement('Address'));

        if(isset($opts['third_party_shipper']['postal_code'])) {
          $third_party_address->appendChild(
            new DOMElement('PostalCode', substr($opts['third_party_shipper']['postal_code'], 0, 6)));
        }

        $third_party_address_country = (isset($opts['third_party_shipper']['country']) ? $opts['third_party_shipper']['country'] : 'US');

        $third_party_address->appendChild(
          new DOMElement('CountryCode', substr($third_party_address_country, 0, 2)));

      } else {

        $third_party_consignee = $bill_third_party->appendChild(
          new DOMElement('BillThirdPartyConsignee'));
          
        $third_party_consignee->appendChild(
          new DOMElement('AccountNumber', substr($opts['third_party_consignee']['ups_account_number'], 0, 6)));

        $third_party_consignee_additional_information = $third_party_consignee->appendChild(
          new DOMElement('ThirdParty'));

        $third_party_consignee_address = $third_party_consignee_additional_information->appendChild(
          new DOMElement('Address'));

        if(isset($opts['third_party_consignee']['postal_code'])) {
          $third_party_address->appendChild(
            new DOMElement('PostalCode', substr($opts['third_party_consignee']['postal_code'], 0, 6)));
        }

        $third_party_address_country = (isset($opts['third_party_consignee']['country']) ? $opts['third_party_consignee']['country'] : 'US');

        $third_party_address->appendChild(
          new DOMElement('CountryCode', substr($third_party_address_country, 0, 2)));
      }

    // end BillThirdParty
    } else {
      $shipment_charge->appendChild(
        new DOMElement('ConsigneeBilled'));
    }

    $itemized_payment_information->appendChild(
      new DOMElement('SplitDutyVATIndicator'));

  // end ItemizedPaymentInformation
  }

  if (isset($opts['goods_not_in_free_circulation']) && $opts['goods_not_in_free_circulation']) {
    $shipment->appendChild(
      new DOMElement('GoodsNotInFreeCirculationIndicator'));
  }

  if (isset($opts['negotiated_rates']) && $opts['negotiated_rates']) {
    $rate_information = $shipment->appendChild(
      new DOMElement('RateInformation'));

    $rate_information->appendChild(
      new DOMElement('NegotiatedRatesIndicator'));
  }

  if (isset($opts['movement_reference_number']) && $opts['movement_reference_number']) {
    $shipment->appendChild(
      new DOMElement('MovementReferenceNumber', substr($opts['movement_reference_number'], 0, 18)));
  }

  if (isset($opts['reference_number']) && $opts['reference_number']) {
    $reference_number = $shipment->appendChild(
      new DOMElement('ReferenceNumber'));

    if (isset($opts['bar_code']) && $opts['bar_code']) {
      $reference_number->appendChild(
        new DOMElement('BarCodeIndicator'));
    }

    $reference_number->appendChild(
      new DOMElement('Code', substr($opts['reference_number']['code'], 0, 2)));

    $reference_number->appendChild(
      new DOMElement('Value', substr($opts['reference_number']['value'], 0, 35)));
  }

  $service = $shipment->appendChild(
    new DOMElement('Service'));

  $service_code = (isset($opts['service_code']) ? $opts['service_code'] : 'ground');

  $service->appendChild(
    new DOMElement('Code', substr(self::$SERVICE_TYPES[$service_code], 0, 2)));

  $service_description = ucwords(preg_replace('/_/', ' ', $service_code));
  $service->appendChild(
    new DOMElement('Description', substr($service_description, 0, 35)));

  if (($opts['to_country'] == 'PR') || ($opts['to_country'] == 'CA')) {
    $invoice_line_total = $shipment->appendChild(
      new DOMElement('InvoiceLineTotal'));

    $invoice_currency = (isset($opts['invoice_currency']) ? $opts['invoice_currency'] : 'USD');

    $invoice_line_total->appendChild(
      new DOMElement('CurrencyCode', substr($invoice_currency, 0, 3)));

    $invoice_line_total->appendChild(
      new DOMElement('MonetaryValue', trim(sprintf('%8.2f', floatval($opts['invoice_total'])))));
  }

  if (isset($opts['saturday_pickup']) ||
      isset($opts['cod_value']) ||
      isset($opts['on_call_day']) ||
      isset($opts['notifications']) ||
      isset($opts['insured_value'])) {

    $shipment_service_options = $shipment->appendChild(
      new DOMElement('ShipmentServiceOptions'));

    if (isset($opts['saturday_pickup'])) {
      $shipment_service_options->appendChild(
        new DOMElement('SaturdayDelivery'));
    }

    if (isset($opts['cod_value'])) {
      $cod = $shipment_service_options->appendChild(
        new DOMElement('COD'));

      $cod->appendChild(
        new DOMElement('CODCode', self::$COD_TYPES['tagless']));

      if (isset($opts['cod_fund_code'])) {
        $cod->appendChild(
          new DOMElement('CODFundsCode', self::$FUND_CODES[$opts['cod_fund_code']]));
      }

      $cod_amount = $cod->appendChild(
        new DOMElement('CODAmount'));

      $currency_code = (isset($opts['cod_currency_code']) ? $opts['cod_currency_code'] : 'USD');

      $cod_amount->appendChild(
        new DOMElement('CurrencyCode', $currency_code));

      $cod_amount->appendChild(
        new DOMElement('MonetaryValue', $opts['cod_value']));

    }

    if (isset($opts['notifications'])) {

      $notification_counter = 0;

      foreach($opts['notifications'] as $notif) {

        // up to three notifications
        if($notification_counter == 3) break;

        $notification = $shipment_service_options->appendChild(
          new DOMElement('Notification'));

        $notification->appendChild(
          new DOMElement('NotificationCode', self::$QV_CODES[$notif['code']]));

        $email = $notification->appendChild(
          new DOMElement('EMailMessage'));

        $email_address_counter = 0;
        foreach($notif['email_addresses'] as $eml) {

          // up to five email addresses
          if($email_address_counter == 5) break;

          $email->appendChild(
            new DOMElement('EMailAddress', substr($eml, 0, 50)));

          $email_address_counter++;
        }

        if (isset($notif['undeliverable_email_address'])) {
          $email->appendChild(
            new DOMElement('UndeliverableEMailAddress', substr($notif['undeliverable_email_address'], 0, 50)));
        }

        if (isset($notif['from_email_address'])) {
          $email->appendChild(
            new DOMElement('FromEMailAddress', substr($notif['from_email_address'], 0, 50)));
        }

        $from_name = (isset($notif['from_name']) ? $notif['from_name'] : $opts['shipper_name']);
        $email->appendChild(
          new DOMElement('FromName', substr($from_name, 0, 35)));

        if (isset($notif['body'])) {
          $email->appendChild(
            new DOMElement('Memo', substr($notif['body'], 0, 150)));
        }

        if (isset($notif['subject'])) {
          $email->appendChild(
            new DOMElement('Subject', substr($notif['subject'], 0, 50)));
        }

        if (isset($notif['subject_code'])) {
          $email->appendChild(
            new DOMElement('SubjectCode', substr(self::$SUBJECT_CODES[$notif['subject_code']], 0, 2)));
        }

        $notification_counter++;

      } // end Notification foreach

    } // end Notifications

    if (isset($opts['return_label'])) {
      $label_delivery = $shipment_service_options->appendChild(
        new DOMElement('LabelDelivery'));

      if (isset($opts['return_label']['get_link']) && $opts['return_label']['get_link']) {
        $label_delivery->appendChild(
          new DOMElement('LabelLinkIndicator'));
      }

      if (isset($opts['return_label']['email_address'])) {
        $email_message = $label_delivery->appendChild(
          new DOMElement('EmailMessage'));

        $email_message->appendChild(
          new DOMElement('EmailAddress', substr($opts['return_label']['email_address']), 0, 50));

        if (isset($opts['return_label']['undeliverable_email_address'])) {
          $email_message->appendChild(
            new DOMElement('UndeliverableEmailAddress', substr($opts['return_label']['undeliverable_email_address'], 0, 50)));
        }

        $email_message->appendChild(
          new DOMElement('FromEmailAddress', substr($opts['return_label']['from_email_address'], 0, 50)));

        if (isset($opts['return_label']['from_name'])) {
          $email_message->appendChild(
            new DOMElement('FromName', substr($opts['return_label']['from_name'], 0, 35)));
        }

        if (isset($opts['return_label']['body'])) {
          $email_message->appendChild(
            new DOMElement('Memo', substr($opts['return_label']['body'], 0, 150)));
        }

        if (isset($opts['return_label']['subject'])) {
          $email_message->appendChild(
            new DOMElement('Subject', substr($opts['return_label']['subject'], 0, 50)));
        }

        $subject_code = (isset($opts['return_label']['subject']) ? 'subject_text' :
                        (isset($opts['return_label']['subject_code']) ? $opts['return_label']['subject_code'] : false));

        if($subject_code) {
          $email_message->appendChild(
            new DOMElement('SubjectCode', self::$SUBJECT_CODES[$subject_code]));
        }

      } // end EmailMessage

    } // end LabelDelivery

    // International Forms
    if (isset($opts['form_codes'])) {
      $international_forms = $shipment_service_options->appendChild(
        new DOMElement('InternationalForms'));

      $form_types_counter = 0;
      foreach($opts['form_codes'] as $form_code) {

        // up to 4 forms
        if($form_types_counter == 4) break;

        $international_forms->appendChild(
          new DOMElement('FormType', self::$FORM_CODES[$form_code]));

        $form_types_counter++;
      }

      if (isset($opts['additional_forms']) && $opts['additional_forms']) {
        $international_forms->appendChild(
          new DOMElement('AdditionalDocumentsIndicator'));
      }

      if (isset($opts['form_group_name'])) {
        $international_forms->appendChild(
          new DOMElement('FormGroupIdName', substr($opts['form_group_name'], 0, 50)));
      }

      if (in_array('sed', $opts['form_codes'])) {
        $international_forms->appendChild(
          new DOMElement('SEDFilingOption', '01'));
      }

      if (in_array(array('sed', 'nafta'), $opts['form_codes'])) {
        $contacts = $international_forms->appendChild(
          new DOMElement('Contacts'));

        if (in_array('sed', $opts['form_codes']) && isset($opts['forwarding_agent'])) {
          $forward_agent = $contacts->appendChild(
            new DOMElement('ForwardAgent'));

          $forward_agent->appendChild(
            new DOMElement('CompanyName', substr($opts['forwarding_agent']['name'], 0, 35)));

          $forward_agent->appendChild(
            new DOMElement('TaxIdentificationNumber', substr($opts['forwarding_agent']['tax_id'], 0, 15)));

          $forward_agent_address = $forward_agent->appendChild(
            new DOMElement('Address'));

          $forward_agent_address->appendChild(
            new DOMElement('AddressLine1', substr($opts['farwarding_agent']['street_address1'], 0, 35)));

          if (isset($opts['forwarding_agent']['street_address2'])) {
            $forward_agent_address->appendChild(
              new DOMElement('AddressLine2', substr($opts['farwarding_agent']['street_address2'], 0, 35)));
          }

          if (isset($opts['forwarding_agent']['street_address3'])) {
            $forward_agent_address->appendChild(
              new DOMElement('AddressLine3', substr($opts['farwarding_agent']['street_address3'], 0, 35)));
          }

          if (isset($opts['forwarding_agent']['city'])) {
            $forward_agent_address->appendChild(
              new DOMElement('City', substr($opts['forwarding_agent']['city'], 0, 30)));
          }

          if (isset($opts['forwarding_agent']['state'])) {
            $forward_agent_address->appendChild(
              new DOMElement('StateProvinceCode', substr($opts['forwarding_agent']['state'], 0, 5)));
          }

          if (isset($opts['forwarding_agent']['postal_code'])) {
            $forward_agent_address->appendChild(
              new DOMElement('PostalCode', substr($opts['forwarding_agent']['postal_code'], 0, 10)));
          }

          $forward_agent_address->appendChild(
            new DOMElement('CountryCode', substr($opts['forwarding_agent']['country'], 0, 2)));

          $ultimate_consignee = $contacts->appendChild(
            new DOMElement('UltimateConsignee'));

          $ultimate_consignee->appendChild(
            new DOMElement('CompanyName', substr($opts['ultimate_consignee']['name']), 0, 35));

          $ultimate_consignee_address = $ultimate_consignee->appendChild(
            new DOMElement('Address'));

          $ultimate_consignee_address->appendChild(
            new DOMElement('AddressLine1', substr($opts['farwarding_agent']['street_address1'], 0, 35)));

          if (isset($opts['ultimate_consignee']['street_address2'])) {
            $ultimate_consignee_address->appendChild(
              new DOMElement('AddressLine2', substr($opts['farwarding_agent']['street_address2'], 0, 35)));
          }

          if (isset($opts['ultimate_consignee']['street_address3'])) {
            $ultimate_consignee_address->appendChild(
              new DOMElement('AddressLine3', substr($opts['farwarding_agent']['street_address3'], 0, 35)));
          }

          if (isset($opts['ultimate_consignee']['city'])) {
            $ultimate_consignee_address->appendChild(
              new DOMElement('City', substr($opts['ultimate_consignee']['city'], 0, 30)));
          }

          if (isset($opts['ultimate_consignee']['state'])) {
            $ultimate_consignee_address->appendChild(
              new DOMElement('StateProvinceCode', substr($opts['ultimate_consignee']['state'], 0, 5)));
          }

          if (isset($opts['ultimate_consignee']['postal_code'])) {
            $ultimate_consignee_address->appendChild(
              new DOMElement('PostalCode', substr($opts['ultimate_consignee']['postal_code'], 0, 10)));
          }

          $ultimate_consignee_address->appendChild(
            new DOMElement('CountryCode', substr($opts['ultimate_consignee']['country'], 0, 2)));

          if (isset($opts['intermediate_consignee'])) {

            $intermediate_consignee = $contacts->appendChild(
              new DOMElement('IntermediateConsignee'));

            $intermediate_consignee->appendChild(
              new DOMElement('CompanyName', substr($opts['intermediate_consignee']['name']), 0, 35));

            $intermediate_consignee_address = $intermediate_consignee->appendChild(
              new DOMElement('Address'));

            $intermediate_consignee_address->appendChild(
              new DOMElement('AddressLine1', substr($opts['farwarding_agent']['street_address1'], 0, 35)));

            if (isset($opts['intermediate_consignee']['street_address2'])) {
              $intermediate_consignee_address->appendChild(
                new DOMElement('AddressLine2', substr($opts['farwarding_agent']['street_address2'], 0, 35)));
            }

            if (isset($opts['intermediate_consignee']['street_address3'])) {
              $intermediate_consignee_address->appendChild(
                new DOMElement('AddressLine3', substr($opts['farwarding_agent']['street_address3'], 0, 35)));
            }

            if (isset($opts['intermediate_consignee']['city'])) {
              $intermediate_consignee_address->appendChild(
                new DOMElement('City', substr($opts['intermediate_consignee']['city'], 0, 30)));
            }

            if (isset($opts['intermediate_consignee']['state'])) {
              $intermediate_consignee_address->appendChild(
                new DOMElement('StateProvinceCode', substr($opts['intermediate_consignee']['state'], 0, 5)));
            }

            if (isset($opts['intermediate_consignee']['postal_code'])) {
              $intermediate_consignee_address->appendChild(
                new DOMElement('PostalCode', substr($opts['intermediate_consignee']['postal_code'], 0, 10)));
            }

            $intermediate_consignee_address->appendChild(
              new DOMElement('CountryCode', substr($opts['intermediate_consignee']['country'], 0, 2)));

          } // end intermediate consignee conditional

        } // end SED form requirements conditional

        if (in_array('nafta', $opts['form_codes'])) {

          $producer = $contacts->appendChild(
            new DOMElement('Producer'));

          if (isset($opts['producer']['option'])) {
            $producer->appendChild(
              new DOMElement('Option', self::$OPTION_CODES[$opts['producer']['option']]));
          }

          if (!isset($opts['producer']['option'])) {
            $producer->appendChild(
              new DOMElement('CompanyName', substr($opts['producer']['name'], 0, 35)));

            if (isset($opts['producer']['tax_id'])) {
              $producer->appendChild(
                new DOMElement('TaxIdentificationNumber', substr($opts['producer']['tax_id'], 0, 15)));
            }

            $producer_address = $producer->appendChild(
              new DOMElement('Address'));

            $producer_address->appendChild(
              new DOMElement('AddressLine1', substr($opts['farwarding_agent']['street_address1'], 0, 35)));

            if (isset($opts['producer']['street_address2'])) {
              $producer_address->appendChild(
                new DOMElement('AddressLine2', substr($opts['farwarding_agent']['street_address2'], 0, 35)));
            }

            if (isset($opts['producer']['street_address3'])) {
              $producer_address->appendChild(
                new DOMElement('AddressLine3', substr($opts['farwarding_agent']['street_address3'], 0, 35)));
            }

            if (isset($opts['producer']['city'])) {
              $producer_address->appendChild(
                new DOMElement('City', substr($opts['producer']['city'], 0, 30)));
            }

            if (isset($opts['producer']['state'])) {
              $producer_address->appendChild(
                new DOMElement('StateProvinceCode', substr($opts['producer']['state'], 0, 5)));
            }

            if (isset($opts['producer']['postal_code'])) {
              $producer_address->appendChild(
                new DOMElement('PostalCode', substr($opts['producer']['postal_code'], 0, 10)));
            }

            $producer_address->appendChild(
              new DOMElement('CountryCode', substr($opts['producer']['country'], 0, 2)));

          } // end producer option is not present conditional
          
        } // end NAFTA CO form requirements conditional

      } // end Contacts

      $products_counter = 0;
      foreach ($opts['products'] as $prod) {
        // no more than 50 products
        if($products_counter == 50) break;

        $product = $international_forms->appendChild(
          new DOMElement('Product'));

        if (!isset($prod['descriptions'])) {
          $product->appendChild(
            new DOMElement('Description', substr($prod['description'], 0, 35)));
        } else {
          $descriptions_counter = 0;
          foreach ($prod['descriptions'] as $desc) {
            // no more than 3 descriptions
            if($descriptions_counter == 3) break;

            $product->appendChild(
              new DOMElement('Description', substr($desc, 0, 35)));
            $descriptions_counter++;
          }
        }

        if (in_array(array('invoice', 'partial_invoice'), $opts['form_codes'])) {
          $unit = $product->appendChild(
            new DOMElement('Unit'));

          $unit->appendChild(
            new DOMElement('Number', $prod['quantity']));

          $unit->appendChild(
            new DOMElement('Value', trim(sprintf("%8.2f", floatval($prod['value'])))));

          $unit_of_measurement = $unit->appendChild(
            new DOMElement('UnitOfMeasurement'));

          $unit_of_measurement_code = (isset($prod['unit']) ? $prod['unit'] : 'other');
          $unit_of_measurement->appendChild(
            new DOMElement('Code', self::$GOOD_UNITS[$unit_of_measurement_code]));

          if ($unit_of_measurement_code == 'other') {
            $unit_of_measurement->appendChild(
              new DOMElement('Description', $prod['unit_of_measurement_description']));
          }

        } // end invoice or partial_invoice form code conditional

        if (isset($prod['commodity_code'])) {
          $product->appendChild(
            new DOMElement('CommodityCode', substr($prod['commodity_code'], 0, 15)));
        }

        if (isset($prod['part_number'])) {
          $product->appendChild(
            new DOMElement('PartNumber', substr($prod['part_number'], 0, 10)));
        }
        
        if (isset($prod['country'])) {
          $product->appendChild(
            new DOMElement('OriginCountryCode', substr($prod['country'], 0, 2)));
        }

        if (isset($prod['joint_production'])) {
          $product->appendChild(
            new DOMElement('JointProductionIndicator'));
        }

        if (in_array('nafta', $opts['fund_codes'])) {
          $net_cost_code = ((isset($prod['net_cost_method']) && $prod['net_cost_method']) ? 'NC' : 'NO');
          $product->appendChild(
            new DOMElement('NetCostCode', $net_cost_code));

          if (isset($prod['net_cost_begin_date'])) {
            $date_range = $product->appendChild(
              new DOMElement('NetCostDateRange'));

            $date_range->appendChild(
              new DOMElement('BeginDate', $prod['net_cost_begin_date']));

            $date_range->appendChild(
              new DOMElement('EndDate', $prod['net_cost_end_date']));
          }

          $product->appendChild(
            // PreferenceCriteria, see XML Shipping Package Developer Guide Appendix I
            new DOMElement('PreferenceCriteria', $prod['preference_criteria']));

          $product->appendChild(
            new DOMElement('ProducerInfo', self::$ORIGIN_OF_GOOD_CODES[$prod['nafta_origin_code']]));
        } // end nafta form code conditional

        if (in_array('co', $opts['form_codes'])) {

          if (isset($prod['marks'])) {
            $product->appendChild(
              new DOMElement('MarksAndNumbers', substr($prod['marks'], 0, 35)));
          }

          $product->appendChild(
            new DOMElement('NumberOfPackagesPerCommodity', substr($prod['package_quantity'], 0, 3)));

        }

        if (in_array(array('co', 'sed'), $opts['form_codes'])) {
          $product_weight = $product->appendChild(
            new DOMElement('ProductWeight'));

          $unit_of_measurement = $product_weight->appendChild(
            new DOMElement('UnitOfMeasurement'));

          $weight_unit = (isset($prod['weight_unit']) ? $prod['weight_unit'] : 'lbs');
          $unit_of_measurement->appendChild(
            new DOMElement('Code', self::$WEIGHT_UNITS[$weight_unit]));

          $unit_of_measurement->appendChild(
            new DOMElement('Description', substr($prod['unit_description'])));

          $product_weight->appendChild(
            new DOMElement('Weight', trim(sprintf("%6.2f", floatval($prod['weight'])))));
        }

        if (in_array('sed', $opts['form_codes'])) {
          if (isset($prod['vin'])) {
            $product->appendChild(
              new DOMElement('VehicleID', $prod['vin']));
          }

          $schedule_b = $product->appendChild(
            new DOMElement('ScheduleB'));

          $schedule_b->appendChild(
            new DOMElement('Number', $prod['schedule_b']['classification_code']));

          $schedule_b_unit = (isset($prod['schedule_b']['unit']) ? $prod['schedule_b']['unit'] : 'no_quantity_required');

          if ($schedule_b_unit != 'no_quantity_required') {
            $schedule_b->appendChild(
              new DOMElement('Quantity', $prod['quantity']));
          }

          $unit_of_measurement = $schedule_b->appendChild(
            new DOMElement('UnitOfMeasurement'));

          $unit_of_measurement->appendChild(
            new DOMElement('Code', self::$SCHEDULE_B_UNITS[$schedule_b_unit]));

          $unit_of_measurement->appendChild(
            new DOMElement('Description', $prod['schedule_b']['unit_description']));

          $product->appendChild(
            new DOMElement('ExportType', self::$EXPORT_TYPES[$prod['export_type']]));

          $product->appendChild(
            new DOMElement('SEDTotalValue', trim(sprintf('%8.2f', floatval($prod['value'])))));

        } // end sed form code conditional

        $products_counter++;
      } // end products foreach

      if (in_array(array('invoice', 'partial_invoice'), $opts['form_codes'])) {
        if (isset($opts['invoice_number'])) {
          $international_forms->appendChild(
            new DOMElement('InvoiceNumber', substr($opts['invoice_number'], 0, 35)));
        }

        if (isset($opts['invoice_date'])) {
          $international_forms->appendChild(
            new DOMElement('InvoiceDate', $opts['invoice_date']));
        }

        if (isset($opts['po_number'])) {
          $international_forms->appendChild(
            new DOMElement('PurchaseOrderNumber', substr($opts['po_number'], 0, 35)));
        }

        if (isset($opts['terms_of_shipment'])) {
          $international_forms->appendChild(
            new DOMElement('TermsOfShipment', self::$TERMS_OF_SHIPMENT[$opts['terms_of_shipment']]));
        }

        if (isset($opts['export_reason'])) {
          $international_forms->appendChild(
            new DOMElement('ReasonForExport', substr(self::$EXPORT_REASONS[$opts['export_reason']], 0, 20)));
        }

        if (isset($opts['comments'])) {
          $international_forms->appendChild(
            new DOMElement('Comments', substr($opts['comments'], 0, 150)));
        }

        if (isset($opts['declaration_statement'])) {
          $international_forms->appendChild(
            new DOMElement('DeclarationStatement', substr($opts['declaration_statement'], 0, 150)));
        }

        if (isset($opts['discount'])) {
          $discount = $international_forms->appendChild(
            new DOMElement('Discount'));

          $discount->appendChild(
            new DOMElement('MonetaryValue', trim(sprintf('%8.2f', floatval($opts['discount'])))));
        }

        if (isset($opts['freight'])) {
          $freight_charges = $international_forms->appendChild(
            new DOMElement('FreightCharges'));

          $freight_charges->appendChild(
            new DOMElement('MonetaryValue', trim(sprintf('%8.2f', floatval($opts['freight'])))));
        }

        if (isset($opts['insurance'])) {
          $insurance_charges = $international_forms->appendChild(
            new DOMElement('InsuranceCharges'));

          $insurance_charges = $international_forms->appendChild(
            new DOMElement('MonetaryValue', trim(sprintf('%8.2f', floatval($opts['insurance'])))));
        }

        if (isset($opts['other_charge'])) {
          $other_charges = $international_forms->appendChild(
            new DOMElement('OtherCharges'));
          $other_charges->appendChild(
            new DOMElement('MonetaryValue', trim(sprintf('%8.2f', floatval($opts['other_charge'])))));
          $other_charges->appendChild(
            new DOMElement('Description', substr($opts['other_charge_description'], 0, 10)));
        }

        $currency_code = (isset($opts['invoice_currency_code']) ? $opts['invoice_currency_code'] : 'USD');
        $international_forms->appendChild(
          new DOMElement('CurrencyCode', $currency_code));

      } // end invoice and partial_invoice form code conditional

      if (in_array('nafta', $opts['form_codes'])) {

        $blanket_period = $international_forms->appendChild(
          new DOMElement('BlanketPeriod'));

        $blanket_period->appendChild(
          new DOMElement('BeginDate', $opts['blanket_begin_date']));

        $blanket_period->appendChild(
          new DOMElement('EndDate', $opts['blanket_end_date']));

      } // end nafta form code conditional

      if (in_array(array('co', 'sed'), $opts['form_codes'])) {
        $international_forms->appendChild(
          new DOMElement('ExportDate', $opts['export_date']));

        $international_forms->appendChild(
          new DOMElement('ExportingCarrier', substr($opts['exporting_carrier'], 0, 35)));
      }

      if (in_array('sed', $opts['form_codes'])) {
        if (isset($opts['carrier_id'])) {
          $international_forms->appendChild(
            new DOMElement('CarrierID', substr($opts['carrier_id'], 0, 17)));
        }

        $bond_code = (isset($opts['bond_code']) ? $opts['bond_code'] : 'not_in_bond');

        $international_forms->appendChild(
          new DOMElement('InBondCode', self::$BOND_CODES[$bond_code]));

        if ($bond_code != 'not_in_bond') {
          $international_forms->appendChild(
            new DOMElement('EntryNumber', $opts['entry_number']));
        }

        $international_forms->appendChild(
          new DOMElement('PointOfOrigin', $opts['point_of_origin']));

        $international_forms->appendChild(
          new DOMElement('ModeOfTransport', self::$MODES_OF_TRANSPORT[$opts['mode_of_transport']]));

        if (isset($opts['port_of_export'])) {
          $international_forms->appendChild(
            new DOMElement('PortOfExport', substr($opts['port_of_export'], 0, 35)));
        }

        if (isset($opts['port_of_unloading'])) {
          $international_forms->appendChild(
            new DOMElement('PortOfUnloading', substr($opts['port_of_unloading'], 0, 35)));
        }

        if (isset($opts['loading_pier'])) {
          $international_forms->appendChild(
            new DOMElement('LoadingPier', substr($opts['loading_pier'], 0, 35)));
        }

        $parties_related = ((isset($opts['parties_related']) && $opts['parties_related']) ? 'R' : 'N');
        $international_forms->appendChild(
          new DOMElement('PartiesToTransaction', $parties_related));

        if (isset($opts['routed_export_transaction']) && $opts['routed_export_transaction']) {
          $international_forms->appendChild(
            new DOMElement('RoutedExportTransactionIndicator'));
        }

        if (isset($opts['containerized']) && $opts['containerized']) {
          $international_forms->appendChild(
            new DOMElement('ContainerizedIndicator'));
        }

        $license = $international_forms->appendChild(
          new DOMElement('License'));

        if (isset($opts['license_number'])) {
          $license->appendChild(
            new DOMElement('Number', substr($opts['license_number'], 0, 35)));

          $license->appendChild(
            new DOMElement('Date', $opts['license_date']));
        } else {
          $license->appendChild(
            new DOMElement('ExceptionCode', substr(self::$LICENSE_EXCEPTION_CODES[$opts['license_exception_code']], 0, 4)));
        }

        if (isset($opts['license_exception_code']) && (in_array($opts['license_exception_code'], array('civ', 'ctp', 'enc', 'kmi', 'lvs')))) {
          $international_forms->appendChild(
            new DOMElement('ECCNNumber', substr($opts['eccn_number'], 0, 8)));
        }

      } // end sed form code conditional

    } // end form_codes conditional

    if (isset($opts['return_of_document']) && $opts['return_of_document']) {
      $shipment_service_options->appendChild(
        new DOMElement('ReturnOfDocumentIndicator'));
    }

    if (isset($opts['import_control_code'])) {
      $label_method = $shipment_service_optoins->appendChild(
        new DOMElement('LabelMethod'));

      $label_method->appendChild(
        new DOMElement('Code', self::$IMPORT_CONTROL_CODES[$opts['import_control_code']]));

      $label_method->appendChild(
        new DOMElement('Description', substr($opts['import_control_description'], 0, 35)));
    }

    if (isset($opts['remove_invoice']) && $opts['remove_invoice']) {
      $shipment_service_options->appendChild(
        new DOMElement('CommercialInvoiceRemovalIndicator'));
    }

    if (isset($opts['carbon_neutral']) && $opts['carbon_neutral']) {
      $shipment_service_options->appendChild(
        new DOMElement('UPScarbonneutral'));
    }

    if (isset($opts['delivery_confirmation'])) {
      $delivery_confirmation = $shipment_service_options->appendChild(
        new DOMElement('DeliveryConfirmation'));
      $delivery_confirmation->appendChild(
        new DOMElement('DCISType', self::$DELIVERY_CONFIRMATION_CODES[$opts['delivery_confirmation']]));
    }

  } // end ShipmentServiceOptions

  if (isset($opts['packages'])) {
    foreach($opts['packages'] as $pkg) {
      $package = $shipment->appendChild(
        new DOMElement('Package'));

      if (isset($pkg['description'])) {
        $package->appendChild(
          new DOMElement('Description', $pkg['description']));
      }

      $packaging_type = $package->appendChild(
        new DOMElement('PackagingType'));

      $type = (isset($pkg['type']) ? $pkg['type'] : 'package');

      $packaging_type->appendChild(
        new DOMElement('Code', self::$PACKAGE_TYPES[$type]));

      if (isset($pkg['packaging_description'])) {
        $packaging_type->appendChild(
          new DOMElement('Description', substr($pkg['packaging_description'], 0, 35)));
      }

      $dimensions = $package->appendChild(
        new DOMElement('Dimensions'));

      $unit_of_measurement = $dimensions->appendChild(
        new DOMElement('UnitOfMeasurement'));

      $length_unit = (isset($pkg['length_unit']) ? $pkg['length_unit'] : 'in');

      $unit_of_measurement->appendChild(
        new DOMElement('Code', self::$LENGTH_UNITS[$length_unit]));

      if (isset($pkg['dimension_description'])) {
        $unit_of_measurement->appendChild(
          new DOMElement('Description', substr($pkg['dimension_description'], 0, 35)));
      }

      $dimensions->appendChild(
        new DOMElement('Length', trim(sprintf("%6.2f", floatval($pkg['length'])))));

      $dimensions->appendChild(
        new DOMElement('Width', trim(sprintf("%6.2f", floatval($pkg['width'])))));

      $dimensions->appendChild(
        new DOMElement('Height', trim(sprintf("%6.2f", floatval($pkg['height'])))));

      if (isset($pkg['weight'])) {
        $package_weight = $package->appendChild(
          new DOMElement('PackageWeight'));

        $weight_unit = (isset($pkg['weight_unit']) ? $pkg['weight_unit'] : 'lbs');

        $package_weight->appendChild(
          new DOMElement('Code', self::$WEIGHT_UNITS[$weight_unit]));

        if (isset($pkg['weight_description'])) {
          $package_weight->appendChild(
            new DOMElement('Description', substr($pkg['weight_description'], 0, 35)));
        }

        $package_weight->appendChild(
          new DOMElement('Weight', trim(sprintf("%6.1f", floatval($pkg['weight'])))));

      } // Weight

      if (isset($pkg['large_package'])) {
        $package->appendChild(
          new DOMElement('LargePackageIndicator'));
      }

      if (isset($pkg['reference_number'])) {
        $reference_number = $package->appendChild(
          new DOMElement('ReferenceNumber'));

        if (isset($pkg['barcode']) && $pkg['barcode']) {
          $reference_number->appendChild(
            new DOMElement('BarCodeIndicator'));
        }

        $reference_number->appendChild(
          new DOMElement('Code', substr($pkg['reference_code'], 0, 2)));

        $reference_number->appendChild(
          new DOMElement('Value', substr($pkg['reference_number'], 0, 35)));
      }

      if (isset($pkg['additional_handling']) && $pkg['additional_handling']) {
        $package->appendChild(
          new DOMElement('AdditionalHandling'));
      }
      
      if (isset($pkg['delivery_confirmation']) ||
          isset($pkg['insured_value']) ||
          isset($pkg['cod_value']) ||
          isset($pkg['verbal_confirmation'])) {

        $package_service_options = $package->appendChild(
          new DOMElement('PackageServiceOptions'));

        if (isset($pkg['delivery_confirmation'])) {
          $delivery_confirmation = $package_service_options->appendChild(
            new DOMElement('DeliveryConfirmation'));

          $delivery_confirmation->appendChild(
            new DOMElement('DCISType', self::$DELIVERY_CONFIRMATION_CODES[$pkg['delivery_confirmation']]));

          if (isset($opts['delivery_confirmation_control_number'])) {
            $delivery_confirmation->appendChild(
              new DOMElement('DCISNumber', substr($pkg['delivery_confirmation_control_number'], 0, 11)));
          }
        } // DeliveryConfirmation

        if (isset($pkg['cod_value'])) {
          $cod = $package_service_options->appendChild(
            new DOMElement('COD'));

          if (isset($pkg['cod_fund_code'])) {
            $cod->appendChild(
              new DOMElement('CODFundsCode', self::$FUND_CODES[$pkg['cod_fund_code']]));
          }

          $cod->appendChild(
            new DOMElement('CODCode', '3'));

          $cod_amount = $cod->appendChild(
            new DOMElement('CODAmount'));

          $cod_currency_code = (isset($pkg['cod_currency_code']) ? $pkg['cod_currency_code'] : 'USD');

          $cod_amount->appendChild(
            new DOMElement('CurrencyCode', $cod_currency_code));

          $cod_amount->appendChild(
            new DOMElement('MonetaryValue', trim(sprintf("%8.2f", floatval($pkg['cod_value'])))));

          $insured_value = $cod->appendChild(
            new DOMElement('InsuredValue'));

          $insured_value->appendChild(
            new DOMElement('CurrencyCode', $cod_currency_code));

          $insured_value->appendChild(
            new DOMElement('MonetaryValue', trim(sprintf("%8.2f", floatval($pkg['cod_insurance'])))));

          if (isset($pkg['cod_control_number'])) {
            $cod->appendChild(
              new DOMElement('ControlNumber', substr($pkg['cod_control_number'], 0, 11)));
          }

        } // COD


        if (isset($opts['verbal_confirmation']) && $opts['verbal_confirmation']) {
          $verbal_confirmation = $package_service_options->appendChild(
            new DOMElement('VerbalConfirmation'));

          if (isset($opts['verbal_confirmation']['name']) ||
              isset($opts['verbal_confirmation']['phone'])) {

            $contact_info = $verbal_confirmation->appendChild(
              new DOMElement('ContactInfo'));

            $name = (isset($opts['verbal_confirmation']['name']) ? $opts['verbal_confirmation']['name'] : $opts['attention_name']);
            $contact_info->appendChild(
              new DOMElement('Name', substr($name, 0, 35)));

            $phone = (isset($opts['verbal_confirmation']['phone']) ? $opts['verbal_confirmation']['phone'] : $opts['phone_number']);
            $contact_info->appendChild(
              new DOMElement('PhoneNumber', substr($phone, 0, 15)));

          } // end verbal_confirmation name or phone conditional
        } // end verbal_confirmation conditional
      } // end deliver_confirmation, insured_value, cod_value, verbal_confirmation

      if (isset($opts['no_signature'])) {
        $package_service_options->appendChild(
          new DOMElement('ShipperReleaseIndicator'));
      }

      if (isset($opts['return_notification'])) {
        $notification = $package_service_options->appendChild(
          new DOMElement('Notification'));

        $notification->appendChild(
          new DOMElement('NotificationCode', '3'));

        $email_message = $notification->appendChild(
          new DOMElement('EMailMessage'));

        if (isset($opts['return_notification']['email'])) {
          $email_message->appendChild(
            new DOMelement('EMailAddress', substr($opts['return_notification']['email'], 0, 50)));
        } else {
          foreach ($opts['return_notification']['email_addresses'] as $email) {
            $email_message->appendChild(
              new DOMElement('EMailAddress', substr($email, 0, 50)));
          }
        }

        // only on first package
        if (array_search($pkg, $opts['packages']) == 0) {
          $from_email = $opts['return_notification']['from_email'];

          $undeliverable_email = (isset($opts['return_notification']['undeliverable_email']) ? $opts['return_notification']['undeliverable_email'] : $from_email);

          $email_message->appendChild(
            new DOMElement('UndeliverableEMailAddress', substr($undeliverable_email, 0, 50)));

          $email_message->appendChild(
            new DOMElement('FromEMailAddress', substr($from_email, 0, 50)));

          if (isset($opts['return_notification']['body'])) {
            $email_message->appendChild(
              new DOMElement('Memo', substr($opts['return_notification']['body'], 0, 150)));
          }
        } // end first package conditional

        if (isset($opts['return_notification']['subject'])) {
          $email_message->appendChild(
            new DOMElement('Subject', substr($opts['return_notification']['subject'], 0, 50)));
        }

        if (isset($opts['return_notification']['subject_code'])) {
          $email_message->appendChild(
            new DOMElement('SubjectCode', substr(self::$SUBJECT_CODES[$opts['return_notification']['subject_code']], 0, 2)));
        }
      } // end return_notification conditional

      if (isset($opts['returns_flexible_access']) && $opts['returns_flexible_access']) {
        $package_service_options->appendChild(
          new DOMElement('ReturnsFlexibleAccessIndicator'));
      }
          
    } // end packages foreach

    // end packages conditional
  } else {

    // build a fake package

    $package = $shipment->appendChild(
      new DOMElement('Package'));

    $packaging_type = $package->appendChild(
      new DOMElement('PackagingType'));

    $package_type = (isset($opts['package_type']) ? $opts['package_type'] : 'package');

    $packaging_type->appendChild(
      new DOMElement('Code', self::$PACKAGE_TYPES[$package_type]));

    $packaging_type->appendChild(
      new DOMElement('Description', '(Default) Medium Express Box'));

    $package->appendChild(
      new DOMElement('Description', 'Default Generated Package'));

    $package_weight = $package->appendChild(
      new DOMElement('PackageWeight'));

    $unit_of_measurement = $package_weight->appendChild(
      new DOMElement('UnitOfMeasurement'));

    $weight_unit = (isset($opts['weight_unit']) ? $opts['weight_unit'] : 'lbs');

    $unit_of_measurement->appendChild(
      new DOMElement('Code', self::$WEIGHT_UNITS[$weight_unit]));

    $package_weight->appendChild(
      new DOMElement('Weight', trim(sprintf('%6.1f', floatval($opts['weight'])))));
  }

  $label_spec = $confirm_request->appendChild(
    new DOMElement('LabelSpecification'));

  $label_print_method = $label_spec->appendChild(
    new DOMElement('LabelPrintMethod'));

  $label_code = (isset($opts['label_code']) ? $opts['label_code'] : 'gif');
  $label_print_method->appendChild(
    new DOMElement('Code', self::$LABEL_CODES[$label_code]));

  if (isset($opts['label_description'])) {
    $label_print_method->appendChild(
      new DOMElement('Description', $opts['label_description']));
  }

  if ($label_code == 'gif') {

    $user_agent = (isset($opts['label_user_agent']) ? $opts['label_user_agent'] : 'Mozilla/4.5');

    $label_spec->appendChild(
      new DOMElement('HTTPUserAgent', substr($user_agent, 0, 64)));

    $label_image_format = $label_spec->appendChild(
      new DOMElement('LabelImageFormat'));

    $label_image_format->appendChild(
      new DOMElement('Code', 'GIF'));

    if (isset($opts['label_format_description'])) {
      $label_image_format->appendChild(
        new DOMElement('Description', $opts['label_format_description']));
    }

  } else {

    $label_stock_size = $label_spec->appendChild(
      new DOMElement('LabelStockSize'));

    $label_stock_size->appendChild(
      new DOMElement('Height', '4'));

    $label_stock_size->appendChild(
      new DOMElement('Width', '6'));

  } // is gif

  return $doc->saveXML();
}

function parse_confirm_response($resp, $opts) {
  $xml = simplexml_load_string($resp);
  if (self::is_error_response($xml)) return self::error_from($xml);
  $response = array(
    'success' => true,
    'total' => self::total_charges($xml),
    'id' => (string) $xml->ShipmentIdentificationNumber,
    'digest' => (string) $xml->ShipmentDigest
  );
  return $response;
}

function accept_request($confirm_resp, $opts) {
  $doc = new DOMDocument('1.0');  
  $accept_request = $doc->appendChild(
    new DOMElement('ShipmentAcceptRequest'));
  $accept_request->setAttributeNode(
    new DOMAttr('xml:lang', 'en-US'));
  $request = $accept_request->appendChild(
    new DOMElement('Request'));
  $request->appendChild(
    new DOMElement('RequestAction', 'ShipAccept'));
  if (isset($opts['customer_context'])) {
    $transaction_reference = $request->appendChild(
      new DOMElement('TransactionReference'));
    $transaction_reference->appendChild(
      new DOMElement('CustomerContext', substr($opts['customer_context'], 0, 50)));
  }
  $accept_request->appendChild(
    new DOMElement('ShipmentDigest', $confirm_resp['digest']));
  return $doc->saveXML();  
}

function parse_accept_response($resp, $opts) {
  $xml = simplexml_load_string($resp);
  if (self::is_error_response($xml)) return self::error_from($xml);
  $raw_total = (string) $xml->ShipmentResults->ShipmentCharges->GrandTotal->MonetaryValue;
  $grandtotal = floatval($raw_total);
  $shipment_id = (string) $xml->ShipmentResults->ShipmentIdentificationNumber;

  $response = array(
    'success' => true,
    'grand_total' => $grandtotal,
    'id' => $shipment_id
  );
  
  // TODO
  // if (($opts['insured_value'] >= 999) && ($opts['insured_value'] <= 50000)) {
  //    $control_receipt_image = (string) $xml->ShipmentResults->ControlLogReceipt->GraphicImage;
  // }

  $packages = $xml->xpath('//ShipmentAcceptResponse/ShipmentResults/PackageResults');
  $response['packages'] = array();
  foreach ($packages as $package) {

    // FIXME
    // Extremely limited response parsing going on here.
    // Just assumes you selected 'GIF' as the label type and there aren't
    // any other requirements (ImportControl, etc.)
    $tracking_number = (string) $package->TrackingNumber;
    $image = (string) $package->LabelImage->GraphicImage;
    $html_image = (string) $package->LabelImage->HTMLImage;
    if ($package->xpath('Receipt')) {
      $receipt_image = (string) $package->Receipt->Image->GraphicImage;
    }

    $pkg = array();
    $pkg['tracking_number'] = $tracking_number;
    $pkg['image'] = $image;
    $pkg['html_image'] = $html_image;

    if (isset($receipt_image)) {
      $pkg['receipt_image'] = $receipt_image;
    }

    $response['packages'][] = $pkg;
  }
  return $response;
}

// TODO
// function void_shipment_request($opts) {
//   
// }

// TODO
// function parse_void_shipment_response($resp, $opts) {
// 
// }

function is_error_response($xml) {
  if (empty($xml)) return true;
  $status_code = (string) $xml->Response->ResponseStatusCode;
  return (!$status_code || (intVal($status_code) == 0));
}

function error_from($xml) {
  if (empty($xml)) {
    $error = array(
      'error' => array(
        'description' => 'Communication with UPS failed.'
      )
    );
  } else {
    $error = array(
      'status_code' => (string) $xml->Response->ResponseStatusCode,
      'status_description' => (string) $xml->Response->ResponseStatusDescription,
      'error' => array(
        'severity' => (string) $xml->Response->Error->ErrorSeverity,
        'code' => (string) $xml->Response->Error->ErrorCode,
        'description' => (string) $xml->Response->Error->ErrorDescription,
        'location' => (string) $xml->Response->Error->ErrorLocation->ErrorLocationElementName
      )
    );
  }
  $error_response = array(
    'success' => false,
    'error_response' => $error
  );
  return $error_response;
}

function total_charges($xml) {
  $total_charges_raw = (string) $xml->ShipmentCharges->TotalCharges->MonetaryValue;
  $total_charges = floatval($total_charges_raw);
  return $total_charges;
}

function http_client_post_xml($service, $xml, $opts) {

  $url = ((isset($opts['test']) && $opts['test']) ? self::TESTING_URL : self::URL) . $service;

  $client = curl_init($url);
  curl_setopt_array($client, array(
    CURLOPT_VERBOSE => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $xml,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HEADER => false,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: text/xml; charset=utf-8',
      'Content-Length: ' . strlen($xml)
    )
  ));

  $resp = curl_exec($client);
  curl_close($client);

  return $resp;
}

function validate_options($opts, $required) {
  $matching_keys = array_intersect(array_keys($opts), $required);
  if (count($matching_keys) != count($required)) {
    throw new Exception("Error: missing required options");
  }
}

} // ups_shipping class

?>
