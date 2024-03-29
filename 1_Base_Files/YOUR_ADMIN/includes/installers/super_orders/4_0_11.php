<?php

$checkTablePayments = $db->Execute("SELECT table_name
                                    FROM information_schema.tables
                                    WHERE table_schema = '" . DB_DATABASE . "'
                                    AND table_name = '" . DB_PREFIX . "so_payments'");

if ($checkTablePayments->RecordCount() > 0) {
  /* Update zero dates on very old installations */
  $db->Execute("ALTER TABLE " . DB_PREFIX . "so_payments CHANGE date_posted date_posted DATETIME NOT NULL DEFAULT '0001-01-01 00:00:00'");
  $db->Execute("ALTER TABLE " . DB_PREFIX . "so_payments CHANGE last_modified last_modified DATETIME NOT NULL DEFAULT '0001-01-01 00:00:00'");
} else {

//-- CREATE SUPER ORDERS PAYMENTS SUPPORT TABLES
  $db->Execute("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "so_payments (
  payment_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  payment_number varchar(32) NOT NULL default '',
  payment_name varchar(40) NOT NULL default '',
  payment_amount decimal(14,2) NOT NULL default '0.00',
  payment_type varchar(20) NOT NULL default '',
  date_posted datetime NOT NULL default '0001-01-01 00:00:00',
  last_modified datetime NOT NULL default '0001-01-01 00:00:00',
  purchase_order_id int(11) NOT NULL default '0',
  PRIMARY KEY (payment_id)
)");
}

$checkTablePorchaseOrders = $db->Execute("SELECT table_name
                                          FROM information_schema.tables
                                          WHERE table_schema = '" . DB_DATABASE . "'
                                          AND table_name = '" . DB_PREFIX . "so_purchase_orders'");

if ($checkTablePorchaseOrders->RecordCount() > 0) {
  /* Update zero dates on very old installations */
  $db->Execute("ALTER TABLE " . DB_PREFIX . "so_purchase_orders CHANGE date_posted date_posted DATETIME NOT NULL DEFAULT '0001-01-01 00:00:00'");
  $db->Execute("ALTER TABLE " . DB_PREFIX . "so_purchase_orders CHANGE last_modified last_modified DATETIME NOT NULL DEFAULT '0001-01-01 00:00:00'");
} else {
  $db->Execute("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "so_purchase_orders (
  purchase_order_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  po_number varchar(32) default NULL,
  date_posted datetime NOT NULL default '0001-01-01 00:00:00',
  last_modified datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY (purchase_order_id)
)");
}

$checkTablePorchaseOrders = $db->Execute("SELECT table_name
                                          FROM information_schema.tables
                                          WHERE table_schema = '" . DB_DATABASE . "'
                                          AND table_name = '" . DB_PREFIX . "so_refunds'");

if ($checkTablePorchaseOrders->RecordCount() > 0) {
  /* Update zero dates on very old installations */
  $db->Execute("ALTER TABLE " . DB_PREFIX . "so_refunds CHANGE date_posted date_posted DATETIME NOT NULL DEFAULT '0001-01-01 00:00:00'");
  $db->Execute("ALTER TABLE " . DB_PREFIX . "so_refunds CHANGE last_modified last_modified DATETIME NOT NULL DEFAULT '0001-01-01 00:00:00'");
} else {

$db->Execute("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "so_refunds (
  refund_id int(11) NOT NULL auto_increment,
  payment_id int(11) NOT NULL default '0',
  orders_id int(11) NOT NULL default '0',
  refund_number varchar(32) NOT NULL default '',
  refund_name varchar(40) NOT NULL default '',
  refund_amount decimal(14,2) NOT NULL default '0.00',
  refund_type varchar(20) NOT NULL default 'REF',
  date_posted datetime NOT NULL default '0001-01-01 00:00:00',
  last_modified datetime NOT NULL default '0001-01-01 00:00:00',
  PRIMARY KEY (refund_id),
  KEY refund_id (refund_id)
)");
}

$db->Execute("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "so_payment_types (
  payment_type_id int(11) NOT NULL auto_increment,
  language_id int(11) NOT NULL default '1',
  payment_type_code varchar(4) NOT NULL default '',
  payment_type_full varchar(20) NOT NULL default '',
  PRIMARY KEY (payment_type_id),
  UNIQUE KEY type_code (payment_type_code)
)");
/* Add default payment types to so_payment_types table */
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'CA', 'Cash')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'CK', 'Check')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'MO', 'Money Order')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'WU', 'Western Union')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'ADJ', 'Adjustment')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'REF', 'Refund')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'CC', 'Credit Card')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'MC', 'MasterCard')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'VISA', 'Visa')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'AMEX', 'American Express')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'DISC', 'Discover')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'DINE', 'Diners Club')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'SOLO', 'Solo')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'MAES', 'Maestro')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "so_payment_types VALUES (NULL, 1, 'JCB', 'JCB')");

/* -- ADD STORE PHONE AND FAX NUMBERS -- */
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added)
              VALUES ('Store Fax', 'STORE_FAX', '555-555-1212', 'Enter the fax number for your store.<br>You can call upon this by using the define <strong>STORE_FAX</strong>.', 1, 4, now())");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added)
              VALUES ('Store Phone', 'STORE_PHONE', '555-555-1212', 'Enter the phone number for your store.<br>You can call upon this by using the define <strong>STORE_PHONE</strong>.', 1, 4, now())");
/* -- ADD PURCHASE ORDER PAYMENT MODULE CONFIGURATION VALUES -- */
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, set_function)
              VALUES ('Enable Purchase Order Module', 'MODULE_PAYMENT_PURCHASE_ORDER_STATUS', 'False', 'Do you want to accept Purchase Order payments?', 6, 1, now(), 'zen_cfg_select_option(array(\'True\', \'False\'), ')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added)
              VALUES ('Make payable to:', 'MODULE_PAYMENT_PURCHASE_ORDER_PAYTO', 'YOUR COMPANY NAME', 'Who should payments be made payable to?', 6, 2, now())");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added)
              VALUES ('Sort order of display.', 'MODULE_PAYMENT_PURCHASE_ORDER_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', 6, 4, now())");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
              VALUES ('Payment Zone', 'MODULE_PAYMENT_PURCHASE_ORDER_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', 6, 5, now(), 'zen_get_zone_class_title', 'zen_cfg_pull_down_zone_classes(')");
$db->Execute("INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function)
              VALUES ('Set Order Status', 'MODULE_PAYMENT_PURCHASE_ORDER_ORDER_STATUS_ID', '2', 'Set the status of orders made with this payment module to this value', 6, 6, now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')");

// add Super Orders columns to orders table
// check if date_completed column exists and if it does not exist, then add it
$sql = "SHOW COLUMNS FROM " . TABLE_ORDERS . " LIKE '%date_completed%'";
$result = $db->Execute($sql);
if (!$result->RecordCount()) {
  $sql = "ALTER TABLE " . TABLE_ORDERS . " ADD date_completed datetime default NULL";
  $db->Execute($sql);
}

// check if date_cancelled column exists and if it does not exist, then add it
$sql = "SHOW COLUMNS FROM " . TABLE_ORDERS . " LIKE '%date_cancelled%'";
$result = $db->Execute($sql);
if (!$result->RecordCount()) {
  $sql = "ALTER TABLE " . TABLE_ORDERS . " ADD date_cancelled datetime default NULL";
  $db->Execute($sql);
}

// check if balance_due column exists and if it does not exist, then add it
$sql = "SHOW COLUMNS FROM " . TABLE_ORDERS . " LIKE '%balance_due%'";
$result = $db->Execute($sql);
if (!$result->RecordCount()) {
  $sql = "ALTER TABLE " . TABLE_ORDERS . " ADD balance_due decimal(14,2) default NULL";
  $db->Execute($sql);
}

// check if split_from_order column exists and if it does not exist, then add it
$sql = "SHOW COLUMNS FROM " . TABLE_ORDERS . " LIKE '%split_from%'";
$result = $db->Execute($sql);
if (!$result->RecordCount()) {
  $sql = "ALTER TABLE " . TABLE_ORDERS . " ADD split_from_order INT DEFAULT '0' NOT NULL";
  $db->Execute($sql);
}

// check if is_parent column exists and if it does not exist, then add it
$sql = "SHOW COLUMNS FROM " . TABLE_ORDERS . " LIKE '%is_parent%'";
$result = $db->Execute($sql);
if (!$result->RecordCount()) {
  $sql = "ALTER TABLE " . TABLE_ORDERS . " ADD is_parent TINYINT (1) DEFAULT '1' NOT NULL";
  $db->Execute($sql);
}

/* Remove Super Orders items from the configuration table */
$db->Execute("DELETE FROM " . DB_PREFIX . "configuration WHERE configuration_group_id ='" . $configuration_group_id . "' AND configuration_key != 'SO_VERSION'");

/* -- ADD VALUES TO SUPER ORDERS CONFIGURATION GROUP (Admin > Configuration > Super Orders) -- */
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Status - Payment', 'AUTO_STATUS_PAYMENT', '2', 'Number of the order status assigned when a payment (<strong>not</strong> attached to a purchase order) is added to the payment data.', '" . $configuration_group_id . "', 5, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Status - P.O. Payment', 'AUTO_STATUS_PO_PAYMENT', '2', 'Number of the order status assigned when a payment <strong>attached to a purchase order</strong> is added to the payment data.', '" . $configuration_group_id . "', 10, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Status - Purchase Order', 'AUTO_STATUS_PO', '2', 'Number of the status assigned to an order when a purchase order is added to the payment data.', '" . $configuration_group_id . "', 15, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Status - Refund', 'AUTO_STATUS_REFUND', '2', 'Number of the order status assigned when a refund is added to the payment data.', '" . $configuration_group_id . "', 20, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Comments - Payment', 'AUTO_COMMENTS_PAYMENT', 'Payment received in our office. Payment ID: %s', 'You''ll have the option of adding these pre-configured comments to an order when a payment is entered.  You can attach the payment number to the comments by typing <strong>%s</strong>.', '" . $configuration_group_id . "', 25, now(), now(), NULL, NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Comments - P.O. Payment', 'AUTO_COMMENTS_PO_PAYMENT', 'Payment on purchase order received in our office. Payment ID: %s', 'You will have the option of adding these pre-configured comments to an order when a purchase order payment is entered.  You can attach the payment number to the comments by typing <strong>%s</strong>.', '" . $configuration_group_id . "', 30, now(), now(), NULL, NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Comments - Purchase Order', 'AUTO_COMMENTS_PO', 'Purchase Order #%s received in our office', 'You will have the option of adding these pre-configured comments to an order when a purchase order is entered.  You can attach the payment number to the comments by typing <strong>%s</strong>.', '" . $configuration_group_id . "', 35, now(), now(), NULL, NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Auto Comments - Refund', 'AUTO_COMMENTS_REFUND', 'Refund #%s has been issued from our office.', 'You will have the option of adding these pre-configured comments to an order when a refund is entered.  You can attach the refund number to the comments by typing <strong>%s</strong>.', '" . $configuration_group_id . "', 40, now(), now(), NULL, NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Tax Exemption ID Number', 'TAX_ID_NUMBER', '', 'If your business or organization is tax exempt, then you may have been issued a tax exmption ID number. Enter the number here and the tax columns will not appear on the invoice and the tax exemption ID number will also be displayed at the top of the invoice.', '" . $configuration_group_id . "', 45, now(), now(), NULL , NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Closed Status - \"Cancelled\"', 'STATUS_ORDER_CANCELLED', '0', 'Insert the order status ID # you would like to assign to an order when you press the special \"Cancelled!\" button on super_orders.php.<p>If you do not have a \"cancel\" status, or do not want assign one automatically, choose <strong>default</strong> and this option will be ignored.<p><strong>You cannot attach comments or notify the customer using this option.</strong>', '" . $configuration_group_id . "', 50, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Closed Status - \"Completed\"', 'STATUS_ORDER_COMPLETED', '0', 'Insert the order status ID # you would like to assign to an order when you press the special \"Completed!\" button on super_orders.php.<p>If you do not have a \"complete\" status, or do not want assign one automatically, choose <strong>default</strong> and this option will be ignored.<p><strong>You cannot attach comments or notify the customer using this option.</strong>', '" . $configuration_group_id . "', 55, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Closed Status - \"Reopened\"', 'STATUS_ORDER_REOPEN', '0', 'Insert the order status ID # you would like to assign to an order when you undo the cancelled/completed status of an order.<p>If you do not have a \"reopened\" status, or do not want assign one automatically, choose <strong>default</strong> and this option will be ignored.<p><strong>You cannot attach comments or notify the customer using this option.</strong>', '" . $configuration_group_id . "', 60, now(), now(), 'zen_get_order_status_name', 'zen_cfg_pull_down_order_statuses(')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Standard Packing Slips - Show Images', 'PACKINGSLIP_IMAGES', 'Yes', 'Do you want to show product images on the packing slip?', '" . $configuration_group_id . "', 65, now(), now(), NULL, 'zen_cfg_select_option(array(''Yes'', ''No''),')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Batch Form Printing - Printing Menu', 'LCSD_PRINTING_MENU', '2', 'Select which printing menu to show on the Super Orders Batch Form Printing page.<br />0=Traditional Super Orders options<br />1=PDF packing slip printing options<br />2=Both menus',  '" . $configuration_group_id . "', 70, now(), now(), NULL, 'zen_cfg_select_option(array(''0'', ''1'', ''2''),')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'PDF Packing Slip - Header Logo', 'LCSD_PACKING_LOGO_LARGE', 'packingslip_HeaderLogo.png','File name of the image to show in the PDF packing slip header. Upload to admin/images folder. For best output quality, the file dimensions should be 252px X 82px.<br /><br />You should replace placeholder image with your own logo. If you do not want to use a logo, you should upload a transparent image to replace the placeholder logo. If you delete the image name in this setting you will get errors when generating PDF packing slips. Supports PNG & JPG files ONLY.','" . $configuration_group_id . "', 75, now(), now(), NULL , NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'PDF Packing Slip - Small Logo', 'LCSD_PACKING_LOGO_SMALL', 'packingslip_SmallLogo.png', 'File name of the image to show in the upper right corner of the PDF packing slip shipping label. Upload to admin/images folder. For best output quality, the file dimensions should be 192px X 64px.<br /><br />You should replace placeholder image with your own logo.  If you do not want to use a logo, you should upload a transparent image to replace the placeholder logo. If you delete the image name in this setting you will get errors when generating PDF packing slips. Supports PNG & JPG files ONLY.','" . $configuration_group_id . "', 80, now(), now(), NULL , NULL)";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'PDF Packing Slip - Show Store Name on Packing Slip', 'LCSD_SHOW_STORE_NAME', 'True', 'Determines whether or not the store name is included in the address block on the PDF packing slip. If the store name is part of the header logo set this to false.',  '" . $configuration_group_id . "', 85, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
$db->Execute($sql);
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'PDF Packing Slip - Enable Shipping Label', 'LCSD_SHOW_SHIPPING_LABEL', 'False', 'Determines whether or not a pre-printed shipping label is included in a customer address block on the packing slip so you don\t have to process a separate label report. If you are using a preprinted packing slips with a peel off label  set this to true.',  '" . $configuration_group_id . "', 90, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
$db->Execute($sql);
/* -- SUPER ORDERS ADMIN FLAGS TO ADD SUPPORT FOR EDIT ORDERS -- */
$sql = "INSERT IGNORE INTO " . DB_PREFIX . "configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (NULL, 'Edit Orders Module Switch', 'SO_EDIT_ORDERS_SWITCH', 'False', 'If you have the Edit Orders v4.0.0 or greater module installed, set this option to TRUE to activate the Edit Orders navigation buttons to work with Super Orders.<br><br><strong><font color=red>YOU MUST HAVE EDIT ORDERS INSTALLED TO USE THIS FEATURE!!</font></strong><br><br>\(Activating this flag without the required mod installed <strong>WILL CAUSE ERRORS IN YOUR STORE!!!!</strong>\)', '" . $configuration_group_id . "', 99, now(), now(), NULL, 'zen_cfg_select_option(array(''True'', ''False''),')";
$db->Execute($sql);

// find next sort order in admin_pages table
$sql = "SELECT (MAX(sort_order)+2) AS sort FROM " . TABLE_ADMIN_PAGES;
$result = $db->Execute($sql);
$admin_page_sort = $result->fields['sort'];

// now register the admin pages
// Admin Menu for Super Orders Configuration Menu
zen_deregister_admin_pages('configSuperOrders');
zen_register_admin_page('configSuperOrders', 'BOX_CONFIGURATION_SUPER_ORDERS', 'FILENAME_CONFIGURATION', 'gID=' . $configuration_group_id, 'configuration', 'Y', $admin_page_sort);

/* -- Admin Menu for Batch Status Update -- */
zen_deregister_admin_pages('customersBatchStatusUpdate');
zen_register_admin_page('customersBatchStatusUpdate', 'BOX_CUSTOMERS_SUPER_BATCH_STATUS', 'FILENAME_SUPER_BATCH_STATUS', '', 'customers', 'Y', $admin_page_sort);

/* -- Admin Menu for Batch Status Print -- */
zen_deregister_admin_pages('customersBatchFormPrint');
zen_register_admin_page('customersBatchFormPrint', 'BOX_CUSTOMERS_SUPER_BATCH_FORMS', 'FILENAME_SUPER_BATCH_FORMS', '', 'customers', 'Y', $admin_page_sort);

/* -- Admin Menu for Batch Print Pages -- */
zen_deregister_admin_pages('customersBatchPages');
zen_register_admin_page('customersBatchPages', 'BOX_CUSTOMERS_SUPER_BATCH_PAGES', 'FILENAME_SUPER_BATCH_PAGES', '', 'customers', 'N', $admin_page_sort);

/* -- Admin Menu for Super Data Sheet -- */
zen_deregister_admin_pages('customersSuperDataSheet');
zen_register_admin_page('customersSuperDataSheet', 'BOX_CUSTOMERS_SUPER_DATA_SHEET', 'FILENAME_SUPER_DATA_SHEET', '', 'customers', 'N', $admin_page_sort);

/* -- Admin Menu for Super Shipping Label -- */
zen_deregister_admin_pages('customersSuperShippingLabel');
zen_register_admin_page('customersSuperShippingLabel', 'BOX_CUSTOMERS_SUPER_SHIPPING_LABEL', 'FILENAME_SUPER_SHIPPING_LABEL', '', 'customers', 'N', $admin_page_sort);

/* -- Admin Menu for Super Orders Edit Pop-Up -- */
zen_deregister_admin_pages('customersSuperPopUp');
zen_register_admin_page('customersSuperPopUp', 'BOX_CUSTOMERS_SUPER_EDIT_POPUP', 'FILENAME_SUPER_EDIT', '', 'customers', 'N', $admin_page_sort);

/* -- Admin Menu for Manage Payment Types -- */
zen_deregister_admin_pages('localizationManagePaymentTypes');
zen_register_admin_page('localizationManagePaymentTypes', 'BOX_LOCALIZATION_MANAGE_PAYMENT_TYPES', 'FILENAME_SUPER_PAYMENT_TYPES', '', 'localization', 'Y', $admin_page_sort);

/* -- Admin Menu for Orders Awaiting Paymments Report -- */
zen_deregister_admin_pages('reportsOrdersAwaitingPayment');
zen_register_admin_page('reportsOrdersAwaitingPayment', 'BOX_REPORTS_SUPER_REPORT_AWAIT_PAY', 'FILENAME_SUPER_REPORT_AWAIT_PAY', '', 'reports', 'Y', $admin_page_sort);

/* -- Admin Menu for Cash Report -- */
zen_deregister_admin_pages('reportsCashReport');
zen_register_admin_page('reportsCashReport', 'BOX_REPORTS_SUPER_REPORT_CASH', 'FILENAME_SUPER_REPORT_CASH', '', 'reports', 'Y', $admin_page_sort);
