<?php

/**
 *	wpsight_get_listing_price_raw()
 *
 *	Return listings price without formatting.
 *
 *	@param integer $post_id Post ID
 *	@uses WPSight_Listings::get_listing_price_raw()
 *	@return string Listing price meta value
 *
 *	@since 1.0.0
 */
function builder_get_property_price_raw( $post_id = '' ) {
    return Builder_General::builder_property_price_raw( $post_id );
}