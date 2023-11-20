<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-8">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Profile-Updated</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                
                        <div class="row m-0 p-0">
                          
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>User Images</label>
                                <input type="file" id="image"name="image"class="form-control">
                               
                            </div>
                      
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onProfileUpdate()" class="btn mt-3 w-100  btn-primary">Complete</button>
                            </div>
                        </div>
                 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body text-center">
                    <h4>Profile-Bio</h4>
                    <hr/>
                    <div class="img-div text-center">
                        <img id="showImage"src="https://dummyimage.com/300x400/" width="100"height="100"class="rounded-circle">
                    </div>
                    <div class="profile-title text-center">
                        <p><b>E-mail:</b> farhad@gmal.com</p>
                        <p><b>Name:</b> farhad@gmal.com</p>
                        <p><b>Phone No:</b> farhad@gmal.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();
    async function getProfile(){
        // showLoader();
        let res=await axios.get("/user-profile");
        // hideLoader();
        if(res.status===200 && res.data['status']==='success'){
            let data=res.data['data'];
            document.getElementById('email').value=data['email'];
            document.getElementById('firstName').value=data['firstName'];
            document.getElementById('lastName').value=data['lastName'];
            document.getElementById('mobile').value=data['mobile'];
            document.getElementById('password').value=data['password'];
        }
        else{
            errorToast(res.data['message']);
        }

    }

    async function onProfileUpdate() {

     let firstName = document.getElementById('firstName').value;
     let lastName = document.getElementById('lastName').value;
     let mobile = document.getElementById('mobile').value;
     let password = document.getElementById('password').value;
     let profileImage = document.getElementById('image').files[0]; // Get the selected image file


     if(firstName.length===0){
        errorToast('First-Name Required');
     }else if(lastName.length===0){
        errorToast('Last-Name Required');
     }else if(mobile.length===0){
        errorToast('Mobile Required');
     }else if(password.length===0){
        errorToast('Password Required');
     }else if(password.length <= 3){
            errorToast('Password should be 3 characters more then !');
     }else if(password.length >= 8){
            errorToast('Password should be 8 characters less then !');
     }else{
        showLoader();
        let res = await axios.post(
            "/user-update",
            {
                email:email,
                firstName:firstName,
                lastName:lastName,
                mobile:mobile,
                password:password,
            });
            hideLoader();
            if(res.status===200 && res.data['status']==='success'){
                successToast(res.data['message']);
                  await getProfile();

            }else{
                errorToast(res.data['message']);
            }
         }
    }
    




    
    //img
    document.addEventListener('DOMContentLoaded', function () {
        
        const imageInput = document.getElementById('image');
        imageInput.addEventListener('change', function (e) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const showImageElement = document.getElementById('showImage');
                showImageElement.src = e.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        });
     });


</script>