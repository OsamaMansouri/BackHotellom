<!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5" style="z-index: 1000;">
                        <div class="card overflow-hidden">
                            <div class="card-body pt-0">

                                <h3 class="text-center mt-2 mb-2">
                                    <a href="" class="d-block auth-logo">
                                        <img src="" alt="" height="150">
                                    </a>
                                </h3>

                                <div class="p-3">
                                    <h4 class="text-muted font-size-18 mb-1 text-center">Reset Password !</h4>
                                    {{-- <p class="text-muted text-center">Connectez-vous.</p> --}}

                                    <form method="POST" action="{{ route('updatePassword') }}" class="form-horizontal mt-4">
                                        @csrf

                                        <!-- Password Reset Token -->

                                        <div class="mb-3">
                                        <label for="email" :value="__('Email')">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                        <label for="password" :value="__('Password')">New Password</label>
                                            <input type="password" class="form-control" name="password" id="password" required autocomplete="current-password" placeholder="Enter new password">

                                        </div>

                                        <div class="mb-3">
                                            <label for="password" :value="__('Confirm Password')">Confirm  Password</label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required autocomplete="current-password" placeholder="Confirm Password">

                                        </div>

                                        <div class="mb-3 row mt-4">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center">
                            © <script>document.write(new Date().getFullYear())</script> Hotellom <span class="d-none d-sm-inline-block"> - Powered <i class="mdi mdi-heart text-danger"></i> by Vigon Systems</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </body>
</html>

