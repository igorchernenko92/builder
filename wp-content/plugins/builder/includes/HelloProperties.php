<?php

class HelloProperties {
    /**
     *	hello_property_price_raw()
     *
     *	Return property price without formatting
     *
     *	@since 1.0.0
     */
    public function hello_property_price_raw( $post_id = '' ) {
        if ( ! $post_id )
            $post_id = get_the_ID();

        // Get listing price
        $price_raw = get_post_meta( $post_id, 'property_price', true );

        if ( empty( $price_raw ) )
            $price_raw = false;

        // Return listing price
        return apply_filters( 'get_property_price_raw', $price_raw, $post_id );
    }
}