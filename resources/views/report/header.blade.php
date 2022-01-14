<div class="page-header page-header-light">

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                @if(!isset($breadcrumbs) )
                <a href="/home" class="breadcrumb-item">
                    <i class="icon-home2 mr-2"></i> 
                </a>
                @if(Request::path() == 'criteria')
                <a href="/reports" class="breadcrumb-item">
                    Reports
                </a>
                @endif
                <span class="breadcrumb-item active">@if(Request::path() == 'criteria') {{ request()->get('title') ?? request()->get('report') }} @else Reports @endif</span>
                @endif

                @if( isset($breadcrumbs) && count($breadcrumbs) > 0 )
                    <a href="/home" class="breadcrumb-item">
                        <i class="icon-home2 mr-2"></i> 
                    </a>
                    @foreach($breadcrumbs as $title => $link)
                        @if( !next( $breadcrumbs ) ) 
                             <div  class="breadcrumb-item">{{ $title }}</div>
                        @else
                            <a href="{{ $link }}" class="breadcrumb-item">
                                {{ $title }}
                            </a>
                        @endif
                       
                    @endforeach
                @endif
            </div>

            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            <div class="breadcrumb justify-content-center">
                <div class="input-group">
                    <!-- <div class="form-group-feedback">
                        <input type="text" ng-model="slotSearchText" class="srch form-control form-control-lg alpha-grey" placeholder="Search">
                        <div class="form-control-feedback dleft form-control-feedback-lg">
                            <i class="icon-search4 text-muted"></i>
                        </div>
                        <a href="#" class="form-control-feedback dright text-warning">
                            <div>
                                <i class="icon-arrow-right7"></i>
                            </div>
                        </a>
                    </div> -->

                </div>

            </div>
        </div>
    </div>
</div>