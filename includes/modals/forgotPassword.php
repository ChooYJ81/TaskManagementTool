<div class="modal fade" id="forgotPwModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width: 500px">
        <div class="modal-content p-3">
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-center">
                    <p class="title-1 m-0">Forgot Password</p>
                </div>
                <p class="text-1 mb-4 text-center">
                    Enter your email and new password to update and validate the OTP.
                </p>

                <form id="forgotPasswordForm" class="row">
                    <div class="col-12 mb-4">
                        <label class="input-label">Registered Email</label>
                        <input class="inputs" type="text" name="registeredEmail" placeholder="Enter your email" required />
                    </div>
                    <div class="col-12 mb-2">
                        <label class="input-label">New Password</label>
                        <input class="inputs" type="text" name="newPassword" placeholder="Enter a new password" required />
                    </div>


                    <div class="w-100 text-center">
                        <button type="submit" class="btn btn-primary mt-4 px-5 b-0" style="background-color:var(--blue)" id="forgotPasswordBtn">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>