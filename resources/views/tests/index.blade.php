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

@section('css')
<style>
    .previous-test .archive-filter-li { margin-right: 10px; }
    .previous-test .archive-type-filter { min-width: 200px; height: 40px; font-size: 14px; border-radius: 8px; border-color: #dfe3ea; color: #1b2533; }
    .previous-test .archive-url-cell { display: flex; align-items: center; gap: 6px; min-width: 0; }
    .previous-test .archive-url-cell .table-image-link { display: block; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .previous-test .archive-more-urls { flex-shrink: 0; display: inline-block; padding: 1px 8px; border-radius: 999px; background: #eef2f7; color: #5b6573; font-size: 12px; white-space: nowrap; }
    .previous-test .archive-test-name { white-space: nowrap; font-size: 13px; }
    .previous-test .archive-test-analysis { font-weight: 500; }
    @media (max-width: 767px) {
        .previous-test .archive-filter-li { margin: 0 0 8px; width: 100%; }
        .previous-test .archive-type-filter { width: 100%; }
    }
</style>
@endsection

@section('content')
        <main style="{{ request()->path() == 'test-archive-web-app' ? 'padding-top: 60px;' : 'padding-top:88px;' }}">

        <div class="inner_content inner_content-tools previous-test">
            <div class="container-fluid">

                <!-- Test Result Area Start -->
                <div class="test_result_area">
                    <h2>Previous Tests</h2><p>A list of all the previous tests made on the website{{ empty($isWebAppArchive) ? ', including website analysis reports and tool results' : '' }}.</p>

                    <div class="test_result_table">
                        <div class="table-responsive">
                            <!-- Download + Search -->
                            <div class="download_result">
                                <ul class="datatable_download_result">
                                    @if(!empty($toolNames))
                                    <li class="datatable_download_result_li archive-filter-li">
                                        <select id="archive-type-filter" class="form-select archive-type-filter" aria-label="Filter by test">
                                            <option value="">All tests</option>
                                            <option value="Website Analysis">Website Analysis</option>
                                            <optgroup label="Tools">
                                                @foreach($toolNames as $toolName)
                                                    <option value="{{ $toolName }}">{{ $toolName }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </li>
                                    @endif
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
                                            <th>Test</th>
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
                                                    @if(($result['extraUrls'] ?? 0) > 0)
                                                        <div class="archive-url-cell">
                                                            <a href="{{ $result['projectUrl'] }}" target="_blank" class="table-image-link" title="{{ $result['projectUrl'] }}">{{ $result['projectUrl'] }}</a>
                                                            <span class="archive-more-urls">+{{ $result['extraUrls'] }} more</span>
                                                        </div>
                                                    @else
                                                        <a href="{{ $result['projectUrl'] }}" target="_blank" class="table-image-link">
                                                            {{ $result['projectUrl'] }}
                                                        </a>
                                                    @endif
                                                </td>
                                                <td><span class="archive-test-name archive-test-{{ $result['testType'] ?? 'analysis' }}">{{ $result['testName'] ?? 'Website Analysis' }}</span></td>
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
                order: [[3, 'desc']], // Default sort on Date column (index 3) in descending order
                columnDefs: [
                    { targets: [0, 1, 2, 4, 5], orderable: false },
                    { targets: [0, 5], searchable: false }
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
                // Number the rows as they appear (after sorting/filtering), not by data index
                table.rows({ page: 'current', search: 'applied', order: 'applied' }).nodes().each(function(node, i) {
                    $(node).find('.row-index').text(pageInfo.start + i + 1);
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

            // Filter by test type (exact match on the Test column)
            $('#archive-type-filter').on('change', function() {
                var value = this.value;
                var escaped = $.fn.dataTable.util.escapeRegex(value);
                table.column(2).search(value ? '^' + escaped + '$' : '', true, false).draw();
            });
        }

        $(document).ready(function() {
            initializeCustomDataTable("custom-dataTable");
        });
    </script>
@endsection