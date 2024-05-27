 $(document).ready(function() {
     let  dataTable = $('#table_reporte').DataTable({
         processing: true,
         serverSide: false,
          dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
         "<'row justify-content-md-center'<'col-sm-12't>>" +
         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
         language: {
             "url": url + "asset/datatables/Spanish.json"
         }
     });
});