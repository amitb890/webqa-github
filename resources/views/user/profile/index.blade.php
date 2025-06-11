@extends('layouts.app')
@section("content")


            <div class="alert-container"></div>
            <!-- Profile Section Start  -->
            <div class="profile-section">
              <h2 class="from-title">My Profile</h2>
              <form id="updateProfileForm" class="form-top form-body">
                <div class="col-md-6 profile-single-input">
                  <label for="name" class="form-label">Full Name</label>
                  <input
                    type="text"
                    value="{{ $user->name }}"
                    class="form-control"
                    id="name"
                    aria-describedby="emailHelp"
                  />
                </div>
                <div class="col-md-6 profile-single-input">
                  <label for="email" class="form-label">Email address</label>
                  <input
                  value="{{ $user->email }}"
                    type="email"
                    class="form-control"
                    id="email"
                    aria-describedby="emailHelp"
                    disabled
                  />
                  <input id="userId" value="{{ $user->id }}" hidden>
                  <div id="emailHelp" class="form-text">
                    Email address cannot be changed
                  </div>
                  <button id="updateProfile" type="submit" class="btn btn_primary rounded-pill">
                    Update Profile
                  </button>
                </div>
              </form>
            </div>
            <!-- Profile Section End  -->

            <!-- Password Section Start  -->
            <div class="password-section">
              <h2 class="from-title">Password</h2>
              <form id="updatePassForm" class="form-bottom form-body needs-validation" novalidate>
                <div class="col-md-6">
                  <div class="profile-single-input">
                    <label for="password" class="form-label"
                      >Enter Current Password</label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="current_password" name="current_password"
                      required
                    />
                    <button
                      type="button"
                      class="eye-icon show-pass-btn bg-transparent border-0"
                    >
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                  <div class="profile-single-input">
                    <label for="newPassword" class="form-label"
                      >Enter New Password</label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="new_password" name="new_password"
                      required
                    />
                    <button
                      type="button"
                      class="eye-icon show-pass-btn bg-transparent border-0"
                    >
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                  <div class="profile-single-input">
                    <label for="confirmPassword" class="form-label"
                      >Confirm New Password</label
                    >
                    <input
                      type="password"
                      class="form-control"
                      id="c_new_password" name="c_new_password"
                      required
                    />
                    <button
                      type="button"
                      class="eye-icon show-pass-btn bg-transparent border-0"
                    >
                      <i class="fa-regular fa-eye"></i>
                    </button>
                  </div>
                </div>
                <button id="updatePass" type="submit" class="btn btn_primary rounded-pill">
                  Update Password
                </button>
              </form>
              <!-- Delete Modal Item -->
              <div
                class="modal fade"
                id="confirmationModalToggle"
                aria-hidden="true"
                aria-labelledby="modal_title1"
                tabindex="-1"
              >
                <div
                  class="modal-dialog modal-dialog-centered profile-modal-dialog"
                >
                  <div class="modal-content">
                    <div class="modal-header frofile-modal-header">
                      <span><i class="fa-solid fa-exclamation"></i></span>
                      <h1 class="modal-title fs-5" id="modal_title1">
                        Delete Account?
                      </h1>
                    </div>
                    <div class="modal-body profile-modal">
                      <span class="none1">Please Note</span>
                      <p>
                        After deleting your account, you will not be able to use
                        our service. Your subscription will be canceled and your
                        content, saved reports and other personal information
                        will be erased.
                      </p>
                    </div>
                    <div class="modal-footer profile-footer-modal">
                      <button
                        class="back-modal"
                        href="profile4.html"
                        data-bs-toggle="modal"
                      >
                        Go Back
                      </button>
                      <button
                        class="btn btn_danger rounded-pill"
                        data-bs-target="#confirmationModalToggle2"
                        data-bs-toggle="modal"
                      >
                        Delete Account
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div
                class="modal fade"
                id="confirmationModalToggle2"
                aria-hidden="true"
                aria-labelledby="modal_title2"
                tabindex="-1"
              >
                <div
                  class="modal-dialog modal-dialog-centered profile-modal-dialog"
                >
                  <div class="modal-content">
                    <div class="modal-header frofile-modal-header">
                      <h1 class="modal-title fs-5" id="modal_title2">
                        Confirm Delete Account
                      </h1>
                    </div>
                    <div class="modal-body profile-modal">
                      <span>Please Note</span>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="reason"
                          id="check-list1"
                        />
                        <label class="form-check-label" for="check-list1"
                          >Needed more features</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="reason"
                          id="check-list2"
                          checked
                        />
                        <label class="form-check-label" for="check-list2"
                          >There were too many bugs and technical issues</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="reason"
                          id="check-list3"
                        />
                        <label class="form-check-label" for="check-list3"
                          >I have decided to use anither tool</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="reason"
                          id="check-list4"
                        />
                        <label class="form-check-label" for="check-list4"
                          >Did not meet my requirements</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="reason"
                          id="check-list5"
                        />
                        <label class="form-check-label" for="check-list5"
                          >Results were inaccurate</label
                        >
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="reason"
                          id="check-list6"
                        />
                        <label class="form-check-label" for="check-list6"
                          >Other reason</label
                        >
                      </div>
                      <div class="profile-textarea">
                        <label for="massage" class="form-label"
                          ><span>Any other feedback?</span></label
                        >
                        <textarea
                        id="message"
                          class="form-control"
                          rows="3"
                          placeholder="Didn’t like the reports, please make the reports better."
                        ></textarea>
                        <p>0/2000</p>
                      </div>
                    </div>
                    <div class="modal-footer profile-footer-modal">
                      <button
                        class="back-modal"
                        href="profile4.html"
                        data-bs-toggle="modal"
                      >
                        Don’t Delete
                      </button>
                      <button
                      id="deleteAccount"
                        class="btn btn_danger rounded-pill"
                        data-bs-target="#confirmationModalToggle2"
                        data-bs-toggle="modal"
                      >
                        Confirm Delete Account
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="delete-account">
                <a
                  href="#confirmationModalToggle"
                  data-bs-toggle="modal"
                  role="button"
                  class="btn btn-outline-secondary rounded-pill"
                  >Delete Account</a
                >
              </div>
            </div>
            <!-- Password Section End  -->

@endsection

@section("js")
<script>
$( document ).ready(function(){
   let updateStatus = false
    $("#updatePass").on( "click", function(e) {
        clearAlerts()
        const id = $("#userId").val()
        const currentPass = $("#current_password")
        const newPassword = $("#new_password")
        const cNewPassword = $("#c_new_password")

        $.ajax({
            url : `/profile/${id}`,
            type : 'POST',
            data: {
                "current_password": currentPass.val(),
                "new_password": newPassword.val(),
                "c_new_password": cNewPassword.val(),
                "type": "password",
                "_method": 'PUT',
                "_token": $('meta[name="csrf-token"]').attr('content'),
			        },       
            success : function(data) {
              if(data.status === 0){
                validate(data)
              }else{
                clearValues([currentPass, newPassword, cNewPassword])
                displayAlert(".alert-container", data)
                scrollToTop()
              }
            }
        });

        e.preventDefault()
    });

    $("#name").on( "change", function(e) {
      updateStatus = true
    })


    $("#updateProfile").on( "click", function(e) {
        if(updateStatus){
          clearAlerts()
          const id = $("#userId").val()
          const name = $("#name")

          $.ajax({
              url : `/profile/${id}`,
              type : 'POST',
              data: {
                  "name": name.val(),
                  "type": "profile",
                  "_method": 'PUT',
                  "_token": $('meta[name="csrf-token"]').attr('content'),
                },       
              success : function(data) {
                if(data.status === 0){
                  validate(data)
                }else{
                  displayAlert(".alert-container", data)
                  scrollToTop()
                  updateStatus = false
                }
              }
          });
        }
        e.preventDefault()
    });

    $("#deleteAccount").on( "click", function() {
        clearAlerts()
        const id = $("#userId").val()
        const reason = $("[name='reason']:checked");
        const message = $("#message")

        $.ajax({
            url : `/profile/${id}`,
            type : 'POST',
            data: {
                "reason": reason.val(),
                "message": message.val(),
                "_method": 'DELETE',
                "_token": $('meta[name="csrf-token"]').attr('content'),
			      },       
            success : function(data) {
              if(data.status === 0){
                validate(data)
              }else{
                window.location = window.location.origin
              }
            }
        });
    });
});
</script>
@endsection