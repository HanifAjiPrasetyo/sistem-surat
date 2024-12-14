<header class="foi-header landing-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light foi-navbar">
            <a class="navbar-brand" href="">
                <div class="display-5 font-weight-bold">SISURPENG</div>
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Beranda
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesMenu" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Pages</a>
                        <div class="dropdown-menu" aria-labelledby="pagesMenu">
                            <a class="dropdown-item" href="blog.html">Blog</a>
                            <a class="dropdown-item" href="login.html">Login</a>
                            <a class="dropdown-item" href="register.html">Register</a>
                            <a class="dropdown-item" href="faq.html">FAQ</a>
                            <a class="dropdown-item" href="404.html">404</a>
                            <a class="dropdown-item" href="careers.html">Careers</a>
                            <a class="dropdown-item" href="blog-single.html">Single blog</a>
                            <a class="dropdown-item" href="privacy-policy.html">Privacy policy</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav mt-2 mt-lg-0">
                    @guest
                        <li class="nav-item dropdown">
                            <a class="btn btn-light nav-link dropdown-toggle font-weight-bold" href="#" id="loginMenu"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">LOGIN</a>
                            <div class="dropdown-menu" aria-labelledby="loginMenu">
                                <a class="dropdown-item" href="/warga/login" target="_blank">Sebagai Warga</a>
                                <a class="dropdown-item" href="/admin/login" target="_blank">Sebagai Admin</a>
                                {{-- <a class="dropdown-item" href="#" target="_blank">Sebagai RT</a>
                                <a class="dropdown-item" href="#" target="_blank">Sebagai RW</a> --}}
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        <div class="header-content">
            <div class="row">
                <div class="col-md-6">
                    <h1>SISTEM INFORMASI SURAT PENGANTAR RT/RW</h1>
                    <p class="text-dark">
                        SISURPENG adalah sebuah website yang dikembangkan sebagai sarana informasi dan pengajuan surat
                        pengantar RT/RW yang dapat diakses oleh warga, RT, dan RW.
                    </p>
                    <button class="btn btn-primary" onclick="window.open('warga/surats/create', '_blank')">
                        Ajukan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
