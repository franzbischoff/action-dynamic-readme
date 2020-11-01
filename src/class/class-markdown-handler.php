<?php

/**
 * Class Markdown_Handler
 *
 * @author Varun Sridharan <varunsridharan23@gmail.com>
 */
class Markdown_Handler {
	/**
	 * @param $content
	 * @param $handlers
	 *
	 * @static
	 * @return string
	 */
	public static function handle( $content, $handlers ) {
		$handlers = ( isset( $handlers['markdown'] ) ) ? $handlers['markdown'] : false;
		if ( ! empty( $handlers ) ) {
			$handlers = explode( '|', $handlers );
			if ( ! empty( $handlers ) ) {
				foreach ( $handlers as $handler ) {
					$content = self::process( $content, $handler );
				}
			}
		}

		return $content;
	}

	/**
	 * Process Markdown Content.
	 *
	 * @param $content
	 * @param $key
	 *
	 * @static
	 * @return string
	 */
	public static function process( $content, $key ) {
		if ( is_array( $key ) ) {
			$key = ( isset( $key['markdown'] ) ) ? $key['markdown'] : false;
		}

		$key   = explode( ':', $key );
		$value = ( isset( $key[1] ) ) ? $key[1] : false;
		$key   = ( isset( $key[0] ) ) ? $key[0] : false;

		$before = '';
		$after  = '';
		switch ( strtolower( $key ) ) {
			case 'code':
				$before = ( ! empty( $value ) ) ? '```' . $value : '```';
				$after  = '```';
				break;
			case 'blockquote':
				$before = '<blockquote>';
				$after  = '</blockquote>';
				break;
			case 'raw':
			case 'escape':
				$content = escape_content_to_raw( $content );
				break;
		}

		$before  = ( ! empty( $before ) ) ? $before . PHP_EOL : $before;
		$after   = ( ! empty( $after ) ) ? $after . PHP_EOL : $after;
		$content = $before . $content . $after;
		return $content;
	}
}