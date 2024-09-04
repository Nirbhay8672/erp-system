<template>
    <inertia-head title="Permissions" />
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
                            <h6 class="mb-0">Permissions</h6>
                            <template v-if="!allow_update">
                                <button v-if="hasPermission(['update_permission'])" @click="allowUpdate()"
                                    class="btn btn-primary btn-sm">
                                    Update Permission
                                </button>
                            </template>
                        </div>
                        <hr class="horizontal dark" />
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="accordion p-3" id="accordionExample">
                            <div class="accordion-item" v-for="(
                            permissions, category, category_index
                        ) in all_permissions" :key="category">
                                <h5 class="accordion-header bg-light mb-3" :id="`heading_${category_index}`">
                                    <button class="accordion-button text-dark" type="button"
                                        :id="`heading_${category_index}_button`" data-bs-toggle="collapse"
                                        :data-bs-target="`#target_area_${category_index}`" aria-expanded="false"
                                        :aria-controls="`target_area_${category_index}`">
                                        <span class="ms-3"><i class="fa fa-shield fs-6 text-primary me-3"></i>{{ category }}</span>
                                    </button>
                                </h5>
                                <div :id="`target_area_${category_index}`" class="accordion-collapse collapse"
                                    :aria-labelledby="`heading_${category_index}`" data-bs-parent="#accordionExample">
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
                                                    <td style="width: 400px;">
                                                        {{ permission.display_name }}
                                                    </td>
                                                    <td v-for="(role, index) in roles" :key="index">
                                                        <template v-if="allow_update">
                                                            <div class="form-check">
                                                                <input
                                                                    type="checkbox"
                                                                    :data-role="role.id"
                                                                    :data-permission="permission.id"
                                                                    class="permissions form-check-input"
                                                                    :value="permission.id"
                                                                    :id="`permission[${role.id}][${permission.id}]`"
                                                                    :name="`permission[${role.id}][${permission.id}]`"
                                                                    :checked="has_permission(role.id,permission.id)"
                                                                />
                                                            </div>
                                                        </template>
                                                        <template v-if="!allow_update">
                                                            <b><i :class="has_permission(
                                                                role.id,
                                                                permission.id
                                                            )
                                                                ? 'fa fa-check text-success fw-bold'
                                                                : 'fa fa-times text-danger fw-bold'
                                                                "></i>
                                                            </b>
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
                </div>
            </div>
        </div>
        <div class="row" v-if="allow_update && hasPermission(['update_permission'])">
            <div class="form-group col-md-12 text-center mt-4">
                <button type="button" class="btn btn-primary" @click="submitForm">
                    Save Changes
                </button>
            </div>
        </div>
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
let loader = ref(true);

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    reload();
});

function reload() {
    axios.get(PermissionRoutes.details).then((response) => {
        roles.value = response.data.roles;
        all_permissions.value = response.data.all_permissions;
        loader.value = false;

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
        .post(PermissionRoutes.update, {
            role_id: role_ids,
            permission: permission_array,
        })
        .then((response) => {
            allow_update.value = false;
            reload();
            toastAlert({ title: response.data.message });
        });
}

function hasPermission(permission_name) {
    let permission_obj = props.auth.user.roles[0].permissions.find(
        (permission) => permission.name == permission_name
    );

    return permission_obj ? true : false;
}

</script>
