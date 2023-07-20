<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!-- Bootstrap CSS -->
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    />

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <!-- Custom Css -->
    <link rel="stylesheet" href="style.css"/>

    <title>Invoice</title>
    <style>
        @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);

        body {
            background-color: blue;
            font-family: 'Calibri', sans-serif !important;
        }


        .mt-100 {
            margin-top: 50px;
        }

        .mb-100 {
            margin-bottom: 50px;
        }

        .card {
            border-radius: 1px !important;
        }

        .card-header {

            background-color: #fff;
        }

        .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
        }

        .btn-sm, .btn-group-sm > .btn {
            padding: .25rem .5rem;
            font-size: .765625rem;
            line-height: 1.5;
            border-radius: .2rem;
        }
    </style>
</head>

<body>
<div class="page" size="A4">
    <div class="container-fluid mt-100 mb-100">
        <div id="ui-view">
            <div>
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-4">
                                <h6 class="mb-3">Billed From:</h6>
                                <div><strong>Hridoy Roy</strong></div>
                                <div>Dhaka, Bangladesh</div>
                                <div>Email: hridoy@mail.com</div>
                                <div>Phone: 01888555666</div>
                            </div>

                            <div class="col-sm-4">
                                <h6 class="mb-3">Billed To:</h6>
                                <div><strong>Hridoy Roy</strong></div>
                                <div>Dhaka, Bangladesh</div>
                                <div>Email: hridoy@mail.com</div>
                                <div>Phone: 01888555666</div>
                            </div>

                            <div class="col-sm-4">
                                <h6 class="mb-3">Details:</h6>
                                <div>Invoice <strong> #-{{$invoice->invoice_no ?? "N/A"}}</strong></div>
                                <div>Date: <strong>{{$invoice->date ?? "N/A"}}</strong></div>
                                <div>Due Date: <strong>{{$invoice->due_date ?? "N/A"}}</strong></div>
                            </div>

                        </div>

                        <div class="table-responsive-sm">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Product</th>
                                    <th class="center">Price</th>
                                    <th class="right">QTY</th>
                                    <th class="right">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoice->invoiceDetails as  $invoiceDetails)
                                    <tr>
                                        <td class="center">{{++$loop->index}}</td>
                                        <td class="left">{{$invoiceDetails->product->title ?? "N/A"}}</td>
                                        <td class="center">{{$invoiceDetails->price ?? "N/A"}}TK</td>
                                        <td class="center">{{$invoiceDetails->quantity ?? "N/A"}}</td>
                                        <td class="right">{{$invoiceDetails->total ?? "N/A"}}TK</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-5">
                                <h3>Comment</h3>
                                {{$invoice->comment ?? "N/A"}}
                            </div>
                            <div class="col-lg-4 col-sm-5 ml-auto">
                                <table class="table table-clear">
                                    <tbody>
                                    <tr>
                                        <td class="left"><strong>Subtotal</strong></td>
                                        <td class="right">{{$invoice->subtotal ?? "N/A"}}TK</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>Discount</strong></td>
                                        <td class="right">{{$invoice->discount ?? "N/A"}}TK</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>TAX</strong></td>
                                        <td class="right">{{$invoice->tax ?? "N/A"}}TK</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>Total</strong></td>
                                        <td class="right"><strong>{{$invoice->total ?? "N/A"}}TK</strong></td>
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
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    window.print()
</script>
</body>
</html>
