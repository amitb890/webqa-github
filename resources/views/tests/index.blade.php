@php
    $url = request()->path(); // current URL path
    $layout = Str::contains($url, 'test-archive-web-app')
                ? 'layouts.app'
                : 'layouts.master';
@endphp

@extends($layout)

@section("title")
webqa - Previous Tests
@endsection

@section('content')
        <main style="{{ request()->path() == 'test-archive-web-app' ? 'padding-top: 60px;' : 'padding-top:88px;' }}">

        <div class="inner_content inner_content-tools previous-test">
            <div class="container-fluid">

                <!-- Test Result Area Start -->
                <div class="test_result_area">
                    <h2>Previous Tests</h2><p>A list of all the previous tests made on the website.</p>

                    <div class="test_result_table">
                        <div class="table-responsive">
                            <!-- Download + Search -->
                            <div class="download_result">
                                <ul class="datatable_download_result">
                                    <li class="datatable_download_result_li">
                                        <input type="text" class="form-control" id="custom-search" placeholder="Search">
                                    </li>
                                </ul>
                            </div>


                            <!-- Table -->
                            <div class="analysis-table-image">
                                <table class="table table-bordered custom-dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>URL</th>
                                            <th>Date</th>
                                            <th>Domain</th>
                                            <th>Report</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td class="text-center row-index"></td>
                                                <td>
                                                    <a href="{{ $result['projectUrl'] }}" target="_blank" class="table-image-link">
                                                        {{ $result['projectUrl'] }}
                                                    </a>
                                                </td>
                                                <td data-order="{{ $result['createdAtSort'] }}">{{ $result['createdAtFormatted'] }}</td>
                                                <td>{{ $result['domain'] }}</td>
                                                <td>
                                                    <a href="{{ $result['reportUrl'] }}" target="_blank" class="table-image-link" title="Open report">
                                                        <span>Open</span>
                                                        <svg class="report-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                            <polyline points="15 3 21 3 21 9"></polyline>
                                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <!-- Custom Pagination Controls -->
                        <div class="table-pagination ms-auto">
                            <div class="showing-pagination">
                                <span id="pagination-info"></span>
                                <div class="btn-group me-2 showing-pagination-btn" role="group">
                                    <button type="button" id="prev-page" class="btn btn-outline-gray">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </button>
                                    <button type="button" id="next-page" class="btn btn-primary"
                                        style="height: 25px; padding: 5px 11px;">
                                        <i class="fa-solid fa-angle-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="total-row">
                                <span>Go to:</span>
                                <input type="text" id="canPageGo" class="form-control can-page-go-control">
                            </div>
                            <div class="show-row">
                                <span>Show rows:</span>
                                <select id="rows-per-page" class="btn btn-outline-gray">
                                    <option value="10">10</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="-1">All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Test Result Area End -->

            </div>
        </div>
    </main>
@endsection

@section('js')
    <script>
        function initializeCustomDataTable(datatableClass) {
            var table = $('.' + datatableClass).DataTable({
                processing: false,
                serverSide: false,
                pageLength: 10,
                paging: true,
                info: false,
                searching: true,
                ordering: true,
                order: [[2, 'desc']], // Default sort on Date column (index 2) in descending order
                columnDefs: [
                    { targets: [0, 1, 3, 4], orderable: false },
                    { targets: [0, 4], searchable: false }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search..."
                }
            });

            // Rest of your existing pagination and search controls
            $('.dataTables_paginate').hide();
            $('.dataTables_info').hide();
            $('.dataTables_length').hide();

            var $rowsPerPage = $("#rows-per-page");
            var $paginationInfo = $("#pagination-info");
            var $canPageGo = $("#canPageGo");
            var $prevPage = $("#prev-page");
            var $nextPage = $("#next-page");
            var $customSearchInput = $("#custom-search");

            function updateRowIndex() {
                var pageInfo = table.page.info();
                table.rows({ page: 'current' }).every(function(rowIdx) {
                    $(this.node()).find('.row-index').text(pageInfo.start + rowIdx + 1);
                });
            }

            function updatePaginationInfo() {
                var pageInfo = table.page.info();
                if (pageInfo.recordsDisplay === 0) {
                    $paginationInfo.text('Showing 0 - 0 of 0');
                    return;
                }
                $paginationInfo.text(`Showing ${pageInfo.start + 1} - ${pageInfo.end} of ${pageInfo.recordsDisplay}`);
            }

            // Update on page load
            updateRowIndex();
            updatePaginationInfo();

            // Update when table redraws
            table.on('draw', function() {
                updateRowIndex();
                updatePaginationInfo();
            });

            $rowsPerPage.change(function() {
                var selectedValue = $(this).val();
                // Convert to integer, -1 means show all rows
                var pageLength = parseInt(selectedValue);
                table.page.len(pageLength).draw();
            });

            $canPageGo.keypress(function(e) {
                if (e.which === 13) {
                    var page = parseInt($(this).val(), 10) - 1;
                    if (!isNaN(page)) {
                        table.page(page).draw('page');
                    }
                }
            });

            $prevPage.click(function() {
                table.page('previous').draw('page');
            });

            $nextPage.click(function() {
                table.page('next').draw('page');
            });

            $customSearchInput.on('input', function() {
                table.search(this.value).draw();
            });
        }

        $(document).ready(function() {
            initializeCustomDataTable("custom-dataTable");
        });
    </script>
@endsection