<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Updated Customer</h5>
                </div>
                <div class="modal-body">
                    <form id="update-form">
                    <div class="container">
                        <div class="row">

                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="customerNameUpdate">
                            </div>

                            <div class="col-12 p-1">
                                <label class="form-label">Customer E-mail <span style="color:red;"> *</span></label>
                                <input type="email" class="form-control" id="customerEmail">
                            </div>

                            <div class="col-12 p-1">
                                <label class="form-label">Customer Mobile <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="customerMobile">
                                <input class="d-none" id="updateID">
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                  
                    <button id="update-modal-close"type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <button onclick="Update()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>
    
   async function FillUpUpdateForm(id){
        document.getElementById('updateID').value=id;
        showLoader();
        let res=await axios.post("/customer-by-id",{id:id})
        hideLoader();
        document.getElementById('customerNameUpdate').value=res.data['name'];
        document.getElementById('customerEmail').value=res.data['email'];
        document.getElementById('customerMobile').value=res.data['mobile'];
    }


  async function Update() {

    let customerNameUpdate = document.getElementById('customerNameUpdate').value;
    let customerEmail      = document.getElementById('customerEmail').value;
    let customerMobile     = document.getElementById('customerMobile').value;
        let updateID       = document.getElementById('updateID').value;

        if (customerNameUpdate.length === 0) {
            errorToast("Customer Name Required !")
        }else if(customerEmail.length === 0){
            errorToast("Customer Email Required !")
        }else if(customerMobile.length === 0){
            errorToast("Customer Mobile Required !")
        }
         else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let res = await axios.post("/update-customer",{name:customerNameUpdate,id:updateID,email:customerEmail,mobile:customerMobile})
            hideLoader();

            if(res.status===200 && res.data['status']==='success'){
                document.getElementById("update-form").reset();
                successToast(res.data['message']);
                await getList();
            }
            else{
                errorToast(res.data['message']);
            }
            


    }



}



</script>