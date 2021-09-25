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
                <td style="padding:5px; @if($is->AccountLevel == 3) padding-left:5px !important; @elseif ($is->AccountLevel == 4) padding-left:20px !important; @elseif ($is->AccountLevel == 5) padding-left:60px !important;  @endif"><u style="@if($is->AccountLevel == 5) text-decoration: none; font-weight: initial; @else font-style: italic; font-weight: 700; @endif">{{ $is->AccountTitle }}</u></td>
                @if($is->OrderNo == 0)
                <td></td>
                <td></td>
                <td></td>
                @elseif ($is->OrderNo == 1)
                <td>Debit</td>
                <td>Credit</td>
                <td>Total</td>
                @else
                    @if($is->AccountLevel == 5 )
                        <td colspan="1">Rs.{{ number_format($is->Debit, 2) }}</td>
                        <td>Rs.{{ number_format($is->Credit, 2) }}</td>
                    @else
                        @if($is->OrderNo != 0 && $is->OrderNo != 1 && $is->OrderNo != 5 && $is->OrderNo != 6 && $is->OrderNo != 10)
                        <td colspan="2"></td>
                        <td>Rs.{{ number_format($is->Total, 2) }}</td>
                        @endif
                    @endif
                @endif
            </tr>
            
        @endforeach
        </tbody>
    </table>