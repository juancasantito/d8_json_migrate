<?php

/**
 * @file
 * Contains Drupal\d8_json_migrate\Plugin\migrate\GmapJSONReader.
 */

namespace Drupal\d8_json_migrate\Plugin\migrate;

use Drupal\migrate_source_json\Plugin\migrate\JSONReader;

/**
 * Object to retrieve and iterate over Gmap JSON data.
 */
class GmapJSONReader extends JSONReader {

  /**
   * {@inheritdoc}
   */
  public function getSourceFields($url) {
    $items = parent::getSourceFields($url);
    // Loop over the JSON values, walk the tree and extract as keyed values.
    foreach ($items as &$item) {
      if (isset($item['address_components']) && is_array($item['address_components'])) {
        foreach ($item['address_components'] as $component) {
          if (isset($component['long_name']) && isset($component['types']) && is_array($component['types'])) {
            foreach ($component['types'] as $type) {
              $item[$type] = $component['long_name'];
            }
          }
        }
      }
      if (isset($item['geometry']['location']['lat'])) {
        $item['lat'] = $item['geometry']['location']['lat'];
      }
      if (isset($item['geometry']['location']['lng'])) {
        $item['lng'] = $item['geometry']['location']['lng'];
      }
    }

    return $items;
  }
}
