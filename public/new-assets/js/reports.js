/* ====================Feedback==================== */

$(function () {

  let currentPage = 1; // Track current page
  let table; // Define DataTable variable
  let recordsPerPage = 10; // Default records per page
  let reordsGet = 0;
  let totalRecords = 0;
  let filterValue = [];
  let searchValue = null;
  let itemOrder = 'desc';

   // Function to load data for the specified page
   function loadDataForPage(page, searchQuery = null, filterValue = null, itemOrder = "desc") {
    // Perform AJAX request to fetch data for the specified page
    $.ajax({
      url: `/datatable/data?page=${page}&perPage=${recordsPerPage}&search=${searchQuery}&filterValue=${filterValue}&itemOrder=${itemOrder}`,

      type: "GET",
      success: function (response) {
        const data = response.data;
        reordsGet = response.data.length
        console.log(response)
        totalRecords = response.recordsTotal;
        currentPage = page;
        initializeDataTable(data, totalRecords); // Initialize DataTable with fetched data and total records
      },
      error: function (xhr, status, error) {
        console.error(error);
      }
    });
  }

  // Initial data loading
  loadDataForPage(currentPage);

  // Function to initialize DataTable
  function initializeDataTable(data, totalRecords) {
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('#reportTable')) {
      // table.destroy();
    }

    table = $('#reportTable').DataTable({
      data: data,
      columns: [
        {
          data: 'url',
          name: 'url',
          render: function (data, type, row, meta) {
            if (type === 'display') {
              var id = row.id;
              return `
                      <td scope="row" style="z-index: 1;">
                          <div class="form-check input-pt-pb">
                              <input class="form-check-input" type="checkbox" value="" class="tableCheckbox">
                              <label class="form-check-label">${data}</label>
                          </div>
                          <div class="dropdown">
                              <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                      <path d="M12 10c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 12c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
                                  </svg>
                              </button>
                              <ul class="dropdown-menu dropdown-menu-end" style="">
                                  <li>
                                      <a class="dropdown-item deleteItem" href="#" data-id="${id}">Delete</a>
                                  </li>
                                 
                              </ul>
                          </div>
                      </td>`;
            }
            return data;
          }
        },
        { data: 'name', name: 'name' },
        { data: 'length', name: 'length' },
        { data: 'casing', name: 'casing' },
        { data: 'duplicate', name: 'duplicate' },
        { data: 'equal_h1', name: 'equal_h1' },
        // Add more columns as needed
      ],
      destroy: true, // Ensure destroying existing DataTable instance
      info: false,
      ordering: false,
      paging: false,
      createdRow: function (row, data, dataIndex) {
        if (data.duplicate == "Yes") {
          $('td:eq(4)', row).addClass('collumn-success'); // Add class to 'duplicate' column's td
        } else {
          $('td:eq(4)', row).addClass('collumn-danger'); // Add class to 'duplicate' column's td
        }

        if (data.equal_h1 == "Yes") {
          $('td:eq(5)', row).addClass('collumn-success'); // Add class to 'equal_h1' column's td
        } else {
          $('td:eq(5)', row).addClass('collumn-danger'); // Add class to 'equal_h1' column's td
        }
      }
    });

    // Update pagination info
    const startIndex = (((currentPage) * recordsPerPage) - recordsPerPage) + 1;
    const endIndex = (((currentPage) * recordsPerPage) - recordsPerPage) + reordsGet;
    const totalItems = totalRecords;
    updatePaginationInfo(startIndex, endIndex, totalItems);
  }
  // Function to handle export options
  $('.tracker_downloading_link .dropdown-item').on('click', function (event) {
    event.preventDefault(); // Prevent default action of the link

    const exportType = $(this).text().trim().toUpperCase(); // Get the selected export type (e.g., CSV, PDF, Google Sheet)

    // Depending on the export type, perform the appropriate action
    switch (exportType) {
      case 'CSV':
        exportToCSV();
        break;
      case 'PDF':
        exportToPDF();
        break;
      case 'GOOGLE SHEET':
        exportToGoogleSheet();
        break;
      default:
        // Do nothing or handle unsupported export types
        break;
    }
  });

  function exportToCSV() {
    // Get the data from the DataTable
    const data = table.rows().data().toArray();
    // Get column headers, excluding "name" and renaming "casing" to "Casing"
    const dataKeys = ["url",	"content", "length",	"casing",	"duplicate",	"equal_h1"];
    const headers = ["URL",	"Meta Title Content",	"Length",	"Casing",	"Is it Duplicate?",	"Is it Equal to H1?"];

    // const headers = ["url", "length", "Casing", "duplicate", "equal_h1"];
    // const dataKeys = ["","length", "casing", "duplicate", "equal_h1"];
    // Convert the data to CSV format
    let csvContent = "data:text/csv;charset=utf-8,";

    // Add column headers
    csvContent += headers.join(',') + "\n";

    // Add rows, excluding the "name" field
    data.forEach(row => {
        let rowArray = [];
        dataKeys.forEach(key => {
            rowArray.push(row[key]);
        });
        csvContent += rowArray.join(',') + "\n";
    });

    // Create a CSV file and trigger download
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "Meta-Title-Report-"+ $('#activeProject').attr('data-name') +".csv");
    document.body.appendChild(link); // Required for Firefox
    link.click(); // Trigger download
}


  function exportToXLSX() {
    // Get the data from the DataTable
    const data = table.rows().data().toArray();
  
    // Convert the data to a format suitable for SheetJS
    const worksheetData = [
      Object.keys(data[0]), // Headers
      ...data.map(row => Object.values(row)) // Rows
    ];
  
    // Create a new workbook and add the worksheet
    const workbook = XLSX.utils.book_new();
    const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
  
    // Set custom column widths (index-based)
    worksheet['!cols'] = [
      { wch: 10 }, // Width for the first column
      { wch: 30 }, // Width for the second column
      { wch: 20 }, // Width for the third column
      // Add more columns as needed
    ];
  
    // Add the worksheet to the workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, "Data");
  
    // Create a binary string for the workbook
    const wbout = XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' });
  
    // Convert the binary string to a Blob
    const blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });
  
    // Create a link and trigger the download
    const link = document.createElement("a");
    link.href = window.URL.createObjectURL(blob);
    link.download = "data.xlsx";
    document.body.appendChild(link); // Required for Firefox
    link.click(); // Trigger download
    document.body.removeChild(link);
  }
  
  // Utility function to convert a string to an ArrayBuffer
  function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i < s.length; i++) {
      view[i] = s.charCodeAt(i) & 0xFF;
    }
    return buf;
  }
  

  
  function padString(str, width) {
    if (!width) return str; // No padding needed for this column
    str = String(str);
    if (str.length >= width) return str; // No padding needed if string is already wider
    return str + ' '.repeat(width - str.length);
  }
  

  // Function to export data to PDF
  function exportToPDF() {
    // Get the CSRF token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Get the data from the DataTable
    const data = table.rows().data().toArray();

    // Create a hidden form
    const form = $('<form>', {
      action: '/download-pdf-report',
      method: 'POST',
      target: '_blank' // Open in a new tab
    });

    // Add CSRF token input
    form.append($('<input>', {
      type: 'hidden',
      name: '_token',
      value: csrfToken
    }));

    // Add PDF data input
    form.append($('<input>', {
      type: 'hidden',
      name: 'data',
      value: JSON.stringify(data) // Convert data to JSON string
    }));

    // Append form to the document and submit
    form.appendTo('body').submit().remove();
  }

  // Function to update pagination info
  function updatePaginationInfo(startIndex, endIndex, totalItems) {
    $('#pagination-info').text(`Showing ${startIndex} - ${endIndex} of ${totalItems}`);
  }

  $('#gsearch').on('keyup', function () {
    searchValue = $(this).val(); // Get the value of the search input field
    loadDataForPage(currentPage, searchValue, filterValue, itemOrder); // Load data for current page with search query
  });

  $('.filterDropdown').on('click', function () {
    //  filterValue = $(this).attr('data-id'); // Get the value of the search input field
    filterValue = [];
    if ($(this).hasClass('filterDropdownActive')) {
      $(this).removeClass('filterDropdownActive')
    } else {
      // $('.filterDropdown').removeClass('filterDropdownActive')
      $(this).addClass('filterDropdownActive')
    }
    if ($('.filterDropdownActive').length > 0) {
      $('.filter_icon').addClass('filter-active')
    } else {

      $('.filter_icon').removeClass('filter-active')
    }
    // Initialize an empty array to store the data

    $('.filterDropdownActive').each(function () {
      var dataValue = $(this).data('id'); // Change 'your-data-attribute' to the actual data attribute you want to retrieve
      filterValue.push(dataValue); // Push the data value into the array
    });
    loadDataForPage(currentPage, searchValue, filterValue, itemOrder); // Load data for current page with search query
  });

  $('#canPageGo').keypress(function (event) {
    if (event.which === 13) {
      var currentPage = $(this).val();
      loadDataForPage(currentPage, searchValue, filterValue, itemOrder);
    }
  });


  $(document).on('click', '.deleteItem', function (event) {
    var id = $(this).attr('data-id');

    $.ajax({
      url: `/reports/` + id,
      type: 'DELETE',

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Fetch CSRF token from meta tag
      },
      success: function (response) {
        // Handle success response
        loadDataForPage(currentPage, searchValue, filterValue, itemOrder);
      },
      error: function (xhr, status, error) {
        // Handle error response
        console.error('Error deleting report:', error);
      }
    });
  });

  $(document).on('click', '.itemOrder', function (event) {
    orderData()
  });

  function orderData() {
    if (itemOrder == 'desc') {
      itemOrder = 'asc';
    } else {
      itemOrder = 'desc';
    }
    loadDataForPage(currentPage, searchValue, filterValue, itemOrder);
  }

  // Previous page button click event
  $('#prev-page').on('click', function () {
    if (currentPage > 1) {
      loadDataForPage(currentPage - 1, searchValue, filterValue, itemOrder);
    }
  });

  // Next page button click event
  $('#next-page').on('click', function () {

    const endIndexVar = (((currentPage) * recordsPerPage) - recordsPerPage) + reordsGet;
    if (totalRecords == endIndexVar) {
      return false;
    }
    currentPage = currentPage + 1;
    loadDataForPage(currentPage, searchValue, filterValue, itemOrder);

  });

  // Event listener for dropdown change
  $('#rows-per-page').on('change', function () {
    recordsPerPage = parseInt($(this).val()); // Get the selected value and parse as integer
    loadDataForPage(currentPage, searchValue, filterValue, itemOrder);
  });


  $('.dropdown-item.filterDropdown').on('click', function (event) {
    // Preventing the default action
    event.preventDefault();
    // Stopping event propagation to prevent closing the dropdown
    event.stopPropagation();

    // Your logic for handling the click event goes here
    console.log('Dropdown item clicked:', $(this).text().trim());
  });

  $('.dropdown-submenu a.dropdown-toggle').on("click", function (e) {
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });

  const options = {
    colResize: {
      isEnabled: () => $(window).width() > 768,
      hoverClass: "dt-colresizable-hover",
      hasBoundCheck: true,
      minBoundClass: "dt-colresizable-bound-min",
      maxBoundClass: "dt-colresizable-bound-max",
      saveState: true,
      isResizable: function (column) {
        return column.idx !== 0;
      },
      onResize: function (column) {
        //console.log('...resizing...');
      },
      onResizeEnd: function (column, columns) {
        //console.log('...resize end...');
        // console.log(column);
        // console.log(columns);
      },
      stateSaveCallback: function (settings, data) {
        let stateStorageName = window.location.pathname + "/colResizeStateData";
        localStorage.setItem(stateStorageName, JSON.stringify(data));
      },
      stateLoadCallback: function (settings) {
        let stateStorageName = window.location.pathname + "/colResizeStateData",
          data = localStorage.getItem(stateStorageName);
        return data != null ? JSON.parse(data) : null;
      },
    },
    info: false,
    ordering: false,
    paging: false,
    autoWidth: false,
    fixedColumns: {
      leftColumns: 1,
    },
    // responsive: true,
    select: {
      style: "multi",
      selector: "td:first-child .form-check-input",
    },
  };

  if ($("#reportTable").length > 0) {
    const table = new DataTable("#reportTable", options);
  }

  $(".left-menu-check .form-check-input").on("change", function () {
    // Get the state of the "All" checkbox
    var isChecked = $(this).prop("checked");

    // Set the state of all individual checkboxes based on the "All" checkbox
    $("td:first-child .form-check-input").prop("checked", isChecked);

    // Update DataTables selection
    // table.rows().select(isChecked);
  });

  $("#reportTable").on("click", function (e) {
    const target = e.target;
    const hideBtn = target.closest("#hide-col-btn");
    const showBtn = target.closest("#show-col-btn");
    if (hideBtn) {
      // hide the first column
      table.column(0).visible(!table.column(0).visible());
      $(this).find(".table-header").prepend(`<td>
        <button
          type="button"
          class="first-col-toggle-btn"
          id="show-col-btn"
        >
          <img
            src="assets/images/table-collapse.png"
            alt="icon"
          />
        </button>`);
    }

    if (showBtn) {
      // show the first column
      table.column(0).visible(!table.column(0).visible());
      $(showBtn).remove();
    }
  });

  $(".t-search-url input").on("input", function () {
    table.search($(this).val()).draw();
  });
});
/* ====================Feedback==================== */


