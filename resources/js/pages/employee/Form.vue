<template>
    <inertia-head :title="`${$page.props.employee ? 'Update Employee' : 'Create Employee'}`" />
    <main-page>
        <div class="row">
            <div class="col-lg-12 position-relative z-index-2">
                <div class="card mb-4" v-if="loader" style="height: 200px">
                    <div class="card-body p-4">
                        <div class="overflow dark" id="preload">
                            <div class="circle-line">
                                <div class="circle-red"></div>
                                <div class="circle-blue"></div>
                                <div class="circle-red"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4" v-else>
                    <div class="card-header">
                        <div class="nav-wrapper position-relative">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item me-2">
                                    <a class="nav-link mb-0 px-0 py-1 cursor-pointer" @click="tabChange('basic_tab')" :class="`${active_tab == 'basic_tab'
                                        ? 'text-white active show bg-primary show'
                                        : ''
                                        }`" style="border: 1px solid #e91e63">
                                        Basic
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link mb-0 px-0 py-1 cursor-pointer" @click="tabChange('address_tab')" :class="`${active_tab == 'address_tab'
                                        ? 'text-white active show bg-primary show'
                                        : ''
                                        }`" style="border: 1px solid #e91e63">
                                        Address
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link mb-0 px-0 py-1 cursor-pointer" @click="tabChange('education_tab')" :class="`${active_tab == 'education_tab'
                                        ? 'text-white active show bg-primary show'
                                        : ''
                                        }`" style="border: 1px solid #e91e63">
                                        Education
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link mb-0 px-0 py-1 cursor-pointer" @click="tabChange('experience_tab')" :class="`${active_tab == 'experience_tab'
                                        ? 'text-white active show bg-primary show'
                                        : ''
                                        }`" style="border: 1px solid #e91e63">
                                        Experience
                                    </a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="nav-link mb-0 px-0 py-1 cursor-pointer" @click="tabChange('document_tab')" :class="`${active_tab == 'document_tab'
                                        ? 'text-white active show bg-primary show'
                                        : ''
                                        }`" style="border: 1px solid #e91e63">
                                        Document
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body" v-show="active_tab == 'basic_tab'">
                        <form>
                            <div class="row">
                                <div class="text-center col-lg-12">
                                    <div class="card-img-actions d-inline-block">
                                        <div style="position: center;overflow: hidden;border-radius: 50%;">
                                            <img
                                                id="profile_image_file"
                                                :src="basic_details.profile_path ? basic_details.profile_path : `${$page.props.url}/images/profile.png`"
                                                class="rounded"
                                                style="width: 120px;height: 120px;"
                                            />
                                        </div>
                                        <button class="btn btn-primary btn-sm mt-2" type="button" @click="trigger">
                                            Upload Image
                                        </button>
                                    </div>
                                    <input
                                        type="file"
                                        id="profile_image"
                                        ref="my_profile"
                                        @change="previewFiles"
                                        class="form-control d-none"
                                        accept="image/png, image/jpeg, image/jpg"
                                        :class="{
                                            'is-invalid': basic_details_validation.hasError('profile_image'),
                                        }"
                                    />
                                    <span :class="{
                                        'is-invalid':
                                            basic_details_validation.hasError(
                                                'basic_details.profile_image'
                                            ),
                                    }"></span>
                                    <div class="invalid-feedback" v-if="basic_details_validation.hasError(
                                        'basic_details.profile_image'
                                    )
                                        ">
                                        <span>{{
                                            basic_details_validation.getError(
                                                "basic_details.profile_image"
                                            )[0]
                                        }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 gy-2">
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.name"
                                        label="Name"
                                        label-class="required"
                                        type="text"
                                        id="basic_details.name"
                                        field="basic_details.name"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.first_name"
                                        label="First Name"
                                        label-class="required"
                                        type="text"
                                        id="basic_details.first_name"
                                        field="basic_details.first_name"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.last_name"
                                        label="Last Name"
                                        label-class="required"
                                        type="text"
                                        id="basic_details.last_name"
                                        field="basic_details.last_name"
                                        :errors="basic_details_validation.errors">
                                    </Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.email"
                                        label="Email"
                                        label-class="required"
                                        type="text"
                                        id="basic_details.email"
                                        field="basic_details.email"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.mobile"
                                        label="Mobile"
                                        label-class="required"
                                        type="text"
                                        id="basic_details.mobile"
                                        field="basic_details.mobile"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        field="basic_details.gender"
                                        id="basic_details.gender"
                                        label-class="required"
                                        :errors="basic_details_validation.errors"
                                        no-input
                                        no-label
                                    >
                                        <template #input="{ hasError }">
                                            <select
                                                class="form-control form-control-solid form-select"
                                                id="gender"
                                                v-model="basic_details.gender"
                                                :class="{'is-invalid': hasError }"
                                            >
                                                <option value=""> -- Select Gender -- </option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </template>
                                    </Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.dob"
                                        label="DOB"
                                        label-class="required"
                                        type="date"
                                        :id="`basic_details.dob`"
                                        :field="`basic_details.dob`"
                                        :class="basic_details.dob ? 'has-value' : ''"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.doj"
                                        label="DOJ"
                                        label-class="required"
                                        type="date"
                                        :id="`basic_details.doj`"
                                        :field="`basic_details.doj`"
                                        :class="basic_details.doj ? 'has-value' : ''"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        field="basic_details.role_id"
                                        id="basic_details.role_id"
                                        label-class="required"
                                        :errors="basic_details_validation.errors"
                                        no-input
                                        no-label
                                    >
                                        <template #input="{ hasError }">
                                            <select
                                                class="form-control form-control-solid form-select"
                                                id="role_id"
                                                v-model="basic_details.role_id"
                                                :class="{'is-invalid': hasError }"
                                            >
                                                <option value=""> -- Select Role -- </option>
                                                <template v-for="( role, index ) in roles" :key="`role_${index}`">
                                                    <option :value="role.id">{{ role.display_name}}</option>
                                                </template>
                                            </select>
                                        </template>
                                    </Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        field="basic_details.designation_id"
                                        id="basic_details.designation_id"
                                        label-class="required"
                                        :errors="basic_details_validation.errors"
                                        no-input
                                        no-label
                                    >
                                        <template #input="{ hasError }">
                                            <select
                                                class="form-control form-control-solid form-select"
                                                id="designation_id"
                                                v-model="basic_details.designation_id"
                                                :class="{'is-invalid': hasError }"
                                            >
                                                <option value=""> -- Select Designation -- </option>
                                                <template v-for="( designation, index ) in designations" :key="`designation_${index}`">
                                                    <option :value="designation.id">{{ designation.name }}</option>
                                                </template>
                                            </select>
                                        </template>
                                    </Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.password"
                                        label="Password"
                                        type="password"
                                        id="basic_details.password"
                                        field="basic_details.password"
                                        autocomplete="off"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                    <Field
                                        v-model="basic_details.confirm_password"
                                        label="Confirm Password"
                                        type="password"
                                        id="basic_details.confirm_password"
                                        field="basic_details.confirm_password"
                                        autocomplete="off"
                                        :errors="basic_details_validation.errors"
                                    ></Field>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col text-center">
                                    <button class="btn btn-primary btn-sm" type="button" @click="tabChange('address_tab')">Next</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body" v-show="active_tab == 'address_tab'">
                        <div class="row mt-3">
                            <div class="col-12 col-lg-4 col-md-4 mb-1">
                                <Field
                                    v-model="address_details.state"
                                    label="State"
                                    label-class="required"
                                    type="text"
                                    id="address_details.state"
                                    field="address_details.state"
                                    :errors="address_details_validation.errors"
                                ></Field>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4 mb-1">
                                <Field
                                    v-model="address_details.city"
                                    label="City"
                                    label-class="required"
                                    type="text"
                                    id="address_details.city"
                                    field="address_details.city"
                                    :errors="address_details_validation.errors"
                                ></Field>
                            </div>
                            <div class="col-12 col-lg-4 col-md-4 mb-1">
                                <Field
                                    v-model="address_details.pincode"
                                    label="Pincode"
                                    label-class="required"
                                    type="text"
                                    id="address_details.pincode"
                                    field="address_details.pincode"
                                    max-length="6"
                                    :errors="address_details_validation.errors"
                                ></Field>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <Field
                                    field="address_details.address_line_1"
                                    id="address_details.address_line_1"
                                    :errors="address_details_validation.errors"
                                >
                                    <template #input="{ hasError }">
                                        <textarea
                                            id="address_line_1"
                                            placeholder="Enter address line 1"
                                            v-model="address_details.address_line_1"
                                            class="custom-textarea form-control"
                                            :class="{'is-invalid': hasError }"
                                        ></textarea>
                                    </template>
                                </Field>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="input-group input-group-outline my-3"> 
                                    <textarea
                                        id="address_line_2"
                                        placeholder="Enter address line 2"
                                        v-model="address_details.address_line_2"
                                        class="custom-textarea form-control"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col text-center">
                                <button class="btn btn-secondary btn-sm me-2" type="button" @click="tabChange('basic_tab')">Previous</button>
                                <button class="btn btn-primary btn-sm me-2" type="button" @click="tabChange('education_tab')">Next</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" v-show="active_tab == 'education_tab'">
                        <template v-if="education_details.length > 0">
                            <div class="row gy-2 mt-3" v-for="(education , index) in education_details" :key="`education_${index}`">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0">{{ `Education ${index + 1}` }}</h6>
                                                <button class="btn btn-danger btn-icon-only" type="button" @click="removeEducation(index , education.id)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="row gy-2">
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="education.degree_name"
                                                        label="Degree Name"
                                                        label-class="required"
                                                        type="text"
                                                        :id="`educations.${index}.degree_name`"
                                                        :field="`educations.${index}.degree_name`"
                                                        :errors="education_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="education.university_name"
                                                        label="University Name"
                                                        label-class="required"
                                                        type="text"
                                                        :id="`educations.${index}.university_name`"
                                                        :field="`educations.${index}.university_name`"
                                                        :errors="education_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="education.starting_year"
                                                        label="Starting Year"
                                                        label-class="required"
                                                        type="text"
                                                        :id="`educations.${index}.starting_year`"
                                                        :field="`educations.${index}.starting_year`"
                                                        :errors="education_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="education.ending_year"
                                                        label="Ending Year"
                                                        label-class="required"
                                                        type="text"
                                                        :id="`educations.${index}.ending_year`"
                                                        :field="`educations.${index}.ending_year`"
                                                        :errors="education_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" v-model="education.is_pursuing" :id="`is_pursuing_${index}`" @change="isPursuing(index)">
                                                        <label class="custom-control-label ms-2" :for="`is_pursuing_${index}`">Is Pursuing</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="row mt-3" v-if="education_details.length < 3">
                            <div class="col">
                                <button class="btn btn-info btn-icon-only" type="button" @click="addEducation()"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col text-center">
                                <button class="btn btn-secondary btn-sm me-2" type="button" @click="tabChange('address_tab')">Previous</button>
                                <button class="btn btn-primary btn-sm me-2" type="button" @click="tabChange('experience_tab')">Next</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" v-show="active_tab == 'experience_tab'">
                        <template v-if="experience_details.length > 0">
                            <div class="row gy-2 mt-3" v-for="(experience , index) in experience_details" :key="`experience_${index}`">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0">{{ `Experience ${index + 1}` }}</h6>
                                                <button class="btn btn-danger btn-icon-only" type="button" @click="removeExperience(index , experience.id)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="row gy-2">
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="experience.job_title"
                                                        label="Job Title"
                                                        label-class="required"
                                                        type="text"
                                                        :id="`experiences.${index}.job_title`"
                                                        :field="`experiences.${index}.job_title`"
                                                        :errors="experiance_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="experience.joining_date"
                                                        label="Joining Date"
                                                        label-class="required"
                                                        type="date"
                                                        :id="`experiences.${index}.joining_date`"
                                                        :field="`experiences.${index}.joining_date`"
                                                        :class="experience.joining_date ? 'has-value' : ''"
                                                        :errors="experiance_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <Field
                                                        v-model="experience.leaving_date"
                                                        label="Leaving Date"
                                                        label-class="required"
                                                        type="date"
                                                        :id="`experiences.${index}.leaving_date`"
                                                        :field="`experiences.${index}.leaving_date`"
                                                        :class="experience.leaving_date ? 'has-value' : ''"
                                                        :errors="experiance_details_validation.errors"
                                                    ></Field>
                                                </div>
                                                <div class="col-12 col-lg-3 col-md-3 mb-1">
                                                    <div class="input-group input-group-outline my-3"> 
                                                        <textarea
                                                            id="job_description"
                                                            placeholder="Enter job description"
                                                            v-model="experience.job_description"
                                                            class="custom-textarea form-control"
                                                        ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="row mt-3">
                            <div class="col">
                                <button class="btn btn-info btn-icon-only" type="button" @click="addExperiance()"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col text-center">
                                <button class="btn btn-secondary btn-sm me-2" type="button" @click="tabChange('education_tab')">Previous</button>
                                <button class="btn btn-primary btn-sm me-2" type="button" @click="tabChange('document_tab')">Next</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" v-show="active_tab == 'document_tab'">
                        <template v-for="(document , key) in document_details" :key="key">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <label :for="`${key}_file`" class="custom-file-upload" v-if="document.id == ''">
                                                <i class="fa fa-upload me-2"></i> {{ document.name }}
                                            </label>
                                            <input :id="`${key}_file`" type="file" class="d-none" @change="showFileName(document)">
                                            <span style="margin-left: 10px;">{{ document.selected_file_name }}</span>
                                            <span class="text-danger" style="margin-left: 10px;" v-if="document_details_validation.hasError(`documents.${key}`)">
                                                {{ document_details_validation.getError(`documents.${key}`)[0] }}
                                            </span>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <a
                                                :href="`/uploads/employees/${basic_details.id}/${document.selected_file_name}`"
                                                v-if="document.id > 0"
                                                class="btn btn-info btn-icon-only"
                                                role="button"
                                                aria-pressed="true"
                                                target="_blank"
                                            ><i class="fa fa-eye link-icon"></i></a>

                                            <button class="btn btn-primary btn-icon-only ms-3" v-if="document.id > 0" @click="deletedDocument(document)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <hr class="dark horizontal mt-3">
                                </div>
                            </div>
                        </template>
                        
                        <div class="row mt-5">
                            <div class="col text-center">
                                <button class="btn btn-secondary btn-sm me-2" type="button" @click="tabChange('experience_tab')">Previous</button>
                                <button class="btn btn-success btn-sm" id="save_button" type="button" @click="submitForm()">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import Field from "../../helpers/Field.vue";
import { FormValidation } from "../../helpers/Validation";
import { toastAlert } from "../../helpers/alert";
import { EmployeeRoutes } from "../../routes/EmployeeRoutes";
import axios from "axios";

const props = defineProps({
    roles: {
        required: true,
        type: Array,
        default: []
    },
    designations: {
        required: true,
        type: Array,
        default: []
    },
    employee: {

    },
    url: {
        required: true,
        type: String,
        default: '/',
    }
});

let loader = ref(true);
let active_tab = ref("basic_tab");

let my_profile = ref("");

let basic_details = reactive({
    id: "",
    profile_path: "",
    profile_image: "",
    name: "",
    first_name: "",
    last_name: "",
    email: "",
    mobile: "",
    gender: "",
    dob: "",
    doj: "",
    role_id: "",
    designation_id: "",
    password: "",
    confirm_password: "",
});

let address_details = reactive({
    state : "",
    city : "",
    pincode : "",
    address_line_1 : "",
    address_line_2 : "",
});

let education_details = reactive([]);
let experience_details = reactive([]);

let deleted_education_ids = reactive([]);
let deleted_experience_ids = reactive([]);
let deleted_document_ids = reactive([]);

let document_details = reactive({
    'addhar_card' : {
        id : '',
        name : 'Addhar Card',
        slug : 'addhar_card',
        msg : 'No addhar card selected',
        selected_file_name : null,
    },
    'pan_card' : {
        id : '',
        name : 'Pan Card',
        slug : 'pan_card',
        msg : 'No pan card selected',
        selected_file_name : null,
    },
    'passbook_front_page' : {
        id : '',
        name : 'Passbook Front Page',
        slug : 'passbook_front_page',
        msg : 'No passbook front page selected',
        selected_file_name : null,
    },
    'address_proof' : {
        id : '',
        name : 'Address Proof',
        slug : 'address_proof',
        msg : 'No address proof selected',
        selected_file_name : null,
    },
});

onMounted(() => {
    setTimeout(function () {
        fetchEmployeeDetails();
    }, 1000);
});

function fetchEmployeeDetails() {
    loader.value = false;

    if(props.employee) {
        
        basic_details.id = props.employee.id;
        basic_details.name = props.employee.name;
        basic_details.first_name = props.employee.first_name;
        basic_details.last_name = props.employee.last_name;
        basic_details.email = props.employee.email;
        basic_details.mobile = props.employee.mobile;
        basic_details.gender = props.employee.gender;
        basic_details.dob = props.employee.dob;
        basic_details.doj = props.employee.doj;
        basic_details.designation_id = props.employee.designation_id;

        basic_details.profile_path = props.employee.profile_path;
        basic_details.profile_image = props.employee.profile_path;
        basic_details.role_id = props.employee.roles[0].id;

        if(props.employee.address) {
            address_details = props.employee.address;
        }

        props.employee.educations.forEach(education => {

            let obj = {
                id : education.id,
                degree_name : education.degree_name,
                university_name : education.university_name,
                starting_year : education.starting_year,
                ending_year : education.ending_year ?? '',
                is_pursuing : education.is_pursuing,
            };
           
            education_details.push(obj);
        });


        props.employee.experiences.forEach(experience => {

            let obj = {
                id : experience.id,
                job_title : experience.job_title,
                joining_date : experience.joining_date,
                leaving_date : experience.leaving_date,
                job_description : experience.job_description,
            };

            experience_details.push(obj);
        });


        experience_details = props.employee.experiences;

        props.employee.documents.forEach(document => {
            document_details[document.document_type]['id'] = document.id;
            document_details[document.document_type]['selected_file_name'] = document.document_file_name;
        });

    } else {

    }
}

function tabChange(tab) {
    active_tab.value = tab;
}

function trigger() {
    my_profile.value.click();
}

function previewFiles(event) {
    basic_details.profile_image = event.target.files[0].name;

    var image = document.getElementById("profile_image_file");
    image.src = URL.createObjectURL(event.target.files[0]);
}

function showFileName(document_obj) {
    var input = document.getElementById(`${document_obj.slug}_file`);
    document_details[document_obj.slug]['selected_file_name'] = input.files.length > 0 ? input.files[0].name : document_obj.msg;
}

function deletedDocument(document) {
    deleted_document_ids.push(document.id);
    document_details[document.slug]['id'] = '';
    document_details[document.slug]['selected_file_name'] = document.msg;
}

function addEducation() {

    education_details.push({
        id : '',
        degree_name : '',
        university_name : '',
        starting_year : '',
        ending_year : '',
        is_pursuing : false,
    });
}

function isPursuing(index) { 
    document.getElementById(`ending_year_${index}`).disabled = education_details[index]['is_pursuing'];
    
    if(education_details[index]['is_pursuing']) {
        education_details[index]['ending_year'] = '';
    }
}

function removeEducation(index , id) {
    education_details.splice(index , 1);
    deleted_education_ids.push(id);
}

function removeExperience(index , id) {
    experience_details.splice(index , 1);
    deleted_experience_ids.push(id);
}

function addExperiance() {

    experience_details.push({
        id : '',
        job_title : '',
        joining_date : '',
        leaving_date : '',
        job_description : '',
    });
}

function submitForm() {

    basic_details_validation.reset();
    address_details_validation.reset();

    let form_data = new FormData();
    let profile_image = document.getElementById("profile_image");

    if (profile_image && profile_image.files.length > 0) {
        let file = profile_image.files[0];
        form_data.set("basic_details[profile_image]", file, file.name);
    }

    form_data.set("basic_details[id]", basic_details.id);
    form_data.set("basic_details[name]", basic_details.name);
    form_data.set("basic_details[first_name]", basic_details.first_name);
    form_data.set("basic_details[last_name]", basic_details.last_name);
    form_data.set("basic_details[email]", basic_details.email);
    form_data.set("basic_details[mobile]", basic_details.mobile);
    form_data.set("basic_details[gender]", basic_details.gender);
    form_data.set("basic_details[dob]", basic_details.dob);
    form_data.set("basic_details[doj]", basic_details.doj);
    form_data.set("basic_details[role_id]", basic_details.role_id);
    form_data.set("basic_details[designation_id]", basic_details.designation_id);
    form_data.set("basic_details[password]", basic_details.password);
    form_data.set("basic_details[confirm_password]", basic_details.confirm_password);

    form_data.set("address_details[state]", address_details.state);
    form_data.set("address_details[city]", address_details.city);
    form_data.set("address_details[pincode]", address_details.pincode);
    form_data.set("address_details[address_line_1]", address_details.address_line_1);
    form_data.set("address_details[address_line_2]", address_details.address_line_2);

    form_data.set("educations" , []);

    education_details.forEach((education, index) => {
        form_data.append(`educations[${index}][id]`, education.id);
        form_data.append(`educations[${index}][degree_name]`, education.degree_name);
        form_data.append(`educations[${index}][university_name]`, education.university_name);
        form_data.append(`educations[${index}][starting_year]`, education.starting_year);
        form_data.append(`educations[${index}][ending_year]`, education.ending_year);
        form_data.append(`educations[${index}][is_pursuing]`, education.is_pursuing ? 1 : 0);
    });

    form_data.set("experiences" , []);

    experience_details.forEach((experience, index) => {
        form_data.append(`experiences[${index}][id]`, experience.id);
        form_data.append(`experiences[${index}][job_title]`, experience.job_title);
        form_data.append(`experiences[${index}][joining_date]`, experience.joining_date);
        form_data.append(`experiences[${index}][leaving_date]`, experience.leaving_date);
        form_data.append(`experiences[${index}][job_description]`, experience.job_description);
    });

    Object.entries(document_details).forEach(([key, value]) => {

        let document_file_element = document.getElementById(`${key}_file`);

        if (document_file_element && document_file_element.files.length > 0) {
            let document_file = document_file_element.files[0];
            form_data.append(`documents[${key}]`, document_file, document_file.name);
        }
    });

    form_data.set("deleted_education_ids", deleted_education_ids);
    form_data.set("deleted_experience_ids", deleted_experience_ids);
    form_data.set("deleted_document_ids", deleted_document_ids);

    let settings = { headers: { "content-type": "multipart/form-data" } };

    document.getElementById('save_button').disabled = true;

    axios
        .post(EmployeeRoutes.createOrUpdate(basic_details.id ?? null), form_data, settings)
        .then((response) => {
            toastAlert({ title: response.data.message ,  didClose: () => {
                window.location.href = `${props.url}/employees/index`; 
            }});
        })
        .catch(function (error) {
            
            if (error.response.status === 422) {
                basic_details_validation.setServerSideErrors(
                    error.response.data.errors
                );

                address_details_validation.setServerSideErrors(
                    error.response.data.errors
                );

                education_details_validation.setServerSideErrors(
                    error.response.data.errors
                );

                experiance_details_validation.setServerSideErrors(
                    error.response.data.errors
                );

                document_details_validation.setServerSideErrors(
                    error.response.data.errors
                );
            }

            document.getElementById('save_button').disabled = false;
        });
}

let basic_details_validation = reactive(
    new FormValidation(basic_details, {})
);

let address_details_validation = reactive(
    new FormValidation(address_details, {})
);

let education_details_validation = reactive(
    new FormValidation(address_details, {})
);

let experiance_details_validation = reactive(
    new FormValidation(address_details, {})
);

let document_details_validation = reactive(
    new FormValidation(document_details, {})
);

</script>
