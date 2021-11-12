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
        /* float: left; */
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
            @foreach ($balance_sheets as $bs)

            <tr style="@if($bs->OrderNo == 0) background: #3f51b5; color:#fff; border:none; @endif">
                {{-- <td style="padding:0px; @if ($bs->AccountLevel == 3) padding-left:20px !important; @elseif ($bs->AccountLevel == 4) padding-left:40px !important; @elseif ($bs->AccountLevel == 5) padding-left:60px !important;  @endif"><u style="@if($bs->AccountLevel == 5) text-decoration: none; font-weight: initial; @else font-weight: 700; @endif">{{ $bs->AccountTitle }}</u></td> --}}
                <td style="padding:0px; @if($bs->AccountLevel == 1 && ($bs->OrderNo == 0 || $bs->OrderNo == 3)) padding-left:0px !important; @elseif ($bs->AccountLevel == 1) padding-left:5px !important; @elseif ($bs->AccountLevel == 2 && $bs->OrderNo != 2) padding-left:20px !important; @elseif ($bs->AccountLevel == 2 && $bs->OrderNo == 2) padding-left:32px !important; @elseif ($bs->AccountLevel == 3) padding-left:45px !important; @elseif ($bs->AccountLevel == 4) padding-left:65px !important; @elseif ($bs->AccountLevel == 5) padding-left:80px !important; @endif"><u style="@if($bs->AccountLevel == 5) text-decoration: none; font-weight: initial; @elseif($bs->OrderNo == 0) font-weight: 900; font-size:larger;@else font-weight: 700; @endif">{{ $bs->AccountTitle }}</u></td>
                <td colspan="2"></td>
                <td>Rs.{{ number_format($bs->Total, 2) }}</td>
                
            </tr>
            
        @endforeach
        @if(count($balance_sheets))
            <td style="padding:0px; font-weight: 900; font-size:larger;"><u>TOTAL LIABILITIES & EQUITY</u></td>   
            <td colspan="2"></td>   
            <td >Rs.{{ number_format($total_equity, 2) }}</td>
        @endif
        </tbody>
    </table>