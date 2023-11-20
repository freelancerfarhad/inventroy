<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>ENTER OTP CODE</h4>
                    <br/>
                    <label>4 Digit Code Here</label>
                    <input id="code" placeholder="Code" class="form-control" type="text"/>
                    <br/>
                    <button onclick="VerifyOtp()"  class="btn w-100 float-end btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   async function VerifyOtp() {

        let code=document.getElementById('code').value;
        if(code.length!==4){
            errorToast('4 Digit Opt Code Required !');
        }
        else{
            let res = await axios.post(
                "/otp-verify",
                {
                    otp:code,
                    email:sessionStorage.getItem('email')
                });
                if(res.status==200){
                    // successToast('4 digit Otp code your emall or checked, successfully !');
                    sessionStorage.clear();
                    window.location.href="/ResetPasswordPage";
                }
                else{
                  errorToast('Otp Not Valid !');
             }
        }

    }
</script>