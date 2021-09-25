<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title></title>

        <style>
            @page { 
                    margin: 100px 25px; 
                }
                header { 
                    position: fixed; 
                    top: -50px; 
                    left: -25px; 
                    right: -25px; 
                    text-align: center;
                    background-color: #353535; 
                    height: 70px;  
                    border-radius: 25%;
                    margin:0 0 0 0 ;

                    /* position: fixed;
                    top: 0cm;
                    left: 0cm;
                    right: 0cm;
                    height: 2cm; */

                    /** Extra personal styles **/
                    /* background-color: #03a9f4;
                    color: white;
                    text-align: center;
                    line-height: 1.5cm; */
                }
                footer { 
                    position: fixed; 
                    bottom: -60px; 
                    left: -25px; 
                    right: -25px; 
                    background-color: #353535; 
                    height: 50px; 
                    border-radius: 25%;
                    margin:0 0 0 0 ;
                }
                .page-break {
                    page-break-after: always;
                }
                .custom-style{
                    width: 100%;
                    margin: 10px;
                    font-size: 10px;
                }
                table {
                    position: relative;
                    top: 30px; 
                    margin: 0,0,50px,0;
                    border-left: 0.01em solid #000;
                    border-right: 0;
                    border-top: 0.01em solid #000;
                    border-bottom: 0;
                    border-collapse: collapse;
                }
                table td,
                table th {
                    border-left: 0;
                    border-right: 0.01em solid #000;
                    border-top: 0;
                    border-bottom: 0.01em solid #000;
                }
                .cover-main{
                    position: absolute;
                    top: 0;
                    left: 0;
                    border: 5px groove;
                    width: 100%;
                    height: 100%;
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                .cover-text{
                    position: absolute;
                    top: 38%;
                    left: 35%;
                    font-size: 30px; 
                }
                .cover-text2{
                    position: absolute;
                    left: 35%;
                    font-size: 20px;  
                    /* top: 40%; */
                   
                }
                .cover-text3{
                    position: absolute;
                    top: 58%;
                    left: 30%;
                    /* margin-right: 70px; */
                    /* float: right; */
                    color:#000;
                    /* width: auto; */
                    /* border: 1px solid #000; */
                    /* border-width: auto; */
                    /* background-color: #000; */
                    /* border-radius: 20%; */
                    /* opacity: 0.5; */
                    /* padding:25px;  */
                }
                /* .cover-text4{
                    border: 1px solid #000; 
                    background-color: #000;
                    opacity: 1;
                    width: 230px;
                    color: #fff
                } */
        </style>
    </head>
    <body>
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_script ('
                if ($PAGE_NUM != 1) {
                    $current_page = $PAGE_NUM - 1;
                    $total_pages = $PAGE_COUNT -1;
                    $pdf->text(525, 800, "Page $current_page of $total_pages", null, 10, array(255,255,255));
                }
                if ($PAGE_NUM == 1) {
                    $total_pages = $PAGE_COUNT -1;
                    $pdf->text(300, 402, "$total_pages", null, 14, [0,0,0]);
                }
                ');

            }
        </script>   
        <div class="cover-main">
            {{-- <img class="cover-img" src="{{ public_path('page_001.jpg')}}" width="700" height="800" alt="BTS" style=""> --}}
            
            
        </div>
        
        <img src="{{ $data['museum_picture'] }}" width="160" height="75" alt="BTS" style="position: absolute; top: 30%;margin-left: 37%; display: inline-block; float:left">
        <small class="cover-text" style="margin-top:10px;">{{ $data['museum_name'] }}</small>
        <small class="cover-text2" style="top:44%;">{{ $data['report_name'] }} Report</small>
        {{-- <small class="cover-text2" style="top:61%;">Time Span</small> --}}
        <small class="cover-text2" style="top:47%;">Page Count :
            <script type="text/php">
            </script>
        </small>
        <small class="cover-text2" style="top:50%;">Generated Date:{{ $data['generated_date'] }}</small>
        <small class="cover-text2" style="top:53%;">Generated By: {{ $data['generated_by'] }}</small>
        {{-- {{ dd(count($data['searchGroups'][0])) }} --}}
        @if(count($data['searchGroups']) > 0)
            @if(count($data['searchGroups'][0]) > 0)
                @if ($data['searchGroups'][0][0]['column'] != null)
            
            {{-- <ul class="cover-text3" style="width: 40%;padding:25px; font-size:16px;"> --}}
                    <ul class="cover-text3">
                        <h3>Criteria</h3>
                        @foreach ($data['searchGroups'] as $key => $searchGroup)
                            @foreach ($searchGroup as $item)
                                
                            <li class="cover-text4">
                                <small> {{ $item['column']['alias'] }} {{ $item['operator'] }} {{ $item['value'] }}</small>
                                @if($item !==  end($searchGroup))
                                    <span>AND</span>
                                @endif
                            </li>
                            
                            @endforeach
                            @if($searchGroup !==  end($data['searchGroups']))
                                <span>OR</span>
                            @endif
                        @endforeach
                        
                    </ul>
                @endif
            @endif
        @endif

        <div class="page-break"></div>
        <header>
            <img src="{{ $data['museum_picture']}}" width="80" height="40" alt="BTS" style="margin: 10px 0 0 30px;display: inline-block; float:left">
            {{-- <img src="/public/museum-icon-ready.png" width="40" height="40"/> --}}
            <h4 style="float:left; margin-left: 25%; font-size: 16px !important; color:#fff">{{ $data['report_name'] }} Report (contd.)</h4>
        </header>
        <footer> 
            {{-- <span id="pageNumber"></span> --}}
            <small style="font-size: 14px !important; display:block; margin: 10px 0 0 30px; color:#fff">{{ $data['museum_name'] }} Confidential</small>
            <!-- <small style="font-size: 12px !important; margin: 10px 0 0 30px; color:#fff">&copy; PatronAssist.com by Integrated Patron Solutions, LLC</small> -->

            
        </footer>
        <h5 class="card-title"> 
            {{-- <a href="criteria[[urlParams]]"><button type="button" class="btn btn-outline-danger"><i class="icon-gear"></i> Configure Report</button></a> --}}
            {{-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#SaveReport"><i class="icon-floppy-disk"></i> Save Report Configuration</button> --}}
        </h5>

        @if(count($data['result']) < 1)
        <h1 style="width:90%;text-align:center;font-weight:bold" >No Data</h1>
        @else
            <table id="report-tbl" class="table datatable-basic custom-style" >
                <thead style="font-size: 11px !important">
                    <tr>
                        @foreach ($data['selectedColumns'] as $col)
                            <th>{{ $col['Alias'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['result'] as $key2 => $row)
                        <tr>
                            @foreach ($row as $key3 => $item)
                            {{-- {{ dd($key3, $data['selectedColumns']) }} --}}
                                
                                @php
                                    preg_match('~>\K[^<>]*(?=<)~', $item, $match);
                                @endphp   
                                @if(count($match))   
                                    <td>{{ $match[0] }}</td>
                                @else
                                    @foreach ($data['selectedColumns'] as $col)
                                        @if ($col['Alias'] == $key3)
                                            @if ($col['Type'] == 'date')
                                                <td>{{ date('m/d/Y', strtotime($item)) }}</td>
                                            @elseif ($col['Type'] == 'amount')
                                                <td>Rs. {{ number_format($item, 2) }}</td>
                                            @elseif ($col['Type'] == 'number')
                                                <td>{{ number_format($item) }}</td>
                                            @elseif  ($col['Type'] == 'time')
                                                <td>{{ date('h:i a', strtotime($item)) }}</td>
                                            @else
                                                <td>{{ $item }}</td>
                                            @endif

                                        @endif
                                    @endforeach 
                                    
                                @endif
                            @endforeach
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @endif
    </body>
</html>