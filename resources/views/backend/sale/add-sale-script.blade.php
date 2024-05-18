<script>
$(document).ready(function() {
    $('.onex-datepicker').datepicker({
        container: '#bsDatePickerContainer',
        format: 'yyyy/mm/dd',
        endDate: '+0d',
        todayHighlight: true,
        autoclose:true
    });
    $('#saleDate').datepicker('setDate', $('#todayDateHidden').val());

    /*Add New Option Add to Select2*/
    $('#customerId').on('select2:open', () => {
        $(".select2-results:not(:has(a))").prepend('<a href="javascript:void(0);" class="select2-add-new-option" data-select2id="customerId" data-modal-id="addNewCustomerModal"><i class="fas fa-plus"></i> Add New Customer</a>');
    });

    /*Quick Add Modal Open*/
    $('body').on('click', '.select2-add-new-option', function(e) {
        e.preventDefault();
        $('#' + $(this).data('select2id')).select2('close');
        $('#' + $(this).data('modal-id')).modal({
            backdrop: 'static', 
            keyboard: false
        }, 'show');
    });

    /*Main Form Validation*/
    $("#frmx").validate({
        errorClass: 'onex-error',
        errorElement: 'div',
        rules: {
            received_date: {
                required: true
            },
            batch_id: {
                required: true,
                digits: true
            },
            customer_id: {
                required: true
            },
            product_id: {
                required: true,
                digits: true
            },
            unit_id: {
                required: true,
                digits: true
            },
            product_qty: {
                required: true,
                number: true
            },
            sale_price: {
                required: true,
                number: true
            },
            gst_rate: {
                required: true,
                number: true
            },
            gst_amount: {
                required: true,
                number: true
            },
            total_amount: {
                required: true,
                number: true
            }
        },
        messages: {
            received_date: {
                required: 'Please select date'
            },
            batch_id: {
                required: 'Please select batch id',
                digits: 'Invalid batch id'
            },
            customer_id: {
                required: 'Please select a customer'
            },
            product_id: {
                required: 'Please select a product',
                digits: 'Invalid product id'
            },
            unit_id: {
                required: 'Please select unit',
                digits: 'Invalid unit id'
            },
            product_qty: {
                required: 'Please enter quantity',
                number: 'Accept only number'
            },
            purchase_price: {
                required: 'Please enter purchase price',
                number: 'Accept only number'
            },
            gst_rate: {
                required: 'Please enter GST rate',
                number: 'Accept only number'
            },
            gst_amount: {
                required: 'Please enter GST amount',
                number: 'Accept only number'
            },
            total_amount: {
                required: 'Please enter total amount',
                number: 'Accept only number'
            },
            sale_price: {
                required: 'Please enter sale price',
                number: 'Accept only number'
            }
        },
        errorPlacement: function (error, element) {
            if(element.hasClass('onex-select2')) {
                error.insertAfter(element.parent().find('span.select2-container'));
            } else if(element.parent().hasClass('input-group')) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    /*Quick Customer Form Validation*/
    $("#addCustomerFrm").validate({
        errorClass: 'onex-error',
        errorElement: 'div',
        ignore: '.ignore',
        rules: {
            first_name: {
                required: true,
                maxlength: 30
            },
            last_name: {
                required: true,
                maxlength: 20
            },
            email_id: {
                required: true,
                email: true,
                maxlength: 60
            },
            phone_number: {
                required: true,
                digits: true,
                maxlength: 10,
                minlength: 10
            }
        },
        messages: {
            first_name: {
                required: 'Please enter first name',
                maxlength: 'Maximum 30 chars accepted'
            },
            last_name: {
                required: 'Please enter last name',
                maxlength: 'Maximum 20 chars accepted'
            },
            email_id: {
                required: 'Please enter email',
                email: 'Please enter valid email',
                maxlength: 'Maximum 60 chars accepted'
            },
            phone_number: {
                required: 'Please enter mobile number',
                digits: 'Please enter valid mobile number',
                maxlength: '10 digitis mobile number required',
                minlength: '10 digitis mobile number required'
            }
        }
    });

    /*Add Quick Customer Ajax Process*/
    $('body').on('click', '#addNewCustomerBtn', function() {
        if($('#addCustomerFrm').valid()) {
            displayLoading();
            $.ajax({
                type: $('#addCustomerFrm').attr('method'),
                url: $('#addCustomerFrm').attr('action'),
                data: $('#addCustomerFrm').serialize(),
                cache: false,
                beforeSend: function() {

                },
                success: function(responseData) {
                    closeSwal();
                    if(responseData) {
                        if(responseData.isSuccess == true && (responseData.data !== null || responseData.data !== '')) {
                            let data = {
                                id: responseData.data.hash_id,
                                text: `${responseData.data.first_name} ${responseData.data.last_name} - ${responseData.data.phone_number}` 
                            };
                            var newOption = new Option(data.text, data.id, false, false);
                            $('#customerId').append(newOption).val(data.id).trigger('change');
                            $('#customerId-error').hide();
                            $('#addCustomerFrm').find('.form-control').val('');
                            $('#addNewCustomerModal').modal('hide');
                            toastr.success(responseData.message, 'Done!');
                        }
                        if(responseData.isSuccess == false) {
                            toastr.error(responseData.message, 'Sorry!');
                        }
                    }
                },
                error: function(errorData) {
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong');
                }
            });
        }
    });

    /*Once Select2 Select Item Then Error Removed*/
    $('body').on('select2:select', '.onex-select2', function (e) { 
        if($(this).val() != '') {
            $('#' + $(this).attr('id') + '-error').hide();
            $(this).next('span.select2-container').removeClass('select2-custom-error');
            $(this).parent().find('.onex-form-lebel').removeClass('onex-error-label');
        }
    });
    $('#unitId').on('change', function() {
        if($(this).val() != '') {
            $('#' + $(this).attr('id') + '-error').hide();
        }
        $('#unitId').valid();
    });

    /*Ajax Call: When Product Dropdown Changed*/
    $('body').on('change', '#productId', function () {
        if($(this).val() != '') {
            let _productId = $(this).val();
            displayLoading();
            $.ajax({
                type: 'POST',
                url: "{{ route('sale.get-product-batches') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "product_id": _productId
                },
                cache: false,
                beforeSend: function() {
                    initPriceCalculation();
                    initItem();
                },
                success: function(responseData) {
                    $('#batchId').empty().html("<option value=''></option>").trigger("change");
                    closeSwal();
                    if(responseData) {
                        if(responseData.isSuccess == true && (responseData.data !== null || responseData.data !== '')) {
                            responseData.data.map((item, index) => {
                                if (item.batch_info.id != '' && item.batch_info.batch_no != '') {
                                    let newOption = new Option(`${item.batch_info.batch_no} (${item.batch_info.name}) - ${item.product_qty}`, item.batch_info.id, false, false);
                                    $('#batchId').append(newOption);
                                }
                            });
                            toastr.success(responseData.message, 'Done!');
                        }
                        if(responseData.isSuccess == false) {
                            toastr.error(responseData.message, 'Sorry!');
                        }
                    }
                },
                error: function(errorData) {
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong');
                }
            });
        }
    });

    /*Ajax Call: When Batch Dropdown Changed*/
    $('body').on('change', '#batchId', function () {
        if($(this).val() != '') {
            let _batchId = $(this).val();
            let _productId = $('#productId').val();
            displayLoading();
            $.ajax({
                type: 'POST',
                url: "{{ route('sale.get-purchase-product') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "batch_id": _batchId,
                    "product_id": _productId
                },
                cache: false,
                beforeSend: function() {
                    initPriceCalculation();
                    initItem();
                },
                success: function(responseData) {
                    closeSwal();
                    if(responseData) {
                        if(responseData.isSuccess == true && (responseData.data !== null || responseData.data !== '')) {
                            if (responseData.data.product_variant_info.available_stock && parseInt(responseData.data.product_variant_info.available_stock) <= 0) {
                                displayAlert('info', 'Product stock is showing 0');
                            } else {
                                $('#currentStock').val(responseData.data.product_variant_info.available_stock);
                                $('#batchProductId').val(responseData.data.batch_product_info.id);
                                $('#batchPurchasePrice').val(responseData.data.batch_product_info.purchase_price);
                                $('#batchSalePrice').val(responseData.data.batch_product_info.sale_price);
                                $('#batchQuantity').val(responseData.data.batch_product_info.product_qty);

                                if (parseFloat(responseData.data.sale_price) > 0) {
                                    $('#salePrice').val(responseData.data.sale_price);
                                } else {
                                    $('#salePrice').val(responseData.data.product_variant_info.price);
                                }

                                if (responseData.data.unit_id != '') {
                                    $('#unitId').val(responseData.data.unit_id).trigger('change');
                                } else {
                                    $('#unitId').val(responseData.data.product_variant_info.unit_id).trigger('change');
                                }

                                if (parseFloat(responseData.data.gst_rate) > 0) {
                                    $('#gstRate').val(responseData.data.gst_rate);
                                } else {
                                    $('#gstRate').val(responseData.data.product_variant_info.gst_rate);
                                }

                                $('#frmx').valid();
                                toastr.success(responseData.message, 'Done!');
                            }
                        }
                        if(responseData.isSuccess == false) {
                            toastr.error(responseData.message, 'Sorry!');
                        }
                    }
                },
                error: function(errorData) {
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong');
                }
            });
        }
    });

    $('#productQty').on('blur', function() {
        if ($(this).val() != '') {
            if (parseInt($(this).val()) <= parseInt($('#currentStock').val())) {
                salePriceCalculate();
            } else {
                initPriceCalculation();
                displayAlert('error', 'Oops!', 'Sale quantity is grater than current stock');
            }
        }
    });
    $('#salePrice').on('blur', function() {
        salePriceCalculate();
    });

    loadCartTable();
    function loadCartTable() {
        initCartTable();
        $('#createSaleBtn').attr('disabled', 'disabled');
    }

    /*Cart Table Init Load*/
    function initCartTable() {
        $('#addToCartTable').find('tbody').empty('').html(`
            <tr class="dummy-tr">
                <td>1.</td>
                <td>--</td>
                <td>0</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td><i class="fas fa-trash-alt" style="color: #a5a5a5;"></i></td>
            </tr>
            <tr class="dummy-tr">
                <td>2.</td>
                <td>--</td>
                <td>0</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td><i class="fas fa-trash-alt" style="color: #a5a5a5;"></i></td>
            </tr>
        `);
    }

    /*Price Related Calculation Fields Init Load*/
    function initPriceCalculation() {
        $('#salePrice').val('');
        $('#productQty').val('');
        $('#unitId').val('');
        $('#gstRate').val('0.00');
        $('#gstAmount').val('0.00');
        $('#totalAmount').val('0.00');
    }

    /*Hidden Fields Init Load*/
    function initItem() {
        $('#currentStock').val('');
        $('#batchProductId').val('');
        $('#batchPurchasePrice').val('');
        $('#batchSalePrice').val('');
        $('#batchQuantity').val('');
    }

    /*Price Calculation With GST*/
    function salePriceCalculate() {
        if ($('#productId').val() != '' && $('#batchId').val() != '' && $('#unitId').val() != '') {
            let productQty = parseFloat($('#productQty').val());
            let salePrice = parseFloat($('#salePrice').val());
            let gstRate = parseFloat($('#gstRate').val());
            let unitTotal = productQty * salePrice;
            let totalGst = (unitTotal * gstRate) / 100;
            let totalAmount = unitTotal + totalGst;

            $('#gstAmount').val(totalGst.toFixed(2));
            $('#totalAmount').val(totalAmount.toFixed(2));
        }
    }

    /*Ajax Call: Add Item To Cart Table*/
    $('#addItemBtn').on('click', function() {
        if($("#frmx").valid()) {
            if(parseFloat($('#salePrice').val()) < parseFloat($('#batchPurchasePrice').val())) {
                Swal.fire({
                    title: 'Want to Sale?',
                    text: "Sale price is less than Purchase price",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Add it!'
                }).then((result) => {
                    if(result.isConfirmed) {
                        displayLoading();
                        $('#addItemBtn').attr('disabled', 'disabled');
                        addItemToCartTable();
                    }
                });
            } else {
                displayLoading();
                $('#addItemBtn').attr('disabled', 'disabled');
                addItemToCartTable();
            }
        } else {
            displayAlert('error', 'Oops!', 'Please check all the required fields');
        }
    });

    /*Ajax: Add Item To Cart Table - Session Process*/
    function addItemToCartTable() {
        $('.cart-reload-btn').removeClass('d-none');
        $('#cancleSaleBtn').removeClass('d-none');
        $('#emptyCartItemBtn').removeClass('d-none');
        $('#createSaleBtn').removeAttr('disabled');
        $('#addItemBtn').removeAttr('disabled');

        $('#productId').val('').trigger('change');
        $('#batchId').empty().html("<option value=''></option>").trigger("change");
        initPriceCalculation();
        initItem();
    }

    $('body').on('click', '#createSaleBtn', function() {
        if ($('#invoiceNo').valid() && $('#saleDate').valid() && $('#customerId').valid()) {
            saleProcess();
        } else {
            displayAlert('error', 'Oops!', 'Please check all the required fields');
        }
    });

    function saleProcess() {
        console.log('xxxxxxxx');
    }
});
</script>