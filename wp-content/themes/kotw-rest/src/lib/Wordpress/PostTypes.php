<?php
/**
 * @author     Kings Of The Web
 * @year       2022
 * @package    mazencanada.com
 * @subpackage KotwRest\Wordpress
 */

namespace KotwRest\Wordpress;

use kotw\Custom\PostType;

class PostTypes {

	public function __construct() {
		self::register();
		self::custom_book_post_type();
	}

	/**
	 * This registers all post types requireed.
	 *
	 * @return void
	 */
	public static function register() {
		// example
		$example_post_type = new PostType(
			'project',
			'Project',
			'Projects',
			array( 'project-category' ),
			array(
				'title',
				'thumbnail',
				'editor',
				'excerpt',
				'revisions',
			),
			'dashicons-welcome-learn-more',
			true,
			array(),
			'Projects'
		);

	}

	// Create custom post book
	public static function custom_book_post_type() {

        $book_post_type = new PostType(
            'book',
            'book',
            'book',
            array( 'book-category' ),
            array(
                'title',
                'thumbnail',
                'editor',
                'excerpt',
                'revisions',
            ),
            'dashicons-welcome-learn-more',
            true,
            array(),
            'Books'
        );

    }
}
