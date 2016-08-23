<?php

namespace Models;

class Model {

  function __construct($props = []) {
    if (!empty($props) && $this->isAssoc($props)) {
      $this->setAssoc($props);
    }
  }

  public function get($prop) {
    return $this->$prop;
  }

  public function set($prop, $val) {
    $this->$prop = $val;
    return $this->$prop;
  }

  public function setAssoc($assoc) {
    // loop over the associative array
    foreach ($assoc as $key => $value) {
      // set the prop on the object
      $this->set($key, $value);
      if ( in_array( $key, $this->schema ) && $this->schema[$key] !== 'json' ) {
        // cast each value in $this->schema
        settype($this->$key, $this->schema[$key]);
      } elseif ( in_array( $key, $this->schema ) && $this->schema[$key] === 'json' ) {
        // special case to parse json
        json_decode($this->$key, true);
      } // end conditionals
    } // end foreach
  } // end setAssoc

  public function isAssoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
  }

  public function parseDate($dateString, $format = '') {
    if (!empty($format)) {
      return date($format, strtotime($dateString));
    } else {
      return strtotime($dateString);
    }
  }

  public function render($template) {
    $searchStrings = []; $replacements = [];
    foreach ($this as $key => $value) {
      array_push($searchStrings, "{{{$key}}}");
      if (is_array($value)) {
        $arrayConversion = implode(', ', $value);
        array_push($replacements, $arrayConversion);
      } else {
        array_push($replacements, $value);
      }
    }
    return str_replace($searchStrings, $replacements, $template);
  }

  # ['prop' => 'type']
  public $schema = [
    // BOOLEANS
    'deleted'           => 'boolean',
    'used'              => 'boolean',
    'deleted'           => 'boolean',
    'notified'          => 'boolean',
    'canInvite'         => 'boolean',
    'published'         => 'boolean',
    'reviewed'          => 'boolean',
    'matureContent'     => 'boolean',
    'isApproved'        => 'boolean',
    'tosAccepted'       => 'boolean',
    'hasOnboarded'      => 'boolean',
    'resolutionIsValid' => 'boolean',
    // INTEGERS
    'id'                 => 'integer',
    'fileID'             => 'integer',
    'productID'          => 'integer',
    'productClassID'     => 'integer',
    'sellerID'           => 'integer',
    'orderID'            => 'integer',
    'jobID'              => 'integer',
    'qty'                => 'integer',
    'invitedBy'          => 'integer',
    'totalItems'         => 'integer',
    'sqFeet'             => 'integer',
    'linFeet'            => 'integer',
    'resolution'         => 'integer',
    'sortOrder'          => 'integer',
    'permissionsLevel'   => 'integer',
    'reviewReqTimestamp' => 'integer',
    'favorites'          => 'integer',
    'ac_reviews'         => 'integer',
    'ac_score'           => 'integer',
    'ac_mature_content'  => 'integer',
    'lastOffset'         => 'integer',
    'count'              => 'integer',
    // FLOATS
    'price'           => 'float',
    'totalPrice'      => 'float',
    'totalRetail'     => 'float',
    'totalCommission' => 'float',
    'unitPrice'       => 'float',
    'unitRetail'      => 'float',
    'unitCommission'  => 'float',
    'price'           => 'float',
    'salePrice'       => 'float',
    'priceTotal'      => 'float',
    'retailPrice'     => 'float',
    'commission'      => 'float',
    'largestDim'      => 'float',
    // JSON objects
    'dims'            => 'json',
    'metaData'        => 'json',
    'finishing'       => 'json',
    'moods'           => 'json',
    'tags'            => 'json',
    'categories'      => 'json',
    'reviewedFileIDs' => 'json',
    // DATE FORMAT
    'created' => 'date',
    'modified' => 'date',
    'placedOn' => 'date',
  ];

  public $dateFormat = 'Y-m-d H:i:s';

}
