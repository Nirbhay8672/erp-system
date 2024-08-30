<template>
    <Modal ref="role_form" :id="'role_form'">
        <template #modal_title>
            <span>{{ title_text }}</span>
        </template>

        <div class="row">
            <div class="col-12 mb-2">
                <Field
                    v-model="fields.name"
                    label="Name"
                    label-class="required"
                    type="text"
                    id="name"
                    field="name"
                    :errors="formValidation.errors"
                ></Field>
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
import { RoleRoutes } from "../../../routes/RoleRoutes";
import { toastAlert } from "../../../helpers/alert";

let role_form = ref(null);
let title_text = ref("");
let button_text = ref("");

const emits = defineEmits(["reload"]);

let fields = reactive({
    id: "",
    name: "",
});

function openModal(role) {
    clearFormData();
    role_form.value.open();

    title_text.value = role ? `Update Role : ${role.display_name}` : "Create Role";
    button_text.value = role ? "Update" : "Submit";

    if (role) {
        fields.id = role.id;
        fields.name = role.display_name;
    }
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
            .post(RoleRoutes.createOrUpdate(fields.id), fields)
            .then((response) => {
                role_form.value.close();
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
        name: {
            required: "Name field is required.",
        },
    })
);
</script>
