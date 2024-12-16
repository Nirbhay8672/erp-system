<template>
    <inertia-head :title="$page.props.page_name" />
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
                <div class="col-auto ms-auto">
                    <a
                        :href="`${$page.props.url}/edit-profile/${user_data.id}`"
                        class="btn btn-primary btn-icon-only"
                        role="button"
                        aria-pressed="true"
                    ><i class="fa fa-pencil link-icon"></i></a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="card card-plain">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Basic Information</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 text-sm">
                            <hr class="my-2 profile-header">
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Username</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">First Name</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.first_name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Last Name</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.last_name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Email</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.email }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Mobile</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.mobile }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Gender</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.gender == 'male' ? 'Male' : 'Female' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Date of birth</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.date_of_birth }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Date of joining</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.date_of_joining }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Role</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.roles[0].display_name }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Designation</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.designation.name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="card card-plain">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Address Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 text-sm">
                            <hr class="my-2 profile-header">
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">State</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.address.state }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">City</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.address.city }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Pincode</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    {{ user_data.address.pincode }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12 col-md-6">
                                    <strong class="text-dark">Address</strong>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p>{{ user_data.address.address_line_1 ?? '' }}</p>
                                    <p>{{ user_data.address.address_line_2 ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="card card-plain">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Education Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 text-sm">
                            <hr class="my-2 profile-header">
                            <template v-for="(education, index ) in user_data.educations" :key="`edu_${index}`">
                                <div class="row">
                                    <span>Education {{ index + 1 }}</span>
                                    <hr class="horizontal mt-0">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">Degree Name</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ education.degree_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">University</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ education.university_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">Passing Year</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ education.starting_year }} - {{ education.is_pursuing > 0 ? 'Pursuing' :
                                            education.ending_year }}
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="card card-plain">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Experience Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 text-sm">
                            <hr class="my-2 profile-header">
                            <template v-for="(experience, index ) in user_data.experiences" :key="`exp_${index}`">
                                <div class="row">
                                    <span>Experience {{ index + 1 }}</span>
                                    <hr class="horizontal mt-0">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">Job Title</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ experience.job_title }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">Joining Date</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ experience.joining_date }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">Leaving Date</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ experience.leaving_date }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">Job Description</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        {{ experience.job_description ?? '' }}
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="card card-plain">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">Document Details</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 text-sm">
                            <hr class="my-2 profile-header">
                            <template v-for="(document, index ) in user_data.documents" :key="`doc_${index}`">
                                <div class="row mb-3">
                                    <div class="col-12 col-md-6">
                                        <strong class="text-dark">{{ document.document_type }}</strong>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <a  :href="`/uploads/employees/${user_data.id}/${document.document_file_name}`" target="_blank">{{ document.document_file_name }}</a>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>

<script setup>
import { ref } from "vue";

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
</script>
