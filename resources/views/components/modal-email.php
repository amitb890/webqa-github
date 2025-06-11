<div class="modal fade email-modal" id="modalEmail" aria-hidden="true" aria-labelledby="modalEmailLabel"
      tabindex="-1">
      <div class="modal-dialog modal-dialog-centered analysis-profile-dialog2">
        <div class="modal-content">
          <div class="modal-header analysis-profile-header">
            <h1 class="modal-title fs-5" id="modalEmailLabel">
              Email This Report
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body analysis-profile-bd2">
            <div class="analysis-mail-top">
              <div class="analysis-mail-to-container">
                  <div class="analysis-mail-to-helper"> 
                    <p>To: </p>
                    <div class="email-suggestion-container">
                      <input id="emailTo">
                      
                      <div class="email-suggestion">
            
                        
                      </div>
                    </div>
                  </div>
              </div>
              <div class="analysis-mail"></div>


              <div class="analysis-mail-to-container">
                  <div class="analysis-mail-to"> 
                    <p>Subject: </p>
                    <input class="email-subject" id="emailSubject">
                  </div>
              </div>
            </div>
      
            <div class="mail-report-description">
              <textarea rows="7" id="modalEmailMessage"></textarea>
            </div>
            <div class="mail-report-file">
              <div class="single-report-file">
                <img src="/new-assets/assets/images/xl.png" alt="icon" />
                <p id="modalEmailFileName" class="download-csv-bulk"></p>
              </div>
            </div>
          </div>
          <div class="modal-footer analysis-mail-footer">
            <button class="btn btn_primary rounded-pill" id="sendAnalysisEmailBtn">
              Send
            </button>
          </div>
        </div>
      </div>
    </div>