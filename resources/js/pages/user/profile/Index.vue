<template>
    <inertia-head title="Profile" />
    <main-page>
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1920&amp;q=80');">
            <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>

        <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img :src="user_data.profile_path
                            ? user_data.profile_path
                            : '/images/profile.png'
                            " alt="profile_image" class="w-100 border-radius-lg">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ user_data.name }}
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            {{ `${user_data.first_name} ${user_data.last_name}` }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row mt-3">
                    <div class="col-12 col-md-6 col-xl-4 mt-md-0 mt-4 position-relative">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Profile Information</h6>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <button
                                            type="button"
                                            class="btn bg-gradient-primary btn-sm mt-2"
                                            @click="openForm()"
                                            title="Edit Profile"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                        >
                                            <span aria-hidden="true"><i class="fa fa-pencil"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <hr class="horizontal gray-light my-2">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                            class="text-dark">Username :</strong> &nbsp; {{ user_data.name }}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">First Name :</strong> &nbsp; {{ user_data.first_name }}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Last Name :</strong> &nbsp; {{ user_data.last_name }}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Email :</strong> &nbsp; {{ user_data.email }}</li>
                                </ul>
                            </div>
                        </div>
                        <hr class="vertical dark">
                    </div>
                </div>
            </div>
        </div>

        <teleport to="body">
            <profile-form ref="profile_form" @reload="loadProfileData" />
        </teleport>
    </main-page>
</template>

<script setup>
import { ref } from "vue";
import profileForm from "./Form.vue";

let profile_form = ref(null);

const props = defineProps({
    user_details: {
        type: Object,
        required: true,
    },
    auth: {
        type: Object,
        required: true,
    },
});

let user_data = ref(props.user_details);

function loadProfileData(data) {
    user_data.value = data;
}

function openForm() {
    profile_form.value.openModal(user_data.value);
}
</script>
