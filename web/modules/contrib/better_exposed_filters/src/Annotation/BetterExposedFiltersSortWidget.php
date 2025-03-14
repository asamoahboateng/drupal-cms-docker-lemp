<?php

namespace Drupal\better_exposed_filters\Annotation;

use Drupal\Component\Annotation\Plugin;
use Drupal\Core\Annotation\Translation;

/**
 * Defines a Better exposed filters sort widget item annotation object.
 *
 * @see \Drupal\better_exposed_filters\Plugin\BetterExposedFiltersSortWidgetManager
 * @see plugin_api
 *
 * @Annotation
 */
class BetterExposedFiltersSortWidget extends Plugin {


  /**
   * The plugin ID.
   *
   * @var string
   */
  public string $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public Translation $label;

}
