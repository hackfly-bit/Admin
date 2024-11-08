@extends('layouts.master')
@section('title')
    Chat
@endsection
@section('page-title')
    Chat
@endsection
@section('body')

    <body>
    @endsection
    @section('content')

        <div class="d-lg-flex">
            <!-- end chat-leftsidebar -->

            <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-3">
                <div class="card">
                    {{-- <div class="p-3 px-lg-4 border-bottom">
                        <div class="row">
                            <div class="col-xl-4 col-7">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar me-3 d-sm-block d-none">
                                        <img src="{{ URL::asset('build/images/users/avatar-6.jpg') }}" alt=""
                                            class="img-fluid d-block rounded-circle">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-16 mb-1 text-truncate"><a href="#"
                                                class="text-dark">Jennie Sherlock</a></h5>
                                        <p class="text-muted text-truncate mb-0">Online</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-5">
                                <ul class="list-inline user-chat-nav text-end mb-0">
                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-search"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">
                                                <form class="px-2">
                                                    <div>
                                                        <input type="text" class="form-control border bg-soft-light"
                                                            placeholder="Search...">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Profile</a>
                                                <a class="dropdown-item" href="#">Archive</a>
                                                <a class="dropdown-item" href="#">Muted</a>
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}

                    <div class="chat-conversation p-3" data-simplebar>

                            <li class="right">
                                <div class="conversation-list">
                                    <div class="d-flex">
                                        <div class="flex-1">
                                            <div class="ctext-wrap">
                                                <div class="ctext-wrap-content">
                                                    <div><span class="time">10:08</span></div>
                                                    <p class="mb-0 text-start">
                                                        Of course I can, just catching up with Steve on it and i'll write it
                                                        out. Speak tomorrow! Let me know if you have any questions!
                                                    </p>

                                                    <p class="mb-0 text-start mt-2">
                                                        img-1.jpg & img-2.jpg images for a New Projects
                                                    </p>

                                                    <ul class="list-inline message-img mt-2 mb-0">
                                                        <li class="list-inline-item message-img-list">
                                                            <a class="d-inline-block" href="">
                                                                <img src="{{ URL::asset('build/images/small/img-1.jpg') }}" alt=""
                                                                    class="rounded img-thumbnail">
                                                            </a>
                                                        </li>

                                                        <li class="list-inline-item message-img-list">
                                                            <a class="d-inline-block" href="">
                                                                <img src="{{ URL::asset('build/images/small/img-2.jpg') }}" alt=""
                                                                    class="rounded img-thumbnail">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>

                    <div class="p-3 border-top">
                        <div class="row">
                            <div class="col">
                                <div class="position-relative">
                                    <input type="text" class="form-control border bg-soft-light"
                                        placeholder="Enter Message...">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit"
                                    class="btn btn-primary chat-send w-md waves-effect waves-light"><span
                                        class="d-none d-sm-inline-block me-2">Send</span> <i
                                        class="mdi mdi-send float-end"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end user chat -->
        </div>
        <!-- End d-lg-flex  -->
    @endsection
    @section('scripts')
        <!-- App js -->
        <script src="{{ URL::asset('build/js/app.js') }}"></script>
    @endsection
