<?php
/**
 * Created by PhpStorm.
 * User: Sarah
 * Date: 02/06/2016
 * Time: 16:20
 */

/**
 * @return string
 */
function gh_fetch_social_media_posts() {

	$output = new GenderHub_Social_Media_Posts;
	return $output->html;
}

class GenderHub_Social_Media_Posts {

	private $options;

	public function __construct($options = array()) {
		
		$this->options = array_merge(
			array(
				'url'						=> 'https://api.twitter.com/1.1/statuses/user_timeline.json',
				'oauth_access_token' 		=> '2706849379-ivqXHZFXqwPMY3QcJcKiXr3IHH1ggHpUrsD7n21',
				'oauth_access_token_secret' => 'wxOr9YOT6D3VzPSNEV6ZvnIKrfXsYUdlO1xBRx5X6h96S',
				'consumer_key' 				=> 'yfgWxDx1rbt4hpPV17EWcEowW',
				'consumer_secret' 			=> 'jKqjAaAb2vPVD7fcxmCxKYwOsAbeIj5JC9G5CtxSmssiTHSJdd',
		
				'cache_dir'					=> dirname(__FILE__) . '/cache/',
				'cache_time'				=> 60 * 60,
			), $options);
		

		$allitems = $this->gh_gather_items();

		$this->html = $this->gh_build_blocks($allitems);
	}

	private function gh_gather_items() {

		$allitems = array();
		$twitter_data = $this->gh_fetch_tweets();
		$i = 1;

		foreach($twitter_data as $tw):
			if ($i < 5):

				$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a href="$2" target="_blank">$2</a> ', $tw->text." ");
				$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a target="_blank" href="http://$2"  target="_blank">$2</a> ', $content." ");
				$allitems[strtotime($tw->created_at)] = array('content' =>$content, 'user' => $tw->user->screen_name);

			endif;
			$i++;
		endforeach;

		$args = array( 'numberposts' => 4, 'post_type'=> 'facebook', 'orderby' => 'post_date', 'order' => 'DESC' );
		$myposts = get_posts( $args );
		foreach ( $myposts as $s ) :

			$content = preg_replace('$(\s|^)(https?://[a-z0-9_./?=&-]+)(?![^<>]*>)$i', ' <a href="$2" target="_blank">$2</a> ', $s->post_title.'<br /><br />'.$s->post_content." ");
			$content = preg_replace('$(\s|^)(www\.[a-z0-9_./?=&-]+)(?![^<>]*>)$i', '<a target="_blank" href="http://$2"  target="_blank">$2</a> ', $content." ");
			$text = $s->post_title.'<br /><br />'.$s->post_content;
			$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

			// Check if there is a url in the text
			if(preg_match($reg_exUrl, $text, $url)) {
				// make the urls hyper links
				$text = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a> ', $text);
			}

			$allitems[strtotime($s->post_date)] = array('content' =>$text, 'user' => '');

		endforeach;

		krsort($allitems);

		return $allitems;

	}

	private function gh_build_blocks($allitems) {

		$i = 1;

		// todo: slikkr - could add parameters to enable customisation of the output

		$html = '<section id="connect">';
		$html .= '<div class="paddingleftright inner purple">';
		$html .= '<h3>Connect and discuss</h3>';

		foreach($allitems as $key => $si):

			if ($i < 5):

				$html .= '<figure class="col4">';
				$html .= '<div class="text">';
				$html .= '<div class="icon">';

				if($si['user'] == ''):
					$html .= '<img src="/wp-content/uploads/2015/05/facebook-icon-large.png"/><span>Facebook post</span>';
				else:
					$html .= '<img src="/wp-content/uploads/2015/05/twitter-icon-large.png"/><span>Twitter post</span>';
				endif;

				$html .= '</div>';
				$html .= '<p>'.$si['content'].'</p>';
				$html .= '</div>';
				$html .= '<img src="/wp-content/uploads/2015/05/bubble1.png" class="bubble"/>';
				$html .= '<small><strong>@'.$si['user'].'</strong> '.date('d M Y',$key).'</small>';
				$html .= '</figure>';

			endif;
			$i++;
		endforeach;

		$html .= '</div>';
		$html .= '</section>';

		return $html;

	}

	private function gh_build_base_string($baseURI, $method, $params) {
		$r = array();
		ksort($params);
		foreach($params as $key=>$value){
			$r[] = "$key=" . rawurlencode($value);
		}
		return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
	}
	
	private function gh_build_authorization_header($oauth) {
		$r = 'Authorization: OAuth ';
		$values = array();
		foreach($oauth as $key=>$value)
			$values[] = "$key=\"" . rawurlencode($value) . "\"";
		$r .= implode(', ', $values);
		return $r;
	}

	private function gh_fetch_tweets() {

		if (!file_exists($this->options['cache_dir'])) {
			mkdir($this->options['cache_dir'], 0755, true);
		}

		$cache_file = $this->options['cache_dir'] . 'twitter-cache.txt';
		$cache_file_timestamp = ((file_exists($cache_file))) ? filemtime($cache_file) : 0;

		if (time() - $this->options['cache_time'] < $cache_file_timestamp) {
			$tweets = unserialize(file_get_contents($cache_file));
		} else {
			$tweets = $this->gh_refresh_tweets();
		}

		return $tweets;

	}

	private function gh_refresh_tweets() {

		$oauth = array(
			'oauth_consumer_key' 	=> $this->options['consumer_key'],
			'oauth_nonce' 			=> time(),
			'oauth_signature_method'=> 'HMAC-SHA1',
			'oauth_token' 			=> $this->options['oauth_access_token'],
			'oauth_timestamp' 		=> time(),
			'oauth_version' 		=> '1.0'
		);

		$base_info 					= $this->gh_build_base_string($this->options['url'], 'GET', $oauth);
		$composite_key 				= rawurlencode($this->options['consumer_secret']) . '&' . rawurlencode($this->options['oauth_access_token_secret']);
		$oauth_signature 			= base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
		$oauth['oauth_signature'] 	= $oauth_signature;
		
		// Make Requests
		$header = array($this->gh_build_authorization_header($oauth), 'Expect:');
		$options = array(
			CURLOPT_HTTPHEADER 		=> $header,
			//CURLOPT_POSTFIELDS 	=> $postfields,
			CURLOPT_HEADER 			=> false,
			CURLOPT_URL 			=> $this->options['url'],
			CURLOPT_RETURNTRANSFER 	=> true,
			CURLOPT_SSL_VERIFYPEER	=> false);

		$feed = curl_init();
		curl_setopt_array($feed, $options);
		$json = curl_exec($feed);
		curl_close($feed);

		$tweets = json_decode($json);

		$cache_file = $this->options['cache_dir'] . 'twitter-cache.txt';

		$file = fopen($cache_file, 'w');
		fwrite($file, serialize($tweets));
		fclose($file);

		return $tweets;

	}

}