<template>
    <Modal ref="leave_form" :id="'leave_form'" :size="'large'">
        <template #modal_title>
            <span>{{ title_text }}</span>
        </template>

        <div class="row">
            <div class="col-12 mb-1">
                <Field
                    field="leave_type"
                    id="leave_type"
                    label-class="required"
                    :errors="formValidation.errors"
                    no-input
                    no-label
                >
                    <template #input="{ hasError }">
                        <select
                            class="form-control form-control-solid form-select"
                            id="leave_type"
                            v-model="fields.leave_type"
                            :class="{'is-invalid': hasError }"
                        >
                            <option value=""> -- Select Leave Type -- </option>
                            <template v-for="(leave , index) in $page.props.leave_types" :key="`leave_type_${index}`">
                                <option :value="leave.leave_type">{{ leave.leave_type }}</option>
                            </template>
                        </select>
                    </template>
                </Field>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mb-1">
                <Field
                    v-model="fields.leave_from"
                    label="Leave From"
                    label-class="required"
                    type="date"
                    id="leave_from"
                    field="leave_from"
                    :class="fields.leave_from ? 'has-value' : ''"
                    :errors="formValidation.errors"
                    :isDate="true"
                ></Field>
            </div>
            <div class="col-12 col-lg-6 col-md-6 mb-1">
                <Field
                    v-model="fields.leave_to"
                    label="Leave To"
                    label-class="required"
                    type="date"
                    id="leave_to"
                    field="leave_to"
                    :class="fields.leave_to ? 'has-value' : ''"
                    :errors="formValidation.errors"
                    :isDate="true"
                ></Field>
            </div>
            <div class="col-12 mb-1">
                <Field
                    field="reason"
                    id="reason"
                    label-class="required"
                    label="Reason"
                    :errors="formValidation.errors"
                    no-input
                >
                    <template #input="{ hasError }">
                        <textarea
                            name="reason"
                            id="reason"
                            cols="30"
                            rows="10"
                            v-model="fields.reason"
                            class="form-control form-control-solid"
                            :class="{'is-invalid': hasError }"
                        ></textarea>
                    </template>
                </Field>
            </div>
        </div>

        <template #modal_footer>
            <button
                class="btn btn-success btn-sm"
                type="button"
                @click="handleSubmit"
            >
                {{ button_text }}
            </button>
        </template>
    </Modal>
</template>

<script setup>
import { ref, reactive } from "vue";
import Modal from "../../../components/Modal.vue";
import { FormValidation } from "../../../helpers/Validation";
import { resetObjectKeys } from "../../../helpers/utils";
import Field from "../../../helpers/Field.vue";
import axios from "axios";
import { toastAlert } from "../../../helpers/alert";
import { MyLeaveRoutes } from "../../../routes/MyLeavesRoutes";

let leave_form = ref(null);
let title_text = ref("");
let button_text = ref("");

const emits = defineEmits(["reload"]);

let fields = reactive({
    leave_type : '',
    leave_from : '',
    leave_to : '',
    reason : '',
});

function openModal() {
    clearFormData();
    leave_form.value.open();

    title_text.value = "Add Leave";
    button_text.value = "Submit";
}

function clearFormData() {
    formValidation.reset();
    title_text.value = "";
    button_text.value = "";
    resetObjectKeys(fields);
}

function handleSubmit() {

    formValidation.validate();

    if (formValidation.isValid()) {
        axios
            .post(MyLeaveRoutes.add, fields)
            .then((response) => {
                leave_form.value.close();
                emits("reload");
                toastAlert({ title: response.data.message });
                clearFormData();
            })
            .catch(function (error) {
                if (error.response.status === 422) {
                    formValidation.setServerSideErrors(
                        error.response.data.errors
                    );
                }
            });
    }
}

defineExpose({
    openModal,
});

let formValidation = reactive(
    new FormValidation(fields, {
        leave_type: {
            required: "Leave type field is required.",
        },
        leave_from: {
            required: "Leave from field is required.",
        },
        leave_to: {
            required: "Leave to field is required.",
        },
        reason: {
            required: "Leave reason field is required.",
        },
    })
);
</script>
