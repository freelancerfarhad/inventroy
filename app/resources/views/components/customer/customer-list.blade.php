<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Customer</h4>
                </div>
                <div class="align-items-center col">
                    <button data-toggle="modal" data-target="#create-modal" class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>

                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead class="">
                <tr class="bg-light">
                    <th>No</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>

getList();


async function getList() {

    showLoader();
    let res = await axios.get("/list-customer");
    hideLoader();

    let tableList =$("#tableList");
    let tableData =$("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();


    res.data.forEach(function(item,index){
        let row = 
        `<tr>
            <td>${index+1}</td>
            <td>${item['name']}</td>
            <td>${item['email']}</td>
            <td>${item['mobile']}</td>
            <td>
               <button data-id="${item['id']}"class="btn EditBtn btn-outline-success">edit</button> 
               <button data-id="${item['id']}"class="btn DeleteBtn btn-sm btn-outline-danger">delete</button> 
            </td>
         </tr>`
         tableList.append(row);
    });

    $(".EditBtn").on('click', async function(){
      let id = $(this).data('id');
            await FillUpUpdateForm(id);
           $("#update-modal").modal('show');

    });  


    $(".DeleteBtn").on('click',function(){
       let id = $(this).data('id')
       $("#deleted-modal").modal('show');
        $("#deleteID").val(id);  
    });
 

    new DataTable('#tableData',{
        order:[[0,'asc']],
        lengthMenu:[5,10,15,20,30]
    });
 

    

}


</script>
