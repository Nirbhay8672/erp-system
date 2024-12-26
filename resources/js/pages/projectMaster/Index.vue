<template>
    <inertia-head title="Project Master" />
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
                            <h6 class="mb-0">Project Master</h6>
                            <button class="btn btn-primary btn-icon-only" @click="openForm()">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-header pb-0 p-4">
                        <div class="d-flex justify-content-between">
                            <select class="me-2" id="per_page" v-model="fields.per_page"
                                @change="changeMainFilter()">
                                <option value="8">8</option>
                                <option value="12">12</option>
                                <option value="20">20</option>
                                <option value="28">28</option>
                            </select>
                            <input
                                class="dataTable-input"
                                placeholder="Search..."
                                type="text"
                                id="search_input"
                                v-model="fields.search"
                                @keyup="changeMainFilter()"
                            />
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row gy-3 custom-card p-4">
                            <div class="col-12 col-md-3 col-sm-6" v-for="(project, index) in projects" :key="`project_${index}`">
                                <div class="card mb-3 h-100">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <b>{{ project.name }}</b>
                                            <button class="btn btn-primary btn-sm" @click="deleteProject(project)">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header" v-if="projects.length > 0">
                        <div class="d-flex justify-content-between">
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
        <teleport to="body">
            <project-form ref="project_form" @reload="reloadTable()"></project-form>
        </teleport>
    </main-page>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import axios from "axios";
import { toastAlert, confirmAlert } from "../../helpers/alert";
import { ProjectMasterRoutes } from "../../routes/ProjectMasterRoutes";
import ProjectForm from "./includes/Form.vue";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

let projects = ref([]);
let loader = ref(true);

let project_form = ref(null);

let fields = reactive({
    search: "",
    per_page: 12,
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
    project_form.value.openModal(user);
}

function reloadTable() {
    axios
        .post(ProjectMasterRoutes.datatable, fields)
        .then((response) => {
            projects.value = response.data.projects;
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

function deleteProject(project) {
    confirmAlert({
        title: "Delete",
        icon: "question",
        html: `Are you sure, you want to delete <strong> ${project.name} </strong> project ?`,
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .get(ProjectMasterRoutes.delete(project.id))
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

</script>
