<?php

if ( ! class_exists('helix_wp_auto_update') ) {
	class helix_wp_auto_update {
		public $helix_current_version;
		public $helix_update_path;
		public $helix_plugin_slug;
		public $helix_slug;

		function __construct($helix_current_version, $helix_update_path, $helix_plugin_slug) {
			$this->current_version = $helix_current_version;
			$this->update_path = $helix_update_path;
			$this->plugin_slug = $helix_plugin_slug;
			list ($helix_t1, $helix_t2) = explode('/', $helix_plugin_slug);
			$this->slug = str_replace('.php', '', $helix_t2);
			
			add_filter('pre_set_site_transient_update_plugins', array(&$this, 'helix_check_update'));
			add_filter('plugins_api', array(&$this, 'helix_check_info'), 10, 3);
		}
		
		public function helix_check_update($helix_transient) {
			if (empty($helix_transient->checked)) {
				return $helix_transient;
			}

			// Get the remote version
			$helix_remote_version = $this->helix_getRemote_version();

			// If a newer version is available, add the update
			if (version_compare($this->current_version, $helix_remote_version, '<')) {
				$helix_obj = new stdClass();
				$helix_obj->slug = $this->slug;
				$helix_obj->new_version = $helix_remote_version;
				$helix_obj->url = $this->update_path;
				$helix_obj->package = $this->update_path;
				$helix_transient->response[$this->plugin_slug] = $helix_obj;
			}
			#var_dump($transient);
			return $helix_transient;	
		}

		/**
		 * Add our self-hosted description to the filter
		 */
		public function helix_check_info($helix_false, $helix_action, $helix_arg) {
			if ($helix_arg->slug === $this->slug) {
				$helix_information = $this->helix_getRemote_information();
				return $helix_information;
			}
			// fixed - checking multiple plugins
			return $helix_false;
		}

		/**
		 * Return the remote version
		 */
		public function helix_getRemote_version() {
			$helix_request = wp_remote_post($this->update_path, array('body' => array('action' => 'version')));
			if (!is_wp_error($helix_request) || wp_remote_retrieve_response_code($helix_request) === 200) {
				return $helix_request['body'];
			}
			return false;
		}
	
		/**
		 * Get information about the remote version
		 */
		public function helix_getRemote_information() {
			$helix_request = wp_remote_post($this->update_path, array('body' => array('action' => 'info')));
			if (!is_wp_error($helix_request) || wp_remote_retrieve_response_code($helix_request) === 200) {
				return unserialize($helix_request['body']);
			}
			return false;
		}

		/**
		 * Return the status of the plugin licensing
		 */
		public function helix_getRemote_license() {
			$helix_request = wp_remote_post($this->update_path, array('body' => array('action' => 'license')));
			if (!is_wp_error($helix_request) || wp_remote_retrieve_response_code($helix_request) === 200) {
				return $helix_request['body'];
			}
			return false;
		}
	}
}


?>