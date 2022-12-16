// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
  $('#laporanTable').DataTable({
    dom: 'lBfrtip',
    buttons: [
        {
            extend: 'pdfHtml5',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            title: 'Laporan Data Stok Sayur Mayur',
            className: 'btn btn-danger btn-sm',
            pageSize: 'A5',
            footer: true,
        }
    ]
  });
});
