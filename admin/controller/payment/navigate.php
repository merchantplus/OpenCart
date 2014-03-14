<?php 
class ControllerPaymentNaviGate extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/navigate');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('navigate', $this->request->post);				

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_test'] = $this->language->get('text_test');
		$this->data['text_live'] = $this->language->get('text_live');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_capture'] = $this->language->get('text_capture');		

		$this->data['entry_login'] = $this->language->get('entry_login');
		$this->data['entry_key'] = $this->language->get('entry_key');
		$this->data['entry_hash'] = $this->language->get('entry_hash');
		$this->data['entry_server'] = $this->language->get('entry_server');
		$this->data['entry_mode'] = $this->language->get('entry_mode');
		$this->data['entry_method'] = $this->language->get('entry_method');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['login'])) {
			$this->data['error_login'] = $this->error['login'];
		} else {
			$this->data['error_login'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/navigate', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/navigate', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['navigate_login'])) {
			$this->data['navigate_login'] = $this->request->post['navigate_login'];
		} else {
			$this->data['navigate_login'] = $this->config->get('navigate_login');
		}

		if (isset($this->request->post['navigate_key'])) {
			$this->data['navigate_key'] = $this->request->post['navigate_key'];
		} else {
			$this->data['navigate_key'] = $this->config->get('navigate_key');
		}

		if (isset($this->request->post['navigate_hash'])) {
			$this->data['navigate_hash'] = $this->request->post['navigate_hash'];
		} else {
			$this->data['navigate_hash'] = $this->config->get('navigate_hash');
		}

		if (isset($this->request->post['navigate_server'])) {
			$this->data['navigate_server'] = $this->request->post['navigate_server'];
		} else {
			$this->data['navigate_server'] = $this->config->get('navigate_server');
		}

		if (isset($this->request->post['navigate_mode'])) {
			$this->data['navigate_mode'] = $this->request->post['navigate_mode'];
		} else {
			$this->data['navigate_mode'] = $this->config->get('navigate_mode');
		}

		if (isset($this->request->post['navigate_method'])) {
			$this->data['navigate_method'] = $this->request->post['navigate_method'];
		} else {
			$this->data['navigate_method'] = $this->config->get('navigate_method');
		}

		if (isset($this->request->post['navigate_total'])) {
			$this->data['navigate_total'] = $this->request->post['navigate_total'];
		} else {
			$this->data['navigate_total'] = $this->config->get('navigate_total'); 
		} 

		if (isset($this->request->post['navigate_order_status_id'])) {
			$this->data['navigate_order_status_id'] = $this->request->post['navigate_order_status_id'];
		} else {
			$this->data['navigate_order_status_id'] = $this->config->get('navigate_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['navigate_geo_zone_id'])) {
			$this->data['navigate_geo_zone_id'] = $this->request->post['navigate_geo_zone_id'];
		} else {
			$this->data['navigate_geo_zone_id'] = $this->config->get('navigate_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['navigate_status'])) {
			$this->data['navigate_status'] = $this->request->post['navigate_status'];
		} else {
			$this->data['navigate_status'] = $this->config->get('navigate_status');
		}

		if (isset($this->request->post['navigate_sort_order'])) {
			$this->data['navigate_sort_order'] = $this->request->post['navigate_sort_order'];
		} else {
			$this->data['navigate_sort_order'] = $this->config->get('navigate_sort_order');
		}

		$this->template = 'payment/navigate.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/navigate')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['navigate_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['navigate_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>