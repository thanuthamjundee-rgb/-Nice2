@extends('layouts.master')
@section('title')
    @lang('translation.Dashboard')
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Minible
        @endslot
        @slot('title')
            Dashboard
                            
        @endslot
    @endcomponent
    
    <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>


<h2>HTML Table</h2>

<table id="userTable">
        <thead>
            <tr>
                <th>user_id</th>
                <th>username</th>
                <th>password</th>
                <th>first_name</th>
                <th>last_name</th>
                <th>gender</th>
                <th>status</th>
            </tr>
        </thead>
  <tbody>
           
 </tbody>
 
</table>
    
@endsection
@section('script')
    <script>
     
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            getData();
        function getData() {
            $.ajax({
               type:'POST',
               method: 'post',
               url:'http://127.0.0.1:8000/details',
               success:function(data) {
                // console.log(data)
                populateTable(data);
               }
            });
         }
         function populateTable(data) {
            const tableBody = $('#userTable tbody');
            tableBody.empty(); // Clear any existing rows
            dataSet = data.data
            dataSet.forEach(item => {
                const row = `
                    <tr>
                        <td>${item.user_id}</td>
                        <td>${item.username}</td>
                        <td>${item.password}</td>
                        <td>${item.first_name}</td>
                        <td>${item.last_name}</td>
                        <td>${item.gender}</td>
                        <td>${item.status}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }
    </script>
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
