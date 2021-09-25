<style>
    .my-table th, .my-table  td {
        border: 1px solid #000 !important;
        padding: 10px 5px;
    }
    .my-table{
        margin-top: 10px;
        width: 100%;
        border-collapse: collapse;
    }
    .mb-15{
        margin-bottom: 15px;
    }
    .mt-15{
        margin-top: 15px;
    }
    .col-50{
        width:50%;
        float: left;
    }
    .text-right{
        text-align: right;
    }
    .float-right{
        float: right;
    }
    .ft-600{
        font-weight: 600;
    }
    </style>

        
        <div  class="row">
            <div class="mb-15">
                <strong>Fiscal Year: <span>{{ $fiscal_year }}</span></strong>
            </div>
            <div class="mb-15">
                <strong>Status: <span>{{ $status }}</span></strong>
            </div>
        </div>
        @foreach ($general_ledgers as $general_ledger)
            <div  class="row ">
                <div class="">
                    <span class="ft-600">{{ $general_ledger->AccountHead }} - ({{ $general_ledger->AccountGlCode }})</span>
                    <small class="float-right">0.00</small>
                </div>
            </div>
        <div class="row mt-15">
                <table class="my-table">
                    <thead>
                        <tr>
                            <th>Voucher </th>
                            <th>Narration </th>
                            <th>Refrence No. </th>
                            <th>Party Name </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $general_ledger->VoucherName }}</td>
                            <td>{{ $general_ledger->Narration }}</td>
                            <td>{{ $general_ledger->RefNo }}</td>
                            <td>{{ $general_ledger->PartyName }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
        </div>
    
        @endforeach
