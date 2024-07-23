<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.png') }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sistem Akademik</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Font Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Font Awesome CDN -->
        <link
          rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"
        />

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="{{ asset('assets/metronics/css/style.css') }}">

    </head>
    <body>

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" width="50" alt="">
                <a class="nav-link fw-bold" href="#" target="_blank">
                  Panduan Penggunaan Sistem
                </a>
            </div>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto align-items-center">
                  <span href="#" class="text-black text-decoration-none pt-lg-0 pt-3 text-center">
                    <span class="fw-bold">Kontak</span> : sismik@email.unidip.ac.id
                  </span>
                  <span class="mx-3 opacity-50 d-lg-block d-none">|</span>

                  <a class="btn btn-info text-white rounded-2 mt-lg-0 mt-3" href="{{ route('login') }}">
                    Log in <i class="fa-solid fa-right-to-bracket ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </nav>

          {{-- HERO --}}
          <div class="homepage">
            <div class="container">
              <div class="hero row d-flex align-items-center">
                <div class="col">
                  <h1 class="mb-4">
                    Selamat Datang di <span class="fw-bold">Sistem Akademik</span> Universitas Dipatiukur Bandung
                  </h1>
                  <p class="lh-lg">Sistem Akademik Universitas Dipatiukur Bandung merupakan media pembelajaran daring untuk memudahkan proses pengajaran di lingkungan Universitas Dipatiukur Bandung</p>
                </div>
                <div class="col">
                  <img src={{ asset('assets/images/hero.png') }} alt="Hero Image" class="d-block mx-auto" />
                </div>
              </div>

              <div class="faq">
                <div class="row text-center mb-5">
                  <div class="col">
                    <h2 class="mb-3">Frequently Asked Question</h2>
                    <p class="lh-lg">Berisikan kumpulan jawaban dari pertanyaan yang sering ditanyakan terkait Sistem Akademik Universitas Dipatiukur Bandung</p>
                  </div>
                </div>
                <div class="row">
                  <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="col mb-3">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed lh-base" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Judul Pertanyaan Pertama
                          </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, cum animi, itaque deserunt eos, molestiae libero minus dolores fugit cumque officiis laboriosam excepturi. Quis architecto molestiae minus eum sint
                            dignissimos?
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col mb-3">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed lh-base" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            Judul Pertanyaan Kedua
                          </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, cum animi, itaque deserunt eos, molestiae libero minus dolores fugit cumque officiis laboriosam excepturi. Quis architecto molestiae minus eum sint
                            dignissimos?
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col mb-3">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed lh-base" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            Judul Pertanyaan Ketiga
                          </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, cum animi, itaque deserunt eos, molestiae libero minus dolores fugit cumque officiis laboriosam excepturi. Quis architecto molestiae minus eum sint
                            dignissimos?
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col mb-3">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed lh-base" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            Judul Pertanyaan Empat
                          </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, cum animi, itaque deserunt eos, molestiae libero minus dolores fugit cumque officiis laboriosam excepturi. Quis architecto molestiae minus eum sint
                            dignissimos?
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col mb-3">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed lh-base" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                            Judul Pertanyaan Lima
                          </button>
                        </h2>
                        <div id="flush-collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, cum animi, itaque deserunt eos, molestiae libero minus dolores fugit cumque officiis laboriosam excepturi. Quis architecto molestiae minus eum sint
                            dignissimos?
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col mb-3">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed lh-base" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                            Judul Pertanyaan Enam
                          </button>
                        </h2>
                        <div id="flush-collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, cum animi, itaque deserunt eos, molestiae libero minus dolores fugit cumque officiis laboriosam excepturi. Quis architecto molestiae minus eum sint
                            dignissimos?
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- FOOTER --}}
          <div class="footer text-center py-5">
            <div class="container">
              <div class="row">
                <div class="col d-flex align-items-center justify-content-center gap-sm-5 gap-3 mb-3 flex-sm-row flex-column">
                  <a href="#" class="text-black text-decoration-none">
                    <i class="fa-solid fa-globe text-info me-1"></i> Unidip Site
                  </a>
                  <p class="p-0 m-0">
                    <i class="fa-solid fa-envelope text-info me-1"></i> sismik@email.Unidip.ac.id
                  </p>
                </div>
              </div>
              <div class="row">
                <p>
                  <span class="fw-bold">Unidip Sismik</span> <span class="opacity-25">•</span> All Rights Reserved
                </p>
              </div>
            </div>
          </div>
        {{-- <div>
            <div>
                <div>
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>

                                    @unless (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Register
                                        </a>
                                    @endunless
                                @endauth
                            </nav>
                        @endif
                    </header>
                </div>
            </div>
        </div> --}}
    </body>
</html>
