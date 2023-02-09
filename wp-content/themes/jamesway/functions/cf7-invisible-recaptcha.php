<?php
if(!defined('ABSPATH')) exit;
if(!class_exists('WPCF7') || is_admin()) return;

$recaptcha = WPCF7::get_option('recaptcha');
if(!$recaptcha) return;

define('CF7_INV_RECAPTCHA_SITE_KEY', key($recaptcha));
define('CF7_INV_RECAPTCHA_SECRET_KEY', current($recaptcha));
define('CF7_INV_RECAPTCHA_HOLDER_CLASS', 'inv-recaptcha-holder');
define('CF7_INV_RECAPTCHA_LANGUAGE_CODE', 'uk'); //see here https://developers.google.com/recaptcha/docs/language

class CF7_Invisible_Recaptcha{
	CONST IP_VERSION_4 = 4;
	CONST IP_VERSION_6 = 6;

	public function __construct(){
		add_filter('wpcf7_form_elements', array($this, 'form_elements'), PHP_INT_MAX);
		add_filter('wpcf7_spam', array($this, 'form_spam'), 9);
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
	}

	public function form_elements($html){
		return $html.'<div class="'.CF7_INV_RECAPTCHA_HOLDER_CLASS.'"></div>';
	}

	public function enqueue_scripts(){
		$siteKey = CF7_INV_RECAPTCHA_SITE_KEY;
		$holderClass = CF7_INV_RECAPTCHA_HOLDER_CLASS;
		$inlineScript = <<<Mch
			var renderInvisibleReCaptcha = function(){
			    for( var i = 0; i < document.forms.length; ++i ){
			        var form = document.forms[i];
			        var holder = form.querySelector('.{$holderClass}');
			        if(null === holder) continue;
					holder.innerHTML = '';
			        
			        (function(frm){
						var cf7SubmitElm = frm.querySelector('.wpcf7-submit');
			            var holderId = grecaptcha.render(holder,{
			                'sitekey': '{$siteKey}',
			                'size': 'invisible',
			                'badge' : 'bottomright',
			                'callback' : function (recaptchaToken){
								if((null !== cf7SubmitElm) && (typeof jQuery != 'undefined')){
									jQuery(frm).submit();
									grecaptcha.reset(holderId);
									return;
								}
								HTMLFormElement.prototype.submit.call(frm);
			                },
			                'expired-callback' : function(){
			                	grecaptcha.reset(holderId);
			                }
			            });

						if(null !== cf7SubmitElm && (typeof jQuery != 'undefined') ){
							jQuery(cf7SubmitElm).off('click').on('click', function(clickEvt){
								clickEvt.preventDefault();
								grecaptcha.execute(holderId);
							});
						} else {
							frm.onsubmit = function(evt){
								evt.preventDefault();
								grecaptcha.execute(holderId);
							};
						}
			        })(form);
			    }
			};
Mch;
		wp_add_inline_style('contact-form-7','.grecaptcha-badge{display:none!important;}');
		wp_enqueue_script('google-invisible-recaptcha', (is_ssl() ? 'https' : 'http').'://www.google.com/recaptcha/api.js?onload=renderInvisibleReCaptcha&render=explicit&hl='.CF7_INV_RECAPTCHA_LANGUAGE_CODE, array(), null, true);
		wp_add_inline_script('google-invisible-recaptcha', $inlineScript, 'before');

		add_filter('script_loader_tag', function($tag,$handle){
			if('google-invisible-recaptcha' !== $handle) return $tag;
			return str_replace(' src',' async defer src',$tag);
		}, 99,2);
	}
	
	public function form_spam(){
		static $requestIsValid = -1;
		if(-1 !== $requestIsValid) return !$requestIsValid;

		if(empty($_POST['g-recaptcha-response'])) return false;

		$response = wp_remote_retrieve_body(wp_remote_get( add_query_arg( array(
			'secret'   => CF7_INV_RECAPTCHA_SECRET_KEY,
			'response' => $_POST['g-recaptcha-response'],
			'remoteip' => $this->getClientIp()
		), 'https://www.google.com/recaptcha/api/siteverify' ) ));

		if(empty($response) || !( $json = json_decode($response) ) || empty($json->success)) return $requestIsValid = true;
		return $requestIsValid = false;
	}

	private function getClientIp(array $arrTrustedProxyIps = array()){
		static $clientIp = 0;
		if(0 !== $clientIp ) return $clientIp;

		// Handle NGINX Proxies
		(!empty($_SERVER['HTTP_REMOTE_ADDR']) && empty( $_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_REMOTE_ADDR'] : null;

		if(empty($_SERVER['REMOTE_ADDR']) || -1 === ($ipVersion = self::getIpAddressVersion($_SERVER['REMOTE_ADDR']))) return null;

		$arrProxyHeaders = array(
			'HTTP_X_FORWARDED_FOR',
			'HTTP_CLIENT_IP',
			'HTTP_X_REAL_IP',
			'HTTP_X_FORWARDED',
			'HTTP_FORWARDED'
		);

		if(!empty($arrTrustedProxyIps) && in_array($_SERVER['REMOTE_ADDR'], $arrTrustedProxyIps, true)){
			foreach( $arrProxyHeaders as $proxyHeader ){
				if(null !== ($clientIp = self::getClientIpAddressFromProxyHeader($proxyHeader))) return $clientIp;
			}
		}
		return $clientIp = $_SERVER['REMOTE_ADDR'];
	}

	private function getClientIpAddressFromProxyHeader($proxyHeader){
		if(empty($_SERVER[$proxyHeader])) return null;

		$arrClientIps = explode(',', $_SERVER[$proxyHeader]);

		if(empty($arrClientIps[0])) return null;

		$arrClientIps[0] = str_replace(' ', '', $arrClientIps[0]);

		if(preg_match('{((?:\d+\.){3}\d+)\:\d+}', $arrClientIps[0], $match)) $arrClientIps[0] = trim($match[1]);

		return (-1 !== self::getIpAddressVersion($arrClientIps[0])) ? $arrClientIps[0] : null;
	}

	private function ipAddressToBinary($ipAddress, $ipVersion = null){
		static $arrBinaryIp = array();
		if(isset($arrBinaryIp[$ipAddress])) return $arrBinaryIp[$ipAddress];

		(null === $ipVersion) ? $ipVersion = self::getIpAddressVersion($ipAddress) :  null;

		if( -1 === $ipVersion) return null;

		(count($arrBinaryIp) > 20) ? array_shift($arrBinaryIp) : null;

		if($ipVersion === self::IP_VERSION_4){
			if(self::hasIpV4Support()) return (false !== ($binStr = inet_pton($ipAddress))) ? $arrBinaryIp[$ipAddress] = $binStr : null;
			return $arrBinaryIp[$ipAddress] = pack('N', ip2long($ipAddress));
		}

		if(self::hasIPV6Support()) return (false !== ($binStr = inet_pton($ipAddress))) ? $arrBinaryIp[$ipAddress] = $binStr : null;

		$binary = explode(':', $ipAddress);
		$binaryCount = count($binary);
		if(($doub = array_search('', $binary, 1)) !== false){
			$length = (!$doub || $doub === ($binaryCount - 1) ? 2 : 1);
			array_splice($binary, $doub, $length, array_fill(0, 8 + $length - $binaryCount, 0));
		}

		$binary = array_map('hexdec', $binary);
		array_unshift($binary, 'n*');

		return $arrBinaryIp[$ipAddress] = call_user_func_array('pack', $binary);
	}

	private function ipAddressFromBinary($binaryString){
		$strLength = strlen($binaryString);

		if(4 === $strLength && !self::hasIpV4Support()) return self::ipV4FromBinary($binaryString);
		if(16 === $strLength && !self::hasIPV6Support()) return self::ipV6FromBinary($binaryString);
		return ($strLength === 4 || $strLength === 16) ? (false !== ($ipAddress = inet_ntop($binaryString))) ? $ipAddress : null : null;
	}

	private function isPublicIpAddress($ipAddress, $ipVersion = null){
		(null === $ipVersion) ? $ipVersion = self::getIpAddressVersion($ipAddress) : -1;

		if($ipVersion === self::IP_VERSION_4 && 0 === strpos($ipAddress, '127.0.0')) return false;
		if($ipVersion === self::IP_VERSION_6 && (0 === strpos($ipAddress, '::') ? '::1' === $ipAddress : '::1' === self::compressIPV6($ipAddress))) return false;
		return false !== filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}

	private function compressIPV6($ipAddress, $shouldValidate = false){
		if($shouldValidate && (self::IP_VERSION_6 !== self::getIpAddressVersion($ipAddress))) return null;
		return self::hasIPV6Support() ? inet_ntop(inet_pton($ipAddress)) : self::ipAddressFromBinary(self::ipAddressToBinary($ipAddress));
	}

	private function ipV6FromBinary($binaryString){
		$ip = bin2hex($binaryString);
		$ip = substr(chunk_split($ip, 4, ':'), 0, -1);
		$ip = explode(':', $ip);
		$res = '';

		foreach( $ip as $index => $seg ){
			while( $seg {0} == '0' ) $seg = substr($seg, 1);
			if($seg != ''){
				$res.= $seg;
				if($index < count($ip) - 1) $res.= ($res == '' ? '' : ':');
			} else {
				if(strpos($res, '::') === false) $res.= ':';
			}
		}
		return $res;
	}

	private function ipV4FromBinary($binaryString){
		$decode = unpack('N', $binaryString);
		return isset($decode[1]) ? long2ip($decode[1]) : null;
	}

	private function getIpAddressVersion($ipAddress){
		static $arrIpVersions = array();
		if(isset($arrIpVersions[$ipAddress])) return $arrIpVersions[$ipAddress];
		if(false !== filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return $arrIpVersions[$ipAddress] = self::IP_VERSION_4;
		if(false !== filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) return $arrIpVersions[$ipAddress] = self::IP_VERSION_6;
		return -1;
	}

	private function hasIpV4Support(){
		static $hasSupport = null;
		if(null !== $hasSupport) return $hasSupport;
		return $hasSupport = (!(PHP_VERSION_ID < 50300 && ('so' !== PHP_SHLIB_SUFFIX))) && @inet_pton('127.0.0.1');
	}

	private function hasIPV6Support(){
		static $ipv6Supported = null;
		if(null !== $ipv6Supported) return $ipv6Supported;
		return $ipv6Supported = self::hasIpV4Support() && ((extension_loaded('sockets') && defined('AF_INET6')) || @inet_pton('::1'));
	}
}

new CF7_Invisible_Recaptcha();