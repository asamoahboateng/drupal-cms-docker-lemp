<?php

namespace Drupal\Tests\webform\Functional\Element;

use Drupal\field\Entity\FieldStorageConfig;
use Drupal\webform\Entity\Webform;

/**
 * Tests for webform address element.
 *
 * @group webform
 */
class WebformElementAddressTest extends WebformElementBrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  protected static $modules = ['webform', 'address', 'node'];

  /**
   * Webforms to load.
   *
   * @var array
   */
  protected static $testWebforms = ['test_element_address'];

  /**
   * Tests address element.
   */
  public function testAddress() {
    $this->drupalLogin($this->rootUser);

    $assert_session = $this->assertSession();

    $webform = Webform::load('test_element_address');

    /* ********************************************************************** */
    // Rendering.
    /* ********************************************************************** */

    $this->drupalGet('/webform/test_element_address');

    // Check basic fieldset wrapper.
    $assert_session->responseContains('<fieldset data-drupal-selector="edit-address" id="edit-address--wrapper" class="address--wrapper fieldgroup form-composite webform-composite-hidden-title js-webform-type-address webform-type-address js-form-item form-item js-form-wrapper form-wrapper">');
    $assert_session->responseContains('<span class="visually-hidden fieldset-legend">address_basic</span>');

    // Check advanced fieldset, legend, help, and description.
    $assert_session->responseContains('<fieldset data-drupal-selector="edit-address-advanced" aria-describedby="edit-address-advanced--wrapper--description" id="edit-address-advanced--wrapper" class="address--wrapper fieldgroup form-composite webform-composite-visible-title webform-element-help-container--title webform-element-help-container--title-after js-webform-type-address webform-type-address js-form-item form-item js-form-wrapper form-wrapper">');
    $assert_session->responseContains('<span class="fieldset-legend">address_advanced<span class="webform-element-help js-webform-element-help" role="tooltip" tabindex="0" aria-label="address_advanced" data-webform-help="&lt;div class=&quot;webform-element-help--title&quot;&gt;address_advanced&lt;/div&gt;&lt;div class=&quot;webform-element-help--content&quot;&gt;This is help text&lt;/div&gt;"><span aria-hidden="true">?</span></span>');
    $assert_session->responseContains('<div class="description"><div id="edit-address-advanced--wrapper--description" data-drupal-field-elements="description" class="webform-element-description">This is a description</div>');

    /* ********************************************************************** */
    // Processing.
    /* ********************************************************************** */

    // Check submitted value.
    $sid = $this->postSubmission($webform);
    $submission = $this->loadSubmission($sid);
    $data = $submission->getData();
    $this->assertEquals([
      'additional_name' => '',
      'address_line1' => '1098 Alta Ave',
      'address_line2' => '',
      'address_line3' => '',
      'administrative_area' => 'CA',
      'country_code' => 'US',
      'dependent_locality' => '',
      'family_name' => 'Smith',
      'given_name' => 'John',
      'langcode' => 'en',
      'locality' => 'Mountain View',
      'organization' => 'Google Inc.',
      'postal_code' => '94043',
      'sorting_code' => '',
    ], $data['address']);
    $this->assertEquals([
      'additional_name' => '',
      'address_line1' => '1098 Alta Ave',
      'address_line2' => '',
      'address_line3' => '',
      'administrative_area' => 'CA',
      'country_code' => 'US',
      'dependent_locality' => '',
      'family_name' => '',
      'given_name' => '',
      'langcode' => 'en',
      'locality' => 'Mountain View',
      'organization' => '',
      'postal_code' => '94043',
      'sorting_code' => '',
    ], $data['address_advanced']);
    $this->assertEquals([
      [
        'address_line1' => '1098 Alta Ave',
        'address_line2' => '',
        'address_line3' => '',
        'administrative_area' => 'CA',
        'country_code' => 'US',
        'family_name' => 'Smith',
        'given_name' => 'John',
        'langcode' => 'en',
        'locality' => 'Mountain View',
        'organization' => 'Google Inc.',
        'postal_code' => '94043',
      ],
    ], $data['address_multiple']);

    // Check text formatting.
    $this->drupalGet("/admin/structure/webform/manage/test_element_address/submission/$sid/text");
    $assert_session->responseContains('address_basic:
John Smith
Google Inc.
1098 Alta Ave
Mountain View, CA 94043
United States

address_advanced:
1098 Alta Ave
Mountain View, CA 94043
United States

address_none:
{Empty}

address_multiple:
- John Smith
  Google Inc.
  1098 Alta Ave
  Mountain View, CA 94043
  United States');

    /* ********************************************************************** */
    // Schema.
    /* ********************************************************************** */

    $field_storage = FieldStorageConfig::create([
      'entity_type' => 'node',
      'field_name' => 'address',
      'type' => 'address',
    ]);
    $schema = $field_storage->getSchema();

    /** @var \Drupal\webform\Plugin\WebformElementManagerInterface $element_manager */
    $element_manager = \Drupal::service('plugin.manager.webform.element');
    /** @var \Drupal\webform\Plugin\WebformElement\Address $element_plugin */
    $element_plugin = $element_manager->getElementInstance(['#type' => 'address']);

    // Get webform address element plugin.
    $element = [];
    $element_plugin->initializeCompositeElements($element);

    // Check composite elements against address schema.
    $composite_elements = $element['#webform_composite_elements'];
    $diff_composite_elements = array_diff_key($composite_elements, $schema['columns']);
    $this->assertEmpty($diff_composite_elements);

    // Check composite elements maxlength against address schema.
    foreach ($schema['columns'] as $column_name => $column) {
      // @todo Add support for address_line3.
      if ($column_name === 'address_line3') {
        continue;
      }
      $this->assertEquals($composite_elements[$column_name]['#maxlength'], $column['length'], $column_name . ' does not match');
    }
  }

}
