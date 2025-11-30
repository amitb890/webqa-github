@extends('layouts.app')
@section('title', 'Website Tracker | Webqa')
@section("content")

@section("css")
<link rel="stylesheet" href="{{ asset('new-assets/vendor/datatables/datatables.min.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
<link rel="stylesheet" href="{{ asset('new-assets/vendor/datatables/jquery.datatables.colResize.css') }}{{ \App\Http\Helpers::getCacheBuster() }}" />
@endsection



    <!-- main sections starts -->
    <input type="hidden"  value="Website tracker report" id="report-slug">

          <div class="tracker-title">
            <h2>Website Tracker</h2>
          </div>
          <div class="alert-section"></div>
          <div class="table-row-border tracker-container d-none">
            <div class="table-menu">
              <div class="table-menu-left">
              </div>
              <div class="main-menu-right">
                <div class="table-menu-right">

                  <div class="dashboard_recheck_area">
        
                  </div>


                  <div class="menu-right-option tricker_download_option">
                    <a
                      class="dropdown-toggle"
                      href="#"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <div class="menu-icon">
                        <img src="/new-assets/assets/images/download.png" alt="icon" />
                        <span>Download</span>
                      </div>
                    </a>
                    <ul
                      class="dropdown-menu dropdown-menu-start tracker_downloading_link"
                    >
                      <li id="downloadCSV">
                        <a class="dropdown-item website-tracker-csv" href="#"
                          ><img src="/new-assets/assets/images/csv.png" alt="icon" /> CSV</a
                        >
                      </li>
                      <li class="download-xlsx-bulk">
                        <a class="dropdown-item" href="#"
                          ><img src="/new-assets/assets/images/csv.png" alt="icon" />Xlsx</a
                        >
                      </li>
                    </ul>
                  </div>
      
                  <div class="dropdown menu-recheck-option">
                    <a
                      class="dropdown-toggle p-2"
                      href="#"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false"
                    >
                      <span class="icon check-reload">
                        <img src="/new-assets/assets/images/reload.png" alt="icon" />
                      </span>
                      <span>Recheck Data</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" id="recheckAllTracker">Recheck all</a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="#"
                          >Recheck selected (3)</a
                        >
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <button id="menuBtn2" class="menu-btn2 ms-3" type="button">
                <span></span><span></span><span></span>
              </button>
            </div>
         
  

            <!-- Tracker Table Start -->
            <div class="tracker-table">
              <div class="table-responsive">
              <table
                  id="reportTableClone"
                  class="d-none"
                  style="width:0;height:0"
                >
                </table>
                <table
                  id="reportTable"
                  class="table table-bordered align-middle main-data-table"
                >
                  <thead class="reports-table-header">
                    <tr class="table-header-top">
                      <td></td>
                      <td></td>
                    </tr>
                    
                    
                    
                    <tr class="table-header">
                      <td scope="col">
                        <div class="form-check left-menu-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="table_input_check1"
                          />
                        </div>
                        <span class="text">URL</span>
                        <button
                          type="button"
                          class="first-col-toggle-btn"
                          id="hide-col-btn"
                        >
                          <img
                            src="/new-assets/assets/images/table-collapse.png"
                            alt="icon"
                          />
                        </button>
                      </td>
          
                    </tr>
               
                  </thead>
                  <tbody class="reports-table-body td-size"></tbody>
                </table>
              </div>
            </div>
            <!-- Tracker Table End -->
            <!-- Main Pagination -->
            <div class="main-pagination">
              <!-- Button-Start -->
              <div class="url-button">
         
              </div>
              <!-- Button-Start -->
              <!-- Pagination Start -->
              <div class="table-pagination">
                <div class="show-row">
                  <span>Show rows:</span>
                  <select name="" id="rowsTable" class="btn btn-outline-gray">
                 
                  </select>
                </div>
   
                <div class="showing-pagination">
                  <span></span>
                  <div
                    class="btn-group me-2 showing-pagination-btn"
                    role="group"
                    aria-label="First group"
                  >
                    <button type="button" class="btn btn-outline-gray" id="tablePrev">
                      <i class="fa-solid fa-angle-left"></i>
                    </button>
                    <button type="button" class="btn btn_primary" id="tableNext">
                      <i class="fa-solid fa-angle-right"></i>
                    </button>
                  </div>
                </div>
              </div>
              <!-- Pagination End -->
            </div>

    <!-- main sections ends -->


    @include("components.url-options-modal")



@endsection
@section("js")
<script src="{{ asset('new-assets/vendor/datatables/datatables.min.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/vendor/datatables/jquery.dataTables.colResize.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="{{ asset('new-assets/js/tracker.js') }}{{ \App\Http\Helpers::getCacheBuster() }}"></script>
<script src="/new-assets/js/exceljs.min.js"></script>
<script src="/new-assets/js/exportXlsx.js"></script>
@endsection