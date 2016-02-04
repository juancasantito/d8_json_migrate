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
class GmapTypeJSONReader extends JSONReader {

  /**
   * {@inheritdoc}
   */
  public function getSourceFields($url) {
    $items = parent::getSourceFields($url);
    $return = [];
    // Loop over the JSON values and extract types
    // as individual rows.
    foreach ($items as &$item) {
      if (isset($item['types']) && is_array($item['types'])) {
        foreach ($item['types'] as $type)
        // We need to use place_id as the identifier for parsing JSON
        // in the parent class.
        // But we are really wanting to import an individual type
        // only once. So over-write the place_id with the type.
        $return[] = [
          'place_id' => $type,
          'type' => $type,
        ];

      }
    }

    return $return;
  }
}
