<template>
    <Modal ref="leave_form" :id="'leave_form'">
        <template #modal_title>
            <span>Leave Details</span>
        </template>

        <div class="row">
            <div class="col-12 mb-1">
                <p>Leave Type : {{ leave_details.leave_type }}</p>
                <p>Leave From : {{ leave_details.leave_from }}</p>
                <p>Leave To : {{ leave_details.leave_to }}</p>
                <p>Leave Reason : {{ leave_details.reason }}</p>
            </div>
            <div class="col-12 mb-1">
                <div class="input-group input-group-outline my-3 is-filled">
                    <select
                        name="status"
                        id="status"
                        class="form-control form-control-solid form-select"
                        v-model="fields.status"
                    >
                        <template v-for="(status , key ) in $page.props.leave_status" :key="key">
                            <option :value="key">{{ status.name }}</option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        <template #modal_footer>
            <button
                class="btn btn-success btn-sm"
                type="button"
                @click="handleSubmit"
            >
                Submit
            </button>
        </template>
    </Modal>
</template>

<script setup>

import { ref, reactive } from "vue";
import Modal from "../../../components/Modal.vue";
import axios from "axios";
import { toastAlert } from "../../../helpers/alert";
import { EmployeeLeaveRoutes } from "../../../routes/EmployeeLeavesRoutes";

let leave_form = ref(null);

const emits = defineEmits(["reload"]);

let leave_details = ref({});

let fields = reactive({
    id : '',
    status : '',
});

function openModal(leave) {
    leave_details.value = leave;
    fields.id = leave.id;
    fields.status = leave.status;
    leave_form.value.open();
}

function handleSubmit() {
    axios
        .post(EmployeeLeaveRoutes.updateStatus, fields)
        .then((response) => {
            leave_form.value.close();
            emits("reload");
            toastAlert({ title: response.data.message });
        })
        .catch(function (error) {
            if (error.response.status === 422) {
                formValidation.setServerSideErrors(
                    error.response.data.errors
                );
            }
        });
}

defineExpose({
    openModal,
});

</script>
