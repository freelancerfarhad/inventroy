<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="CustomerName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer E-mail <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="CustomerEmail">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Mobile <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="CustomerMobile">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                  
                    <button id="modal-close"type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>

    async function Save() {

        let CustomerName = document.getElementById('CustomerName').value;
        let CustomerEmail = document.getElementById('CustomerEmail').value;
        let CustomerMobile = document.getElementById('CustomerMobile').value;

        if (CustomerName.length === 0) {
            errorToast("Customer Name Required !")
        }else if (CustomerEmail.length === 0) {
            errorToast("Customer E-mail Required !")
        }else if (CustomerMobile.length === 0) {
            errorToast("Customer Mobile Required !")
        }
        else {
            document.getElementById('modal-close').click();

            showLoader();
            let res = await axios.post(
                "/create-customer",
                {
                    name:CustomerName,
                    email:CustomerEmail,
                    mobile:CustomerMobile
                });
            hideLoader();

            if(res.status===200 && res.data['status']==='success'){

                successToast(res.data['message']);

                document.getElementById("save-form").reset();

                await getList();
            }
            else{
                errorToast(res.data['message']);
            }
        }
    }

</script>