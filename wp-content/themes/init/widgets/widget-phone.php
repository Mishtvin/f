<?php 
/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			esc_html__( 'Номер на главной и минимальная стоимость', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Меняем здесь', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

	// Display the phone number
	echo 'Телефон: ' . esc_html( $instance['phone'] ) . '<br>';

    echo 'Телефон 2: ' . esc_html( $instance['phone2'] ) . '<br>';

	// Display the minimum price
	echo 'Минимальная стоимость: ' . esc_html( $instance['minprice'] ) . '<br>';

	// Display the telegram link
	echo 'Ссылка Telegram: ' . esc_html( $instance['telegram'] ) . '<br>';

	// Display the whatsapp link
	echo 'Ссылка WhatsApp: ' . esc_html( $instance['whatsapp'] ) . '<br>';

	// Display the viber link
	echo 'Ссылка Viber: ' . esc_html( $instance['viber'] ) . '<br>';
	
	// Display the vk link
	echo 'Ссылка vk: ' . esc_html( $instance['viber'] ) . '<br>';

	echo $args['after_widget'];
}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
            $phone = ! empty( $instance['phone'] ) ? $instance['phone'] : esc_html__( 'phone', 'text_domain' );
            $phone2 = ! empty( $instance['phone2'] ) ? $instance['phone2'] : esc_html__( 'phone', 'text_domain' );
            $minprice = ! empty( $instance['minprice'] ) ? $instance['minprice'] : esc_html__( 'minprice', 'text_domain' );
            $telegram = ! empty( $instance['telegram'] ) ? $instance['telegram'] : esc_html__( 'telegram', 'text_domain' );
            $whatsapp = ! empty( $instance['whatsapp'] ) ? $instance['whatsapp'] : esc_html__( 'whatsapp', 'text_domain' );
            $viber = ! empty( $instance['viber'] ) ? $instance['viber'] : esc_html__( 'viber', 'text_domain' );
            $vk = ! empty( $instance['vk'] ) ? $instance['vk'] : esc_html__( 'vk', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_attr_e( 'Number:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'phone2' ) ); ?>"><?php esc_attr_e( 'Number 2:', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'phone2' ) ); ?>" type="text" value="<?php echo esc_attr( $phone2 ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'minprice' ) ); ?>"><?php esc_attr_e( 'minprice:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'minprice' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'minprice' ) ); ?>" type="text" value="<?php echo esc_attr( $minprice ); ?>">
		</p>
<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'telegram' ) ); ?>"><?php esc_attr_e( 'Telegram:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'telegram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'telegram' ) ); ?>" type="text" value="<?php echo esc_attr( $telegram ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'whatsapp' ) ); ?>"><?php esc_attr_e( 'Whatsapp:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'whatsapp' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'whatsapp' ) ); ?>" type="text" value="<?php echo esc_attr( $whatsapp ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'viber' ) ); ?>"><?php esc_attr_e( 'Viber:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'viber' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'viber' ) ); ?>" type="text" value="<?php echo esc_attr( $viber ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'vk' ) ); ?>"><?php esc_attr_e( 'VK:', 'text_domain' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vk' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vk' ) ); ?>" type="text" value="<?php echo esc_attr( $vk ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? sanitize_text_field( $new_instance['phone'] ) : '';
		$instance['phone2'] = ( ! empty( $new_instance['phone2'] ) ) ? sanitize_text_field( $new_instance['phone2'] ) : '';
		$instance['minprice'] = ( ! empty( $new_instance['minprice'] ) ) ? sanitize_text_field( $new_instance['minprice'] ) : '';
		$instance['telegram'] = ( ! empty( $new_instance['telegram'] ) ) ? sanitize_text_field( $new_instance['telegram'] ) : '';
   		$instance['whatsapp'] = ( ! empty( $new_instance['whatsapp'] ) ) ? sanitize_text_field( $new_instance['whatsapp'] ) : '';
        $instance['viber'] = ( ! empty( $new_instance['viber'] ) ) ? sanitize_text_field( $new_instance['viber'] ) : '';
        $instance['vk'] = ( ! empty( $new_instance['vk'] ) ) ? sanitize_text_field( $new_instance['vk'] ) : '';

		// Update the 'phones' option in the database
		update_option( 'phones', [
			[
				'tel' => $instance['phone'],
				'link' => unmask_phone( $instance['phone'] )
			],
            [
                'tel' => $instance['phone2'],
                'link' => unmask_phone( $instance['phone2'] )
            ],
		] );

		// Update the 'min_price' option in the database
		update_option( 'min_price', $instance['minprice'] );
		
		// Update the 'telegram' option in the database
    	update_option( 'telegram', $instance['telegram'] );

    	// Update the 'whatsapp' option in the database
    	update_option( 'whatsapp', $instance['whatsapp'] );
    
    	// Update the 'viber' option in the database
    	update_option( 'viber', $instance['viber'] );
    
    	// Update the 'vk' option in the database
    	update_option( 'vk', $instance['vk'] );

		return $instance;
	}

} // class Foo_Widget
