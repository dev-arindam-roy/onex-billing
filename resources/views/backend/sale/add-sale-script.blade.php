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
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
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
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
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
                                $('#purchaseProductId').val(responseData.data.id);
                                $('#batchPurchasePrice').val(responseData.data.batch_product_info.purchase_price);
                                $('#batchSalePrice').val(responseData.data.batch_product_info.sale_price);
                                $('#batchQuantity').val(responseData.data.batch_product_info.product_qty);

                                if (parseFloat(responseData.data.batch_product_info.sale_price) > 0) {
                                    $('#salePrice').val(responseData.data.batch_product_info.sale_price);
                                } else if (parseFloat(responseData.data.sale_price) > 0) {
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
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
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

    /*Page Load: Cart Table Render By Session Data*/
    loadCartTable();
    function loadCartTable() {
        let onexcart = [];
        let sessionCart = document.getElementById('cartTableJson').value;
        if (sessionCart && sessionCart != '') {
            onexcart = Object.values(JSON.parse(sessionCart));
        }
        //console.log(onexcart);
        if (onexcart.length > 0) {
            $('#addToCartTable').find('tbody').empty('').html(cartTableLoadingPlaceholder());
            setTimeout(() => {
                cartTableRenderDynamically(onexcart);
                cartActionButtons();
            }, 3000);
        } else {
            initCartTable();
            $('#createSaleBtn').attr('disabled', 'disabled');
            cartActionButtons();
        }
    }

    /*Cart Table Creation Dynamically - Page load (Session Data) & Ajax Call*/
    function cartTableRenderDynamically(onexcartObj) {
        if (onexcartObj.length) {
            let slNo = 1;
            let sumTotal = parseFloat(0);
            $('#addToCartTable').find('tbody').html('');
            $('#cartItemCount').html(`(${onexcartObj.length})`);
            onexcartObj.map((item, index) => {
                let cartItemTr = `
                    <tr class="cart-item" id="cartItem-${index}">
                        <td>${slNo}</td>
                        <td>
                            <span class="cart-item-product-name">${item.product_info.name}</span><br/>
                            <span class="cart-item-product-barcode">${item.product_info.barcode_no}</span><br/>
                            <span class="cart-item-product-brand">${item.product_info.product_brand.name}</span><br/>
                        </td>
                        <td>${item.product_info.hsn_code ?? ''}</td>
                        <td>${item.price_info.item_qty}</td>
                        <td>${parseFloat(item.price_info.unit_price).toFixed(2)}</td>
                        <td>${parseFloat(item.price_info.gst_rate).toFixed(2)}</td>
                        <td>${parseFloat(item.price_info.total_sgst_amount).toFixed(2)}</td>
                        <td>${parseFloat(item.price_info.total_cgst_amount).toFixed(2)}</td>
                        <td>${parseFloat(item.price_info.total_igst_amount).toFixed(2)}</td>
                        <td>${parseFloat(item.price_info.total_amount).toFixed(2)}</td>
                        <td>
                            <a href="javascript:void(0);" class="cart-item-delete-btn" id="cartItemDelBtn-${index}" data-cart-product="${item.product_info.id}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </a>
                        </td>
                    </tr>
                `;
                sumTotal = sumTotal + parseFloat(item.price_info.total_amount);
                let totalDiscount = parseFloat(0);
                let totalPayable = sumTotal;
                if (document.getElementById('totalCartDiscount').value != '') {
                    if (parseFloat(document.getElementById('totalCartDiscount').value) > 0) {
                        totalDiscount = parseFloat(document.getElementById('totalCartDiscount').value);
                    }
                }
                totalPayable = sumTotal - totalDiscount;
                slNo++;
                $('#addToCartTable').find('tbody').append(cartItemTr);
                $('#addToCartTable tfoot').find('td#totalCartAmount').html(`${sumTotal.toFixed(2)}`);
                $('#addToCartTable tfoot').find('td#totalPayableCartAmount').html(`${Math.round(totalPayable).toFixed(2)}`);
            });
        }
    }

    /*Cart Table Init Load*/
    function initCartTable() {
        $('#addToCartTable').find('tbody').empty('').html(`
            <tr class="dummy-tr">
                <td>1.</td>
                <td>--</td>
                <td>--</td>
                <td>0</td>
                <td>0.00</td>
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
                <td>--</td>
                <td>0</td>
                <td>0.00</td>
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
        $('#purchaseProductId').val('');
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

    /*Ajax Call: Add New Item To Cart Table - Using Session Process*/
    function addItemToCartTable() {
        displayLoading();
        $.ajax({
            type: $('#frmx').attr('method'),
            url: "{{ route('sale.add-item') }}",
            data: $('#frmx').serialize(),
            cache: false,
            beforeSend: function() {

            },
            success: function(responseData) {
                closeSwal();
                $('#addItemBtn').removeAttr('disabled');
                if(responseData) {
                    if(responseData.isSuccess == true && (responseData.data !== null || responseData.data !== '')) {
                        let onexcart = Object.values(responseData.data);
                        if (onexcart.length > 0) {
                            $('#addToCartTable').find('tbody').empty('').html(cartTableLoadingPlaceholder());
                            setTimeout(() => {
                                cartTableRenderDynamically(onexcart);
                                toastr.success(responseData.message, 'Done!');
                                cartActionButtons();
                            }, 3000);
                            $('#productId').val('').trigger('change');
                            $('#batchId').empty().html("<option value=''></option>").trigger("change");
                            initPriceCalculation();
                            initItem();
                        } else {
                            displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again or Reload The Page');
                        }
                    }

                    if(responseData.isSuccess == false) {
                        toastr.error(responseData.message, 'Sorry!');
                    }
                }
            },
            error: function(errorData) {
                displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
            }
        });
    }

    function cartActionButtons() {
        if($('#addToCartTable tbody').find('tr.cart-item').length > 0) {
            $('.cart-reload-btn').removeClass('d-none');
            $('#cancleSaleBtn').removeClass('d-none');
            $('#createSaleBtn').removeAttr('disabled');
        } else {
            $('.cart-reload-btn').addClass('d-none');
            $('#cancleSaleBtn').addClass('d-none');
            $('#createSaleBtn').attr('disabled', 'disabled');
        }
    }

    $('body').on('click', '#createSaleBtn', function() {
        if ($('#invoiceNo').valid() && $('#saleDate').valid() && $('#customerId').valid()) {
            displayLoading();
            saleProcess();
        } else {
            displayAlert('error', 'Oops!', 'Please check all the required fields');
        }
    });

    function saleProcess() {
        $.ajax({
            type: "POST",
            url: "{{ route('sale.save') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "total_discount": document.getElementById('totalCartDiscount').value
            },
            cache: false,
            beforeSend: function() {

            },
            success: function(responseData) {
                closeSwal();
                if(responseData) {
                    if(responseData.isSuccess == true && (responseData.data !== null || responseData.data !== '')) {
                        toastr.success(responseData.message, 'Done!');
                        displayAlert('success', 'Done!', `Sale has been created successfullt<br/><strong>Invoice No: ${responseData.data.invoice_no}</strong><br/>Please Wait...`, false);
                        setTimeout(() => {
                            window.location.href = "{{ route('sale.index') }}";
                        }, 3000);
                    }
                    if(responseData.isSuccess == false) {
                        toastr.error(responseData.message, 'Sorry!');
                    }
                } else {
                    displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
                }
            },
            error: function(errorData) {
                displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
            }
        })
    }

    $('body').on('click', '.cart-item-delete-btn', function(e) {
        e.preventDefault();
        if($(this).data('cart-product') != '' && $(this).attr('id') != '') {
            let _productId = $(this).data('cart-product');
            let _thisTrId = $(this).attr('id');
            Swal.fire({
                title: 'Want to Remove?',
                text: "Are you want to remove this item from list",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove it!',
                cancelButtonText: 'No'
            }).then((result) => {
                if(result.isConfirmed) {
                    displayLoading();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('sale.remove-item') }}",
                        data: {
                            "product_id": _productId,
                            "_token": "{{ csrf_token() }}"
                        },
                        cache: false,
                        beforeSend: function() {

                        },
                        success: function(responseData) {
                            closeSwal();
                            if(responseData) {
                                if(responseData.isSuccess == true && (responseData.data !== null || responseData.data !== '')) {
                                    let onexcart = Object.values(responseData.data);
                                    if (onexcart.length > 0) {
                                        $('#addToCartTable').find('tbody').empty('').html(cartTableLoadingPlaceholder());
                                        setTimeout(() => {
                                            cartTableRenderDynamically(onexcart);
                                            toastr.success(responseData.message, 'Done!');
                                            cartActionButtons();
                                        }, 3000);
                                    } else {
                                        displayAlert('info', 'Empty Cart!', 'Your Sale Cart Is Empty <br/> Please Wait...', false);
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                }

                                if(responseData.isSuccess == false) {
                                    toastr.error(responseData.message, 'Sorry!');
                                }
                            }
                        },
                        error: function(errorData) {
                            displayAlert('error', 'SERVER ERROR!', 'Something Went Wrong <br/> Please Try Again Later');
                        }
                    });
                }
            });
        }
    });

    $('body').on('click', '#cancleSaleBtn', function() {
        Swal.fire({
            title: 'Want to Cancel?',
            text: "Are you want to cancel this sale",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!',
            cancelButtonText: 'No'
        }).then((result) => {
            if(result.isConfirmed) {
                displayLoading();
                window.location.href = "{{ route('sale.cancel') }}";
            }
        });
    });

    $('body').on('click', '.cart-reload-btn', function() {
        displayLoading();
        window.location.reload();
    });

    document.getElementById('totalCartDiscount').addEventListener("blur", invoiceDiscountCalculation);

    function invoiceDiscountCalculation() {
        let discount = parseFloat(0);
        if (document.getElementById('totalCartDiscount').value != '') {
            if (parseFloat(document.getElementById('totalCartDiscount').value) > 0) {
                discount = parseFloat(document.getElementById('totalCartDiscount').value);
            }
        } else {
            document.getElementById('totalCartDiscount').value = parseFloat(0).toFixed(2);
        }
        let totalAmount = parseFloat(document.getElementById('totalCartAmount').innerHTML);
        if (discount > totalAmount) {
            displayAlert('error', 'Wrong Discount!', 'Discount Price Should Be Less Than ToTal Amount<br/>Please Check...');
            document.getElementById('totalCartDiscount').value = parseFloat(0).toFixed(2);
            document.getElementById('totalPayableCartAmount').innerHTML = Math.round(totalAmount).toFixed(2);
        } else {
            let totalPayable = Math.round(totalAmount - discount);
            document.getElementById('totalPayableCartAmount').innerHTML = totalPayable.toFixed(2);
        }
    }
});
</script>