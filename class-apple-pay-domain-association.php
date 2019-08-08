<?php
/**
 * Domain Association for Apple Pay
 *
 * @package Apple_Pay_Domain_Association
 */

namespace Thoughtis;

use WP;

/**
 * Apple Pay Domain Association
 */
class Apple_Pay_Domain_Association {

	/**
	 * Construct
	 */
	public function __construct() {

		add_action( 'init', array( __CLASS__, 'add_rewrite_rule' ), 10 );
		add_action( 'parse_request', array( __CLASS__, 'handle_request' ), 10, 1 );

		add_filter( 'query_vars', array( __CLASS__, 'add_query_var' ), 10, 1 );

	}

	/**
	 * Add Rewrite Rule
	 */
	public static function add_rewrite_rule() : void {

		$rewrite_test = '^\.well-known\/apple-developer-merchantid-domain-association$';
		$rewrite_dest = 'index.php?apple_pay_domain_association=true';

		add_rewrite_rule( $rewrite_test, $rewrite_dest, 'top' );

	}

	/**
	 * Add Query Var
	 *
	 * @param  array $public_query_vars - provided public query vars.
	 * @return array $public_query_vars - updated public query vars.
	 */
	public static function add_query_var( array $public_query_vars ) : array {

		array_push( $public_query_vars, 'apple_pay_domain_association' );

		return $public_query_vars;

	}

	/**
	 * Handle Request
	 *
	 * @param WP $wp Current WordPress environment instance.
	 */
	public static function handle_request( WP $wp ) : void {

		if ( ! isset( $wp->query_vars['my_theme_adstxt'] ) ) {
			return;
		}

		if ( 'true' !== $wp->query_vars['my_theme_adstxt'] ) {
			return;
		}

		header( 'Content-Type: application/octet-stream' );

		echo esc_html(
			file_get_contents(
				plugin_dir_path( __FILE__ ) . 'apple-developer-merchantid-domain-association'
			)
		);

		exit;

	}

}

new Apple_Pay_Domain_Association();
