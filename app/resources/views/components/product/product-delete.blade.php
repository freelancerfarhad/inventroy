<div class="modal" id="delete-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deleted Product</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <p>Are you sure to product deleted !</p>
                                <input class="d-none" id="deleteID"/>
                                <input class="d-none" id="deleteFilePath"/>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                  
                    <button id="modal-close"type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <button onclick="itemDelete()" id="save-btn" class="btn btn-sm  btn-danger" >Deleted</button>
                </div>
            </div>
    </div>
</div>

<script>
     async  function  itemDelete(){
            let id=document.getElementById('deleteID').value;
            let deleteFilePath=document.getElementById('deleteFilePath').value;
            document.getElementById('modal-close').click();
            showLoader();
            let res=await axios.post("/delete-product",{id:id,file_path:deleteFilePath})
            hideLoader();
            if(res.data===1){
                successToast("Request completed")
                await getList();
            }
            else{
                errorToast("Request fail!")
            }
     }
</script>