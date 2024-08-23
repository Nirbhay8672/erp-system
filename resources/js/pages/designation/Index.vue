<template>
    <inertia-head title="Designations" />
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
                            <h6 class="mb-0">Designations</h6>
                            <button class="btn btn-primary btn-icon-only" @click="openForm()" v-if="hasPermission('add_designation')">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <hr class="horizontal dark" />
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                <div class="dataTable-top">
                                    <div class="dataTable-dropdown">
                                        <label>
                                            <select class="dataTable-selector me-2" id="per_page" v-model="fields.per_page"
                                                @change="changeMainFilter()">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="dataTable-search">
                                        <input class="dataTable-input" placeholder="Search..." type="text" id="search_input"
                                            v-model="fields.search" @keyup="changeMainFilter()" />
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
                                                    Name
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="designations.length > 0">
                                                <tr class="text-sm" v-for="(designation, index) in designations" :key="`designation_${index}`">
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ index + 1 }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ designation.name }}
                                                        </p>
                                                    </td>
                                                    <td class="align-middle text-end">
                                                        <div class="d-flex justify-content-center mb-0">
                                                            <button
                                                                class="btn btn-icon-only btn-primary ms-3"
                                                                @click="openForm(designation)"
                                                                v-if="hasPermission('update_designation')"
                                                            >
                                                                <i class="fa fa-pencil"></i>
                                                            </button>

                                                            <button
                                                                class="btn btn-icon-only btn-danger ms-3"
                                                                @click="deleteDesignation(designation)"
                                                                v-if="hasPermission('delete_designation')"
                                                            >
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td colspan="6" class="text-center text-primary">No Record Found ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="dataTable-bottom" v-if="designations.length > 0">
                                    <div class="dataTable-info">
                                        Showing {{ fields.start_index }} to
                                        {{ fields.end_index }} of
                                        {{ fields.total_record }} Results
                                    </div>
                                    <nav class="dataTable-pagination">
                                        <ul class="dataTable-pagination-list">
                                            <li class="pager">
                                                <button type="button" class="btn btn-outline-primary btn-icon-only rounded-circle" @click="prev()">
                                                    <span class="btn-inner--icon">
                                                        <i class="fa fa-angle-double-left"></i>
                                                    </span>
                                                </button>
                                            </li>

                                            <template v-for="page_number in fields.total_pages" :key="`page_number_${page_number}`">
                                                <li class="paper ms-2">
                                                    <button
                                                        type="button"
                                                        :class="page_number === fields.page ? 'btn-primary' : ''"
                                                        class="btn btn-icon-only rounded-circle btn"
                                                        style="border: 1px solid #e91e63;"
                                                        @click="setPage(page_number)"
                                                    >
                                                        <span class="btn-inner--icon">{{ page_number }}</span>
                                                    </button>
                                                </li>
                                            </template>

                                            <li class="pager ms-2">
                                                <button type="button" class="btn btn-outline-primary btn-icon-only rounded-circle" @click="next()">
                                                    <span class="btn-inner--icon">
                                                        <i class="fa fa-angle-double-right"></i>
                                                    </span>
                                                </button>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <teleport to="body">
            <designation-form ref="designation_form" @reload="reloadTable()"></designation-form>
        </teleport>
    </main-page>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import axios from "axios";
import { toastAlert, confirmAlert } from "../../helpers/alert";
import { DesignationRoutes } from "../../routes/DesignationRoutes";
import DesignationForm from "./includes/Form.vue";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

let designations = ref([]);
let loader = ref(true);

let designation_form = ref(null);

let fields = reactive({
    search: "",
    per_page: 10,
    total_record: 0,
    total_pages: 1,
    page: 1,
    start_index: 0,
    end_index: 0,
});

onMounted(() => {
    setTimeout(function () {
        reloadTable();
    }, 1000);
});

function changeMainFilter() {
    fields.page = 1;
    reloadTable();
}

function setPage(page_number = 1) {
    fields.page = page_number;
    reloadTable();
}

function prev() {
    if (fields.page === 1) {
        return;
    }
    fields.page--;
    reloadTable();
}

function next() {
    if (fields.page === fields.total_pages) {
        return;
    }
    fields.page++;
    reloadTable();
}

function openForm(user = null) {
    designation_form.value.openModal(user);
}

function reloadTable() {
    axios
        .post(DesignationRoutes.datatable, fields)
        .then((response) => {
            designations.value = response.data.designations;
            fields.total_record = response.data.total;
            fields.total_pages = response.data.total_pages;
            fields.start_index = response.data.start_index;
            fields.end_index = response.data.end_index;
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

function deleteDesignation(designation) {
    confirmAlert({
        title: "Delete",
        icon: "question",
        html: `Are you sure, you want to delete <strong> ${designation.name} </strong> designation ?`,
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .get(DesignationRoutes.deleteDesignation(designation.id))
                .then((response) => {
                    toastAlert({ title: response.data.message });
                    reloadTable();
                })
                .catch(function (error) {
                    if (error.response.status === 422) {
                        toastAlert({
                            title: error.response.data.message,
                            icon: "error",
                        });
                    }
                    if (error.response.status === 500) {
                        toastAlert({
                            title: error.response.data.message,
                            icon: "error",
                        });
                    }
                });
        }
    });
}

function hasPermission(permission_name) {
    let permission_obj = props.auth.user.roles[0].permissions.find(
        (permission) => permission.name == permission_name
    );

    return permission_obj ? true : false;
}
</script>
