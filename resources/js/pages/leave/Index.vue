<template>
    <inertia-head title="My Leaves" />
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
                            <h6 class="mb-0">My Leaves</h6>
                            <button class="btn btn-primary btn-icon-only" @click="openForm()">
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
                                        <div class="row">
                                            <div class="col-12">
                                                <select
                                                    name="status"
                                                    id="status"
                                                    class="dataTable-selector form-select"
                                                    style="width:100px;"
                                                    v-model="fields.status"
                                                    @change="changeMainFilter()"
                                                >
                                                    <option value="">All</option>
                                                    <option value="1">Pending</option>
                                                    <option value="2">Approved</option>
                                                    <option value="3">Declined</option>
                                                </select>
                                            </div>
                                        </div>
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
                                                    Leave Type
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Leave Date
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Reason
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="leaves.length > 0">
                                                <tr class="text-sm" v-for="(leave, index) in leaves" :key="`designation_${index}`">
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ index + 1 }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ leave.leave_type }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ leave.leave_from }} <i class="fa fa-arrow-right ms-2 me-2"></i> {{ leave.leave_to }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <p class="text-sm font-weight-normal mb-0">
                                                            {{ leave.reason }}
                                                        </p>
                                                    </td>
                                                    <td>
                                                        <span class="badge" :class="$page.props.leave_status[leave.status]['color']">{{ $page.props.leave_status[leave.status]['name'] }}</span>
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr v-else>
                                                <td colspan="7" class="text-center text-primary">No Record Found ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="dataTable-bottom" v-if="leaves.length > 0">
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
            <leave-form ref="leave_form" @reload="reloadTable()"></leave-form>
        </teleport>
    </main-page>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import axios from "axios";
import { toastAlert, confirmAlert } from "../../helpers/alert";
import { MyLeaveRoutes } from "../../routes/MyLeavesRoutes";
import LeaveForm from "./includes/Form.vue";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

let leaves = ref([]);
let loader = ref(true);

let leave_form = ref(null);

let fields = reactive({
    status: "",
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
    leave_form.value.openModal(user);
}

function reloadTable() {
    axios
        .post(MyLeaveRoutes.datatable, fields)
        .then((response) => {
            leaves.value = response.data.leaves;
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

function hasPermission(permission_name) {
    let permission_obj = props.auth.user.roles[0].permissions.find(
        (permission) => permission.name == permission_name
    );

    return permission_obj ? true : false;
}
</script>
