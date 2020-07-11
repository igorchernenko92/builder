<?php

/**
 *	builder_get_property_price_raw()
 *
 *	Return property price without formatting.
 *
 *	@since 1.0.0
 */
function builder_get_property_price_raw( $post_id = '' ) {
    return Builder_General::builder_property_price_raw( $post_id );
}


/**
 *	builder_get_property_price()
 *
 *	Return property price.
 *
 *	@since 1.0.0
 */
function builder_get_property_price( $post_id = '' ) {
    return Builder_General::builder_property_price( $post_id );
}


/**
 *	builder_get_property_status()
 *
 *	Return property price.
 *
 *	@since 1.0.0
 */
function builder_get_property_status( $post_id = '' ) {
    return Builder_General::builder_property_status( $post_id );
}