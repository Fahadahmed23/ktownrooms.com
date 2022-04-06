<div class="page-header page-header-light">

    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                @if( isset($breadcrumbs) && count($breadcrumbs) > 0 )
                    @foreach($breadcrumbs as $title => $link)
                        @if( !next( $breadcrumbs ) ) 
                             <div  class="breadcrumb-item">{{ $title }}</div>
                        @else
                            <a href="{{ $link }}" class="breadcrumb-item">
                                @if($title == 'Home')
                                    <i class="icon-home2 mr-2"></i>
                                @endif
                                {{ $title }}
                            </a>
                        @endif
                       
                    @endforeach
                @endif
                <!-- <span class="breadcrumb-item active">Reports</span> -->
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