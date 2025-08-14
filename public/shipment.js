$(document).ready(function () {

    $('.select2').select2();
    // $('.select2-multi').select2();



    $('#container_number').on('change', function () {
        let selectedCount = parseInt($(this).val());
        let container = $('#containerInputs');
        $("#conatinerDive").removeAttr('style');

        container.empty();

        if (!isNaN(selectedCount) && selectedCount > 0) {
            for (let i = 1; i <= selectedCount; i++) {
                container.append(`
                        <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label for="container_${i}">Container #${i}</label>
                            <input type="text" class="form-control mb-2 daynamic-input" name="containers[]" id="container_${i}" placeholder="Enter Container #${i}">
                        </div>
                        </div>
                    `);
            }
        }
    });

    $("#btnSave").on('click', function () {

        let values = [];
        // var getContainerNumber = $('#container_number').val();
        // $("#hide_container_number").val(getContainerNumber);
        // $("#container_number").prop('disabled', true);

        $(".daynamic-input").each(function () {
            $(this).attr('readonly', true);
            values.push($(this).val());
        });

        $(this).attr('disabled', true);
        $("#saveSuccess").text('Successfully');


        values.forEach(function (val) {
            if ($(".bilty_container_number option[value='" + val + "']").length === 0) {
                $('.bilty_container_number').append('<option value="' + val + '">' + val + '</option>');
            }
        });




    });





    let biltyIndex = 1;

    $('#addMoreBtn').on('click', function () {
        let firstGroup = $('.field-group').first();

        firstGroup.find('select').each(function () {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });

        let newFields = firstGroup.clone();

        newFields.find('select').each(function () {
            $(this).find('option[selected]').removeAttr('selected');

        });



        newFields.find('input').each(function () {
            if ($(this).attr('type') === 'number') {
                $(this).val(0);
                $(this).attr('value', 0);
            } else {
                $(this).val('');
                $(this).attr('value', '');
            }
        });


        let selectedValues = [];
        $('.bilty_container_number').each(function () {
            let val = $(this).val();
            if (val) {
                selectedValues = selectedValues.concat(val);
            }
        });

        newFields.find('.bilty_container_number option').each(function () {
            if (selectedValues.includes($(this).val())) {
                $(this).remove();
            }
        });



        let biltyIndex = $('.field-group').length;


        newFields.find('[name]').each(function () {
            const oldName = $(this).attr('name');


            if (oldName && oldName.startsWith('bilty_container_number')) {
                const base = oldName.replace(/\[\d+\]\[\]/, '');
                $(this).attr('name', `${base}[${biltyIndex}][]`);
            }
        });


        let groupNumber = $('.field-group').length + 1;

        $('#field-container').append(`
            <hr class="head-line" style="background:#000000; height:1px; border:none; margin:10px 0;">
            <div class="row field-group bilty-expense-group bilty_expense_group_${groupNumber}">
                ${newFields.html()}
            </div>
        `);


        $('#field-container .field-group:last select').select2();

        biltyIndex++;
    });



    // Remove row
    $(document).on('click', '.remove-btn', function () {
        if ($('.field-group').length > 1) {
            $(this).closest('.field-group').remove();
            updateIndexes();
        } else {
            alert('At least one row is required.');
        }
    });

    // Update index numbers
    function updateIndexes() {
        $('.field-group').each(function (i) {
            $(this).find('.index-number').text(i + 1);
        });
    }

    // final amount
    // $(document).on('input', '.bilty-expense-group input', function () {
    //     const $group = $(this).closest('.bilty-expense-group');

    //     let biltyTotal = 0;
    //     selectors.forEach(selector => {
    //         biltyTotal += parseFloat($group.find('.bilty_total_amount').val()) || 0;
    //     });

    //     $(".final_amount").parseFloat(biltyTotal.val());
    // });





    $(document).on('input', '.bilty-expense-group input', function () {

        const $group = $(this).closest('.bilty-expense-group');

        const selectors = [
            '.booker_vhicle_freight_amount',
            '.mt_return_place',
            '.booker_mt_charges_amount',
            '.gate_pass_amount',
            '.lifter_charges_amount',
            '.labour_charges_amount',
            '.local_charges_amount',
            '.party_commision_charges_amount',
            '.tracker_charges_amount',
            '.other_charges_amount'
        ];

        let biltyTotal = 0;
        selectors.forEach(selector => {
            biltyTotal += parseFloat($group.find(selector).val()) || 0;
        });

        $group.find('.expence_amount').val(biltyTotal.toFixed(2));

        let biltyInvoiceAmount = parseFloat($group.find('.bilty_invoice_amount').val()) || 0;
        let biltyToPayAmount = parseFloat($group.find('.bilty_to_pay_amount').val()) || 0;


        let biltyTotalAmount = biltyInvoiceAmount - biltyToPayAmount - biltyTotal;

        $group.find('.bilty_total_amount').val(

            biltyInvoiceAmount.toFixed(2) + ' - ' +
            biltyToPayAmount.toFixed(2) + ' - ' +
            biltyTotal.toFixed(2) + ' = ' +
            biltyTotalAmount.toFixed(2)
        );


        let grandTotal = 0;
        let totalExpense = 0;
        let totalToPay = 0;

        $('.bilty-expense-group').each(function () {
            let rowInvoice = parseFloat($(this).find('.bilty_invoice_amount').val()) || 0;
            let rowToPay = parseFloat($(this).find('.bilty_to_pay_amount').val()) || 0;
            let rowExpense = 0;

            selectors.forEach(selector => {
                rowExpense += parseFloat($(this).find(selector).val()) || 0;
            });

            totalExpense += parseFloat($(this).find('.expence_amount').val()) || 0;
            totalToPay += rowToPay;

            let rowTotal = rowInvoice - rowToPay - rowExpense;
            grandTotal += rowTotal;
        });

        // Set final totals
        $('.total_invoice_amount').val(grandTotal.toFixed(2));
        $('.total_expence_amount').val(totalExpense.toFixed(2));
        $('.total_to_pay_amount').val(totalToPay.toFixed(2));
    });






    let currentSelectBox = null;

    $(document).on('click', '.open-sender-modal', function () {
        currentSelectBox = $(this).closest('.sender-group').find('select.sendar_id');
        $('#senderModal').modal('show');
    });
    // sender form submit
    $('#senderForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/sendar',
            data: formData,
            success: function (response) {

                $('#senderModal').modal('hide');
                toastr.success(response.message);
                $('#senderForm')[0].reset();
                if (currentSelectBox) {
                    currentSelectBox.append(
                        $('<option>', {
                            value: response.sendar.id,
                            text: response.sendar.name,
                            selected: true
                        })
                    ).trigger('change');
                }

            },
            error: function (xhr) {
              if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
                }
            }
        });
    });
    // recipient form submit

    let currentRecipentSelectBox = null;
    $(document).on('click', '.open-recipient-modal', function () {
        currentRecipentSelectBox = $(this).closest('.recipient-group').find('select.recipient_id');
        $('#recipientModal').modal('show');
    });

    // recipient form submit
    $('#recipientForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/recipients',
            data: formData,
            success: function (response) {

                $('#recipientModal').modal('hide');
                toastr.success(response.message);
                $('#recipientForm')[0].reset();
                if (currentRecipentSelectBox) {
                    currentRecipentSelectBox.append(
                        $('<option>', {
                            value: response.recipient.id,
                            text: response.recipient.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
                }
            }
        });
    });

    let currentBrokerSelectBox = null;
    $(document).on('click', '.open-broker-modal', function () {
        currentBrokerSelectBox = $(this).closest('.broker-group').find('select.broker_id');
        $('#createBrokerModal').modal('show');
    }
    );

    // broker form submit
    $('#brokerForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/brokers',
            data: formData,
            success: function (response) {
                $('#createBrokerModal').modal('hide');
                toastr.success(response.message);
                $('#brokerForm')[0].reset();
                if (currentBrokerSelectBox) {
                    currentBrokerSelectBox.append(

                        $('<option>', {
                            value: response.broker.id,
                            text: response.broker.name,
                            selected: true
                        })
                    ).trigger('change');

                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
                } else {
                    toastr.error('Something went wrong, please try again later.');
                }
            }
        });
    });


    // gate pass form submit
    $('#gatePassForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/gate-pass',
            data: formData,
            success: function (response) {
                $('#addGatePassModal').modal('hide');
                toastr.success(response.message);
                $('#gatePassForm')[0].reset();
                $('#gatePass_id').append(
                    $('<option>', {
                        value: response.gatePass.id,
                        text: response.gatePass.name,
                        selected: true
                    })
                ).trigger('change');

            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
            }
            }
        });
    });


    // cleaning agent form submit
    $('#clearingAgentForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/clearing-agent',
            data: formData,
            success: function (response) {
                $('#addClearingAgent').modal('hide');
                toastr.success(response.message);
                $('#clearingAgentForm')[0].reset();
                $('#clearingAgent_id').append(
                    $('<option>', {
                        value: response.ca.id,
                        text: response.ca.name,
                        selected: true
                    })
                ).trigger('change');

            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });

    // customers

    // gate pass form submit
    $('#customerForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/customers',
            data: formData,
            success: function (response) {
                $('#addCustomerNameModal').modal('hide');
                toastr.success(response.message);
                $('#customerForm')[0].reset();
                $('#customer_id').append(
                    $('<option>', {
                        value: response.cus.id,
                        text: response.cus.first_name,
                        selected: true
                    })
                ).trigger('change');

            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });

    // add lifter charges
    let cureentLifterChargesSelectBox = null;
    $(document).on('click', '.open-lifter-charges-modal', function () {
        cureentLifterChargesSelectBox = $(this).closest('.lifter_charges_group').find('select.lifter_charges_id');
        $("#addLifterCharges").modal('show');
    });

    $('#lifterChargesForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/lifter-charges',
            data: formData,
            success: function (response) {
                $('#addLifterCharges').modal('hide');
                toastr.success(response.message);
                $('#lifterChargesForm')[0].reset();
                if (cureentLifterChargesSelectBox) {
                    cureentLifterChargesSelectBox.append(
                        $('<option>', {
                            value: response.lif.id,
                            text: response.lif.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
               if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
            }
            }
        });
    });

    // labour chaegs
    let currentLabourChargesBox = null;
    $(document).on('click', '.open-labour-charges-modal', function () {
        currentLabourChargesBox = $(this).closest(".labour_charges_group").find('select.labour_charges_id');
        $("#addLabourCharges").modal('show');
    })

    $('#labourChargesForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/labour-charges',
            data: formData,
            success: function (response) {
                $('#addLabourCharges').modal('hide');
                toastr.success(response.message);
                $('#labourChargesForm')[0].reset();
                if (currentLabourChargesBox) {
                    currentLabourChargesBox.append(
                        $('<option>', {
                            value: response.lc.id,
                            text: response.lc.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
              if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });



    // local Charges
    let currentlocalChargesBox = null;
    $(document).on('click', '.open_local_charges_modal', function () {
        currentlocalChargesBox = $(this).closest(".local_charges_group").find('select.local_charges_id');
        $("#addLocalCharges").modal('show');
    })

    $('#LocalChargesForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/local-charges',
            data: formData,
            success: function (response) {
                $('#addLocalCharges').modal('hide');
                toastr.success(response.message);
                $('#LocalChargesForm')[0].reset();
                if (currentlocalChargesBox) {
                    currentlocalChargesBox.append(
                        $('<option>', {
                            value: response.localc.id,
                            text: response.localc.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
              if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });


    // partyCommissionChargesForm
    let PartyCommissionChargesForm = null;
    $(document).on('click', '.open_party_commission_charges_modal', function () {
        PartyCommissionChargesForm = $(this).closest(".party_commission_charges_group").find('select.party_commission_charges_id');
        $("#addPartyCommissionCharges").modal('show');
    })

    $('#PartyCommissionChargesForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/party-commission-charges',
            data: formData,
            success: function (response) {
                $('#addPartyCommissionCharges').modal('hide');
                toastr.success(response.message);
                $('#PartyCommissionChargesForm')[0].reset();
                if (PartyCommissionChargesForm) {
                    PartyCommissionChargesForm.append(
                        $('<option>', {
                            value: response.party.id,
                            text: response.party.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });


    // tracker_charges
    let currentTrackerChargesBox = null;
    $(document).on('click', '.open_tracker_charges_modal', function () {
        currentTrackerChargesBox = $(this).closest(".tracker_charges_group").find('select.tracker_charges_id');
        $("#addTrackerCharges").modal('show');
    })

    $('#TrackerChargesForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/tracker-charges',
            data: formData,
            success: function (response) {
                $('#addTrackerCharges').modal('hide');
                toastr.success(response.message);
                $('#TrackerChargesForm')[0].reset();
                if (currentTrackerChargesBox) {
                    currentTrackerChargesBox.append(
                        $('<option>', {
                            value: response.tracker.id,
                            text: response.tracker.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
               if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });


    // other charges
    let currentOtherChargesBox = null;
    $(document).on('click', '.open_other_charges_modal', function () {
        currentOtherChargesBox = $(this).closest(".other_charges_group").find('select.other_charges_id');
        $("#addOtherCharges").modal('show');
    })

    $('#OtherChargesForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/module/other-charges',
            data: formData,
            success: function (response) {
                $('#addOtherCharges').modal('hide');
                toastr.success(response.message);
                $('#OtherChargesForm')[0].reset();
                if (currentOtherChargesBox) {
                    currentOtherChargesBox.append(
                        $('<option>', {
                            value: response.otherc.id,
                            text: response.otherc.name,
                            selected: true
                        })
                    ).trigger('change');
                }
            },
            error: function (xhr) {
               if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                     $.each(errors, function (field, messages) {
                    const input = $(`[name="${field}"]`);
                    if (input.length) {
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    }
                });
}
            }
        });
    });




    // Shipments

    $('#shipmentForm').on('submit', function (e) {

        e.preventDefault();
        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Clear old errors
        $('.error-message').text('');

        $.ajax({
            url: "/shippings",
            method: 'POST',
            data: formData,

            beforeSend: function () {
            $("#save_shipment").prop('disabled', true); // disable before sending
        },

            success: function (response) {
                console.log(response)
                if (response.success) {
                    toastr.success(response.message);
                    $('#shipmentForm')[0].reset();
                    if (response.html && response.html.html_content) {
                        // Inject HTML into hidden container
                        $('.printContainer').html(response.html.html_content);

                        // Trigger print after short delay
                        setTimeout(function () {
                            let printContents = document.getElementById('printContainer').innerHTML;
                            let printWindow = window.open('', '', 'height=600,width=800');
                            printWindow.document.write('<html><head><title>Print Job</title>');
                            printWindow.document.write('</head><body>');
                            printWindow.document.write(printContents);
                            printWindow.document.write('</body></html>');
                            printWindow.document.close();
                            printWindow.focus();
                            printWindow.print();
                            printWindow.close(); //remove after when need to print
                        }, 500);

                        window.location.href = "/shippings"
                    }

                }

            },
            error: function (xhr) {
                 $("#save_shipment").prop('disabled', false);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                    $.each(errors, function (field, messages) {
                        const name = field.replace(/\.\d+$/, '[]'); // no_of_packges.0 → no_of_packges[]
                        const input = $(`[name="${name}"]`).eq(field.split('.')[1] || 0);
                        input.next('.text-danger').text(messages[0]);
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    });

                }
            }
        });
    });



    // Update Shipments

    $('#shipmentEditForm').on('submit', function (e) {
        e.preventDefault();
        var shipment_id = $("#shipment_id").val();

        var formData = $(this).serialize();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Clear old errors
        $('.error-message').text('');

        $.ajax({
            url: "/shippings/" + shipment_id,
            method: 'PATCH',
            data: formData,

             beforeSend: function () {
            $("#save_shipment").prop('disabled', true); // disable before sending
        },

            success: function (response) {
                console.log(response)
                if (response.success) {
                    toastr.success(response.message);
                    $('#shipmentEditForm')[0].reset();
                    if (response.html && response.html.html_content) {
                        // Inject HTML into hidden container
                        $('.printContainer').html(response.html.html_content);

                        // Trigger print after short delay
                        setTimeout(function () {
                            let printContents = document.getElementById('printContainer').innerHTML;
                            let printWindow = window.open('', '', 'height=600,width=800');
                            printWindow.document.write('<html><head><title>Print Job</title>');
                            printWindow.document.write('</head><body>');
                            printWindow.document.write(printContents);
                            printWindow.document.write('</body></html>');
                            printWindow.document.close();
                            printWindow.focus();
                            printWindow.print();
                            printWindow.close(); //remove after when need to print
                        }, 500);

                        window.location.href = "/shippings"
                    }

                }

            },
            error: function (xhr) {
                 $("#save_shipment").prop('disabled', false);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                    $.each(errors, function (field, messages) {
                        const name = field.replace(/\.\d+$/, '[]'); // no_of_packges.0 → no_of_packges[]
                        const input = $(`[name="${name}"]`).eq(field.split('.')[1] || 0);
                        input.next('.text-danger').text(messages[0]);
                        input.closest('.form-group').find('.text-danger').text(messages[0]);
                    });

                }
            }
        });
    });

});
// end of document ready
