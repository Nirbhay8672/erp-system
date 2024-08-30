<template>
    <inertia-head title="Permissions" />
    <main-page
        :breadcrumb-links="[
            { title: 'User Management', url: '#' },
            { title: 'Permissions', url: '#' },
        ]"
    >
        <card>
            <template #left>
                <h5 class="mb-0">Permissions</h5>
            </template>

            <template #right v-if="!allow_update">
                <button
                    v-if="hasPermissions(['update_permission'])"
                    @click="allowUpdate()"
                    class="btn btn-primary btn-sm"
                >
                    Update Permission
                </button>
            </template>

            <div class="row">
                <div class="accordion" id="accordionExample">
                    <div
                        class="accordion-item"
                        v-for="(
                            permissions, category, category_index
                        ) in all_permissions"
                        :key="category"
                    >
                        <h2
                            class="accordion-header bg-light"
                            :id="`heading_${category_index}`"
                        >
                            <button
                                class="accordion-button text-dark"
                                type="button"
                                :id="`heading_${category_index}_button`"
                                data-bs-toggle="collapse"
                                :data-bs-target="`#target_area_${category_index}`"
                                aria-expanded="false"
                                :aria-controls="`target_area_${category_index}`"
                            >
                                {{ category }}
                            </button>
                        </h2>
                        <div
                            :id="`target_area_${category_index}`"
                            class="accordion-collapse collapse"
                            :aria-labelledby="`heading_${category_index}`"
                            data-bs-parent="#accordionExample"
                        >
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Permissions</th>
                                            <th v-for="role in roles">
                                                {{ role.name }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="permission in permissions">
                                            <td>
                                                {{ permission.display_name }}
                                            </td>
                                            <td
                                                v-for="(role, index) in roles"
                                                :key="index"
                                            >
                                                <template v-if="allow_update">
                                                    <input
                                                        type="checkbox"
                                                        :data-role="role.id"
                                                        :data-permission="
                                                            permission.id
                                                        "
                                                        class="permissions"
                                                        :value="permission.id"
                                                        :id="`permission[${role.id}][${permission.id}]`"
                                                        :name="`permission[${role.id}][${permission.id}]`"
                                                        :checked="
                                                            has_permission(
                                                                role.id,
                                                                permission.id
                                                            )
                                                        "
                                                    />
                                                </template>
                                                <template v-if="!allow_update">
                                                    <i
                                                        :class="
                                                            has_permission(
                                                                role.id,
                                                                permission.id
                                                            )
                                                                ? 'ph-check text-success fw-bold'
                                                                : 'ph-x text-danger fw-bold'
                                                        "
                                                    ></i>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="row"
                v-if="allow_update && hasPermissions(['update_permission'])"
            >
                <div class="form-group col-md-12 text-center mt-4">
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="submitForm"
                    >
                        Save Changes
                    </button>
                </div>
            </div>
        </card>
    </main-page>
</template>

<script setup>
import { nextTick, onMounted, ref } from "vue";
import { PermissionRoutes } from "../../routes/PermissionRoutes";
import axios from "axios";
import { toastAlert } from "../../helpers/alert";

let roles = ref([]);
let all_permissions = ref([]);
let allow_update = ref(false);

onMounted(() => {
    reload();
});

function reload() {
    axios.get(PermissionRoutes.details).then((response) => {
        roles.value = response.data.roles;
        all_permissions.value = response.data.all_permissions;

        nextTick(() => {
            document.getElementById("heading_0_button").click();
        });
    });
}

function allowUpdate() {
    allow_update.value = true;
}

function has_permission(role_id, permission_id) {
    let role = roles.value.find((role) => role.id === role_id);
    let has_permission = role.role_permission.find(
        (permission) => permission.id === permission_id
    );
    return has_permission.has_permission;
}

function submitForm() {
    let role_ids = [];
    let permission_array = {};

    roles.value.forEach((role) => {
        permission_array[role.id] = {};
        role_ids.push(role.id);
    });

    var checked = document.querySelectorAll(":checked");
    checked.forEach((element) => {
        if (element.dataset.permission != null) {
            permission_array[element.dataset.role][element.dataset.permission] =
                parseInt(element.dataset.permission);
        }
    });

    axios
        .post(permissionRoutes.update, {
            role_id: role_ids,
            permission: permission_array,
        })
        .then((response) => {
            allow_update.value = false;
            reload();
            toastAlert({ title: response.data.message });
        });
}
</script>
