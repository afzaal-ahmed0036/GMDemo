@extends('template.tmp')

@section('title', $pagetitle)

@push('after-styles')
    <style id="compiled-css" type="text/css">
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        /* EOS */
    </style>
@endpush
@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @if (session('error'))
                    <div class="alert alert-{{ Session::get('class') }} p-1" id="success-alert">
                        <strong>{{ Session::get('error') }} </strong>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                            data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
                    </div>
                @endif
                @if (session()->has('not_permitted'))
                    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                            data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
                @endif
                @if (count($errors) > 0)
                    <div>
                        <div class="alert alert-danger p-1 border-1 bg-danger text-white">
                            <p class="font-weight-bold"> There were some problems with your input.</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right ">
                                <strong class="text-danger">{{ session::get('Email') }}</strong>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">

                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span
                                                    class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                    <i class="mdi mdi-passport"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Daily Sale</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4 class="text-center"><a
                                                    href="{{ URL('/') }}">{{ $sale[0]->Total == null ? '0' : $sale[0]->Total }}
                                                </a> </h4>
                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span
                                                    class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                    <i class="mdi mdi-passport"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Monthly Expense</h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4 class="text-center"><a
                                                    href="{{ URL('/') }}">{{ $expense[0]->Balance == null ? '0' : $expense[0]->Balance }}
                                                </a> </h4>
                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span
                                                    class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                    <i class="mdi mdi-calendar-cursor font-size-30 "></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Monhtly Income </h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4 class="text-center"><a
                                                    href="{{ URL('/') }}">{{ $revenue[0]->Balance == null ? '0' : $revenue[0]->Balance }}


                                                </a> </h4>

                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-xs me-3">
                                                <span
                                                    class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                                    <i class="mdi mdi-fingerprint"></i>
                                                </span>
                                            </div>
                                            <h5 class="font-size-14 mb-0">Last Year P&L </h5>
                                        </div>
                                        <div class="text-muted mt-4">
                                            <h4 class="text-center"><a href="{{ URL('/') }}">{{ $profit_loss }}</a>
                                            </h4>

                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>

                <div class="row">

                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">

                                        <div class="text-muted mt-4">
                                            <div id="container"></div>
                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">

                                        <div class="text-muted mt-4">
                                            <div id="container2"></div>
                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body border-secondary border-top border-3 rounded-top">

                                        <div class="text-muted mt-4">
                                            <div id="container4"></div>
                                            <div class="d-flex">
                                                <span class="ms-2 text-truncate mt-3"> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    </div>
@endsection
@push('after-scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- apexcharts -->
    <script src="{{ URL('/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- dashboard init -->
    <script src="{{ URL('/') }}/assets/js/pages/dashboard.init.js"></script>

    <script src="{{ URL('/') }}/assets/js/pages/profile.init.js"></script>

    <script type="text/javascript">
        Highcharts.chart('container2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Monthly Income & Expense'
            },

            xAxis: {
                categories: [
                    @foreach ($cash1 as $value)
                        '{{ $value->MonthName }}',
                    @endforeach
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Amount'
                }
            },

            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [

                {
                    name: 'Income',
                    data: [

                        @foreach ($cash1 as $value)



                            {{ $value->Rev }},
                        @endforeach

                    ]

                }, {
                    name: 'Expense',
                    data: [

                        @foreach ($cash1 as $value)



                            {{ $value->Exp }},
                        @endforeach

                    ]

                }
            ],
            credits: {
                enabled: false
            },
        });
        //<![CDATA[


        Highcharts.chart('container', {

            title: {
                text: 'Cash Flow'
            },


            yAxis: {
                title: {
                    text: 'Amount'
                }
            },

            xAxis: {
                categories: [
                    @foreach ($v_cashflow as $value)
                        '{{ $value->MonthName }}',
                    @endforeach
                ],
                // crosshair: true
            },





            series: [{
                // name: 'CashFlow',
                showInLegend: false,
                name: ' ',
                data: [
                    @foreach ($v_cashflow as $value)
                        {
                            {
                                $value - > Balance
                            }
                        },
                    @endforeach
                ]
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            },
            credits: {
                enabled: false
            },

        });


        //]]>
        // Create the chart
        Highcharts.chart('container3', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Browser market shares. January, 2018'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: "Browsers",
                colorByPoint: true,
                data: [1, 1, 1]
            }],

        });
        // Create the chart
        Highcharts.chart('container4', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Cash Summary'
            },

            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Amount'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}'
                    }
                }
            },
            series: [{
                name: "",
                colorByPoint: true,
                data: [
                    @foreach ($cash as $value)
                        {
                            name: "{{ $value->ChartOfAccountName }}",
                            y: {
                                {
                                    ($value - > Balance)
                                }
                            },
                        },
                    @endforeach
                ]
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [{
                        name: "Chrome",
                        id: "Chrome",
                        data: [
                            [
                                "v65.0",
                                0.1
                            ],
                            [
                                "v64.0",
                                1.3
                            ],
                            [
                                "v63.0",
                                53.02
                            ],
                            [
                                "v62.0",
                                1.4
                            ],
                            [
                                "v61.0",
                                0.88
                            ],
                            [
                                "v60.0",
                                0.56
                            ],
                            [
                                "v59.0",
                                0.45
                            ],
                            [
                                "v58.0",
                                0.49
                            ],
                            [
                                "v57.0",
                                0.32
                            ],
                            [
                                "v56.0",
                                0.29
                            ],
                            [
                                "v55.0",
                                0.79
                            ],
                            [
                                "v54.0",
                                0.18
                            ],
                            [
                                "v51.0",
                                0.13
                            ],
                            [
                                "v49.0",
                                2.16
                            ],
                            [
                                "v48.0",
                                0.13
                            ],
                            [
                                "v47.0",
                                0.11
                            ],
                            [
                                "v43.0",
                                0.17
                            ],
                            [
                                "v29.0",
                                0.26
                            ]
                        ]
                    },
                    {
                        name: "Firefox",
                        id: "Firefox",
                        data: [
                            [
                                "v58.0",
                                1.02
                            ],
                            [
                                "v57.0",
                                7.36
                            ],
                            [
                                "v56.0",
                                0.35
                            ],
                            [
                                "v55.0",
                                0.11
                            ],
                            [
                                "v54.0",
                                0.1
                            ],
                            [
                                "v52.0",
                                0.95
                            ],
                            [
                                "v51.0",
                                0.15
                            ],
                            [
                                "v50.0",
                                0.1
                            ],
                            [
                                "v48.0",
                                0.31
                            ],
                            [
                                "v47.0",
                                0.12
                            ]
                        ]
                    },
                    {
                        name: "Internet Explorer",
                        id: "Internet Explorer",
                        data: [
                            [
                                "v11.0",
                                6.2
                            ],
                            [
                                "v10.0",
                                0.29
                            ],
                            [
                                "v9.0",
                                0.27
                            ],
                            [
                                "v8.0",
                                0.47
                            ]
                        ]
                    },
                    {
                        name: "Safari",
                        id: "Safari",
                        data: [
                            [
                                "v11.0",
                                3.39
                            ],
                            [
                                "v10.1",
                                0.96
                            ],
                            [
                                "v10.0",
                                0.36
                            ],
                            [
                                "v9.1",
                                0.54
                            ],
                            [
                                "v9.0",
                                0.13
                            ],
                            [
                                "v5.1",
                                0.2
                            ]
                        ]
                    },


                ]
            }
        });
    </script>
@endpush
