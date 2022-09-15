<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 5.8 - DataTables Server Side Processing using Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Laravel 5.8 Ajax Crud Tutorial - Delete or Remove Data</h3>
        <br />
        <div align="right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button>
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="user_table">
                <thead>
                    <tr>
                        <th width="10%">Id</th>
                        <th width="10%">JsonId</th>
                        <th width="10%">UserId</th>
                        <th width="20%">User Name</th>
                        <th width="10%">Post Id</th>
                        <th width="40%">Body</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br />
        <br />
    </div>
</body>

</html>

<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Record</h4>
            </div>
            <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-md-4">Select Json File : </label>
                        <div class="col-md-8">
                            <input type="file" name="file" id="file" />
                            <span id="store_image"></span>
                        </div>
                    </div>
                    <br />
                    <div class="form-group" align="center">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="hidden_id" id="hidden_id" />
                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $("#user_table").DataTable({
        processing: true,
        serverSide: true,
        
        ajax: {
            url: "{{ route('home') }}",
            "type": "GET"
        },
        columns: [
            {
                data: "id",
                name: "id",
            },
            {
                data: "jsonId",
                name: "jsonId",
            },
            {
                data: "user_id",
                name: "user_id",
            },
            {
                data: "user_name",
                name: "user_name",
            },
            {
                data: "post_id",
                name: "post_id",
            },
            {
                data: "body",
                name: "body",
            },
        ],
    });

    $("#create_record").click(function() {
        $(".modal-title").text("Add New Record");
        $("#action_button").val("Add");
        $("#action").val("Add");
        $("#formModal").modal("show");
    });

    $("#sample_form").on("submit", function(event) {
        event.preventDefault();
        if ($("#action").val() == "Add") {
            $.ajax({
                url: "{{ route('storeData') }}",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    var html = "";
                    if (data.errors) {
                        html = '<div class="alert alert-danger">';
                        for (
                            var count = 0; count < data.errors.length; count++
                        ) {
                            html += "<p>" + data.errors[count] + "</p>";
                        }
                        html += "</div>";
                    }
                    if (data.success) {
                        html =
                            '<div class="alert alert-success">' +
                            data.success +
                            "</div>";
                        $("#sample_form")[0].reset();
                        $("#user_table").DataTable().ajax.reload();
                    }
                    $("#form_result").html(html);
                },
            });
        }

    });


});
</script>
