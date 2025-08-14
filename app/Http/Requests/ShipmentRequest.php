<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'import_export' => 'required|in:import,export',
            'bill_no' => 'nullable|string',
            'lc_no' => 'nullable|string',
            'shipping_line' => 'nullable|string',
            'gate_pass_id' => 'required|exists:gate_passes,id',
            'clearing_agent_id' => 'required|exists:clearing_agents,id',
            'customer_id' => 'required|exists:customers,id',
            'payment' => 'required|in:cash,credit',
            'bilty_invoice_amount.*' => 'required|numeric',
            'container_type' => 'required|string',
            'container_number' => 'required|numeric',
            'bilty_to_pay_amount.*' => 'required|numeric',
            'no_of_packges.*' => 'required|string|max:50',


            'description.*' => 'required|string|max:255',


            'bilty_number.*' => 'required|string|max:255',
            'sendar_id.*' => 'required|string|exists:contacts,id',
            'recipient_id.*' => 'required|string|exists:contacts,id',
            'from_location.*' => 'required|string|max:255',
            'to_location.*' => 'required|string|max:255',
            'broker_id.*' => 'required|string|exists:brokers,id',
            'vehicle_no.*' => 'required|string|max:100',
            'driver_no.*' => 'required|string|max:100',


            'booker_vhicle_freight_amount.*' => 'required|numeric',
            'mt_return_place.*' => 'nullable|string|max:255',

            'booker_mt_charges_amount.*' => 'required|numeric|min:0',

            'gate_pass_amount.*' => 'required|numeric',

            'lifter_charges_id.*' => 'nullable|exists:lifter_charges,id',
            'lifter_charges_amount.*' => 'nullable|numeric|min:0',

            'labour_charges_id.*' => 'nullable|exists:labour_charges,id',
            'labour_charges_amount.*' => 'nullable|numeric|min:0',

            'local_charges_id.*' => 'nullable|exists:local_charges,id',
            'local_charges_amount.*' => 'nullable|numeric|min:0',

            // 'party_commission_charges_id.*' => 'required|exists:party_commission_charges,id',
            // 'party_commission_charges_amount.*' => 'required|numeric|min:0',

            // 'tracker_charges_id.*' => 'required|exists:tracker_charges,id',
            // 'tracker_charges_amount.*' => 'required|numeric|min:0',

            'other_charges_id.*' => 'nullable|exists:other_charges,id',
            'other_charges_amount.*' => 'nullable|numeric|min:0',

            // 'bilty_container_number' => 'nullable|string'
        ];
    }


    public function messages()
    {
        return [
            'date.required' => 'Please provide the shipping date.',
            // 'job_no.required' => 'The job number is required.',
            // 'job_no.unique' => 'This job number has already been taken.',
            'import_export.required' => 'Please specify import or export.',
            'gate_pass_id.required' => 'Gate pass is required.',
            'gate_pass_id.exists' => 'Selected gate pass does not exist.',
            'clearing_agent_id.required' => 'Clearing agent is required.',
            'clearing_agent_id.exists' => 'Selected clearing agent does not exist.',
            'customer_id.required' => 'Customer name is required.',
            'payment.required' => 'Please select a payment method.',
            'bilty_invoice_amount.*.required' => 'Invoice amount is required.',
            'container_number.required' => 'Container number is required.',
            'container_type.required' => 'Container type is required.',
            'bilty_to_pay_amount.*.required' => 'To pay bill amount is required.',

            'no_of_packges.*.required' => ' Package no is required',
            'description.*.required' => 'Package must have a description.',
            'bilty_number.*.required' => 'Each package must have a bilty number.',
            'sendar_id.*.required' => 'Sender is required for each package.',
            'sendar_id.*.exists' => 'Selected sender does not exist.',
            'recipient_id.*.required' => 'Recipient is required for each package.',
            'recipient_id.*.exists' => 'Selected recipient does not exist.',
            'from_location.*.required' => 'From location is required.',
            'to_location.*.required' => 'To location is required.',
            'vehicle_no.*.required' => 'Vehicle number is required.',
            'driver_no.*.required' => 'Driver number is required.',

            'broker_id.*.required' => 'Booker name is required.',

            'booker_vhicle_freight_amount.*.required' => 'Freight amount is required.',
            'booker_mt_charges_amount.*.required' => 'Empty return charges are required.',
            'gate_pass_amount.*.required' => 'Gate pass amount is required.',

            'lifter_charges_id.*.required' => 'Lifter charge is required.',
            'lifter_charges_id.*.exists' => 'Selected lifter charge does not exist.',
            'lifter_charges_amount.*.required' => 'Lifter charge amount is required.',

            'labour_charges_id.*.required' => 'Labour charge is required.',
            'labour_charges_id.*.exists' => 'Selected labour charge does not exist.',
            'labour_charges_amount.*.required' => 'Labour charge amount is required.',

            'local_charges_id.*.required' => 'Local charge is required.',
            'local_charges_id.*.exists' => 'Selected local charge does not exist.',
            'local_charges_amount.*.required' => 'Local charge amount is required.',

            // 'party_commission_charges_id.*.required' => 'Party commission charge is required.',
            // 'party_commission_charges_id.*.exists' => 'Selected party commission charge does not exist.',
            // 'party_commission_charges_amount.*.required' => 'Party commission charge amount is required.',

            // 'tracker_charges_id.*.required' => 'Tracker charge is required.',
            // 'tracker_charges_id.*.exists' => 'Selected tracker charge does not exist.',
            // 'tracker_charges_amount.*.required' => 'Tracker charge amount is required.',

            'other_charges_id.*.required' => 'Other charge is required.',
            'other_charges_id.*.exists' => 'Selected other charge does not exist.',
            'other_charges_amount.*.required' => 'Other charge amount is required.',
        ];
    }
}
