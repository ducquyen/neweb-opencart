<?php
class ModelPaymentNewebConvenienceStorePay extends Model {
  public function getMethod($address, $total) {
    $this->load->language('payment/neweb_convenience_store_pay');
 
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('neweb_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

    // show or hide the payment method. For example, if amount is less than 50, hide this method.
    if ($this->config->get('neweb_convenience_store_pay_total') > $total) {
      $status = false;
    } elseif (!$this->config->get('neweb_geo_zone_id')) {
      $status = true;
    } elseif ($query->num_rows) {
      $status = true;
    } else {
      $status = false;
    }
    
    $method_data = array();
 
    if ($status) {
      $method_data = array(
	'code'       => 'neweb_convenience_store_pay',
	'title'      => $this->language->get('text_title'),
	'sort_order' => $this->config->get('neweb_sort_order')
      );
    }
 
    return $method_data;
  }
}
?>
