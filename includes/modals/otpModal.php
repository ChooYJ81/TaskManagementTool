<!-- OTP Modal -->
<div class="modal fade otpModal" id="otpModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="width: 430px;">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <img src="./images/rafiki.png" />
                <p class="title-1 mt-2">Verify your email</p>
                <p style="font-size:0.875rem" class="text-wrap">Enter the five-digit code we sent to your email address to verify your new SunCollab account.</p>
                <form id="otpForm">
                    <div class="otpInputs">
                        <input type="text" maxlength="1" autofocus />
                        <input type="text" maxlength="1" />
                        <input type="text" maxlength="1" />
                        <input type="text" maxlength="1" />
                        <input type="text" maxlength="1" />
                    </div>
                    <button class="button-fill mb-3 px-3 py-2" type="submit">Verify Now</button>
                </form>
                <br>
                <a href="#" style="font-size: 0.875rem;">Resend OTP?</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verifiedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="width: 430px;">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <img src="./images/amico.png" />
                <p class="title-1 mt-4">Account Verified!</p>
                <p style="font-size:0.875rem" class="text-wrap">Yahoo! You have successfully verified the account.</p>
                <a class="button-fill mb-3 px-3 py-2" href="./dashboard.php">Get Started</a>
            </div>
        </div>
    </div>
</div>
<script src="./scripts/register.js"></script>