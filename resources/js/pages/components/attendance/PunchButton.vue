<template>
    <div class="d-flex justify-content-center align-items-center px-5 mb-3 mt-2">
        <div
            class="symbol symbol-125px symbol-circle"
            @click="punch"
            id="punch_card"
        >
            <div
                class="punch-button-circle cursor-pointer"
            >
                {{ punch_text }}
            </div>
        </div>
    </div>
</template>

<script setup>

import axios from "axios";
import { AttendanceRoutes } from "../../../routes/AttendanceRoutes";
import { toastAlert } from "../../../helpers/alert";

const emits = defineEmits(["reload-data"]);

const props = defineProps({
    punch_text: {
        type: String,
        default: "Punch In",
    },
    is_punch_in: {
        type: Boolean,
        default: false,
    },
    is_active_service: {
        type: Boolean,
        default: false,
    },
});

function punch() {
    let url = props.is_punch_in
        ? AttendanceRoutes.punchOut
        : AttendanceRoutes.punchIn;

        axios
        .get(url)
        .then((response) => {
            const punch_card = document.getElementById("punch_card");
            punch_card.classList.remove(
                "animate__animated",
                "animate__flipInY"
            );
            punch_card.offsetHeight;
            punch_card.classList.add("animate__animated", "animate__flipInY");
            toastAlert({ title: response.data.message });
            emits("reload-data");
        })
        .catch(function (error) {
            if (error.response.status === 422) {
                toastAlert({
                    icon: "error",
                    title: error.response.data.message,
                });
            }
        });
}
</script>
