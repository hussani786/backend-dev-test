
<?php
/**
 * End point to retrieve book data by using id
 *
 *
 * @author    Mohammad iqbal
 * @endpoint   /wp-json/kotwrest/books/get-book/{id}
 *
 */

namespace KotwRest\Endpoints\Books;

use kotw\Rest\Endpoint;
use WP_REST_Request as WP_REST_Request;
use WP_REST_Response;

class GetBook extends Endpoint {

	public static bool $public_access;
	/**
	 * @var string[]
	 */
	public static array $allowed_user_roles;
	/**
	 * @var string[]
	 */
	public static array $allowed_domains;

	/**
	 * @var bool
	 */
	public static bool $same_domain_access;

	/**
	 * This initializes the endpoint's data.
	 * @return array
	 */
	public static function init(): array {
		parent::init();
		self::$public_access      = true;
		self::$same_domain_access = true;
		self::$allowed_user_roles = array( 'administrator', 'developer', 'subscriber' );
		self::$allowed_domains    = array();

		return array(
			'kotwrest',
			'books/get-book/(?P<id>[\d]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( __CLASS__, 'callback' ),
				'permission_callback' => array( __CLASS__, 'permission_callback' ),
			),
		);
	}

	public static function callback( WP_REST_Request $request ) {

		// get book id.
		$bookID = $request->get_param( 'id' );

		if ( ! $bookID ) {
			return self::handle_error(
				'Please provide book ID',
				400
			);
		}

		$book = get_post( $bookID );
		if( ! get_post_status( $bookID ) ) {
			return self::handle_error(
				'There is not any book against this ID',
				404
			);
		}

		return self::handle_success(
			array(
				'id'        => $book->ID,
				'title'     => $book->post_title,
				'permalink' => $book->permalink,
				'meta_data'      => get_fields( $book_id ),
			)
		);
	}

	
	/**
	 * This function is called before the callback, and it validates the request.
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return bool
	 */
	public static function permission_callback( WP_REST_Request $request ): bool {
		// Returns a user, if current it is a valid request.
		$user_array = self::verify_access( $request, __CLASS__ );
		if ( $user_array ) {
			return true;
		}

		return false;
	}
}
