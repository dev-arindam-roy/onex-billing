<!-- Add Customer Modal -->
<div class="modal fade" id="addNewCustomerModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title select2-option-modal-title"><i class="fas fa-plus-square text-success"></i> Add New Customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form name="add_customer_frm" id="addCustomerFrm" action="{{ route('user.quick-add') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstName" class="onex-form-label">First Name: <em>*</em></label>
                        <input type="text" name="first_name" id="firstName" class="form-control" placeholder="Enter First Name" required="required"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName" class="onex-form-label">Last Name: <em>*</em></label>
                        <input type="text" name="last_name" id="lastName" class="form-control" placeholder="Enter Last Name" required="required"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phoneNumber" class="onex-form-label">Phone Number: <em>*</em></label>
                        <input type="number" name="phone_number" id="phoneNumber" class="form-control" placeholder="Enter Mobile Number" required="required" autocomplete="new-phone-number"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emailId" class="onex-form-label">Email Id: <em>*</em></label>
                        <input type="email" name="email_id" id="emailId" class="form-control" placeholder="Enter Email Id" required="required" autocomplete="new-email"/>
                    </div>
                </div>
            </div>
            <input type="hidden" name="user_category" id="userCategory" value="5"/>
            <input type="hidden" name="role_id" id="userRole" value="3"/>
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" id="addNewCustomerBtn" class="btn btn-success mr-auto">Add Customer</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->