@extends(auth()->check() ? 'layouts.app' : 'layouts.master')

@section("title")
Previous Tests | Webqa
@endsection

@section('content')
        <main {{ Auth::check() ? '' : 'class="main-sections"  style=padding-block:58px;' }}>

        <div class="inner_content inner_content-tools previous-test">
            <div class="container-fluid">

                <!-- Test Result Area Start -->
                <div class="test_result_area">
                    <h2>Previous Tests</h2><p>A list of all the previous tests made on the website.</p>
                    <span class="failed-list"></span>

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
                            <table class="table bulk-table table-bordered custom-dataTable">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
                                        <th>URL</th>
                                        <th>Date</th>
                                        <th>Domain</th>
                                        <th>Report</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>

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
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
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
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('get.results') }}", // Set your route name here
                    type: "GET",
                    data: function(d) {
                        // ✅ add the browser page URL to the request
                        d.projectUrl = window.location.href;
                    }
                },
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1, width: '30px', className: 'text-center',searchable: false, orderable: false },

                    {
                        data: 'projectUrl',
                        render: function(data) {
                            return '<a href="' + data + '" target="_blank" style="color: rgba(55, 55, 55, 1);">' + data + '</a>';
                        },
                        width: '40%',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return new Date(data).toLocaleDateString('en-US', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        },
                        width: '150px',
                        orderable: true
                    },
                    {
                        data: 'projectUrl',
                        render: function(data) {
                            try {
                                let url = new URL(data);
                                return url.origin; // gives protocol + domain only
                            } catch (e) {
                                return data;
                            }
                        },
                        width: '30%',
                        orderable: false
                    },

                    {
                        data: 'report',
                        orderable: false,
                        searchable: false,
                        width: '80px'
                    }
                ],
                pageLength: 10,
                paging: true,
                info: false,
                searching: true,
                ordering: true,
                order: [[2, 'desc']], // Default sort on Date column (index 2) in descending order
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

            function updatePaginationInfo() {
                var pageInfo = table.page.info();
                $paginationInfo.text(`Showing ${pageInfo.start + 1} - ${pageInfo.end} of ${pageInfo.recordsTotal}`);
            }

            // Update on page load
            updatePaginationInfo();

            // Update when table redraws
            table.on('draw', function() {
                updatePaginationInfo();
            });

            $rowsPerPage.change(function() {
                table.page.len($(this).val()).draw();
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
