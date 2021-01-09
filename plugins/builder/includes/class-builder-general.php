<?php

class Builder_General {

    /**
     * Constructor
     */
    public function __construct( ) {
//        add_filter( 'init', array( $this, 'listing_query_vars_details' ) );
    }

    /**
     *	hello_property_price_raw()
     *
     *	Return property price without formatting
     *
     *	@since 1.0.0
     */
    public static function builder_property_price_raw( $post_id = '' ) {
        if ( ! $post_id )
            $post_id = get_the_ID();

        // Get listing price
        $price_raw = get_post_meta( $post_id, 'property_price', true );

        if ( empty( $price_raw ) )
            $price_raw = false;

        // Return listing price
        return apply_filters( 'get_property_price_raw', $price_raw, $post_id );
    }


    /**
     *	builder_property_offer_period_raw()
     *
     *	Return property offer period without formatting
     *
     *	@since 1.0.0
     */
    public static function builder_property_offer_period_raw( $post_id = '' ) {
        if ( ! $post_id )
            $post_id = get_the_ID();

        // Get listing offer
        $offer_period = get_field( 'property_offer_period', $post_id );


        // Return offer key or label
        return apply_filters( 'builder_get_property_offer_period', $offer_period, $post_id );
    }


    /**
     *	builder_get_offer_period()
     *
     *	Return property rent period
     *
     *	@since 1.0.0
     */
    public static function builder_get_offer_period( $period_name ) {
        $periods = [
            'none' => '',
            'per_year' => ' / Year',
            'per_month' => ' / Month',
            'per_week' => ' / Week',
            'per_day' => ' / Day',
        ];
        return isset( $periods[ $period_name ] ) ? $periods[ $period_name ] : '';
    }


    /**
     *	builder_get_currency_symbol()
     *
     *	Return property currency symbol
     *
     *	@since 1.0.0
     */
    public static function builder_get_currency_symbol( $symbol_name ) {
        $symbols = [
            'dollar'       => '&#36;',
            'franc'        => '&#8355;',
            'euro'         => '&#128;',
            'ruble'        => '&#8381;',
            'pound'        => '&#163;',
            'indian_rupee' => '&#8377;',
            'baht'         => '&#3647;',
            'shekel'       => '&#8362;',
            'yen'          => '&#165;',
            'guilder'      => '&fnof;',
            'won'          => '&#8361;',
            'peso'         => '&#8369;',
            'lira'         => '&#8356;',
            'peseta'       => '&#8359',
            'rupee'        => '&#8360;',
            'real'         => 'R$',
            'krona'        => 'kr',
        ];
        return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
    }



    /**
     * get_property_price()
     *
     * Returns formatted property price with
     * with currency and rental period.
     *
     * @return string|bool Formatted property price or false
     *
     * @since 1.0.0
     */
    public static function builder_property_price( $post_id = '', $before = '', $after = '', $args = array() ) {
        // Check if custom post ID
        if ( ! $post_id )
            $post_id = get_the_ID();

        // Check if custom or global post ID
        if ( ! $post_id )
            return false;


        $property_price  = self::builder_property_price_raw( $post_id );
        $property_offer_period  = self::builder_property_offer_period_raw( $post_id );

        if ( !empty( $property_price ) ) {
            $property_price = preg_replace( '/\s+/', '', $property_price );

            // remove dots and commas
            $property_price = str_replace( '.', '', $property_price );
            $property_price = str_replace( ',', '', $property_price );

            if ( is_numeric( $property_price ) ) {

                // Get thousands separator
                $listing_price_format = get_field('property_price_separator', 'option');

                if ( $listing_price_format == 'dot' ) {
                    $property_price = number_format( $property_price, 0, ',', '.' );
                } else {
                    $property_price = number_format($property_price, 0, '.', ',');
                }
            }

            $currency =  get_field('property_currency', 'option');
            if ( !$currency ) $currency = 'dollar';
            $currency_symbol =  self::builder_get_currency_symbol($currency);
            $offer_period  =  self::builder_get_offer_period($property_offer_period);

            $property_price = '<span class="hl-listing-price__value">' . $currency_symbol . '' .  $property_price . '</span>';

            if ( $offer_period ) {
                $property_price .= '<span class="hl-listing-price__label">' . $offer_period . '</span>';
            }

        }

        return apply_filters( 'builder_get_property_price', $property_price, $post_id );

    }



    /**
     *	hello_property_status_raw()
     *
     *	Return property status without formatting
     *
     *	@since 1.0.0
     */
//    public static function builder_property_status_raw( $post_id = '') {
//        if ( ! $post_id )
//            $post_id = get_the_ID();
//
//        if ( ! $post_id )
//            return false;
//
//        $terms = get_the_terms( $post_id, 'status' );
//
//        return $terms[0];
//    }


    /**
 * builder_property_status()
 *
 * Returns formatted property status
 *
 * @return string|bool Formatted property status or false
 *
 * @since 1.0.0
 */
    public static function builder_property_status( $post_id = '') {
        if ( ! $post_id ) $post_id = get_the_ID();
        if ( ! $post_id ) return false;

        $terms = get_the_terms( $post_id, 'status' );
        if ( !$terms ) return false;
        $term = $terms[0];
        $term_link = get_term_link( $term );
        $term_name = $term->name;

        if ( is_wp_error($term_link) ) return false;

        $term_color = get_field('status_color', $term->taxonomy . '_' . $term->term_id); // format - #0073e1
        $property_status = '<div class="hl-listing-status hl-listing-card__wrap-tag hl-listing-card__wrap-tag_right">';
        $property_status .= '<a href="' . $term_link . '" style="background-color: ' . $term_color . ';" class="hl-listing-status__inner">' .  $term_name . '</a>';
        $property_status .= '</div>';

        return apply_filters( 'builder_get_property_status', $property_status, $post_id );
    }



    /**
     * options_array()
     *
     * Returns array of options
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function builder_options_array( $is_tax,  $include, $exclude ) {

        $options_array = [
            'property_year_built' 	=> __( 'Year Built', 'elementor' ),
            'property_bedrooms' 	=> __( 'Bedrooms', 'elementor' ),
            'property_bath' 		=> __( 'Bath', 'elementor' ),
            'property_garages' 		=> __( 'Garages', 'elementor' ),
            'property_rooms' 		=> __( 'Rooms', 'elementor' ),
            'property_living_area' 	=> __( 'Living Area', 'elementor' ),
            'property_terrace' 		=> __( 'Terrace', 'elementor' ),
            'property_price' 		=> __( 'Price', 'elementor' ),
            'keyword' 				=> __( 'Search', 'elementor' ),
        ];

        if ( $is_tax ) {
            foreach( get_object_taxonomies( 'property', 'objects' ) as $tax  ) {
                $options_array[$tax->name] = $tax->label;
            }
        }

        //include
        if ( is_array( $include ) && (!empty($include)) ) $options_array = array_merge($options_array, $include);

        //exclude
        if ( is_array( $exclude ) && ( !empty( $exclude ) ) ) {
            foreach ( $exclude as $item ) {
                unset($options_array[$item]);
            }
        }

        return apply_filters( 'options_array', $options_array );
    }



    /**
     * currencies()
     *
     * Function that defines the array
     * of available currencies (USD, EUR  etc.)
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function currencies() {

        $currencies = array(
            'aed' => __( 'AED => United Arab Emirates Dirham', 'builder' ),
            'ang' => __( 'ANG => Netherlands Antillean Guilder', 'builder' ),
            'ars' => __( 'ARS => Argentine Peso', 'builder' ),
            'aud' => __( 'AUD => Australian Dollar', 'builder' ),
            'bdt' => __( 'BDT => Bangladeshi Taka', 'builder' ),
            'bgn' => __( 'BGN => Bulgarian Lev', 'builder' ),
            'bhd' => __( 'BHD => Bahraini Dinar', 'builder' ),
            'bnd' => __( 'BND => Brunei Dollar', 'builder' ),
            'bob' => __( 'BOB => Bolivian Boliviano', 'builder' ),
            'brl' => __( 'BRL => Brazilian Real', 'builder' ),
            'bwp' => __( 'BWP => Botswanan Pula', 'builder' ),
            'cad' => __( 'CAD => Canadian Dollar', 'builder' ),
            'chf' => __( 'CHF => Swiss Franc', 'builder' ),
            'clp' => __( 'CLP => Chilean Peso', 'builder' ),
            'cny' => __( 'CNY => Chinese Yuan', 'builder' ),
            'cop' => __( 'COP => Colombian Peso', 'builder' ),
            'crc' => __( 'CRC => Costa Rican Colon', 'builder' ),
            'czk' => __( 'CZK => Czech Republic Koruna', 'builder' ),
            'dkk' => __( 'DKK => Danish Krone', 'builder' ),
            'dop' => __( 'DOP => Dominican Peso', 'builder' ),
            'dzd' => __( 'DZD => Algerian Dinar', 'builder' ),
            'eek' => __( 'EEK => Estonian Kroon', 'builder' ),
            'egp' => __( 'EGP => Egyptian Pound', 'builder' ),
            'eur' => __( 'EUR => Euro', 'builder' ),
            'fjd' => __( 'FJD => Fijian Dollar', 'builder' ),
            'gbp' => __( 'GBP => British Pound', 'builder' ),
            'hkd' => __( 'HKD => Hong Kong Dollar', 'builder' ),
            'hnl' => __( 'HNL => Honduran Lempira', 'builder' ),
            'hrk' => __( 'HRK => Croatian Kuna', 'builder' ),
            'huf' => __( 'HUF => Hungarian Forint', 'builder' ),
            'idr' => __( 'IDR => Indonesian Rupiah', 'builder' ),
            'ils' => __( 'ILS => Israeli New Sheqel', 'builder' ),
            'inr' => __( 'INR => Indian Rupee', 'builder' ),
            'jmd' => __( 'JMD => Jamaican Dollar', 'builder' ),
            'jod' => __( 'JOD => Jordanian Dinar', 'builder' ),
            'jpy' => __( 'JPY => Japanese Yen', 'builder' ),
            'kes' => __( 'KES => Kenyan Shilling', 'builder' ),
            'krw' => __( 'KRW => South Korean Won', 'builder' ),
            'kwd' => __( 'KWD => Kuwaiti Dinar', 'builder' ),
            'kyd' => __( 'KYD => Cayman Islands Dollar', 'builder' ),
            'kzt' => __( 'KZT => Kazakhstani Tenge', 'builder' ),
            'lbp' => __( 'LBP => Lebanese Pound', 'builder' ),
            'lkr' => __( 'LKR => Sri Lankan Rupee', 'builder' ),
            'ltl' => __( 'LTL => Lithuanian Litas', 'builder' ),
            'lvl' => __( 'LVL => Latvian Lats', 'builder' ),
            'mad' => __( 'MAD => Moroccan Dirham', 'builder' ),
            'mdl' => __( 'MDL => Moldovan Leu', 'builder' ),
            'mkd' => __( 'MKD => Macedonian Denar', 'builder' ),
            'mur' => __( 'MUR => Mauritian Rupee', 'builder' ),
            'mvr' => __( 'MVR => Maldivian Rufiyaa', 'builder' ),
            'mxn' => __( 'MXN => Mexican Peso', 'builder' ),
            'myr' => __( 'MYR => Malaysian Ringgit', 'builder' ),
            'nad' => __( 'NAD => Namibian Dollar', 'builder' ),
            'ngn' => __( 'NGN => Nigerian Naira', 'builder' ),
            'nio' => __( 'NIO => Nicaraguan Cordoba', 'builder' ),
            'nok' => __( 'NOK => Norwegian Krone', 'builder' ),
            'npr' => __( 'NPR => Nepalese Rupee', 'builder' ),
            'nzd' => __( 'NZD => New Zealand Dollar', 'builder' ),
            'omr' => __( 'OMR => Omani Rial', 'builder' ),
            'pen' => __( 'PEN => Peruvian Nuevo Sol', 'builder' ),
            'pgk' => __( 'PGK => Papua New Guinean Kina', 'builder' ),
            'php' => __( 'PHP => Philippine Peso', 'builder' ),
            'pkr' => __( 'PKR => Pakistani Rupee', 'builder' ),
            'pln' => __( 'PLN => Polish Zloty', 'builder' ),
            'pyg' => __( 'PYG => Paraguayan Guarani', 'builder' ),
            'qar' => __( 'QAR => Qatari Rial', 'builder' ),
            'ron' => __( 'RON => Romanian Leu', 'builder' ),
            'rsd' => __( 'RSD => Serbian Dinar', 'builder' ),
            'rub' => __( 'RUB => Russian Ruble', 'builder' ),
            'sar' => __( 'SAR => Saudi Riyal', 'builder' ),
            'scr' => __( 'SCR => Seychellois Rupee', 'builder' ),
            'sek' => __( 'SEK => Swedish Krona', 'builder' ),
            'sgd' => __( 'SGD => Singapore Dollar', 'builder' ),
            'skk' => __( 'SKK => Slovak Koruna', 'builder' ),
            'sll' => __( 'SLL => Sierra Leonean Leone', 'builder' ),
            'svc' => __( 'SVC => Salvadoran Colon', 'builder' ),
            'thb' => __( 'THB => Thai Baht', 'builder' ),
            'tnd' => __( 'TND => Tunisian Dinar', 'builder' ),
            'try' => __( 'TRY => Turkish Lira', 'builder' ),
            'ttd' => __( 'TTD => Trinidad and Tobago Dollar', 'builder' ),
            'twd' => __( 'TWD => New Taiwan Dollar', 'builder' ),
            'tzs' => __( 'TZS => Tanzanian Shilling', 'builder' ),
            'uah' => __( 'UAH => Ukrainian Hryvnia', 'builder' ),
            'ugx' => __( 'UGX => Ugandan Shilling', 'builder' ),
            'usd' => __( 'USD => US Dollar', 'builder' ),
            'uyu' => __( 'UYU => Uruguayan Peso', 'builder' ),
            'uzs' => __( 'UZS => Uzbekistan Som', 'builder' ),
            'vef' => __( 'VEF => Venezuelan Bolivar', 'builder' ),
            'vnd' => __( 'VND => Vietnamese Dong', 'builder' ),
            'xof' => __( 'XOF => CFA Franc BCEAO', 'builder' ),
            'yer' => __( 'YER => Yemeni Rial', 'builder' ),
            'zar' => __( 'ZAR => South African Rand', 'builder' ),
            'zmk' => __( 'ZMK => Zambian Kwacha', 'builder' )
        );

        return apply_filters( 'property_currencies', $currencies );
    }

}



