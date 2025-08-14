<?php

namespace App\Utils;

use App\Models\Invoice;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ShippingUtil extends Util
{

    public function getReceiptDetails($business_id , $shipment_id)
    {


      return $shipment_id = Shipping::with(['details'])->select('shippings.*')
            ->where('shippings.business_id' , $business_id)->where('shippings.id' , $shipment_id)->first();

    }

    public function getInvoiceDetails($business_id , $invoice_id)
    {
      return $invoice_id = Invoice::with(['shipment.details' , 'shipment.customer' , 'shipment.agent'])->select('invoices.*')
            ->where('invoices.business_id' , $business_id)->where('invoices.id' , $invoice_id)
            ->orWhere('invoices.shipment_id' , $invoice_id)->first();
    }

}

