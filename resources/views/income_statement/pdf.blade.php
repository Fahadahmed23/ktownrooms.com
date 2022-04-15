<style>
    table.table ul {
        list-style: none;
    }
    .remove-underline {
        text-decoration: none;
        font-weight: initial;
    }
    .aheads .row {
        background: #eeeeee21;
        border-bottom: 1px dashed #e8e8e8;
        padding: 1px 0px;
    }
    .cstStyle{
        /* margin-left: 15%; */
        display: inline-block;
    }
    /* .col-md-6{
        flex: 0 0 50%;
        max-width: 50%;
        float: left;
    }
    .col-md-2{
        flex: 0 0 20%;
        max-width: 20%;
        /* width: 20%; */
        float: left;
    } */
    /* .text-right{
        text-align: right;
    } */
  /* table {
border-collapse: collapse;
}
table th, table td{
    border: 1px solid #dbdbdb;
    padding: 5px;
} */
    </style>
    
    
    <table style="width:100%; padding: 5px" class="table table-bordered">
       
        <tbody>
            @foreach ($income_statements as $is)

            <tr>
                <td style="padding:0px; @if($is->AccountLevel == 1 && $is->OrderNo == 0) padding-left:0px !important; @elseif ($is->AccountLevel == 1) padding-left:5px !important; @elseif ($is->AccountLevel == 2) padding-left:20px !important; @elseif ($is->AccountLevel == 3) padding-left:45px !important; @elseif ($is->AccountLevel == 4) padding-left:65px !important; @elseif ($is->AccountLevel == 5) padding-left:80px !important; @endif"><u style="@if($is->AccountLevel == 5) text-decoration: none; font-weight: initial; @elseif($is->OrderNo == 0) font-weight: 900; font-size:larger;@else font-weight: 700; @endif">{{ $is->AccountTitle }}</u></td>
       
                <td colspan="2"></td>
                <td style="@if($is->OrderNo == 0) font-weight:900; font-size:larger @endif">Rs.{{ number_format($is->Total, 2) }}</td>
            </tr>
            
        @endforeach
        </tbody>
    </table>