<template>
    <inertia-head title="Settings" />
    <main-page>
        <div class="row mt-4">
            <div class="col-lg-12 position-relative z-index-2">
                <div class="row gy-4 mt-3">
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons fa fa-user-times opacity-10"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-capitalize">Leave</p>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/settings/leave`" class="btn btn-outline-primary btn-sm mb-0">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons fa fa-user-secret opacity-10"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-capitalize">Roles ( {{ $page.props.total_roles }} )</p>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/roles/index`" class="btn btn-outline-primary btn-sm mb-0">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons fa fa-shield opacity-10"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-capitalize">Permissions</p>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/permissions/index`" class="btn btn-outline-primary btn-sm mb-0">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons fa fa-users opacity-10"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-capitalize">Designations ( {{ $page.props.total_designations }} )</p>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/designations/index`" class="btn btn-outline-primary btn-sm mb-0">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>
