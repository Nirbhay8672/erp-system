<template>
    <nav class="navbar navbar-main navbar-expand-lg position-sticky mt-4 top-1 px-0 mx-4 shadow-none border-radius-xl z-index-sticky bg-white"
        id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm">
                        <i class="fa fa-home"></i>
                    </li>
                    <li class="breadcrumb-item text-sm"><span>/ Pages / </span>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $page.props.page_name }}</li>
                </ol>
            </nav>
            <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
                <a href="javascript:;" class="nav-link text-body p-0">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </div>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                </div>
                <ul class="navbar-nav justify-content-end">
                    <li class="nav-item">
                        <a
                            :href="`${$page.props.url}/profile`"
                            class="nav-link text-body p-0 position-relative"
                        >
                        <span class="me-3">{{ $page.props.auth.user.name }}</span>
                        <img :src="$page.props.auth.user.profile_path
                                ? $page.props.auth.user.profile_path
                                : `${$page.props.url}/images/profile.png`
                            " class="avatar" style="height: 40px;width: 40px;">
                        </a>
                    </li>
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup></script>
