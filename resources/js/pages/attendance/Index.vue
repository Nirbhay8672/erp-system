<template>
    <inertia-head title="Attendance" />
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
                    <div class="card-header pb-0 p-4">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0">Attendance</h6>
                        </div>
                        <hr class="horizontal dark" />
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                <div class="dataTable-top">
                                    <div class="row">
                                        <div class="col justify-content-center">
                                            <button class="btn btn-primary btn-sm mt-2" @click="adjustDate(-1)"><i class="fa fa-arrow-left fs-6"></i></button>
                                            <span class="ms-3 me-3">{{ fields.date }}</span>
                                            <input type="date" id="from_date" class="form-control d-none" v-model="fields.date">
                                            <button class="btn btn-primary btn-sm mt-2" @click="adjustDate(1)"><i class="fa fa-arrow-right fs-6"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="dataTable-container">
                                    <table class="table table-flush dataTable-table" id="member_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Sr No.
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Attendance Date
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Punch In
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Punch Out
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Total Hours
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="attendances.length > 0">
                                                <tr class="text-sm" v-for="(attendance, index) in attendances"
                                                    :key="`attendance_${index}`">
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ index + 1 }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ attendance.date }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ attendance.punch_in_formatted }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ attendance.punch_out_formatted ?? '' }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ attendance.total_hours ?? '' }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td colspan="6" class="text-center text-primary">No Record Found ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
import { toastAlert } from "../../helpers/alert";
import { AttendanceRoutes } from "../../routes/AttendanceRoutes";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

let attendances = ref([]);
let loader = ref(true);

let designation_form = ref(null);

let fields = reactive({
    'date': getTodayDate(),
});

onMounted(() => {
    setTimeout(function () {
        reloadTable();
    }, 1000);
});

function getTodayDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function changeMainFilter() {
    reloadTable();
}

function openForm(user = null) {
    designation_form.value.openModal(user);
}

function reloadTable() {
    axios
        .post(AttendanceRoutes.datatable, fields)
        .then((response) => {
            attendances.value = response.data.attendances;
            loader.value = false;
        })
        .catch(function (error) {
            if (error.response.status === 422) {
                toastAlert({
                    title: "somthing went wrong.",
                    icon: "error",
                });
            }
        });
}

function adjustDate(days) {
    if (!fields.date) {
        fields.date = new Date().toISOString().split("T")[0];
    }
    const currentDate = new Date(fields.date);
    currentDate.setDate(currentDate.getDate() + days);
    fields.date = currentDate.toISOString().split("T")[0];

    reloadTable();
}

</script>
