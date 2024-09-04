<template>
    <div
        class="text-center"
    >
        <template v-if="data.last_entry != null">
            <p>
                {{
                    data.last_entry.time_out === null
                        ? "Last Punch In at :"
                        : "Last Punch Out at :"
                }}
                <span class="fs-6 fw-bold">
                    {{
                        data.last_entry.time_out === null
                            ? data.last_entry.time_in_format
                            : data.last_entry.time_out_format
                    }}
                </span>
            </p>
        </template>
        <template v-if="data.last_entry === null">
            <h3 class="mb-5 text-danger">No action</h3>
        </template>
        <p>
            Total Hours :
            <span class="fs-6 fw-bold text-gray-700">{{
                data.working_hours
            }}</span>
        </p>
    </div>
    <hr class="dark horizontal mt-2 mb-2">
</template>

<script setup>
import axios from "axios";
import { onMounted, reactive } from "vue";
import { AttendanceRoutes } from "../../../routes/AttendanceRoutes";

const emits = defineEmits(["update-button-details"]);

let data = reactive({
    last_entry: {},
    working_hours: "00:00 hrs",
});

onMounted(() => {
    reloadData();
});

function reloadData() {
    axios.post(AttendanceRoutes.summary).then((response) => {
        let attendance_data = response.data.attendance_data;
        data.last_entry = attendance_data.last_entry;
        data.working_hours = attendance_data.working_hours;

        let punch_text = "Punch In";
        let is_punch_in = false;

        if (attendance_data.last_entry) {
            punch_text = attendance_data.last_entry.time_out
                ? "Punch In"
                : "Punch Out";

            is_punch_in = attendance_data.last_entry.time_out ? false : true;
        } else {
            punch_text = "Punch In";
            is_punch_in = false;
        }

        emits("update-button-details", {
            punch_text,
            is_punch_in,
        });
    });
}

defineExpose({
    reloadData,
});
</script>
