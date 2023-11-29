@foreach ($stickerxy as $value2)
    @for ($i = 1; $i <= $value2->qty; $i++)
        <html>

        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>@font-face Demo</title>
            <style>
                * {
                    box-sizing: border-box;
                }

                .rotate1 {
                    /* writing-mode: vertical-lr; */
                    margin: 0 0 0;
                    line-height: 9px;
                    /*font-size: 28px;*/
                    /*letter-spacing: 0.5px;*/
                    width: 4cm;
                    text-align: left;
                    /*transform: rotate(270deg);*/
                }

                .box {
                    /*background-color: #2b547e;*/
                    /*color: white;*/
                    /*padding: 20px;*/
                    margin: 0px;
                    display: inline-block;
                    position: absolute;
                    left: -40px;
                    top: -37px;
                }
            </style>
        </head>

        <body style="margin: 0px !important; padding: 0px !important;">
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

            <div class="box rotate1">
                <span style="font-size: 13px;">{{ $companyName->Name }}</span>
                <br>
                <span style="font-size: 9px;">Tel: {{ $companyName->Contact }}</span><br>
                <span
                    style="font-size: 13px; letter-spacing: 3px; line-height: 12px !important;">{{ $value2->itemid }}</span><br>
                <span><img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($value2->itemid, 'C128') }}"
                        alt="barcode" style="width: 30mm; height:10mm;" /></span><br>
                <span style="font-size: 14px; line-height: 14px !important;">AED: {{ $value2->price }}</span><br>
            </div>

        </body>

        </html>
    @endfor
@endforeach
