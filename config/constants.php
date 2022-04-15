<?php 

return [
    'reports' => [
        // 'Hotels' => [
        //     'base_table' => 'hotels',
		// 	'module' => 'Hotels',
		// 	'columns' => [
		// 		['name' => 'id', 'alias' => 'Hotel ID', 'type' => 'int', 'isDefault' => '1'],
		// 		['name' => 'HotelName', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '1'],
        //         ['name' => 'city_id', 'alias' => 'city_id', 'type' => 'int', 'isDefault' => '1']
		// 	],
		// 	'searchGroups' => [
		// 		[
		// 			['column' => ['name' => 'city_id'], 'operator' => '=', 'value' => '1']
		// 			//['column' => ['name' => 'transaction_type'], 'operator' => '=', 'value' => 'credit']
		// 		]
		// 	]
		// ],

		// 'Bookings' => [
        //     'base_table' => 'view_bookings_report',
		// 	'module' => 'Bookings',
		// 	'columns' => [
		// 		['name' => 'booking_id', 'alias' => 'Booking ID', 'type' => 'int', 'isDefault' => '0'],
		// 		['name' => 'booking_no', 'alias' => 'Booking #', 'type' => 'string', 'isDefault' => '1'],
		// 		['name' => 'customer_name', 'alias' => 'Customer Name', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Customer&_period_=__period__&title=Customer Report&customer_id=__customer id', 'dependent_columns' => 'customer_id:Customer ID'],
		// 		['name' => 'hotel_name', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '1'],
		// 		['name' => 'BookingFrom', 'alias' => 'Check-In Date', 'type' => 'date', 'isDefault' => '1'],
		// 		['name' => 'BookingTo', 'alias' => 'Check-Out Date', 'type' => 'date', 'isDefault' => '1'],
		// 		['name' => 'rooms', 'alias' => 'Rooms', 'type' => 'int', 'isDefault' => '1'],
		// 		['name' => 'no_occupants', 'alias' => 'Occupants', 'type' => 'int', 'isDefault' => '1'],
		// 		['name' => 'status', 'alias' => 'Status', 'type' => 'enum', 'enumArr' => ['Confirmed', 'Cancelled', 'Active', 'Completed', 'Declined', 'Pending'], 'isDefault' => '1', 'group' => '0'],
		// 		['name' => 'net_total', 'alias' => 'Total Amount', 'type' => 'amount', 'isDefault' => '1'],
		// 		['name' => 'BookingDate', 'alias' => 'Booking Date', 'type' => 'date', 'isDefault' => '0'],
		// 		['name' => 'cancelreason', 'alias' => 'Cancel Reason', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'invoice_id', 'alias' => 'Invoice ID', 'type' => 'int', 'isDefault' => '0'],
		// 		['name' => 'customer_id', 'alias' => 'Customer ID', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
		// 		['name' => 'total', 'alias' => 'Total', 'type' => 'amount', 'isDefault' => '0'],
		// 		['name' => 'discount_amount', 'alias' => 'Discount', 'type' => 'amount', 'isDefault' => '0'],
		// 		['name' => 'paid', 'alias' => 'Paid', 'type' => 'int', 'isDefault' => '0'],
		// 		['name' => 'payment_mode_id', 'alias' => 'Payment Mode ID', 'type' => 'int', 'isDefault' => '0'],
		// 		['name' => 'payment_amount', 'alias' => 'Payment Amount', 'type' => 'amount', 'isDefault' => '0'],
		// 		['name' => 'payment_date', 'alias' => 'Payment Date', 'type' => 'date', 'isDefault' => '0'],
		// 		['name' => 'payment_mode_name', 'alias' => 'Payment Mode', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'payment_mode_details', 'alias' => 'Payment Details', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'customer_first_name', 'alias' => 'First Name', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'customer_last_name', 'alias' => 'Last Name', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'customer_cnic', 'alias' => 'CNIC', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'customer_email', 'alias' => 'Email', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'customer_phone', 'alias' => 'Contact #', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'tax_rate_id', 'alias' => 'Tax Rate ID', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'tax_rate', 'alias' => 'Tax Rate', 'type' => 'number', 'isDefault' => '0'],
		// 		['name' => 'tax_charges', 'alias' => 'Tax Charges', 'type' => 'amount', 'isDefault' => '0'],
		// 		['name' => 'promo_id', 'alias' => 'Promo ID', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
		// 		['name' => 'promo_code', 'alias' => 'Promo Code', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'promo_is_percentage', 'alias' => 'Promo Percentage', 'type' => 'int', 'isDefault' => '0'],
		// 		['name' => 'promo_value', 'alias' => 'Promo Discount', 'type' => 'number', 'isDefault' => '0'],
		// 		['name' => 'hotel_id', 'alias' => 'Hotel ID', 'type' => 'int', 'isDefault' => '0', 'group' => "0"],
		// 		['name' => 'city_id', 'alias' => 'City ID', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
		// 		['name' => 'city_name', 'alias' => 'City Name', 'type' => 'string', 'isDefault' => '0'],
		// 		['name' => 'nights', 'alias' => 'Stay', 'type' => 'int', 'isDefault' => '0'],
		// 	]
		// ],


		'Bookings' => [
            'base_table' => 'view_bookings',
			'module' => 'Bookings',
			'columns' => [
				// ['name' => 'booking_id', 'alias' => 'Booking ID', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'booking_no', 'alias' => 'Booking No', 'type' => 'string', 'isDefault' => '1', 'group'=> '1'],
				['name' => 'third_party_booking_no', 'alias' => 'Third Party Booking No', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Third Parties&_period_=__period__&title=Third Parties&booking_third_party_id=__booking third party code', 'dependent_columns' => 'booking_third_party_id:Booking Third Party Code'],
				['name' => 'customer_name', 'alias' => 'Customer Name', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Customer&_period_=__period__&title=Customer&customer_id=__customer code', 'dependent_columns' => 'customer_id:Customer Code'],
				['name' => 'hotel_name', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Hotels&_period_=__period__&title=Hotels&id=__hotel code', 'dependent_columns' => 'hotel_id:Hotel Code'],
				['name' => 'BookingFrom', 'alias' => 'Check-In Date', 'type' => 'date', 'isDefault' => '1'],
				['name' => 'BookingTo', 'alias' => 'Check-Out Date', 'type' => 'date', 'isDefault' => '1'],
				['name' => 'rooms', 'alias' => 'Rooms', 'type' => 'int', 'isDefault' => '1'],
				['name' => 'no_occupants', 'alias' => 'Occupants', 'type' => 'int', 'isDefault' => '1'],
				['name' => 'status', 'alias' => 'Status', 'type' => 'enum', 'enumArr' => ['Confirmed', 'Cancelled', 'Active', 'Completed', 'Declined', 'Pending'], 'isDefault' => '1', 'group' => '0'],
				['name' => 'net_total', 'alias' => 'Total Amount', 'type' => 'amount', 'isDefault' => '1'],
				['name' => 'BookingDate', 'alias' => 'Booking Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'cancelreason', 'alias' => 'Cancel Reason', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'invoice_id', 'alias' => 'Invoice Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'customer_id', 'alias' => 'Customer Code', 'type' => 'number', 'isDefault' => '0', 'group'=>'0'],
				['name' => 'total', 'alias' => 'Total', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'discount_amount', 'alias' => 'Discount', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'paid', 'alias' => 'Paid', 'type' => 'int', 'isDefault' => '0'],
				// ['name' => 'payment_mode_id', 'alias' => 'Payment Mode Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'payment_amount', 'alias' => 'Payment Amount', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'payment_date', 'alias' => 'Payment Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'payment_mode_name', 'alias' => 'Payment Mode', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'payment_mode_details', 'alias' => 'Payment Details', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_first_name', 'alias' => 'First Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_last_name', 'alias' => 'Last Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_cnic', 'alias' => 'CNIC', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_email', 'alias' => 'Email', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_phone', 'alias' => 'Contact #', 'type' => 'string', 'isDefault' => '0'],
				// ['name' => 'tax_rate_id', 'alias' => 'Tax Rate Code', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'tax_rate', 'alias' => 'Tax Rate', 'type' => 'number', 'isDefault' => '0'],
				['name' => 'tax_charges', 'alias' => 'Tax Charges', 'type' => 'amount', 'isDefault' => '0'],
				// ['name' => 'promo_id', 'alias' => 'Promo ID', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
				// ['name' => 'promo_code', 'alias' => 'Promo Code', 'type' => 'string', 'isDefault' => '0'],
				// ['name' => 'promo_is_percentage', 'alias' => 'Promo Percentage', 'type' => 'int', 'isDefault' => '0'],
				// ['name' => 'promo_value', 'alias' => 'Promo Discount', 'type' => 'number', 'isDefault' => '0'],
				['name' => 'hotel_id', 'alias' => 'Hotel Code', 'type' => 'int', 'isDefault' => '0', 'group' => "0"],
				// ['name' => 'city_id', 'alias' => 'City Code', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
				['name' => 'city_name', 'alias' => 'City Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'nights', 'alias' => 'Stay', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'booking_third_party_id', 'alias' => 'Booking Third Party Code', 'type' => 'int', 'isDefault' => '0'],
			]
		],


		'Monthly Bookings' => [
            'base_table' => 'view_bookings',
			// 'base_where' => "third_party_booking_no IS NOT NULL",
			'module' => 'Bookings',
			'columns' => [
				// ['name' => 'booking_id', 'alias' => 'Booking ID', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'BookingDateMonth', 'alias' => 'Booking Date Month', 'isMonth' => '1', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'booking_no', 'alias' => 'Booking No', 'type' => 'string', 'isDefault' => '1', 'group'=> '1'],
				['name' => 'third_party_booking_no', 'alias' => 'Third Party Booking No', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Third Parties&_period_=__period__&title=Third Parties&booking_third_party_id=__booking third party code', 'dependent_columns' => 'booking_third_party_id:Booking Third Party Code'],
				['name' => 'customer_name', 'alias' => 'Customer Name', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Customer&_period_=__period__&title=Customer&customer_id=__customer code', 'dependent_columns' => 'customer_id:Customer Code'],
				['name' => 'hotel_name', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '1', 'link' => 'report?report=Hotels&_period_=__period__&title=Hotels&id=__hotel code', 'dependent_columns' => 'hotel_id:Hotel Code'],
				['name' => 'BookingFrom', 'alias' => 'Check-In Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'BookingTo', 'alias' => 'Check-Out Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'rooms', 'alias' => 'Rooms', 'type' => 'int', 'isDefault' => '1'],
				['name' => 'no_occupants', 'alias' => 'Occupants', 'type' => 'int', 'isDefault' => '1'],
				['name' => 'status', 'alias' => 'Status', 'type' => 'enum', 'enumArr' => ['Confirmed', 'Cancelled', 'Active', 'Completed', 'Declined', 'Pending'], 'isDefault' => '1', 'group' => '0'],
				['name' => 'net_total', 'alias' => 'Total Amount', 'type' => 'amount', 'isDefault' => '1'],
				['name' => 'BookingDate', 'alias' => 'Booking Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'cancelreason', 'alias' => 'Cancel Reason', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'invoice_id', 'alias' => 'Invoice Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'customer_id', 'alias' => 'Customer Code', 'type' => 'number', 'isDefault' => '0', 'group'=>'0'],
				['name' => 'total', 'alias' => 'Total', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'discount_amount', 'alias' => 'Discount', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'paid', 'alias' => 'Paid', 'type' => 'int', 'isDefault' => '0'],
				// ['name' => 'payment_mode_id', 'alias' => 'Payment Mode Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'payment_amount', 'alias' => 'Payment Amount', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'payment_date', 'alias' => 'Payment Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'payment_mode_name', 'alias' => 'Payment Mode', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'payment_mode_details', 'alias' => 'Payment Details', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_first_name', 'alias' => 'First Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_last_name', 'alias' => 'Last Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_cnic', 'alias' => 'CNIC', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_email', 'alias' => 'Email', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'customer_phone', 'alias' => 'Contact #', 'type' => 'string', 'isDefault' => '0'],
				// ['name' => 'tax_rate_id', 'alias' => 'Tax Rate Code', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'tax_rate', 'alias' => 'Tax Rate', 'type' => 'number', 'isDefault' => '0'],
				['name' => 'tax_charges', 'alias' => 'Tax Charges', 'type' => 'amount', 'isDefault' => '0'],
				// ['name' => 'promo_id', 'alias' => 'Promo ID', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
				// ['name' => 'promo_code', 'alias' => 'Promo Code', 'type' => 'string', 'isDefault' => '0'],
				// ['name' => 'promo_is_percentage', 'alias' => 'Promo Percentage', 'type' => 'int', 'isDefault' => '0'],
				// ['name' => 'promo_value', 'alias' => 'Promo Discount', 'type' => 'number', 'isDefault' => '0'],
				['name' => 'hotel_id', 'alias' => 'Hotel Code', 'type' => 'int', 'isDefault' => '0', 'group' => "0"],
				// ['name' => 'city_id', 'alias' => 'City Code', 'type' => 'int', 'isDefault' => '0', 'group'=>'0'],
				['name' => 'city_name', 'alias' => 'City Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'nights', 'alias' => 'Stay', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'booking_third_party_id', 'alias' => 'Booking Third Party Code', 'type' => 'int', 'isDefault' => '0'],
			], 
			'searchGroups' => [
					[
						['column' => ['name' => 'BookingDateMonth', 'alias' => 'Booking Date Month', 'type' => 'enum'], 'operator' => '=', 'value' => date('F') .' '.date('Y')],

						// ['column' => ['name' => 'BookingDateMonth', 'alias' => 'Booking Date Month', 'type' => 'string']],
					]
				]
		],

		'Customer' => [
            'base_table' => 'view_bookings',
			'module' => 'Bookings',
			'columns' => [
				// ['name' => 'booking_id', 'alias' => 'Booking ID', 'type' => 'int', 'isDefault' => '0'],

				// link for customer
				['name' => 'customer_id', 'alias' => 'Customer Code', 'type' => 'int', 'isDefault' => '0', 'group' => "1"],
				['name' => 'customer_name', 'alias' => 'Customer Name', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'customer_first_name', 'alias' => 'First Name', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'customer_last_name', 'alias' => 'Last Name', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'customer_cnic', 'alias' => 'CNIC', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'customer_email', 'alias' => 'Email', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'customer_phone', 'alias' => 'Contact #', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'booking_no', 'alias' => 'Total Bookings', 'type' => 'string', 'isDefault' => '1', 'aggregation' => 'count'],
				['name' => 'net_total', 'alias' => 'Total Revenue', 'type' => 'string', 'isDefault' => '1', 'aggregation' => 'sum'],

				// link for hotel
				['name' => 'hotel_name', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'BookingFrom', 'alias' => 'Check-In Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'BookingTo', 'alias' => 'Check-Out Date', 'type' => 'date', 'isDefault' => '0'],
				// link for rooms
				['name' => 'rooms', 'alias' => 'Rooms', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'no_occupants', 'alias' => 'Occupants', 'type' => 'int', 'isDefault' => '0'],
				// link for status
				['name' => 'status', 'alias' => 'Status', 'type' => 'enum', 'enumArr' => ['Confirmed', 'Cancelled', 'Active', 'Completed', 'Declined', 'Pending'], 'isDefault' => '0'],
				
				['name' => 'BookingDate', 'alias' => 'Booking Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'cancelreason', 'alias' => 'Cancel Reason', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'invoice_id', 'alias' => 'Invoice Code', 'type' => 'int', 'isDefault' => '0'],
				
				['name' => 'total', 'alias' => 'Total', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'discount_amount', 'alias' => 'Discount', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'paid', 'alias' => 'Paid', 'type' => 'int', 'isDefault' => '0'],
				// ['name' => 'payment_mode_id', 'alias' => 'Payment Mode Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'payment_amount', 'alias' => 'Payment Amount', 'type' => 'amount', 'isDefault' => '0'],
				['name' => 'payment_date', 'alias' => 'Payment Date', 'type' => 'date', 'isDefault' => '0'],
				['name' => 'payment_mode_name', 'alias' => 'Payment Mode', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'payment_mode_details', 'alias' => 'Payment Details', 'type' => 'string', 'isDefault' => '0'],
				
				
				// ['name' => 'tax_rate_id', 'alias' => 'Tax Rate Code', 'int' => 'string', 'isDefault' => '0'],
				['name' => 'tax_rate', 'alias' => 'Tax Rate', 'type' => 'number', 'isDefault' => '0'],
				['name' => 'tax_charges', 'alias' => 'Tax Charges', 'type' => 'amount', 'isDefault' => '0'],
				// ['name' => 'promo_id', 'alias' => 'Promo ID', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'promo_code', 'alias' => 'Promo Code', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'promo_is_percentage', 'alias' => 'Promo Percentage', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'promo_value', 'alias' => 'Promo Discount', 'type' => 'number', 'isDefault' => '0'],
				['name' => 'hotel_id', 'alias' => 'Hotel Code', 'type' => 'int', 'isDefault' => '0'],
				// link for city
				// ['name' => 'city_id', 'alias' => 'City Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'city_name', 'alias' => 'City Name', 'type' => 'string', 'isDefault' => '0'],
				['name' => 'nights', 'alias' => 'Stay', 'type' => 'int', 'isDefault' => '0'],
			]
		],

		'Hotels' => [
            'base_table' => 'view_hotels_report',
			'module' => 'Hotels',
			'columns' => [
				['name' => 'id', 'alias' => 'Hotel Code', 'type' => 'int', 'isDefault' => '0',],
				['name' => 'HotelName', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '1'],
				// ['name' => 'city_d', 'alias' => 'City Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'CityName', 'alias' => 'City', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'Address', 'alias' => 'Address', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'ZipCode', 'alias' => 'Zip Code', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'rooms', 'alias' => 'Rooms', 'type' => 'int', 'isDefault' => '1', 'link' => 'report?report=Hotel Rooms&_period_=__period__&title=Hotel Rooms&hotel_id=__hotel code', 'dependent_columns' => 'id:Hotel Code'],
				['name' => 'total_bookings', 'alias' => 'Total Bookings', 'type' => 'int', 'isDefault' => '1', 'link' => 'report?report=Bookings&_period_=__period__&title=Bookings&hotel_id=__hotel code', 'dependent_columns' => 'id:Hotel Code'],
				['name' => 'net_total', 'alias' => 'Total Revenue', 'type' => 'amount', 'isDefault' => '1', 'aggregation' => 'sum']
			]
		],

		'Hotel Rooms' => [
			'base_table' => 'view_rooms_report',
			'module' => 'Rooms',
			'columns' => [
				['name' => 'hotel_id', 'alias' => 'Hotel Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'HotelName', 'alias' => 'Hotel Name', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'room_title', 'alias' => 'Room Title', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'room_category_id', 'alias' => 'Room Category Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'RoomNumber', 'alias' => 'Room #', 'type' => 'int', 'isDefault' => '1'],
				['name' => 'FloorNo', 'alias' => 'Floor #', 'type' => 'int', 'isDefault' => '1'],
				['name' => 'RoomCharges', 'alias' => 'Charges per Night', 'type' => 'amount', 'isDefault' => '1'],
				['name' => 'RoomCategory', 'alias' => 'Category', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'additional_guest_charges', 'alias' => 'Additional Guest Charges', 'type' => 'amount', 'isDefault' => '1'],
				['name' => 'allowed', 'alias' => 'Capacity', 'type' => 'amount', 'isDefault' => '1'],
				['name' => 'max_allowed', 'alias' => 'Max. Capacity', 'type' => 'amount', 'isDefault' => '1']
			]
		],

		'Third Parties' => [
			'base_table' => 'view_bookings',
			'base_where' => "third_party_booking_no IS NOT NULL",
			'module' => 'Bookings',
			'columns' => [
				['name' => 'booking_third_party_id', 'alias' => 'Booking Third Party Code', 'type' => 'int', 'isDefault' => '0'],
				['name' => 'third_party_booking_no', 'alias' => 'Booking No', 'type' => 'string', 'isDefault' => '1', 'group'=> '1'],
				['name' => 'third_party_first_name', 'alias' => 'First Name', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'third_party_last_name', 'alias' => 'Last Name', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'third_party_phone', 'alias' => 'Phone', 'type' => 'string', 'isDefault' => '1'],
				['name' => 'third_party_email', 'alias' => 'Email', 'type' => 'string', 'isDefault' => '1', 'group'=> '0'],
				['name' => 'third_party_total_rooms', 'alias' => 'Total Room', 'type' => 'int', 'isDefault' => '1', 'group'=> '0'],
				['name' => 'third_party_total_cost', 'alias' => 'Total Cost', 'type' => 'amount', 'isDefault' => '1', 'aggregation' => 'sum'],
			],
			// 'searchGroups' => [
			// 	[
			// 		['column' => ['name' => 'third_party_booking_no', 'alias' => 'Booking No', 'type' => 'string']],
			// 	]
			// ]
		]
    ]
];