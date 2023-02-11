@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Property Stats</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left refresh mr-15 inline-block">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <a href="#" class="pull-left full-screen mr-15 inline-block">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                            <div class="pull-left dropdown inline-block">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
                                    role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                                class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                                class="icon wb-share" aria-hidden="true"></i>General</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i
                                                class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div id="e_chart_1" class="" style="height:350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel card-view">
                    <div class="panel-heading small-panel-heading relative">
                        <div class="pull-left">
                            <h6 class="panel-title">Monthly Revenue</h6>
                        </div>
                        <div class="clearfix"></div>
                        <div class="head-overlay"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body row pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="block"><i
                                                    class="zmdi zmdi-trending-up txt-warning font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font">growth</span></span>
                                            <span class="txt-dark counter block">$<span
                                                    class="counter-anim">15,678</span></span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-right pl-0 pr-0 text-center">
                                            <div id="sparkline_6" style="width: 100px; overflow: hidden; margin: 0px auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel card-view">
                    <div class="panel-heading small-panel-heading relative">
                        <div class="pull-left">
                            <h6 class="panel-title">Category Overview</h6>
                        </div>
                        <div class="clearfix"></div>
                        <div class="head-overlay"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body row pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class=""><i
                                                    class="zmdi zmdi-trending-up txt-warning font-18 mr-5"></i><span
                                                    class="weight-500 uppercase-font">growth</span></span>
                                            <span class="txt-dark counter block">$<span
                                                    class="counter-anim">5,676</span></span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-right pl-0 pr-0 text-center">
                                            <div id="sparkline_7" style="width: 100px; overflow: hidden; margin: 0px auto;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span
                                                    class="counter-anim">914,001</span></span>
                                            <span class="weight-500 uppercase-font font-13 block">All Properties</span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span
                                                    class="counter-anim">46.41</span>%</span>
                                            <span class="weight-500 uppercase-font block">growth rate</span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="icon-graph data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span
                                                    class="counter-anim">4,054,876</span></span>
                                            <span class="weight-500 uppercase-font block">Totle Sales</span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 data-wrap-left pl-0 pr-0 text-center">
                                            <span class="txt-dark counter block"><span
                                                    class="counter-anim">4,054</span></span>
                                            <span class="weight-500 uppercase-font block">Rented</span>
                                        </div>
                                        <div class="col-xs-6 data-wrap-right pl-0 pr-0 text-center">
                                            <i class="icon-flag data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Project Sales</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper in collapse">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table-hover mb-0 table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Products</th>
                                                <th>Popularity</th>
                                                <th>Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Milk Powder</td>
                                                <td><span class="peity-bar" data-width="90"
                                                        data-peity='{ "fill": ["#667add"], "stroke":["#667add"]}'
                                                        data-height="40">0,-3,-2,-4,5,-4,3,-2,5,-1</span> </td>
                                                <td><span class="text-danger text-semibold"><i class="fa fa-level-down"
                                                            aria-hidden="true"></i> 28.76%</span> </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Air Conditioner</td>
                                                <td><span class="peity-bar" data-width="90"
                                                        data-peity='{ "fill": ["#667add"], "stroke":["#667add"]}'
                                                        data-height="40">0,-1,1,-2,-3,1,-2,-3,1,-2</span> </td>
                                                <td><span class="text-warning text-semibold"><i class="fa fa-level-down"
                                                            aria-hidden="true"></i> 8.55%</span> </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>RC Cars</td>
                                                <td><span class="peity-bar" data-width="90"
                                                        data-peity='{ "fill": ["#667add"], "stroke":["#667add"]}'
                                                        data-height="40">0,3,6,1,2,4,6,3,2,1</span> </td>
                                                <td><span class="text-success text-semibold"><i class="fa fa-level-up"
                                                            aria-hidden="true"></i> 58.56%</span> </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Down Coat</td>
                                                <td><span class="peity-bar" data-width="90"
                                                        data-peity='{ "fill": ["#667add"], "stroke":["#667add"]}'
                                                        data-height="40">0,3,6,4,5,4,7,3,4,2</span> </td>
                                                <td><span class="text-info text-semibold"><i class="fa fa-level-up"
                                                            aria-hidden="true"></i> 35.76%</span> </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Xyz Byke</td>
                                                <td><span class="peity-bar" data-width="90"
                                                        data-peity='{ "fill": ["#667add"], "stroke":["#667add"]}'
                                                        data-height="40">0,3,6,4,5,4,7,3,4,2</span> </td>
                                                <td><span class="text-info text-semibold"><i class="fa fa-level-up"
                                                            aria-hidden="true"></i> 35.76%</span> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->


    </div>
@endsection

@section('javascript')
    <script src="{{ asset('admin') }}/vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="{{ asset('admin') }}/dist/js/dashboard6-data.js"></script>
@endsection
