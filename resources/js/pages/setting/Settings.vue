<template>
    <inertia-head title="Settings" />
    <main-page>
        <div class="row mt-4">
            <div class="col-lg-12 position-relative z-index-2">
                <div class="row gy-3 mt-3">
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
                                <a :href="`${$page.props.url}/settings/leave`" class="btn btn-outline-primary btn-sm mb-0">Open</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>
