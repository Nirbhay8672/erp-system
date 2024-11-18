<template>
    <div class="row gy-5" v-if="all_attendance.length > 0">
        <div class="col-12 col-md-5 col-sm-5 d-flex flex-column" style="max-height: 350px; overflow-y: auto">
            <div class="timeline timeline-one-side" v-if="all_attendance.length > 0">
                <div class="timeline-block mb-3" v-for="(time_line, index) in all_attendance" :key="`time_line_${index}`">
                    <span class="timeline-step">
                        <i class="fa fa-circle text-primary"></i>
                    </span>
                    <div class="timeline-content">
                        <h6 class="text-dark text-sm font-weight-bold mb-0">{{
                                time_line.time_in_format
                            }} <i class="fa fa-arrow-right me-3"></i>
                            
                            <span v-if="time_line.time_out_format != null">
                                <span class="text-danger">{{
                                    time_line.time_out_format
                                }}</span>
                            </span>
                            <span v-else class="text-success">
                                Working
                            </span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-7 col-sm-7 text-center">
            <h5 class="card-title">Total Hours</h5>
            <h3>{{ total_time }}</h3>
        </div>
    </div>
    <h3 class="mb-5 text-danger text-center" v-else>No action today</h3>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

onMounted(() => {
    reloadTime();
    reloadActivity();
});

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

let all_attendance = ref([]);
let total_time = ref("");

function reloadActivity() {
    axios
        .post("attendance/details", {
            employee_id: props.auth.id,
        })
        .then((response) => {
            all_attendance.value = response.data.attendance_data.all_attendance;
        });
}

function reloadTime() {
    axios
        .post("attendance/summary", {
            employee_id: props.auth.id,
        })
        .then((response) => {
            let attendance_data = response.data.attendance_data;
            total_time.value = attendance_data.working_hours;
        });
}

defineExpose({ reloadActivity, reloadTime });

</script>
