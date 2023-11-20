<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Procudt</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category <span style="color:red;"> *</span></label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option disabled selected>Select Category</option>
                                </select>
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Product Price<span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productPrice">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Product Unit <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productUnit">
                            </div>

                            <div class="col-12 p-1">
                                <label class="form-label">Product Photo <span style="color:red;"> *</span></label>
                                <img id="showImage"src="https://dummyimage.com/300x400/" width="100"height="100">
                                <input type="file"oninput="showImage.src=window.URL.createObjectURL(this.files[0])" class="form-control" id="ProductImage">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                  
                    <button id="create-modal-close"type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>
    FillCategoryDropDown();

async function FillCategoryDropDown(){
    let res = await axios.get("/list-category")
    res.data.forEach(function (item,i) {
        let option=`<option value="${item['id']}">${item['name']}</option>`
        $("#productCategory").append(option);
    })
}




async function Save() {

    let productCategory=document.getElementById('productCategory').value;
    let productName = document.getElementById('productName').value;
    let productPrice = document.getElementById('productPrice').value;
    let productUnit = document.getElementById('productUnit').value;
    let productImg = document.getElementById('ProductImage').files[0];

    if (productCategory.length === 0) {
        errorToast("Product Category Required !");
    }else if(productName.length===0){
        errorToast("Product Name Required !");
    }else if(productPrice.length===0){
        errorToast("Product Price Required !");
    }else if(productUnit.length===0){
        errorToast("Product Unit Required !");
    }else if(!productImg){
        errorToast("Product Image Required !");
    }else {

       

        let formData=new FormData();
        formData.append('img_url',productImg);
        formData.append('name',productName);
        formData.append('price',productPrice);
        formData.append('unit',productUnit);
        formData.append('category_id',productCategory);

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }

        document.getElementById('create-modal-close').click();
        showLoader();
        let res = await axios.post("/create-product",formData,config);
        hideLoader();

        if(res.status===200 && res.data['status']==='success'){
            successToast(res.data['message']);
            document.getElementById("save-form").reset();
            await getList();
        }
        else{
            errorToast("Request fail !");
        }
    }
}
    //img
    // $(document).ready(function(){
    //     $('#ProductImage').change(function(e){
    //         var reader = new FileReader();
    //         reader.onload = function(e){
    //             $('#showImage').attr('src',e.target.result);
    //         }
    //         reader.readAsDataURL(e.target.files['0']);
    //     });
    // });
</script>