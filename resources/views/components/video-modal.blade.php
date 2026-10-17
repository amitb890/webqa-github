<!-- video modal -->
<div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-labelledby="videoModalTitle" aria-hidden="true">
    <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close" id="closeBtn">Close <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24"> <path fill="#F5F8FA" fill-rule="evenodd" d="M19.795 4.205c-.273-.273-.716-.273-.99 0L12 11.01 5.195 4.205l-.087-.074c-.274-.197-.657-.172-.903.074-.273.273-.273.716 0 .99L11.01 12l-6.805 6.805-.074.087c-.197.274-.172.657.074.903.273.273.716.273.99 0L12 12.99l6.805 6.805.087.074c.274.197.657.172.903-.074.273-.273.273-.716 0-.99L12.99 12l6.805-6.805.074-.087c.197-.274.172-.657-.074-.903z" clip-rule="evenodd"></path> </svg> </button>
    <div class="modal-dialog video-content">
        <div class="modal-content">
            <div class="modal-body">
                <h2 id="videoModalTitle" class="visually-hidden">WebQA explainer video</h2>
                <video class="explainer-modal-video" id="videoExplainer" controls playsinline preload="none">
                    <source src="{{ asset('new-assets/assets/webqa-explainer.mp4') }}" type="video/mp4">
                </video>
                <a href="{{ route('register') }}" class="btn btn_primary rounded-pill explainer-modal-cta">Get Started</a>
            </div>
        </div>
    </div>
</div>
