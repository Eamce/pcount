<script type="text/javascript">
    $(document).ready(function(){
        tbl_user = $('#file_tbl').DataTable({
            destroy:true,
            'ajax':'<?php echo base_url('csv/get_all_csv_file')?>',
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
    function uploadCSVFile(){
        $("#myModal4").modal("show");
        $(":file").change(function() {
            var file = this.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/csv"];
            if ($.inArray(fileType, validImageTypes) < 0) {
                alert("Invalid type of csv!");
                $(":file").val('')
                return false;
            }
        });
    }
</script>