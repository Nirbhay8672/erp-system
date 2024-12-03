<template>
    <inertia-head title="Dashboard" />
    <main-page>
        <div class="row mt-4">
            <div class="col-lg-12 position-relative z-index-2">
                <div class="row gy-3 mt-3">
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons fa fa-users opacity-10"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Employees</p>
                                    <h4 class="mb-0">{{ $page.props.total_users }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/employees/index`"
                                    class="btn btn-outline-primary btn-sm mb-0">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                <div
                                    class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
                                    <i class="material-icons fa fa-id-card opacity-10"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Designations</p>
                                    <h4 class="mb-0">{{ $page.props.total_designations }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/designations/index`"
                                    class="btn btn-outline-primary btn-sm mb-0">View</a>
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
                                    <p class="text-sm mb-0 text-capitalize">Roles</p>
                                    <h4 class="mb-0">{{ $page.props.total_roles }}</h4>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-3 text-center">
                                <a :href="`${$page.props.url}/roles/index`"
                                    class="btn btn-outline-primary btn-sm mb-0">View</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12 col-lg-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                Attendance
                            </div>
                            <hr class="dark horizontal my-0">

                            <div class="card-body">
                                <div class="row">
                                    <basic-info ref="basic_info_element" @update-button-details="updateButtonDetails" />
                                </div>

                                <punch-button
                                    :punch_text="data.punch_text"
                                    :is_punch_in="data.is_punch_in"
                                    @reload-data="reloadData"
                                />

                                <hr class="dark horizontal mt-2 mb-3">

                                <div class="row text-center">
                                    <p><b>Break :</b> 01:00 To 02:00 PM</p>
                                    <p class="mt-2"><b>Overtime :</b> 2 hrs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card mb-2">
                            <div class="card-header p-3 pt-2">
                                Today Activity
                            </div>
                            
                            <hr class="dark horizontal my-0">

                            <div class="card-body">
                                <today-activity
                                    ref="today_activity_element"
                                    :auth="auth"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gy-3 mt-3 custom-card">
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-5 h-100">
                            <div class="card-header p-3 pt-2 text-primary"> Upcoming Holidays </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-body p-3" v-if="$page.props.upcomingHolidays.length > 0">
                                <div v-for="holiday in $page.props.upcomingHolidays" :key="`holiday_${holiday.id}`">
                                    <p> {{ holiday.day }} {{ holiday.day_name }} - {{ holiday.title }}</p>
                                </div>
                            </div>
                            <div class="card-body p-3" v-else>
                                <span class="text-center">
                                    No upcoming holidays
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <div class="card mb-5 h-100">
                            <div class="card-header p-3 pt-2 text-primary"> Upcoming Birtdays </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-body p-3" v-if="$page.props.upcomingBirthDays.length > 0">
                                <div v-for="birth_day in $page.props.upcomingBirthDays" :key="`birth_day_${birth_day.id}`">
                                    <p> {{ birth_day.date_format }} - {{ birth_day.employee_name }} </p>
                                </div>
                            </div>
                            <div class="card-body p-3" v-else>
                                <span class="text-center mt-5">
                                    No upcoming birthdays
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>

<script setup>

import { reactive , ref } from 'vue';
import BasicInfo from './components/attendance/BasicInfo.vue';
import PunchButton from './components/attendance/PunchButton.vue';
import TodayActivity from './components/attendance/TodayActivity.vue';

let basic_info_element = ref("");
let today_activity_element = ref("");

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

let data = reactive({
    punch_text: "Punch In",
    is_punch_in: false,
    is_loading: true,
});

function updateButtonDetails(buttonData) {
    data.punch_text = buttonData.punch_text;
    data.is_punch_in = buttonData.is_punch_in;
}

function reloadData() {
    basic_info_element.value.reloadData();
    today_activity_element.value.reloadActivity();
    today_activity_element.value.reloadTime();
}

</script>
