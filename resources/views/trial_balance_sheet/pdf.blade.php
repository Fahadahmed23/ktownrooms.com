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
</style>


<table class="table table-bordered">
   
    <tbody>
        <tr>
        <td>    
            <ul>
                @foreach ($account_heads as $ah)
                    
                <li class="aheads">
                    <div  class="row">
                        @if($ah->AccountLevel == 1)
                            <div class="col-md-6"><u class="font-italic font-weight-bold">{{ $ah->AccountTitle }} </u></div>
                        @else
                            <div class="col-md-6"><span class="font-italic child-level font-weight-bold" class="@if($ah->AccountLevel == 2) pl-2 @elseif ($ah->AccountLevel == 3) pl-3 @elseif ($ah->AccountLevel == 4) pl-4 @else pl-5 @endif"><u class="@if($ah->AccountLevel == $level) remove-underline @endif">{{ $ah->AccountTitle }}</u> </span></div>
                        @endif
                        <div class="col-md-3 text-right">Rs.{{ number_format($ah->Debit, 2) }}</div>
                        <div class="col-md-3 text-right">Rs.{{ number_format($ah->Credit, 2) }}</div>
                    </div>
                </li>
                @endforeach
                <li>
                    <div class="row total_credit_debit">
                        <div class="col-md-9 text-right"><strong>Total Debit :Rs.{{ $totalDebit }}</strong></div>
                        <div class="col-md-3 text-right"><strong>Total Credit :Rs.{{ $totalCredit }} </strong></div>
                    </div>
                </li>
            </ul>
        </td>
        </tr>
    </tbody>
</table>