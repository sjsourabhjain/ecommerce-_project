    <script type="text/javascript" src="{{ asset('js/admin/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/bootstrap.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/jquery.nicescroll.min.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="{{ asset('js/admin/datatables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/developer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/lobibox.min.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<input type="hidden" value="virendra_commit-20-dec-2021:11:33">
<script>

$(document).ready(function(){
    $('#dataTable').DataTable({
        dom: 'Plfrtip',
        stateSave: true
    });
});
const today = new Date();

$(function(){
    $(".addDOB").datepicker({
        endDate:today,
        todayHighlight:true,
        clearBtn:true,
        autoclose:true,
        format:'dd-mm-yyyy'
    }).datepicker('setDate',today);

    $(".editDOB").datepicker({
        endDate:today,
        todayHighlight:true,
        clearBtn:true,
        autoclose:true,
        format:'dd-mm-yyyy'
    });
});

CKEDITOR.replace('content',{
    customConfig : 'config.js',
    toolbar : 'simple'
});

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    CKEDITOR.replace('editor1')
});

$.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        return this.optional(element) || regexp.test(value);
    },
    "Please check your input."
);

$("input").on("keypress", function(e) {
    if (e.which === 32 && !this.value.length)
        e.preventDefault();
});
$("textarea").on("keypress", function(e) {
    if (e.which === 32 && !this.value.length)
        e.preventDefault();
});

 /*$('.delete').click(function(event) {
      var form =  $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();
      swal({
          title: `Are you sure you want to delete?`,
          text: "If you delete this, it will be gone forever.",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          closeOnClickOutside: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });*/

 $('.checknumber').bind('keyup paste ', function(){
          this.value = this.value.replace(/[^0-9]/g, '');
    });

</script>