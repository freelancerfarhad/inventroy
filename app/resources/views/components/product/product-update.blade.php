<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Procudt</h5>
                </div>
                <div class="modal-body">
                    <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category <span style="color:red;"> *</span></label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option disabled selected>Select Category</option>
                                </select>
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productNameUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Product Price<span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productPriceUpdate">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Product Unit <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productUnitUpdate">
                            </div>

                            <div class="col-12 p-1">
                                <label class="form-label">Product Photo <span style="color:red;"> *</span></label>
                                <img id="oldImg"src="https://dummyimage.com/300x400/" width="100"height="100">
                                <input type="file"oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" class="form-control" id="productImgUpdate">
                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                  
                    <button id="update-modal-close"type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <button onclick="update()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
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
        $("#productCategoryUpdate").append(option);
    })
}
async function FillUpUpdateForm(id,filePath){

    document.getElementById('updateID').value=id;
    document.getElementById('filePath').value=filePath;
    document.getElementById('oldImg').src=filePath;


    showLoader();
    await FillCategoryDropDown();

    let res=await axios.post("/product-by-id",{id:id})
    hideLoader();

    document.getElementById('productNameUpdate').value=res.data['name'];
    document.getElementById('productPriceUpdate').value=res.data['price'];
    document.getElementById('productUnitUpdate').value=res.data['unit'];
    document.getElementById('productCategoryUpdate').value=res.data['category_id'];

}
async function update() {

let productCategoryUpdate=document.getElementById('productCategoryUpdate').value;
let productNameUpdate = document.getElementById('productNameUpdate').value;
let productPriceUpdate = document.getElementById('productPriceUpdate').value;
let productUnitUpdate = document.getElementById('productUnitUpdate').value;
let updateID=document.getElementById('updateID').value;
let filePath=document.getElementById('filePath').value;
let productImgUpdate = document.getElementById('productImgUpdate').files[0];


if (productCategoryUpdate.length === 0) {
    errorToast("Product Category Required !")
}
else if(productNameUpdate.length===0){
    errorToast("Product Name Required !")
}
else if(productPriceUpdate.length===0){
    errorToast("Product Price Required !")
}
else if(productUnitUpdate.length===0){
    errorToast("Product Unit Required !")
}

else {

    document.getElementById('update-modal-close').click();

    let formData=new FormData();
    formData.append('img_url',productImgUpdate)
    formData.append('id',updateID)
    formData.append('name',productNameUpdate)
    formData.append('price',productPriceUpdate)
    formData.append('unit',productUnitUpdate)
    formData.append('category_id',productCategoryUpdate)
    formData.append('file_path',filePath)



    const config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    }

    showLoader();
    let res = await axios.post("/update-product",formData,config)
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