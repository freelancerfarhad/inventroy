@extends('Layouts.sidenav-layout')
@section('content')
    
<div class="container-fluid">
    <div class="row">

        <div class="col-md-4 col-sm-12 col-lg-4 p-2">
            <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                <div class="row">
                    <div class="col-8">
                        <p class="text-bold text-dark">BILLED TO</span>
                        <p class="text-xs mx-0 my-1">Name:  <span id="cName"></span></p>
                        <p class="text-xs mx-0 my-1">Email:  <span id="cEmail"></span></p>
                        <p class="text-xs mx-0 my-1">User ID:  <span id="cId"></span></p>
                    </div>
                    <div class="col-4">
                        <img src="{{asset('assets/logo.png')}}" alt="" class="w-40">
                        <p class="text-bold mx-0 my-1 text-dark">Invoice</p>
                        <p class="text-bold mx-0 my-1 text-dark">Date: {{date('Y-m-d')}}</p>
                    </div>
                </div>
                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                    <div class="col-12">
                        <table class="table  w-100" id="invoiceTable">
                            <thead class="w-100">
                            <tr class="text-xs">
                                <th>Name</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody class="w-100"id="invoiceList">
        
                            </tbody>
                        </table>

                    </div>
                </div>
                <hr class="mx-0 my-2 p-0 bg-secondary"/>
                <div class="row">
                   <div class="col-12">
                       <p class="text-bold text-xs my-1 text-dark"> TOTAL: <i class="bi bi-currency-dollar"></i> <span id="total"></span></p>
                       <p class="text-bold text-xs my-2 text-dark"> PAYABLE: <i class="bi bi-currency-dollar"></i>  <span id="payable"></span></p>
                       <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>  <span id="vat"></span></p>
                       <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>  <span id="discount"></span></p>
                       <span class="text-xxs">Discount(%):</span>
                       <input onkeydown="return false" value="0" min="0" type="number" step="0.25" onchange="DiscountChange()" class="form-control w-40 " id="discountP"/>
                       <p>
                          <button onclick="createInvoice()" class="btn  my-3 bg-gradient-primary w-40">Confirm</button>
                       </p>
                   </div>
                    <div class="col-12 p-2">

                    </div>
                    </div>

            </div>
        </div> <!----end col------>

        <div class="col-md-4 col-sm-12 col-lg-4 p-2">
            <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                <table class="table table-sm w-100" id="productTable">
                    <thead class="w-100">
                    <tr class="text-xs">
                        <th>Product</th>
                        <th>Price</th>
                        <th>Pick</th>
                    </tr>
                    </thead>
                    <tbody class="w-100"id="productList">

                    </tbody>
                </table>
            </div>
        </div> <!----end col------>

        <div class="col-md-4 col-sm-12 col-lg-4 p-2">
            <div class="shadow-sm h-100 bg-white rounded-3 p-3">
                <table class="table table-sm w-100" id="customerTable">
                    <thead class="w-100">
                    <tr class="text-xs">
                        <th>No</th>
                        <th>Customer</th>
                        <th>Pick</th>
                    </tr>
                    </thead>
                    <tbody class="w-100"id="customerList">

                    </tbody>
                </table>
            </div>
        </div> <!----end col------>

    </div>
</div>
<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Products</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Products Id <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="PId">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Products Name <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="PName">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Products Price <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="PPrice">
                            </div>
                            <div class="col-12 p-1">
                                <label class="form-label">Products Quy <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="productQty">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                  
                    <button id="modal-close"type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>

                    <button onclick="add()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
                </div>
            </div>
    </div>
</div>

<script>
    let invoiceItemList=[];

    //fiveth data show tabile card
    function showInvoiceItemList(){
        let invoiceList =$("#invoiceList");
        invoiceList.empty();
        invoiceItemList.forEach(function(item,index){
            let row =
             `<tr class="text-xs">
                <td>${item['name']}</td>
                <td>${item['qty']}</td>
                <td>${item['sale_price']}</td>
                <td><a data-index="${index}"class="btn remove text-xxs px-2 py-1 0-auth btn-sm">remove</a></td>
                </tr>`
                invoiceList.append(row);
        });
        CalculateGrandTotal();

        $(".remove").on('click', async function(){
        let index = $(this).data('index');
            removeItem(index);
    });  
    }
    //six remove and update data card work
    function  removeItem(index){
        invoiceItemList.splice(index,1);
        showInvoiceItemList();
    } 
    //eight discunt update
    function DiscountChange() {
            CalculateGrandTotal();
        }
    // seven item calculate

    function CalculateGrandTotal(){
        let Total=0;
        let Payable=0;
        let Vat=0;
        let Discount=0;
        let DiscountPersenties = parseFloat(document.getElementById('discountP').value);

        invoiceItemList.forEach((item,index)=>{
            Total = Total+parseFloat(item['sale_price']);
        })
   


        if(DiscountPersenties===0){
            Vat = ((Total*5)/100).toFixed(2);
        }else{
            Discount = (Total*DiscountPersenties)/100;
            Total = (Total-((Total*DiscountPersenties)/100)).toFixed(2);
            // Total = Total-Discount.toFixed(2);
            Vat = ((Total*5)/100).toFixed(2);
        }

      
        Payable=(parseFloat(Total)+parseFloat(Vat)).toFixed(2);
            document.getElementById('total').innerText=Total;
            document.getElementById('payable').innerText=Payable;
            document.getElementById('vat').innerText=Vat;
            document.getElementById('discount').innerText=Discount;
    }

    //fourth card added
    function add(){
        let PId = document.getElementById('PId').value;
        let PName = document.getElementById('PName').value;
        let PPrice = document.getElementById('PPrice').value;
        let productQty = document.getElementById('productQty').value;
        let ProductTotal = parseFloat(PPrice)*parseFloat(productQty).toFixed(2);
        if(PId.length===0){
            errorToast('Product Id Required');
        }else if(PName.length===0){
            errorToast('Product Name Required');
        }else if(PPrice.length===0){
            errorToast('Product Price Required');
        }else if(productQty.length===0){
            errorToast('Product QTY Required');
        }else{
            let item = {name:PName,product_id:PId,qty:productQty,sale_price:ProductTotal};
            invoiceItemList.push(item);
            console.log(invoiceItemList);
            $("#create-modal").modal('hide');
            showInvoiceItemList();
        }
    }

// third addmodal added
    async function addModal(id,name,price){
        let productid = document.getElementById('PId').value=id;
        let productName = document.getElementById('PName').value=name;
        let productPrice = document.getElementById('PPrice').value=price;
           $("#create-modal").modal('show');

    }; 
//first customer added
    customerList();
async function customerList() {
    showLoader();
    let res = await axios.get("/list-customer");
    hideLoader();
    let customerList =$("#customerList");
    let customerTable =$("#customerTable");

    customerTable.DataTable().destroy();
    customerList.empty();


    res.data.forEach(function(item,index){
        let row = 
        `<tr class="text-xs">
            <td>${index+1}</td>
            <td><i class="bi bi-person"></i>${item['name']}</td>
            <td><a data-name="${item['name']}"data-email="${item['email']}"data-id="${item['id']}"class="btn btn-outline-dark addCustomer text-xxs px-2 py-1 btn-sm m-auto">add</a></td>
         </tr>`
         customerList.append(row);
    });
    $(".addCustomer").on('click', async function(){
        let cName = $(this).data('name');
        let cEmail = $(this).data('email');
        let cId = $(this).data('id');

        $('#cName').text(cName);
        $('#cEmail').text(cEmail);
        $('#cId').text(cId);

    });  

    new DataTable('#customerTable',{
        order:[[0,'asc']],
        scrollCollapse:false,
        info:false,
        lengthChange:false
    });
 

}

 
//second porduct added
productList();
async function productList() {
        let res = await axios.get("/list-product");
    let productList =$("#productList");
    let productTable =$("#productTable");

    productTable.DataTable().destroy();
    productList.empty();


    res.data.forEach(function(item,index){
        let row = 
        `<tr class="text-xs">
            <td><i class="bi bi-person"></i><img src="${item['img_url']}"class="w-20"/>
            <i class="bi bi-person"></i>${item['name']}</td>
            <td>$${item['price']}</td>
            <td><a data-id="${item['id']}" data-name="${item['name']}"data-price="${item['price']}"class="btn btn-outline-dark addProduct text-xxs px-2 py-1 btn-sm m-auto">add</a></td>
         </tr>`
         productList.append(row);
    });
    $(".addProduct").on('click', async function(){
        let PId = $(this).data('id');
        let PName = $(this).data('name');
        let PPrice = $(this).data('price');
        addModal(PId,PName,PPrice);

        // $('#PName').text(PName);
        // $('#PPrice').text(PPrice);
        // $('#PId').text(PId);

    });  
}

async function createInvoice(){
    let total = document.getElementById('total').innerText;
    let discount = document.getElementById('discount').innerText;
    let vat = document.getElementById('vat').innerText;
    let payable = document.getElementById('payable').innerText;
    let cId = document.getElementById('cId').innerText;

    let Data= {
        "total":total,
    "discount":discount,
    "vat":vat,
    "payable":payable,
    "customer_id":cId,
    "products":invoiceItemList
    }

    if (cId.length === 0) {
        errorToast("Customer Required !");
    }else if (total.length === 0) {
        errorToast("Product TOtal Required !");
    }else if (discount.length === 0) {
        errorToast("Product Discount Required !");
    }else if (vat.length === 0) {
        errorToast("Product Vat Required !");
    }else if (payable.length === 0) {
        errorToast("Product Payable Required !");
    }else{
        showLoader();
    let res = await axios.post("/create-invoice",Data);
    hideLoader();
    if(res.status===200 && res.data['status']==='success'){
            window.location.href="/invoicePage";
            successToast(res.data['message']);
        }
        else{
            errorToast("Request fail !");
        }
    }
    
}
</script>


 @endsection


