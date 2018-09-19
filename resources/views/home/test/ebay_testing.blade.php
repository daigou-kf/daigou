<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">

    <style>
        .text-primary{
            color:#2f7bbd !important;
        }

        .center-row {
            margin: 0;
            width: 80vw;
            margin-left: 10vw;
        }

        #logo-and-navi .logo-header {
            height: 12.5vh;
        }

        #logo-and-navi #logo-img {
            height: 100%;
            width: auto;
        }

        #logo-and-navi .nav-link {
            color: #71717b;
        }

        .main-section .tabs img.card-img-top {
            min-height: 15vh;
        }

        .main-section .categories .card{
            border: 0px;
        }

        .main-section .categories img.card-img-top {
            padding-left:50px;
            padding-right:50px;
            min-height: 20vh;
            height: 20vh;
        }

        .main-section .tabs .card{
            background-color: #1a1a1a;
            border: 0px;
        }

        .pl-c {
            padding-left: 10vw;
        }

        .pr-c {
            padding-right: 10vw;
        }

        .img-wrapper img {
            height: 35vh;
            width: 80vw;
        }

        #nav-top-hr {
            width: 80vw;
        }

        .bg-gray{
            background-color: #393939;
        }

        .footer-section #part-1{
            background-color:#303030;
        }

        .footer-section #part-2{
            background-color:#393939;
        }

        .text-light-grey{
            color: #afafad;
        }

        @media screen and (min-width: 1200px) {
            .pl-c {
                padding-left: 20vw !important;
            }

            .pr-c {
                padding-right: 20vw !important;
            }

            .img-wrapper img {
                width: 60vw;
            }

            .center-row {
                margin: 0;
                width: 60vw;
                margin-left: 20vw;

            }

            #nav-top-hr {
                width: 60vw;
            }
        }


    </style>
</head>
<body>
<!-- top bar -->
<div id="top-bar" class="container-fluid">
    <div class="row bg-dark text-light" style="line-height: 2.5">
        <div class="col-6 pl-c">
            <span class="text-left">
            <i class="fas fa-shopping-bag"></i> First Shopping Group
        </span>
        </div>

        <div class="col-6 pr-c">
            <span class="float-right">
                Make First Shopping Group your favourite store <i class="fas fa-heart"></i>
            </span>
        </div>
    </div>
</div>
<!-- Logo and Navigation -->
<div id="logo-and-navi" class="container-fluid">
    <div class="row bg-white logo-header mt-3">
        <div class="center-row">
            <img id="logo-img" src="https://www.tangqi.com.au/daigou/storage/app/assets/point_img_logo_default@2x.png">
        </div>
    </div>
    <div class="row bg-white navi mt-3">
        <div class="pl-c">
            <hr id="nav-top-hr" class="m-1">
            <ul class="nav pb-2">
                <li class="nav-item">
                    <a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322"
                       class="nav-link">Bathroom</a>
                </li>
                <li class="nav-item">
                    <a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322"
                       class="nav-link">Kitchen</a>
                </li>
                <li class="nav-item">
                    <a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322"
                       class="nav-link">Stationary</a>
                </li>
                <li class="nav-item">
                    <a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322"
                       class="nav-link text-danger">Sale</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!--  Main Section -->
<div class="main-section bg-light">
    <div class="img-wrapper pt-3">
        <div class="center-row">
            <div class="container-fluid">
                <div class="row">
                        <img id="logo-img" src="/daigou/storage/app/assets/testing_banner.gif">
                </div>
            </div>
        </div>
    </div>
    <!-- 4 tabs -->
    <div class="center-row tabs">
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-3 pl-0 pr-1">
                    <div class="card">
                        <img src="https://www.tangqi.com.au/daigou/storage/app/assets/home_logo.png" class="card-img-top">
                        <div class="card-body bg-gray" style="line-height: 2">
                            <span class="text-left text-light-grey">Contact Us</span>
                            <span class="float-right text-light"><i class="fas fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-1">
                    <div class="card">
                        <img class="card-img-top" src="https://www.tangqi.com.au/daigou/storage/app/assets/home_logo.png">
                        <div class="card-body bg-gray" style="line-height: 2">
                            <span class="text-left text-light-grey">Delivery & Return</span>
                            <span class="float-right text-secondary"><i class="fas fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-1">
                    <div class="card">
                        <img class="card-img-top" src="https://www.tangqi.com.au/daigou/storage/app/assets/home_logo.png">
                        <div class="card-body bg-gray" style="line-height: 2">
                            <span class="text-left text-light-grey">Shipping</span>
                            <span class="float-right text-secondary"><i class="fas fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-0">
                    <div class="card">
                        <img class="card-img-top" src="https://www.tangqi.com.au/daigou/storage/app/assets/home_logo.png">
                        <div class="card-body bg-gray" style="line-height: 2">
                            <span class="text-left text-light-grey">About Us</span>
                            <span class="float-right text-secondary"><i class="fas fa-chevron-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="center-row categories bg-white">
        <div class="container-fluid mt-2">
            <div class="row">
                <div class="col-3 pl-0 pr-1">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-1">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-1">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-0">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 pl-0 pr-1">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-1">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-1">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-3 pl-1 pr-0">
                    <div class="card">
                        <img class="card-img-top"
                             src="/daigou/storage/app/assets/testing.png">
                        <div class="card-body" style="line-height: 2">
                            <h6 class="card-title text-primary text-center"><strong>Appliances</strong></h6>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="card-text text-center small text-muted">Stand Mixer & Attachments
                                Ice Cream & Yoghurt Makers
                                Blenders</p>
                            <hr class="m-1" style="border-top: dotted 1px lightgray;">
                            <p class="text-center"><a href="http://www.ebaystores.com.au/firstshoppinggroup/Cabinet-/_i.html?_fsub=23586481010&_sid=1619918490&_trksid=p4634.c0.m322" class="text-center text-primary small">View All Appliances</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<div class="footer-section">
    <div id="part-1">
        <div class="center-row">
            <div class="container-fluid pt-5">
                <div class="row">
                    <div class="col-1 pl-0 pr-3">
                        <p class="text-light text-right"><i class="far fa-envelope-open"></i></p>
                    </div>
                    <div class="col-5 pl-0">
                        <h5 class="text-light"><strong>Do you Love First Shopping Deals?</strong></h5>
                        <p class="text-light-grey small">Get First Shopping Deals first, exclusive promotions and more delivered to your inbox</p>
                    </div>
                    <div class="col-2 offset-4">
                        <button class="btn btn-lg btn-danger">SIGN ME UP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="part-2" class="pb-5">
        <div class="center-row">
            <div class="container-fluid pt-5">
                <div class="row">
                    <div class="col-3">
                        <p class="text-white"><strong>About First Shopping</strong></p>
                        <p class="small text-light-grey">About Us</p>
                        <p class="small text-light-grey">Payment</p>
                        <p class="small text-light-grey">Delivery & Returns</p>
                        <p class="small text-light-grey">Shipping</p>
                    </div>
                    <div class="col-3">
                        <p class="text-white"><strong>Customer Service</strong></p>
                        <p class="small text-light-grey">Contact Us</p>
                        <p class="small text-light-grey">Ask Seller a Question</p>
                        <p class="small text-light-grey">View Feedback</p>
                    </div>
                    <div class="col-6 text-right">
                        <p class="text-white"><strong>Payment Methods</strong></p>
                        <img src="/daigou/storage/app/assets/payment_methods.png">
                        <br>
                        <img src="/daigou/storage/app/assets/paypal.png" class="mt-2">
                    </div>
                </div>
            </div>
            <hr class="pb-3" style="border-top:1px solid #4c4c4c">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2 text-left">
                        <img id="footer-logo" src="https://www.tangqi.com.au/daigou/storage/app/assets/point_img_logo_default@2x.png" style="width:50%">
                    </div>
                    <div class="col-10 text-right">
                        <p class="text-light">© Copyright 2009 - 2018 - First Shopping Group, All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>