<?php
class ControllerPaymentNavigateMerchantplus extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/navigate_merchantplus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('navigate_merchantplus', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title']      = $this->language->get('heading_title');
		$data['text_edit']          = $this->language->get('text_edit');
		$data['text_enabled']       = $this->language->get('text_enabled');
		$data['text_disabled']      = $this->language->get('text_disabled');
		$data['text_all_zones']     = $this->language->get('text_all_zones');
		$data['text_test']          = $this->language->get('text_test');
		$data['text_live']          = $this->language->get('text_live');
		$data['text_authorization'] = $this->language->get('text_authorization');
		$data['text_capture']       = $this->language->get('text_capture');
		$data['entry_login']        = $this->language->get('entry_login');
		$data['entry_key']          = $this->language->get('entry_key');
		$data['entry_hash']         = $this->language->get('entry_hash');
		// $data['entry_server']       = $this->language->get('entry_server');
		$data['entry_mode']         = $this->language->get('entry_mode');
		$data['entry_method']       = $this->language->get('entry_method');
		$data['entry_total']        = $this->language->get('entry_total');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_geo_zone']     = $this->language->get('entry_geo_zone');
		$data['entry_status']       = $this->language->get('entry_status');
		$data['entry_sort_order']   = $this->language->get('entry_sort_order');
		$data['help_total']         = $this->language->get('help_total');
		$data['button_save']        = $this->language->get('button_save');
		$data['button_cancel']      = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['login'])) {
			$data['error_login'] = $this->error['login'];
		} else {
			$data['error_login'] = '';
		}

		if (isset($this->error['key'])) {
			$data['error_key'] = $this->error['key'];
		} else {
			$data['error_key'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('payment/navigate_merchantplus', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('payment/navigate_merchantplus', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['navigate_merchantplus_login'])) {
			$data['navigate_merchantplus_login'] = $this->request->post['navigate_merchantplus_login'];
		} else {
			$data['navigate_merchantplus_login'] = $this->config->get('navigate_merchantplus_login');
		}

		if (isset($this->request->post['navigate_merchantplus_key'])) {
			$data['navigate_merchantplus_key'] = $this->request->post['navigate_merchantplus_key'];
		} else {
			$data['navigate_merchantplus_key'] = $this->config->get('navigate_merchantplus_key');
		}

		if (isset($this->request->post['navigate_merchantplus_hash'])) {
			$data['navigate_merchantplus_hash'] = $this->request->post['navigate_merchantplus_hash'];
		} else {
			$data['navigate_merchantplus_hash'] = $this->config->get('navigate_merchantplus_hash');
		}

		// if (isset($this->request->post['navigate_merchantplus_server'])) {
		// 	$data['navigate_merchantplus_server'] = $this->request->post['navigate_merchantplus_server'];
		// } else {
		// 	$data['navigate_merchantplus_server'] = $this->config->get('navigate_merchantplus_server');
		// }

		if (isset($this->request->post['navigate_merchantplus_mode'])) {
			$data['navigate_merchantplus_mode'] = $this->request->post['navigate_merchantplus_mode'];
		} else {
			$data['navigate_merchantplus_mode'] = $this->config->get('navigate_merchantplus_mode');
		}

		if (isset($this->request->post['navigate_merchantplus_method'])) {
			$data['navigate_merchantplus_method'] = $this->request->post['navigate_merchantplus_method'];
		} else {
			$data['navigate_merchantplus_method'] = $this->config->get('navigate_merchantplus_method');
		}

		if (isset($this->request->post['navigate_merchantplus_total'])) {
			$data['navigate_merchantplus_total'] = $this->request->post['navigate_merchantplus_total'];
		} else {
			$data['navigate_merchantplus_total'] = $this->config->get('navigate_merchantplus_total');
		}

		if (isset($this->request->post['navigate_merchantplus_order_status_id'])) {
			$data['navigate_merchantplus_order_status_id'] = $this->request->post['navigate_merchantplus_order_status_id'];
		} else {
			$data['navigate_merchantplus_order_status_id'] = $this->config->get('navigate_merchantplus_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['navigate_merchantplus_geo_zone_id'])) {
			$data['navigate_merchantplus_geo_zone_id'] = $this->request->post['navigate_merchantplus_geo_zone_id'];
		} else {
			$data['navigate_merchantplus_geo_zone_id'] = $this->config->get('navigate_merchantplus_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['navigate_merchantplus_status'])) {
			$data['navigate_merchantplus_status'] = $this->request->post['navigate_merchantplus_status'];
		} else {
			$data['navigate_merchantplus_status'] = $this->config->get('navigate_merchantplus_status');
		}

		if (isset($this->request->post['navigate_merchantplus_sort_order'])) {
			$data['navigate_merchantplus_sort_order'] = $this->request->post['navigate_merchantplus_sort_order'];
		} else {
			$data['navigate_merchantplus_sort_order'] = $this->config->get('navigate_merchantplus_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('payment/navigate_merchantplus.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/navigate_merchantplus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['navigate_merchantplus_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['navigate_merchantplus_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}

		return !$this->error;
	}
}