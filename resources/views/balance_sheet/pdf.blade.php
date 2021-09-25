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
                <td style="padding:0px; @if ($bs->AccountLevel == 3) padding-left:20px !important; @elseif ($bs->AccountLevel == 4) padding-left:40px !important; @elseif ($bs->AccountLevel == 5) padding-left:60px !important;  @endif"><u style="@if($bs->AccountLevel == 5) text-decoration: none; font-weight: initial; @else font-style: italic; font-weight: 700; @endif">{{ $bs->AccountTitle }}</u></td>
                @if($bs->OrderNo == 0)
                <td></td>
                <td></td>
                <td></td>
                @elseif ($bs->OrderNo == 1)
                <td>Debit</td>
                <td>Credit</td>
                <td>Total</td>
                @else
                    @if($bs->AccountLevel == 5 )
                        <td colspan="1">Rs.{{ number_format($bs->Debit, 2) }}</td>
                        <td>Rs.{{ number_format($bs->Credit, 2) }}</td>
                    @else
                        @if($bs->AccountTitle == 'Total Equity' )
                            <td colspan="2"></td>
                            <td>Rs.{{ number_format($total_equity, 2) }}</td>
                        @else
                            @if($bs->OrderNo != 0 && $bs->OrderNo != 1)
                            <td colspan="2"></td>
                            <td>Rs.{{ number_format($bs->Net, 2) }}</td>
                            @endif
                        @endif
                    @endif
                @endif
            </tr>
            
        @endforeach
        </tbody>
    </table>