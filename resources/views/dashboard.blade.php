@extends('layouts.app')

@section('content')
<div class="container-fluid pb-2">
    <div class="vh-100" id="dashboard"></div>
</div>

<script>
    const calipers = <?php echo json_encode($calipers); ?>;
    console.log(calipers);

    //create Tabulator on DOM element with id "dashboard"
    let table = new Tabulator("#dashboard", {
        maxHeight:"100%", // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
        data:calipers, //assign data to table
        layout:"fitColumns", //fit columns to width of table (optional)
        columns:[ //Define Table Columns
            {title:"JH Part Number", field:"jh_part_number", headerFilter:true},
            {title:"Cardone Part Number", field:"cardone_part_number", headerFilter:true},
            {title:"Centric Part Number", field:"centric_part_number", headerFilter:true},
            {title:"Family", field:"caliper_families.family", headerFilter:true},
            {title:"Casting #1", field:"casting1", headerFilter:true},
            {title:"Casting #2", field:"casting2", headerFilter:true},
            {title:"Bracket Casting #", field:"bracket_casting", headerFilter:true},
        ],
    });
    
    //trigger an alert message when the row is clicked
    table.on("rowClick", function(e, row) {
        window.location.href = "/calipers/" + row.getData().id
    });
</script>
@endsection
