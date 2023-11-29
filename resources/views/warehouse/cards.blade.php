@extends('template.tmp')

@section('title', $pagetitle)

@section('page-styles')

<style>
    img {
        height: 150px;
        width: 100%;
    }

    div [class^="col-"] {
        padding-left: 5px;
        padding-right: 5px;
    }

    .card {
        transition: 0.5s;
        cursor: pointer;
    }

    .card-title {
        font-size: 15px;
        transition: 1s;
        cursor: pointer;
    }

    .card-title i {
        font-size: 15px;
        transition: 1s;
        cursor: pointer;
        color: #ffa710
    }

    .card-title i:hover {
        transform: scale(1.25) rotate(100deg);
        color: #18d4ca;

    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.3);
    }

    .card-text {
        height: 80px;
    }

    .card::before,
    .card::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        transform: scale3d(0, 0, 1);
        transition: transform .3s ease-out 0s;
        background: rgba(255, 255, 255, 0.1);
        content: '';
        pointer-events: none;
    }

    .card::before {
        transform-origin: left top;
    }

    .card::after {
        transform-origin: right bottom;
    }

    .card:hover::before,
    .card:hover::after,
    .card:focus::before,
    .card:focus::after {
        transform: scale3d(1, 1, 1);
    }

    /* CARE SECOND */


    .card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        transition: all 0.2s ease-in-out;
        box-sizing: border-box;
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #FFF;
    }

    .card:hover {
        box-shadow: 0 5px 5px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }

    .card>.card-inner {
        padding: 10px;
    }

    .card .header h2,
    h3 {
        margin-bottom: 0px;
        margin-top: 0px;
    }

    .card .header {
        margin-bottom: 5px;
    }

    .card img {
        width: 100%;
    }

    /* LAST CARDS */

    .cstm-height-card .card-img-top {
        height: 100px;
        object-fit: cover;
    }
</style>
@endsection
@section('content')

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right ">
                            <strong class="text-danger"> </strong>

                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->



            @if (session('error'))

            <div class="alert alert-{{ Session::get('class') }} p-3" id="success-alert">

                {{ Session::get('error') }}
            </div>

            @endif

            @if (count($errors) > 0)

            <div>
                <div class="alert alert-danger pt-3 pl-0   border-3 bg-danger text-white">
                    <p class="font-weight-bold"> There were some problems with your input.</p>
                    <ul>

                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div>
            </div>

            @endif
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="card card-block">
                        <h4 class="card-title text-right"><i class="material-icons">settings</i></h4>
                        <img src="https://static.pexels.com/photos/7096/people-woman-coffee-meeting.jpg" alt="Photo of sunset">
                        <h5 class="card-title mt-3 mb-3">Sierra Web Development • Owner</h5>
                        <p class="card-text">This is a company that builds websites, web apps and e-commerce solutions.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card card-block">
                        <h4 class="card-title text-right"><i class="material-icons">settings</i></h4>
                        <img src="https://static.pexels.com/photos/7357/startup-photos.jpg" alt="Photo of sunset">
                        <h5 class="card-title  mt-3 mb-3">ProVyuh</h5>
                        <p class="card-text">This is a company that builds websites, web .</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card card-block">
                        <h4 class="card-title text-right"><i class="material-icons">settings</i></h4>
                        <img src="https://static.pexels.com/photos/262550/pexels-photo-262550.jpeg" alt="Photo of sunset">
                        <h5 class="card-title  mt-3 mb-3">ProVyuh</h5>
                        <p class="card-text">This is a company that builds websites, web apps and e-commerce solutions.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card card-block">
                        <h4 class="card-title text-right"><i class="material-icons">settings</i></h4>
                        <img src="https://static.pexels.com/photos/326424/pexels-photo-326424.jpeg" alt="Photo of sunset">
                        <h5 class="card-title  mt-3 mb-3">ProVyuh</h5>
                        <p class="card-text">This is a company that builds websites, web apps and e-commerce solutions.</p>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                            <img src="http://loremflickr.com/320/150?random=4" />
                        </div>
                        <div class="card-inner">
                            <div class="header">
                                <h2>Title</h2>
                                <h3>Sub-Head</h2>
                            </div>
                            <div class="content">
                                <p>Content area</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                            <img src="http://loremflickr.com/320/150?random=5" />
                        </div>
                        <div class="card-inner">
                            <div class="header">
                                <h2>Title</h2>
                                <h3>Sub-Head</h2>
                            </div>
                            <div class="content">
                                <p>Content area</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                            <img src="http://loremflickr.com/320/150?random=6" />
                        </div>
                        <div class="card-inner">
                            <div class="header">
                                <h2>Title</h2>
                                <h3>Sub-Head</h2>
                            </div>
                            <div class="content">
                                <p>Content area</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                            <img src="http://loremflickr.com/320/150?random=2" />
                        </div>
                        <div class="card-inner">
                            <div class="header">
                                <h2>Title</h2>
                                <h3>Sub-Head</h2>
                            </div>
                            <div class="content">
                                <p>Content area</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                            <img src="http://loremflickr.com/320/150?random=3" />
                        </div>
                        <div class="card-inner">
                            <div class="header">
                                <h2>Title</h2>
                                <h3>Sub-Head</h2>
                            </div>
                            <div class="content">
                                <p>Content area</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                            <img src="http://loremflickr.com/320/150" />
                        </div>
                        <div class="card-inner">
                            <div class="header">
                                <h2>Title</h2>
                                <h3>Sub-Head</h2>
                            </div>
                            <div class="content">
                                <p>Content area</p>
                            </div>
                        </div>
                    </div>
                </div>





            </div> <!-- end row -->


            <div class="row">

                <div class="col-sm-3">
                    <div class="card card-block">
                        <img class="card-img-top" data-src="holder.js/100px180/" alt="100%x180" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22318%22%20height%3D%22180%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px180%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_153cdb63a13%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_153cdb63a13%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%22118.0859375%22%20y%3D%2297.35%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                        <div class="card-block">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Button</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card card-block">
                        <img class="card-img-top" data-src="holder.js/100px180/" alt="100%x180" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22318%22%20height%3D%22180%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px180%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_153cdb63a13%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_153cdb63a13%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%22118.0859375%22%20y%3D%2297.35%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                        <div class="card-block">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Button</a>
                        </div>


                    </div>


                </div>

                <div class="col-sm-3">
                    <div class="card card-block">
                        <img class="card-img-top" data-src="holder.js/100px180/" alt="100%x180" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22318%22%20height%3D%22180%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px180%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_153cdb63a13%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_153cdb63a13%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%22118.0859375%22%20y%3D%2297.35%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                        <div class="card-block">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Button</a>
                        </div>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="card card-block">
                        <img class="card-img-top" data-src="holder.js/100px180/" alt="100%x180" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22318%22%20height%3D%22180%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3C!--%0ASource%20URL%3A%20holder.js%2F100px180%2F%0ACreated%20with%20Holder.js%202.8.2.%0ALearn%20more%20at%20http%3A%2F%2Fholderjs.com%0A(c)%202012-2015%20Ivan%20Malopinsky%20-%20http%3A%2F%2Fimsky.co%0A--%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%3C!%5BCDATA%5B%23holder_153cdb63a13%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%5D%5D%3E%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_153cdb63a13%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%2F%3E%3Cg%3E%3Ctext%20x%3D%22118.0859375%22%20y%3D%2297.35%22%3E318x180%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                        <div class="card-block">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Button</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/random/1920x1080" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/random/1920x1080" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/random/1920x1080" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <h3>Same height for image (Suitable for dynamic different size images) ―</h3>
            <div class="row mb-5 cstm-height-card">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/random/1200x900" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/random/1500x800" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://source.unsplash.com/random/1400x700" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-sm btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-4">
                                <img src="https://source.unsplash.com/random/600x800" class="card-img" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-4">
                                <img src="https://source.unsplash.com/random/600x800" class="card-img" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->



        </div>
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->


</div>

@endsection