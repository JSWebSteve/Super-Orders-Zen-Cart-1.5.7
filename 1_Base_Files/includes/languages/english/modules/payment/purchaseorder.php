<?php
/**
 *
 *  SUPER ORDERS - Version 5.0
 *
 *  By Frank Koehl  (fkoehl@gmail.com)
 *
 *  Powered by Zen-Cart (www.zen-cart.com)
 *  Portions Copyright (c) 2005 The Zen-Cart Team
 *
 *  Released under the GNU General Public License
 *  available at www.zen-cart.com/license/2_0.txt
 *  or see "license.txt" in the downloaded zip
 *
 */

define('MODULE_PAYMENT_PURCHASE_ORDER_TEXT_TITLE', 'Purchase Order');

define('MODULE_PAYMENT_PURCHASE_ORDER_TEXT_DESCRIPTION','
<span style="font-size:small;color:red;"><b>PLEASE READ!<br>Important Payment Information:</b></span><p>
<b>Your order will not be processed until we have received your purchase order.</b><p>
Authorize your PO payment to:<br>' . MODULE_PAYMENT_PURCHASE_ORDER_PAYTO . '<br><br>
Alternatively, you may send us a <b>signed copy</b> of your P.O. by fax or email for immediate order processing.
Be sure to display your <b>invoice number</b> prominently somewhere on the document,
or include a copy of your invoice (e-mailed to you after your order is placed).<br><br>
Fax your P.O. to <b>' . STORE_FAX . '</b>, or email it to <b>' . STORE_OWNER_EMAIL_ADDRESS . '</b> .
');

define('MODULE_PAYMENT_PURCHASE_ORDER_TEXT_EMAIL_FOOTER', 'IMPORTANT PAYMENT INFORMATION:' . "\n" .
'Your order will not be processed until we have received your purchase order.' . "\n" .
'Authorize your PO payment to:' . "\n" . MODULE_PAYMENT_PURCHASE_ORDER_PAYTO ."\n" .
'Mail your payment to:' . "\n" . STORE_NAME_ADDRESS . " \n" .
'Alternatively, you may send us a *SIGNED* copy of your P.O. by fax or email for immediate order processing. Be sure to display your invoice number prominently somewhere on the document, or include a copy of your invoice.' . "\n" .
'Fax your P.O. to ' . STORE_FAX . ', or email it to ' . STORE_OWNER_EMAIL_ADDRESS);
