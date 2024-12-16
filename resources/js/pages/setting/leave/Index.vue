<template>
    <inertia-head title="Leave Setting" />
    <main-page>
        <div class="row">
            <div class="col-lg-12 position-relative z-index-2">
                <div class="card mb-4">
                    <div class="card-header pb-0 p-4">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Leave Settings</h6>
                            <button class="btn btn-primary btn-icon-only" @click="updateMode()"><i
                                    :class="leave_mode_icon"></i></button>
                        </div>
                        <hr class="horizontal dark" />
                    </div>
                    <div class="card-body">
                        <div v-if="!is_view_mode">
                            <div class="row gy-5">
                                <div class="col-md-5">
                                    <h5 class="stepper-title text-center">
                                        Casual Leave
                                    </h5>
                                    <div class="text-center mt-3 text-primary">
                                        <i class="fa fa-bed fs-3"></i>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row gy-3">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.casual_leave.details
                                                .add_leave_per_month
                                                " label="Add Leave Per Month" label-class="required" type="text"
                                                id="cl_add_per_month" field="casual_leave.details.add_leave_per_month"
                                                placeholder="Enter add leave per month" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.casual_leave.details
                                                .max_leave_per_month
                                                " label="Max Leave Per Month" label-class="required" type="text"
                                                id="cl_max_per_month" field="casual_leave.details.max_leave_per_month"
                                                placeholder="Enter max leave per month" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.casual_leave.details
                                                .total_leave_per_year
                                                " label="Total Leave Per Year" label-class="required" type="text"
                                                id="cl_total_leave_per_year"
                                                field="casual_leave.details.total_leave_per_year"
                                                placeholder="Enter total leave per year" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-check mt-4">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="cl_is_carry_forward" 
                                                    :checked="fields.casual_leave.details.is_carry_forward == 1"
                                                />
                                                <label class="form-check-label" for="cl_is_carry_forward">
                                                    Is Carry Forward.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark" />
                            <div class="row gy-5">
                                <div class="col-md-5">
                                    <h5 class="stepper-title text-center">
                                        Earned Leave
                                    </h5>
                                    <div class="text-center mt-3 text-primary">
                                        <i class="fa fa-dollar fs-3"></i>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row gy-3">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.earned_leave.details
                                                .add_leave_per_month
                                                " label="Add Leave Per Month" label-class="required" type="text"
                                                id="el_add_leave_per_month" field="earned_leave.details.add_leave_per_month"
                                                placeholder="Enter add leave per month" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.earned_leave.details
                                                .max_accumulated_leaves
                                                " label="Max Accumulated Leaves" label-class="required" type="text"
                                                id="el_max_accumulated_leaves"
                                                field="earned_leave.details.max_accumulated_leaves"
                                                placeholder="Enter max accumulated leaves" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.earned_leave.details
                                                .total_leave_per_year
                                                " label="Total Leave Per Year" label-class="required" type="text"
                                                id="el_total_leave_per_year"
                                                field="earned_leave.details.total_leave_per_year"
                                                placeholder="Enter total leave per year" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-check mt-4">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="el_is_carry_forward"
                                                    @change="updateCheckbox('el_is_carry_forward', 'earned_leave' , 'is_carry_forward')"
                                                    :checked="fields.earned_leave.details.is_carry_forward == 1"
                                                />
                                                <label class="form-check-label" for="el_is_carry_forward">
                                                    Is Carry Forward.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark" />
                            <div class="row gy-5">
                                <div class="col-md-5">
                                    <h5 class="stepper-title text-center">
                                        Sick Leave
                                    </h5>
                                    <div class="text-center mt-3 text-primary">
                                        <i class="fa fa-heartbeat fs-3"></i>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row gy-3">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.sick_leave.details
                                                .add_leave_per_month
                                                " label="Add Leave Per Month" label-class="required" type="text"
                                                id="sl_add_leave_per_month" field="sick_leave.details.add_leave_per_month"
                                                placeholder="Enter add leave per month" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.sick_leave.details
                                                .total_leave_per_year
                                                " label="Total Leave Per Year" label-class="required" type="text"
                                                id="sl_total_leave_per_year" field="sick_leave.details.total_leave_per_year"
                                                placeholder="Enter total leave per year" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="sl_is_carry_forward"
                                                    @change="updateCheckbox('sl_is_carry_forward', 'sick_leave' , 'is_carry_forward')"
                                                    :checked="fields.sick_leave.details.is_carry_forward == 1"
                                                />
                                                <label class="form-check-label" for="sl_is_carry_forward">
                                                    Is Carry Forward.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark" />
                            <div class="row gy-5">
                                <div class="col-md-5">
                                    <h5 class="stepper-title text-center">
                                        Work From Home
                                    </h5>
                                    <div class="text-center mt-3 text-primary">
                                        <i class="fa fa-laptop fs-3"></i>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row gy-3">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.work_from_home.details
                                                .add_leave_per_month
                                                " label="Add Leave Per Month" label-class="required" type="text"
                                                id="wfh_add_leave_per_month" field="work_from_home.details.add_leave_per_month"
                                                placeholder="Enter add leave per month" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <Field v-model="fields.work_from_home.details
                                                .total_leave_per_year
                                                " label="Total Leave Per Year" label-class="required" type="text"
                                                id="wfh_total_leave_per_year" field="work_from_home.details.total_leave_per_year"
                                                placeholder="Enter total leave per year" :errors="formValidation.errors">
                                            </Field>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    id="wfh_is_carry_forward"
                                                    @change="updateCheckbox('wfh_is_carry_forward', 'work_from_home' , 'is_carry_forward')"
                                                    :checked="fields.work_from_home.details.is_carry_forward == 1"
                                                />
                                                <label class="form-check-label" for="wfh_is_carry_forward">
                                                    Is Carry Forward.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark" />

                            <div class="row">
                                <div class="text-center mt-3">
                                    <button
                                        class="btn btn-primary"
                                        @click="submitForm"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row gy-3 custom-card" v-if="is_view_mode">
                            <div class="col-12 col-md-4 col-sm-6" v-for="(leave, index) in leave_seeings"
                                :key="`leave_${index}`" v-if="leave_seeings.length > 0">
                                <template v-if="leave.leave_type_slug != 'leave_without_pay' && leave.leave_type_slug != 'compensatory_off'">
                                    <div class="card mb-5 h-100">
                                        <div class="card-header p-3 pt-2 text-primary"> {{ leave.leave_type }}</div>
                                        <hr class="dark horizontal my-0">
                                        <div class="card-body p-3">
                                            <div v-for="(leave, index) in leave.details" :key="`leave_${index}`">
                                                <p>
                                                    <span class="fw-bold">
                                                        {{ convertIntoTitleText(index) }} - 
                                                    </span>
                                                    <span v-if="index == 'is_carry_forward' || index == 'one_time_in_organization'">
                                                        {{ leave === 1 ? "Yes" : "No" }}
                                                    </span>
                                                    <span v-else>{{ leave }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
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
import axios from "axios";
import Field from "../../../helpers/Field.vue";
import { FormValidation } from "../../../helpers/Validation";
import { toastAlert } from "../../../helpers/alert";
import { LeaveSettingsRoutes } from "../../../routes/LeaveSettingsRoutes";

let leave_seeings = ref({});

onMounted(() => {
    reload();
});

let is_view_mode = ref(true);
let leave_mode_icon = ref("fa fa-pencil");

let fields = reactive({
    casual_leave: {
        id: "",
        details: {
            add_leave_per_month: 0,
            max_leave_per_month: 0,
            total_leave_per_year: 0,
            is_carry_forward: false,
        },
    },
    earned_leave: {
        id: "",
        details: {
            add_leave_per_month: 0,
            max_accumulated_leaves: 0,
            total_leave_per_year: 0,
            is_carry_forward: false,
        },
    },
    sick_leave: {
        id: "",
        details: {
            total_leave_per_year: 9,
            add_leave_per_month: 0,
            is_carry_forward: false,
        },
    },
    leave_without_pay: {
        id: "",
        details: {
            total_leave_per_year: 3,
            add_leave_per_month: 0,
            is_carry_forward: false,
        },
    },
});

function updateMode() {
    is_view_mode.value = !is_view_mode.value;
    leave_mode_icon.value = is_view_mode.value ? "fa fa-pencil" : "fa fa-eye";
}

function convertIntoTitleText(string) {
    return string
        .replace(/(^\w)/g, (g) => g[0].toUpperCase())
        .replace(/([-_]\w)/g, (g) => " " + g[1].toUpperCase())
        .trim();
}

function updateCheckbox(element_id , object , key) {
    let value = document.getElementById(element_id).checked;
    fields[object].details[key] = value ? 1 : 0;
}

function reload() {
    axios.get(LeaveSettingsRoutes.allleaves).then((response) => {
        leave_seeings.value = response.data.leaves;

        leave_seeings.value.forEach((leave) => {

            fields[leave.leave_type_slug] = leave;

            if(leave.details.is_carry_forward) {
                fields[leave.leave_type_slug].is_carry_forward = leave.details.is_carry_forward > 0 ? true : false;
            }

            if (leave.details.one_time_in_organization) {
                fields[leave.leave_type_slug].one_time_in_organization = leave.details.one_time_in_organization > 0 ? true : false;
            }
        });
        addValidation();
    });
}

function addValidation() {
    formValidation.addFields(
        fields.casual_leave.details,
        {
            add_leave_per_month: {
                required: "The add leave per month field is required.",
                numeric: "The add leave per month must be numeric.",
            },
            max_leave_per_month: {
                required: "The max leave per month field is required.",
                numeric: "The max leave per month must be numeric.",
            },
            total_leave_per_year: {
                required: "The total leave per year field is required.",
                numeric: "The total leave per year must be numeric.",
            },
        },
        "casual_leave.details"
    );

    formValidation.addFields(
        fields.earned_leave.details,
        {
            add_leave_per_month: {
                required: "The add leave per month field is required.",
                numeric: "The add leave per month must be numeric.",
            },
            max_accumulated_leaves: {
                required: "The max accumulated leave field is required.",
                numeric: "The max accumulated leave must be numeric.",
            },
            total_leave_per_year: {
                required: "The total leave per year field is required.",
                numeric: "The total leave per year must be numeric.",
            },
        },
        "earned_leave.details"
    );

    formValidation.addFields(
        fields.sick_leave.details,
        {
            add_leave_per_month: {
                required: "The add leave per month field is required.",
                numeric: "The add leave per month must be numeric.",
            },
            total_leave_per_year: {
                required: "The total leave per year field is required.",
                numeric: "The total leave per year must be numeric.",
            },
        },
        "sick_leave.details"
    );

    formValidation.addFields(
        fields.work_from_home.details,
        {
            add_leave_per_month: {
                required: "The add leave per month field is required.",
                numeric: "The add leave per month must be numeric.",
            },
            total_leave_per_year: {
                required: "The total leave per year field is required.",
                numeric: "The total leave per year must be numeric.",
            },
        },
        "work_from_home.details"
    );
}

function submitForm() {

    formValidation.validate();

    if (formValidation.isValid()) {
        
        axios.post(LeaveSettingsRoutes.update, fields)
            .then((response) => {
                toastAlert({ title: response.data.message });
                is_view_mode.value = true;
                reload();
            })
            .catch((error) => {
                if (error.response.status === 422) {
                    formValidation.setServerSideErrors(
                        error.response.data.errors
                    );
                }
            });
    }
}

let formValidation = reactive(new FormValidation());

</script>

