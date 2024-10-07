<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ecole Mariam | Messagerie</title>

    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin') }}/assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="{{ asset('admin') }}/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('admin') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('admin') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('admin') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('admin') }}/assets/css/custom.min.css" rel="stylesheet" type="text/css" />


</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="{{ asset('admin') }}/assets/images/logo-light.png" alt="" height="20">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">

                                <div class="text-center mb-3">
                                    <a href="{{ url('/') }}"><img src="{{ asset('admin') }}/images/logo_mariam.png"
                                                                  alt="" style="width: 100px; margin: auto"></a>
                                </div>
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Ecole Internationale Mariam | Messagerie </h5>

                                </div>
                                <div class="p-2 mt-4">

                                    <span class="text-danger" id="erreurserveur"></span>
                                    <form action="">

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Login </label>
                                            <input type="text" class="form-control" id="login" name="login">

                                            <span class="text-danger" id="erreurlogin"></span>
                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label" for="password-input">Mot de passe </label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>

                                            <span class="text-danger" id="erreurmotpasse"></span>


                                        </div>



                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" id="authentifier" type="submit">Valider</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('admin') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('admin') }}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('admin') }}/assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{ asset('admin') }}/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="{{ asset('admin') }}/assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="{{ asset('admin') }}/assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="{{ asset('admin') }}/assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="{{ asset('admin') }}/assets/js/pages/password-addon.init.js"></script>

    <script>
        jQuery(document).ready(function() {



            $("#authentifier").click(function(event) {
                event.preventDefault();


                authentifier()
            });



            clearData()

        });

        function clearData() {


            $('#login').val('');
            $('#mot_passe').val('');



            $('#erreurlogin').text('');
            $('#erreurmotpasse').text('');
            $('#erreurserveur').text('');




        }



        //------------------------ fonction d' authentification
        function authentifier() {

            let allValid = true;

            let login = $('#login').val();
            let mot_passe = $('#mot_passe').val();


            $('#erreurlogin').text('');
            $('#erreurmotpasse').text('');
            $('#erreurserveur').text('');


            if (login === '') {
                $('#erreurlogin').text("Le login est obligatoire   ");
                allValid = false;

            }



            if (mot_passe === '') {
                $('#erreurmotpasse').text("Le mot de passe est obligatoire   ");
                allValid = false;

            }



            if (allValid) {

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('utilisateur_authenticate') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {

                        login: login,

                        mot_passe: mot_passe,


                    },

                    success: function(data) {


                        console.log(data);



                        // return 0;
                        if (data.code == 1) {
                            location.href = '{{ route('tableau') }}'

                        } else {

                            $('#erreurserveur').text(data.msg);
                            // $('#erreurMotpasse').text(data.data.erreurMotpasse);


                        }

                    },


                    error: function(data) {

                        console.log(data);



                    }



                });

            }
        }
    </script>


</body>







</html>
