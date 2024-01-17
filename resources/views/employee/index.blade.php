<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salary range slider filter</title>
        {{-- jQuery --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        {{-- DataTables --}}
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
   
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
        $( function() {
          $( "#slider-range" ).slider({
            range: true,
            min: 10000,
            max: 90000,
            values: [ 10000, 90000 ],
            slide: function( event, ui ) {
              $( "#amount" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ] );
              $( "#min_amt" ).val(ui.values[ 0 ]);
              $( "#max_amt" ).val(ui.values[ 1 ]);
            }
          });
          $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
            " - " + $( "#slider-range" ).slider( "values", 1 ) );
        } );
        </script>
       
    
</head>
<body>
    @extends('employee.layout')

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-center">Employee CRUD</h2>
        </div>
        <div class="pull-right">
                
                <a href="{{route('employee.statistics')}}" class="btn btn-secondary">Statistics</a>

                <p>
                    <label for="amount">Price range:</label>
                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <input type="hidden" id="min_salary" name="min_salary" value="">
                    <input type="hidden" id="max_salary" name="max_salary" value="">
                  </p>
                   
                  <div id="slider-range"></div>
                <div id="employee-container">
                    {{-- Employee list will be diplayed here --}}
                </div><br>
                <div>
                    <select name="department" id="department" class="form-control w-25">
                        <option value="">Select Department</option>
                        @foreach ($department as $row)
                        <option value="{{$row->id}}">
                            {{$row->dept}}
                        </option>
                        @endforeach
                    </select>
                   
                </div><br>
            </form> 
            {{-- <center><button type="button" class="btn btn-success">Search</button></center> --}}
        </div>

       
    </div>
</div><br>

@if ($message=Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif


 <!-- jQuery CDN Link -->
 <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

 <!-- Bootstrap 5 Bundle CDN Link -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

 <!-- jQuery UI CDN Link -->
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

 <!-- DataTables JS CDN Link -->
 <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

 <!-- DataTables JS ( includes Bootstrap 5 for design [UI] ) CDN Link -->
 <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

<table class="table table-bordered data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Salary</th>
            <th>Department</th>
            <th>Email</th>
            <th>DOB</th>
            <th>Gender</th>
        </tr>
    </thead>
    
    <tbody>

    </tbody>
   
</table>
@endsection

<script>
    $(function(){

        let csrf_token = $('meta[name="csrf_token"]').attr('content');

        var table=$('.data-table').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                url:"{{route('employee.index')}}",
                data:function(d){
                    d.department=$('#department').val(),
                    d.min_salary=$('#min_salary').val(),
                    d.max_salary=$('#max_salary').val(),
                    d.search = $('input[type="search"]').val()
                }
            },
            columns:[
                {data:'id',name:'id'},
                {data:'name',name:'name'},
                {data:'salary',name:'salary'},
                {data:'depart',name:'department'},
                {data:'email',name:'email'},
                {data:'dob',name:'dob'},
                {data:'gender',name:'gender'}
                
            ]
        });

        $('#slider-range').on('click',function(){

            table.draw();
            // var min_salary=$('#min_salary').val();
            // var max_salary=$('#max_salary').val();

            // //Make ajax call
            // $.ajax({
            //     url:'{{route('employee.search')}}',
            //     type:'POST',
            //     data:{min_salary:min_salary,max_salary:max_salary},
            //     success:function(response){
            //         $('.data-table').html(response);
            //     }
            // });
        });

       
        $('#department').click(function(){
            table.draw();
        });
        $('#amount').click(function(){
            table.draw();
        });

    });
</script>
    
</body>
</html>
