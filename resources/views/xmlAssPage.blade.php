<!DOCTYPE html>
<html lang="en">
<head>
  <title>XML Table</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</head>
<body>

<div class="row">
  <div class="container">
    <div class="col-sm-2">

    </div>
    <div class="col-sm-10">


            <h2>Xml File uploaded</h2>
                <form class="border border-success" action="{{ route('xml-upload') }}" id="frm-create-course" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row" >
                        <div class="form-group col-md-9">
                            <label for="user_file">Select XML File:</label>
                            <input type="file" class="form-control" required id="user_file" name="user_file">
                        </div>
                        <div class="col-md-3" style="margin: 23px 0px 0px 0px !important;">
                            <button type="submit" class="btn btn-primary" id="submit-post">Submit</button>
                        </div>
                    </div>
                </form>
            </form>
            <p style="color:red"> <?php echo session()->get('message') ?> </p>


        <h2>XML Details Table</h2>
            <a class="btn btn-warning float-end" href="{{ route('xml.export') }}">Export User Data</a>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($xmlAssModel as $value)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $value->name }} {{ $value->lastname }}</td>
                            <td>{{ $value->phone }}</td>
                            <td><a href="javascript:void(0)" data-id="{{ $value->id }}" class="xml-edit">Edit</a> / <a href="javascript:void(0)" data-id="{{ $value->id }}" class="xml-delete">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    <div class="col-sm-2">

    </div>
  </div>
</div>

<div id="add_update-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Edit Xml</h4>
            </div>
            <form id="xml-update">
                <div class="modal-body">
                    <input type="hidden" name="id" id="ids">
                    <div class="form-group">
                        <label for="name" class="control-label sr-only">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="control-label sr-only">Enter Lastname</label>
                        <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname" required>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label sr-only">Enter Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

        //js to edit an allowance
		$('.xml-edit').click(function(event) {
			var id = $(this).attr('data-id');
			$.ajax({
				type:"GET",
				url:"{{ route('XmlAss.edit') }}",
				data:{ "id" : id },
				success:function(res)
				{
                    $('#ids').val(res['id']);
					$('#name').val(res['name']);
					$('#lastname').val(res['lastname']);
					$('#phone').val(res['phone']);

					$('#add_update-modal .modal-title').text('Edit Xml');
					$('#add_update-modal').modal('show');
				}
			});
		});

		//js to update an allowance
		$('#xml-update').submit(function(e){    
            e.preventDefault();
    		$.ajax({
				type:"POST",
				url:"{{ route('XmlAss.update') }}",
				data:$('form').serialize(),
				dataType: "JSON",
				headers:{'X-CSRF-TOKEN' : '{{ csrf_token() }}'},
				success:function(res){

                    if(res)
					{
						toastr["success"]('XML Updated Successfully');
						setTimeout(function(){
								location.reload();
						}, 3000);
					}
					else
					{
						toastr["error"]('Unable to Update');
						setTimeout(function(){
								location.reload();
						}, 3000);
					}
				}

			});
		});

		//js to delete an allowance
		$('.xml-delete').click(function(){
			var id = $(this).attr('data-id');
			$.ajax({
				type:"GET",
				url:"{{ route('XmlAss.delete') }}",
				data:{'id' : id},
				success:function(res){
					if(res){
						toastr["success"]('XML Deleted Successfully');
						setTimeout(function(){
								location.reload();
						}, 3000);
					}
					else
					{
						toastr["error"]('XML Not Deleted');
						setTimeout(function(){
							location.reload();
						}, 3000);
					}
				}

			});
		});

});
</script>
</body>
</html>
