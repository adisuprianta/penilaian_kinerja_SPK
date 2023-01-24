// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    "language":{
        "url" : "/assets/vendor/datatables/indonesia.json",
        "sEmptyTable" : "Tidads"
    },
    responsive: true,
  });
});
$(document).ready(function() {
  $('#dataTable1').DataTable({
    "language":{
        "url" : "/assets/vendor/datatables/indonesia.json",
        "sEmptyTable" : "Tidads"
    },
    responsive: true,
  });
});