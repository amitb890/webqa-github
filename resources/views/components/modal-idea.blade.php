<div class="analysis_sidebar_main">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="analysis_sidebar" aria-labelledby="analysis_sidebarLabel" aria-modal="true" role="dialog">
        <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="analysis_sidebarLabel">Submit your idea</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        <div class="analysis_sidebar_form">
            <form id="modalIdeaForm" enctype='multipart/form-data'>
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="ideaName" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="ideaName" value="{{\Auth::user()->name}}">
            </div>
            
            <div class="mb-3">
                <label for="ideaEmail" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="ideaEmail" value="{{\Auth::user()->email}}">
            </div>


            <div class="mb-3">
                <label for="ideaUrl" class="form-label">URL</label>
                <input type="text" class="form-control" id="ideaUrl">
            </div>


            <div class="mb-3">
                <label for="ideaMessage" class="form-label">Issue</label>
                <textarea class="form-control" id="ideaMessage" rows="3"></textarea>
            </div>

        
            <label class="form-label">Attachments</label>
            <div class="mb-3">
                <label for="ideaAttachment" class="input_file"> <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 8.032L8.38112 14.7203C7.57026 15.5397 6.47049 16 5.32376 16C4.17703 16 3.07726 15.5397 2.2664 14.7203C1.45554 13.9009 1 12.7896 1 11.6309C1 10.4721 1.45554 9.36081 2.2664 8.54144L8.88528 1.85312C9.42585 1.30688 10.159 1 10.9235 1C11.688 1 12.4212 1.30688 12.9618 1.85312C13.5023 2.39937 13.806 3.14024 13.806 3.91275C13.806 4.68526 13.5023 5.42613 12.9618 5.97237L6.33568 12.6607C6.06539 12.9338 5.6988 13.0873 5.31656 13.0873C4.93431 13.0873 4.56773 12.9338 4.29744 12.6607C4.02715 12.3876 3.8753 12.0171 3.8753 11.6309C3.8753 11.2446 4.02715 10.8742 4.29744 10.6011L10.4122 4.42947" stroke="#B7B7B7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> &nbsp;
                <span>Attachments</span>
            </label>
                <input class="form-control" type="file" id="ideaAttachment" hidden>
            </div>


            <label for="important_check" class="form-label">Severity</label>
            <div class="mb-3" id="important_check">
                <input type="radio" class="btn-check" name="ideaImportanceRadio" value="Nice to have" id="ideaImportanceNice" autocomplete="off">
                <label class="btn" for="ideaImportanceNice">Nice to have</label>

                <input type="radio" class="btn-check" name="ideaImportanceRadio" value="Important" id="ideaImportanceImportant" autocomplete="off" checked>
                <label class="btn" for="ideaImportanceImportant">Important</label>

                <input type="radio" class="btn-check" name="ideaImportanceRadio" value="Critical" id="ideaImportanceCritical" autocomplete="off">
                <label class="btn" for="ideaImportanceCritical">Critical</label>
            </div>


            <button id="submitIdeaBtn" type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
        </div>
    </div>
    </div>