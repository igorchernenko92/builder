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



    public static function builder_property_offer_raw( $post_id = '' ) {
        if ( ! $post_id )
            $post_id = get_the_ID();

        // Get listing offer
        $offer = get_post_meta( $post_id, 'property_offer', true );


        // Return offer key or label
        return apply_filters( 'builder_get_property_offer', $offer, $post_id );
    }





    /**
     * get_property_price()
     *
     * Returns formatted property price with
     * with currency and rental period.
     *
     * @return string|bool Formatted listing price or false
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

        // Set listing price labels
        $listing_price_labels = array(
            'sold'    => __( 'Sold', 'wpcasa'  ),
            'rented'  => __( 'Rented', 'wpcasa'  ),
            'request' => __( 'Price on request', 'wpcasa' )
        );

        $listing_price_labels = apply_filters( 'wpsight_get_listing_price_labels', $listing_price_labels );

        // Set listing price args
        $defauts = array(
            'number_format' => true,
            'show_currency' => true,
            'show_period'  => true,
            'show_request'  => true
        );

        $args = wp_parse_args( $args, $defauts );


        // Get price info
        $property_price  = self::builder_property_price_raw( $post_id );
        $property_offer  = self::builder_property_offer_raw( $post_id );
//        $listing_period = self::get_listing_period( $post_id, false );

        if ( !empty( $property_price ) ) {
            $property_price = preg_replace( '/\s+/', '', $property_price );

            if ( strpos( $property_price, ',' ) )
                $property_price_arr = explode( ',', $property_price );

            if ( strpos( $property_price, '.' ) )
                $property_price_arr = explode( '.', $property_price );



            // remove dots and commas
//            $property_price = str_replace( '.', '', $property_price );
//            $property_price = str_replace( ',', '', $property_price );



            if ( is_numeric( $property_price ) ) {

                // Get thousands separator
//                $listing_price_format = wpsight_get_option( 'currency_separator', true );
                $listing_price_format = 'dot';

                // Add thousands separators

                if ( $listing_price_format == 'dot' ) {
                    $property_price = number_format( $property_price, 0, ',', '.' );
                    if ( is_array( $property_price_arr ) )
                        $property_price .= ',' . $property_price_arr[1];
                } else {
                    $property_price = number_format( $property_price, 0, '.', ',' );
                    if ( is_array( $property_price_arr ) )
                        $property_price .= '.' . $property_price_arr[1];
                }

            }


        }


        return apply_filters( 'builder_get_property_price', $property_price, $post_id );

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
            'aed' => __( 'AED => United Arab Emirates Dirham', 'wpcasa' ),
            'ang' => __( 'ANG => Netherlands Antillean Guilder', 'wpcasa' ),
            'ars' => __( 'ARS => Argentine Peso', 'wpcasa' ),
            'aud' => __( 'AUD => Australian Dollar', 'wpcasa' ),
            'bdt' => __( 'BDT => Bangladeshi Taka', 'wpcasa' ),
            'bgn' => __( 'BGN => Bulgarian Lev', 'wpcasa' ),
            'bhd' => __( 'BHD => Bahraini Dinar', 'wpcasa' ),
            'bnd' => __( 'BND => Brunei Dollar', 'wpcasa' ),
            'bob' => __( 'BOB => Bolivian Boliviano', 'wpcasa' ),
            'brl' => __( 'BRL => Brazilian Real', 'wpcasa' ),
            'bwp' => __( 'BWP => Botswanan Pula', 'wpcasa' ),
            'cad' => __( 'CAD => Canadian Dollar', 'wpcasa' ),
            'chf' => __( 'CHF => Swiss Franc', 'wpcasa' ),
            'clp' => __( 'CLP => Chilean Peso', 'wpcasa' ),
            'cny' => __( 'CNY => Chinese Yuan', 'wpcasa' ),
            'cop' => __( 'COP => Colombian Peso', 'wpcasa' ),
            'crc' => __( 'CRC => Costa Rican Colon', 'wpcasa' ),
            'czk' => __( 'CZK => Czech Republic Koruna', 'wpcasa' ),
            'dkk' => __( 'DKK => Danish Krone', 'wpcasa' ),
            'dop' => __( 'DOP => Dominican Peso', 'wpcasa' ),
            'dzd' => __( 'DZD => Algerian Dinar', 'wpcasa' ),
            'eek' => __( 'EEK => Estonian Kroon', 'wpcasa' ),
            'egp' => __( 'EGP => Egyptian Pound', 'wpcasa' ),
            'eur' => __( 'EUR => Euro', 'wpcasa' ),
            'fjd' => __( 'FJD => Fijian Dollar', 'wpcasa' ),
            'gbp' => __( 'GBP => British Pound', 'wpcasa' ),
            'hkd' => __( 'HKD => Hong Kong Dollar', 'wpcasa' ),
            'hnl' => __( 'HNL => Honduran Lempira', 'wpcasa' ),
            'hrk' => __( 'HRK => Croatian Kuna', 'wpcasa' ),
            'huf' => __( 'HUF => Hungarian Forint', 'wpcasa' ),
            'idr' => __( 'IDR => Indonesian Rupiah', 'wpcasa' ),
            'ils' => __( 'ILS => Israeli New Sheqel', 'wpcasa' ),
            'inr' => __( 'INR => Indian Rupee', 'wpcasa' ),
            'jmd' => __( 'JMD => Jamaican Dollar', 'wpcasa' ),
            'jod' => __( 'JOD => Jordanian Dinar', 'wpcasa' ),
            'jpy' => __( 'JPY => Japanese Yen', 'wpcasa' ),
            'kes' => __( 'KES => Kenyan Shilling', 'wpcasa' ),
            'krw' => __( 'KRW => South Korean Won', 'wpcasa' ),
            'kwd' => __( 'KWD => Kuwaiti Dinar', 'wpcasa' ),
            'kyd' => __( 'KYD => Cayman Islands Dollar', 'wpcasa' ),
            'kzt' => __( 'KZT => Kazakhstani Tenge', 'wpcasa' ),
            'lbp' => __( 'LBP => Lebanese Pound', 'wpcasa' ),
            'lkr' => __( 'LKR => Sri Lankan Rupee', 'wpcasa' ),
            'ltl' => __( 'LTL => Lithuanian Litas', 'wpcasa' ),
            'lvl' => __( 'LVL => Latvian Lats', 'wpcasa' ),
            'mad' => __( 'MAD => Moroccan Dirham', 'wpcasa' ),
            'mdl' => __( 'MDL => Moldovan Leu', 'wpcasa' ),
            'mkd' => __( 'MKD => Macedonian Denar', 'wpcasa' ),
            'mur' => __( 'MUR => Mauritian Rupee', 'wpcasa' ),
            'mvr' => __( 'MVR => Maldivian Rufiyaa', 'wpcasa' ),
            'mxn' => __( 'MXN => Mexican Peso', 'wpcasa' ),
            'myr' => __( 'MYR => Malaysian Ringgit', 'wpcasa' ),
            'nad' => __( 'NAD => Namibian Dollar', 'wpcasa' ),
            'ngn' => __( 'NGN => Nigerian Naira', 'wpcasa' ),
            'nio' => __( 'NIO => Nicaraguan Cordoba', 'wpcasa' ),
            'nok' => __( 'NOK => Norwegian Krone', 'wpcasa' ),
            'npr' => __( 'NPR => Nepalese Rupee', 'wpcasa' ),
            'nzd' => __( 'NZD => New Zealand Dollar', 'wpcasa' ),
            'omr' => __( 'OMR => Omani Rial', 'wpcasa' ),
            'pen' => __( 'PEN => Peruvian Nuevo Sol', 'wpcasa' ),
            'pgk' => __( 'PGK => Papua New Guinean Kina', 'wpcasa' ),
            'php' => __( 'PHP => Philippine Peso', 'wpcasa' ),
            'pkr' => __( 'PKR => Pakistani Rupee', 'wpcasa' ),
            'pln' => __( 'PLN => Polish Zloty', 'wpcasa' ),
            'pyg' => __( 'PYG => Paraguayan Guarani', 'wpcasa' ),
            'qar' => __( 'QAR => Qatari Rial', 'wpcasa' ),
            'ron' => __( 'RON => Romanian Leu', 'wpcasa' ),
            'rsd' => __( 'RSD => Serbian Dinar', 'wpcasa' ),
            'rub' => __( 'RUB => Russian Ruble', 'wpcasa' ),
            'sar' => __( 'SAR => Saudi Riyal', 'wpcasa' ),
            'scr' => __( 'SCR => Seychellois Rupee', 'wpcasa' ),
            'sek' => __( 'SEK => Swedish Krona', 'wpcasa' ),
            'sgd' => __( 'SGD => Singapore Dollar', 'wpcasa' ),
            'skk' => __( 'SKK => Slovak Koruna', 'wpcasa' ),
            'sll' => __( 'SLL => Sierra Leonean Leone', 'wpcasa' ),
            'svc' => __( 'SVC => Salvadoran Colon', 'wpcasa' ),
            'thb' => __( 'THB => Thai Baht', 'wpcasa' ),
            'tnd' => __( 'TND => Tunisian Dinar', 'wpcasa' ),
            'try' => __( 'TRY => Turkish Lira', 'wpcasa' ),
            'ttd' => __( 'TTD => Trinidad and Tobago Dollar', 'wpcasa' ),
            'twd' => __( 'TWD => New Taiwan Dollar', 'wpcasa' ),
            'tzs' => __( 'TZS => Tanzanian Shilling', 'wpcasa' ),
            'uah' => __( 'UAH => Ukrainian Hryvnia', 'wpcasa' ),
            'ugx' => __( 'UGX => Ugandan Shilling', 'wpcasa' ),
            'usd' => __( 'USD => US Dollar', 'wpcasa' ),
            'uyu' => __( 'UYU => Uruguayan Peso', 'wpcasa' ),
            'uzs' => __( 'UZS => Uzbekistan Som', 'wpcasa' ),
            'vef' => __( 'VEF => Venezuelan Bolivar', 'wpcasa' ),
            'vnd' => __( 'VND => Vietnamese Dong', 'wpcasa' ),
            'xof' => __( 'XOF => CFA Franc BCEAO', 'wpcasa' ),
            'yer' => __( 'YER => Yemeni Rial', 'wpcasa' ),
            'zar' => __( 'ZAR => South African Rand', 'wpcasa' ),
            'zmk' => __( 'ZMK => Zambian Kwacha', 'wpcasa' )
        );

        return apply_filters( 'wpsight_currencies', $currencies );

    }
}