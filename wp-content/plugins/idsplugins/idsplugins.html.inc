<?php 

define('IDS_PLUGINS_SCRIPTS_PATH', 'scripts/');

/*-------------------------------------  Generic template tags functions -------------------------------------*/

// Prints the value (or values) of a field.
function ids_field($field_name, $before='', $after='', $format='', $separator=', ') {
  $field = ids_get_field($field_name, $format, $separator);
  if ($field) {
    echo $before . $field . $after;
  }
}

// Returns a string with the value (or values) of a field based on its name (joined by the separator).
function ids_get_field($field_name, $format='', $separator=', ') {
  global $post;
  $fields = (isset($post->{$field_name}) ? $post->{$field_name} : get_post_meta($post->ID, $field_name));
  if (is_array($fields)) {
    $array_fields=array();
    foreach ($fields as $field) {
      $array_fields[] = ids_format_field($field, $format);
    }
    $fields = implode($separator, $array_fields);
  }
  else {
    $fields = ids_format_field($fields, $format);
  }
  return $fields;
}

// Prints HTML with links to IDS categories.
function ids_categories($category, $before='', $after='', $separator=', ', $base_url='') {
  $categories = ids_get_categories($category, $before, $after, $separator, $base_url);
  if ($categories) {
    echo $categories;
  }
}

// Retrieves a string (with HTML format) with links to IDS categories.
function ids_get_categories($category, $before='', $after='', $separator=', ', $base_url='') {
  global $post;
  $taxonomy = "ids_$category";
  $results = (isset($post->{$taxonomy}) ? $before. implode($separator, ids_links_category($post->{$taxonomy}, $base_url)) . $after : ids_get_list_categories($post->ID, $category, $before, $separator, $after));
  if (!is_wp_error($results)) {
    return $results;
  }
  else {
    return '';
  }
}

/*----------------------------------------  Specific template tag functions -------------------------------- */
/*** These functions are deprecated and left only for backwards compatibility. Use the generic ones, above ***/

// ids_acronym
function ids_acronym($before='', $after='') {
  $acronym = ids_get_acronym();
  if ($acronym) {
    echo $before . $acronym . $after;
  }
}

// ids_get_acronym
function ids_get_acronym() {
  global $post;
  $acronym = (isset($post->acronym) ? $post->acronym : get_post_meta($post->ID, 'acronym', TRUE));
  return $acronym;
}

// ids_location_country
function ids_location_country($before='', $after='') {
  $location_country = ids_get_location_country();
  if ($location_country) {
    echo $before . $location_country . $after;
  }
}

// ids_get_location_country
function ids_get_location_country() {
  global $post;
  $location_country = (isset($post->location_country) ? $post->location_country : get_post_meta($post->ID, 'location_country', TRUE));
  return $location_country;
}

// ids_organisation_type
function ids_organisation_type($before='', $after='') {
  $organisation_type = ids_get_organisation_type();
  if ($organisation_type) {
    echo $before . $organisation_type . $after;
  }
}

// ids_get_organisation_type
function ids_get_organisation_type() {
  global $post;
  $organisation_type = (isset($post->organisation_type) ? $post->organisation_type : get_post_meta($post->ID, 'organisation_type', TRUE));
  return $organisation_type;
}

// ids_authors
function ids_authors($before='', $sep=', ', $after='') {
  $authors = ids_get_authors();
  if ($authors) {
    echo $before . $authors . $after;
  }
}

// ids_get_authors
function ids_get_authors($sep=', ') {
  global $post;
  $authors = (isset($post->authors) ? $post->authors : get_post_meta($post->ID, 'authors', FALSE));
  if (is_array($authors)) {
    $authors = implode($sep, $authors);
  }
  return $authors;
}

// ids_organisation_url
function ids_organisation_url($before='', $after='') {
  $organisation_url = ids_get_organisation_url();
  if ($organisation_url) {
    echo $before . ids_new_html_link($organisation_url, $organisation_url) . $after;
  }
}

// ids_get_organisation_url
function ids_get_organisation_url() {
  global $post;
  $organisation_url = (isset($post->organisation_url) ? $post->organisation_url : get_post_meta($post->ID, 'organisation_url', TRUE));
  return $organisation_url;
}

// ids_get_date_updated
function ids_get_date_updated() {
  global $post;
  $date = (isset($post->date_updated) ? $post->date_updated : get_post_meta($post->ID, 'date_updated', TRUE));
  if ($date) {
    if (is_numeric($date)) { // for backwards compatibility.
      $date = date_i18n(get_option('date_format'), $date);
    }
  }
  return $date;
}

// ids_date_created
function ids_date_created($before='', $after='') {
  $date = ids_get_date_created();
  if ($date) {
    echo $before . $date . $after;
  }
}

// ids_get_date_created
function ids_get_date_created() {
  global $post;
  $date = (isset($post->date_created) ? $post->date_created : get_post_meta($post->ID, 'date_created', TRUE));
  if ($date) {
    if (is_numeric($date)) { // for backwards compatibility.
      $date = date_i18n(get_option('date_format'), $date);
    }
  }
  return $date;
}

// ids_date_updated
function ids_date_updated($before='', $after='') {
  $date = ids_get_date_updated();
  if ($date) {
    echo $before . $date . $after;
  }
}

// ids_external_urls
function ids_external_urls($before='', $sep=', ', $after='') {
  $urls = ids_get_external_urls();
  if (is_array($urls)) {
    $urls = implode($sep, array_map('ids_new_html_link', $urls, $urls));
  }
  else {
    $urls = ids_new_html_link($urls, $urls);
  }
  if ($urls) {
    echo $before . $urls . $after;
  }
}

// ids_get_external_urls
function ids_get_external_urls() {
  global $post;
  $urls = (isset($post->urls) ? $post->urls : get_post_meta($post->ID, 'urls', FALSE));
  return $urls;
}


// ids_countries
function ids_countries($before='', $sep=', ', $after='', $base_url='') {
  $countries = ids_get_countries($before, $sep, $after, $base_url);
  if ($countries) {
    echo $countries;
  }
}

// ids_get_countries
function ids_get_countries($before='', $sep=', ', $after='', $base_url='') {
  return ids_categories('countries', $before='', $sep=', ', $after='', $base_url='');
}

// ids_regions
function ids_regions($before='', $sep=', ', $after='', $base_url='') {
  $regions = ids_get_regions($before, $sep, $after, $base_url);
  if ($regions) {
    echo $regions;
  }
}

// ids_get_regions
function ids_get_regions($before='', $sep=', ', $after='', $base_url='') {
  return ids_categories('regions', $before='', $sep=', ', $after='', $base_url='');
}

// ids_themes
function ids_themes($before='', $sep=', ', $after='', $base_url='') {
  $themes = ids_get_themes($before, $sep, $after, $base_url);
  if ($themes) {
    echo $themes;
  }
}

// ids_get_themes
function ids_get_themes($before='', $sep=', ', $after='', $base_url='') {
  return ids_categories('regions', $before='', $sep=', ', $after='', $base_url='');
}

//-------------------- Functions used to generate/format the output --------------------

// Given a category object, returns a link to it. Used in idsview_documents/idsview_organisations.
function ids_links_category($categories, $baseurl='') {
  global $post;
  $links = array();
  if (empty($baseurl)) {
    $baseurl = get_page_link($post->ID);
  }
  $par = ((preg_match('[\?]', $baseurl)) ? '&' : '?');
  foreach ($categories as $category) {
    if (isset($category->name) && isset ($category->object_type) && isset($category->object_id)) {
      $object_type = strtolower($category->object_type);
      $category_name = rtrim($category->name, " ($category->object_id)");
      $url = '<a href="'. $baseurl . $par . $object_type . "=$category->object_id" . '">' . $category_name . '</a>';
      $links[] = $url;
    }
  }
  return $links;
}

// ids_format_field
function ids_format_field($field, $format) {
  if (is_array($format)) {
    list($format_type, $format_data) = $format;
  }
  else {
    $format_type = $format;
    $format_data = '';
  }
  switch ($format_type) {
    case 'date':
      if (!is_numeric($field)) {
        $field = strtotime($field);
      }
      if (!$format_data) {
        $format_data = get_option('date_format');
      }
      $field = date_i18n($format_data, $field);
      break;
    case 'link':
        $field = ids_new_html_link($field, $format_data);
        break;
  }
  return $field;
}

// Create and return link
function ids_new_html_link($link, $text='') {
  if (!$text) {
    $text = $link;
  }
  return '<a href="' . esc_url( $link ) . '" rel="tag">' . $text . '</a>';
}

// Generate array of categories that correspond to the indicated dataset.
function ids_get_category_array($api_key, $dataset, $category) {
  $idsapi = new IdsApiWrapper;
  switch ($category) {
    case 'countries':
      $array_category = $idsapi->search('countries', $dataset, $api_key)->getArrayTitles();
      break;
    case 'regions': 
      $array_category = $idsapi->search('regions', $dataset, $api_key)->getArrayTitles();
      break;
    case 'themes': 
      $array_category = $idsapi->search('themes', $dataset, $api_key)->getArrayTitles('--');
      break;
  }
  return $array_category;
}

// Returns IDS categories attached to post (the post could have been assigned both Eldis and Bridge categories).
function ids_get_list_categories($post_id, $category, $before, $sep, $after) {
  global $ids_datasets;
  $terms='';
  if (!get_page_template_slug($post_id)) {
    foreach ($ids_datasets as $dataset) {
      $taxonomy_name = $dataset . '_' . $category;
      if (taxonomy_exists($taxonomy_name)) {
        if ($list_terms = get_the_term_list($post_id, $taxonomy_name, $before, $sep, $after)) {
          $terms .= $list_terms;
        }
      }
    }
  }
  return $terms;
}

//-------------------- Generation of HTML and javascript code -------------------

// Shows a message to the user at the top of an admin page.
function ids_show_message($message, $visibility='block') {
?>
  <div class="updated" style="display:<?php echo $visibility; ?>>;">
    <p>
    <?php
      echo $message;
    ?>
    </p>
  </div>
<?php
}

// Generate select boxes.
function  ids_select_box($select_name, $id, $items, $selected_values = array(), $attributes=array()) {
	$html = "<select id='$id' name='$select_name'";
  if (!empty($attributes)) {
    foreach ($attributes as $attr_name => $attr_value) {
      $html .= ' ' . $attr_name . '="' . $attr_value . '"';
    }
  }
  $html .= '>';
	foreach($items as $key => $value) {
    $html .= "<option value='$key' ";
    if (in_array($key, $selected_values)) {
      $html .= 'selected';
    }
    $html .= '>';
    $html .= $value;
    $html .= '</option>';
	}
	$html .= '</select>';
  return $html;
}

// Generate input field.
// TODO: Generalize.
function ids_input_field($name, $size, $value, $id, $label, $description, $class_field, $required) {
	$html  = "<input name='$name' id='$id' class='$class_field' type='text' value='$value' size='$size' aria-required='$required' />";
	$html .= "<p class='description'>$description</p>";
  return $html;
}

// Generate <tr> field wrapper.
// TODO: Generalize.
function ids_tr_field_wrapper($class, $field_name, $label, $contents) {
	$html  = "<tr class='$class'>";
	$html .= "	<th scope='row' valign='top'>";
	$html .= "		<label for='$field_name'>$label</label>";
	$html .= "	</th>";
	$html .= "	<td>";
  $html .= "    $contents";
	$html .= "	</td>";
	$html .= "</tr>";
  return $html;
}

// Generate <div> field wrapper.
// TODO: Generalize.
function ids_div_field_wrapper($class, $field_name, $label, $contents) {
	$html  = "<div class='$class'>";
  if ($field_name && $label) {
    $html .= "	<label for='$field_name'>$label</label>";
  }
  $html .= "    $contents";
	$html .= "</div>";
  return $html;
}



// Creates javascript arrays from category arrays retrieved by the API.
function ids_js_array($array_category) {
  $js_code = array();
  foreach ($array_category as $key => $value) {
    $value = addslashes($value);
    $js_code[] = "'$key':'$value'";
  }
  $js_array = "{\n" . implode(",\n", $js_code) . '};';
  return $js_array;
}

// Load themes to populate tree in the "settings" page.
function ids_js_tree($type, $dataset, $api_key) {
  $idsapi = new IdsApiWrapper;
  $response = $idsapi->search($type, $dataset, $api_key, 'short', 0, 0, array('archived' => 'false', 'level' => 1));
  $results = array();
  $url = plugins_url('idsapi.trees.php', __FILE__);
  $url .= '?token_guid=' . $api_key . '&site=' . $dataset .'&type=' . $type;
  if (!$response->isError()) {
    foreach ($response->results as $item) {
      $results[] = "{ 'label': '$item->title', 'value': '$item->object_id', 'items': [{ 'value': '$url&id=$item->object_id', 'label': 'Loading...' }] }";
    }
  }
  $output = implode(",\n", $results);
  $output = "[\n" . $output . "\n]";
  return $output;
}


// Converts a PHP array into a javascript one.
function ids_php2js($php_array = array()) {
  if (empty($php_array)) {
    $js_array = '{}';
  }
  else {
    $js_array = "['" . implode("','", $php_array) . "']";
  }
  return $js_array;
}

// Initialize category arrays for each dataset in a javascript variable, default dataset and keep track of selected categories.
function ids_init_javascript($plugin, $api_key='', $api_key_validated = FALSE, $default_dataset = IDS_API_DEFAULT_DATASET, $categories = array(), $categories_mappings = array(), $default_user = FALSE) {
  global $ids_datasets;
  ?>
  <script type="text/javascript">
  var $jqorig = jQuery.noConflict();
  var $jqtree = jQuery.noConflict();
  var $jqchosen = jQuery.noConflict();
  </script>
  <script type="text/javascript">
  ids_plugin = '<?php echo $plugin; ?>';
  default_dataset = '<?php echo $default_dataset; ?>';
  ids_array_trees_themes = {'eldis':{}, 'bridge':{}};
  ids_array_categories = {'eldis':{'countries':{}, 'regions':{}, 'themes':{}}, 'bridge':{'countries':{}, 'regions':{}, 'themes':{}}};
  ids_array_categories_mappings = {'eldis':{'countries':{}, 'regions':{}, 'themes':{}}, 'bridge':{'countries':{}, 'regions':{}, 'themes':{}}};
  selected_categories_mappings = {'eldis':{}, 'bridge':{}};
  selected_categories = {'eldis':{}, 'bridge':{}};
  /* Arrays with previously selected category filters and mappings */
  <?php foreach ($ids_datasets as $dataset) { ?>
    <?php if (!empty($categories)) { ?>
      selected_categories['<?php echo $dataset; ?>'] = {
        'countries':<?php echo ids_php2js($categories['countries'][$dataset]); ?>,
        'regions':<?php echo ids_php2js($categories['regions'][$dataset]); ?>,
        'themes':<?php echo ids_php2js($categories['themes'][$dataset]); ?>
      };
    <?php } ?>
    <?php if (!empty($categories_mappings)) { ?>
      selected_categories_mappings['<?php echo $dataset; ?>'] = {
        'countries':<?php echo ids_php2js($categories_mappings['countries'][$dataset]); ?>,
        'regions':<?php echo ids_php2js($categories_mappings['regions'][$dataset]); ?>,
        'themes':<?php echo ids_php2js($categories_mappings['themes'][$dataset]); ?>
      };
    <?php } ?>
  <?php } ?>

  function initCategoriesArrays() {
  <?php
  $ids_array_categories = array();
  if ($api_key_validated) {
    $types_category = array_keys($categories);
    foreach ($ids_datasets as $dataset) {
      $ids_array_categories[$dataset] = array('countries', 'regions', 'themes');
      foreach ($types_category as $category) {
        $ids_array_categories[$dataset][$category] = ids_get_category_array($api_key, $dataset, $category);
        // Populate the sources of the select boxes for categories in filters and mappings.
        echo "\nids_array_categories['$dataset']['$category'] = " . ids_js_array($ids_array_categories[$dataset][$category]);
      }
      // Populate sources of the tree widgets.
      echo "\nids_array_trees_themes['$dataset'] = " . ids_js_tree($category, $dataset, $api_key);
    } 
  }
  ?>
  }
  
  <?php if ($plugin == 'idsimport' && $default_user) { ?>
  default_user = '<?php echo $default_user; ?>';
  <?php } ?>
  </script>
  <?php
}






