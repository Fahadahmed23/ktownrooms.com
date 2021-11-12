
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
.customUnderline{
    /* font-style: italic;  */
    font-weight: 700;
}
    </style>
    
    
    <table style="width:100%; padding: 5px" class="table table-bordered">
       
        <tbody>
            @foreach ($account_heads as $ah)

            <tr>
                {{-- <td style="padding:5px; @if($ah->AccountLevel == 2) padding-left:20px !important; @elseif($ah->AccountLevel == 3) padding-left:35px !important; @elseif ($ah->AccountLevel == 4) padding-left:60px !important; @elseif ($ah->AccountLevel == 5) padding-left:75px !important;  @endif"><u style="@if($ah->AccountLevel != 1) text-decoration: none; font-weight: initial; @else font-style: italic; font-weight: 700; @endif">{{ $ah->AccountTitle }}</u></td> --}}
                <td style="padding:5px; @if($ah->AccountLevel == 2) padding-left:20px !important; @elseif($ah->AccountLevel == 3) padding-left:35px !important; @elseif ($ah->AccountLevel == 4) padding-left:60px !important; @elseif ($ah->AccountLevel == 5) padding-left:75px !important;  @endif"><u class="customUnderline" style="@if($ah->AccountLevel == $level) text-decoration: none; font-weight: initial; @endif">{{ $ah->AccountTitle }}</u></td>
                {{-- @if($ah->OrderNo == 0)
                <td></td>
                <td></td>
                <td></td>
                @elseif ($ah->OrderNo == 1)
                <td>Debit</td>
                <td>Credit</td>
                <td>Total</td>
                @else --}}
                {{-- @if($ah->AccountLevel == 5 ) --}}
                <td>Rs.{{ number_format($ah->Debit, 2) }}</td>
                <td>Rs.{{ number_format($ah->Credit, 2) }}</td>
                {{-- @else
                    @if($ah->OrderNo != 0 && $ah->OrderNo != 1 && $ah->OrderNo != 5 && $ah->OrderNo != 6 && $ah->OrderNo != 10)
                    <td colspan="2"></td>
                    <td>Rs.{{ number_format($ah->Total, 2) }}</td>
                    @endif --}}
                {{-- @endif --}}
                {{-- @endif --}}
            </tr>
            
        @endforeach
        </tbody>
    </table>

