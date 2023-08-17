<?php

new Rewrite_Post_Type_And_Taxonomy();

class Rewrite_Post_Type_And_Taxonomy {
	
	// Переменные Новостей
	static $news_type = 'news';
	static $rubric_tax = 'rubric';

	static $request = [];

	function __construct(){

		add_action( 'init', [ __CLASS__, 'register_post_types' ] );

		add_action( 'request', [ __CLASS__, 'fix_request' ] );

		add_filter( self::$news_type . '_rewrite_rules', [ __CLASS__, 'post_rewrite_rules' ] );

		add_filter( 'pre_term_link', [ __CLASS__, 'create_term_link' ], 10, 2 );

		add_filter( 'query_vars', static function( $vars ){
			$vars[] = 'query_tax';
			return $vars;
		} );
	}

	static function register_post_types(){

		// register post_type "news"
		register_post_type( self::$news_type, [
			'label'  => null,
			'labels' => [
				'name'          => 'Новости', // основное название для типа записи
				'singular_name' => 'Новости', // название для одной записи этого типа
			],
			'public'        => true,
			'menu_position' => 3,
			'menu_icon' => 'dashicons-welcome-write-blog', 
			'hierarchical'  => false,
			'supports'      => [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'    => [ self::$rubric_tax ],
			'has_archive'   => true,
			'rewrite'       => [ 'with_front'=>false, 'feeds'=>false, 'endpoints'=>false ],
			'query_var'     => true,
		] );

		// register taxonomy "rubric" for news
		register_taxonomy( self::$rubric_tax, [ self::$news_type ], [
			'label'             => '',
			'labels'            => [
				'name'          => 'Категории',
				'singular_name' => 'Категории',
			],
			'public'            => true,
			'hierarchical'      => true,
			'rewrite'			=> false,
			'show_admin_column' => false,

		] );

	}

	static function fix_request( $vars ){

		if( isset( $vars['post_type'] ) ){


			// post request like catalog
			if( !empty( $vars['name'] ) && self::$news_type === $vars['post_type'] ){

				$name = $vars['name'];

				$unset_vars__fn = static function( & $vars ){
					unset( $vars['post_type'], $vars['name'], $vars[ self::$news_type ] ); // clear
				};

				// catalog
				if( $term = get_term_by( 'slug', $name, self::$rubric_tax ) ){
					$unset_vars__fn( $vars ); // clear
					$vars[ self::$rubric_tax ] = $name;
				}
			}
		}

		// special query_tax request
		if( ! empty( $vars['query_tax'] ) ){

			$catalogs = [];
			$lnk = & $catalogs;
			foreach( explode( '/', $vars['query_tax'] ) as $part ){
				$lnk[] = $part;
			}
			unset( $lnk );

			$reversed_catalogs = array_reverse($catalogs);

			$catalog_slug = '';

			foreach($reversed_catalogs as $slug){	
				$post = get_page_by_path( $slug, OBJECT, self::$news_type );
				$term = get_term_by('slug', $slug, self::$rubric_tax);

				if($post){
					wp_redirect( get_permalink( $post->ID ), 301 );
					exit;
				}else if($term){
					$catalog_slug = $term;
					break;
				}
			}

			// for check reliability of the URL to redirect to right one
			$build_catalog  = $catalog_slug ? self::_build_tax_uri( $catalog_slug, self::$rubric_tax ) : '';

			// catalog
			if( $catalog_slug ){

				// 301 redirect to correct URL
				if( implode( '/', $catalogs ) !== $build_catalog ){
					wp_redirect( get_term_link( $catalog_slug, self::$rubric_tax ), 301 );
					exit;
				}

				$vars[ self::$rubric_tax ] = $catalog_slug;
			}

			unset( $vars['query_tax'] );
		}

		return $vars;
	}

	static function post_rewrite_rules( $rules ){

		$_first_part = self::$news_type . "/(.+?)";
		$_page_part = 'page/?([0-9]{1,})';
		$more_riles = [
			"$_first_part/$_page_part/?$" => 'index.php?query_tax=$matches[1]&paged=$matches[2]',
			"$_first_part/?$"             => 'index.php?query_tax=$matches[1]',
		];

		// delete conflict attachment rules
		foreach( $rules as $regex => $rule ){
			if( false === strpos( $regex, '/attachment/' ) && false !== strpos( $rule, 'attachment=' ) )
				unset( $rules[ $regex ] );
		}

		$rules += $more_riles;

		return $rules;
	}

	static function create_term_link( $url, $term ){

		if( $term->taxonomy === self::$rubric_tax ){
			return user_trailingslashit( '/'. self::$news_type .'/'. self::_build_tax_uri( $term ) );
		}

		return $url;
	}

	static function parent_terms( $term, $taxonomy = null ){

		if( is_string( $term ) )
			$term = get_term_by( 'slug', $term, $taxonomy );

		$path = [ $term ];

		while( $term->parent ){
			$term = get_term( $term->parent );
			$path[] = $term;
		}

		return array_reverse( $path );
	}

	static function _build_tax_uri( $term, $taxonomy = null ){
		$slugs = wp_list_pluck( self::parent_terms( $term, $taxonomy ), 'slug' );
		return implode( '/', $slugs );
	}

}