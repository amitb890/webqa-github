@extends('layouts.app')
@section('title', 'Webqa - Dashboard')
@section("content")


<div class="dashboard-page dashboard_content dashboard-elements d-none">
  <div class="dashboard_recheck_area">
    <p>Last updated: <span id="lastUpdated"></span></p>
    <a href="#" class="das_rec_btn" id="recheckBtn">Recheck</a>
  </div>
  <div class="dashboard_top_items_main">
    
  </div>
  <div class="dashboard_offcanvas">
    <div
      class="offcanvas offcanvas-start sidebar-modal"
      tabindex="-1"
      id="offcanvasExample"
      aria-labelledby="offcanvasExampleLabel"
    >
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">
          Add Widgets
        </h5>
        <button
          type="button"
          class="btn-close text-reset"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body">
        <div class="dashboard_offcanvas_content">
         
        </div>
      </div>
    </div>
  </div>
</div>


@section("js")
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/TweenMax.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.17.0/utils/Draggable.min.js"></script>

<script src="{{ asset('new-assets/js/dashboard-tracker-view-cache.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/dashboard.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
@endsection
@endsection
