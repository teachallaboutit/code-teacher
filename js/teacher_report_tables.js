(function (fn) {
    if (document.readyState !== 'loading') {
        console.log('DOM in use calling function');
        fn();
    } else {
        console.log('DOM not in use - adding EventListener');
        document.addEventListener('DOMContentLoaded', fn);
    }
})(function () {
    const tableElement = document.querySelector('#teacher-report-table');

    if (tableElement) {
        // Check if DataTable is already initialized
        if (!jQuery.fn.DataTable.isDataTable(tableElement)) {
            // Initialize DataTables on the teacher-report-table
            jQuery(tableElement).DataTable({
                "paging": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "order": [[0, "asc"]], // Default sort by Tutorial ID
                "columnDefs": [
                    { "orderable": true, "targets": [0, 1, 2] },  // Columns in the table
                    { "className": "dt-center", "targets": [0, 1, 2] } // Center-align all columns
                ],
                "dom": 'Bfrtip', // Add buttons to the DataTable
                "buttons": [
                    {
                        extend: 'colvis',
                        text: 'Filter Columns'
                    }
                ],
                "createdRow": function (row, data, dataIndex) {
                    // If the "Completed" column (index 1) is "Yes", color the cell green
                    if (data[1] === 'Yes') {
                        jQuery('td:eq(1)', row).addClass('completed-yes');
                    }
                }
            });
        }
    }
});