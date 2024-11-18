<template>
    <inertia-head title="Holidays" />
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
                            <h6 class="mb-0">Holidays</h6>
                        </div>
                        <hr class="horizontal dark" />
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="d-flex justify-content-center text-center">
                                <ul class="pagination">
                                    <li class="page-item previous">
                                        <button class="btn btn-primary btn-icon-only" @click="previous">
                                            <i class="fa fa-arrow-left"></i>
                                        </button>
                                    </li>
                                    <li class="page-item ms-4">
                                        <h3 id="year_label" class="animate__animated">
                                            {{ year_filter }}
                                        </h3>
                                    </li>
                                    <li class="page-item previous ms-4">
                                        <button class="btn btn-primary btn-icon-only" @click="next">
                                            <i class="fa fa-arrow-right"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row gy-3 mt-3">
                            <div class="col-12 col-md-4 col-sm-6" v-for="(holidays, title) in year_list" :key="title"
                                v-if="Object.entries(year_list).length > 0">
                                <div class="card mb-4" style="min-height: 200px;">
                                    <div class="card-header p-3 pt-2"> {{ title }} </div>
                                    <hr class="dark horizontal my-0">
                                    <div class="card-body p-3" v-if="holidays.length > 0">
                                        <div v-for="holiday in holidays" :key="`holiday_${holiday.id}`">
                                            <p> <span class="fw-bold"> {{ holiday.day }} {{ holiday.day_name }} </span> {{ holiday.title }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main-page>
</template>

<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

let holiday_form_element = ref(null);
let loader = ref(true);

let holiday_years = ref([]);
let year_filter = ref("");
let year_list = ref([]);

onMounted(() => {
    let current_year = new Date().getFullYear();

    holiday_years.value.push(current_year - 1);
    holiday_years.value.push(current_year);
    holiday_years.value.push(current_year + 1);

    year_filter.value = current_year;

    setTimeout(function () {
        reloadData();
    }, 1000);
});

function animate() {
    let year_label = document.getElementById("year_label");
    year_label.classList.remove("animate__flipInY");
    year_label.offsetHeight;
    year_label.classList.add("animate__flipInY");

    reloadData();
}

function previous() {
    if (year_filter.value >= new Date().getFullYear()) {
        year_filter.value = year_filter.value - 1;
        animate();
    }
}
function next() {
    if (year_filter.value <= new Date().getFullYear()) {
        year_filter.value = year_filter.value + 1;
        animate();
    }
}

const customSort = (a, b) => {
    const monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    const monthA = monthNames.indexOf(a);
    const monthB = monthNames.indexOf(b);

    if (monthA === -1 || monthB === -1) {
        return 0;
    }

    return monthA - monthB;
};

function reloadData() {
    axios
        .post("/holidays/year-filter", {
            year_filter: year_filter.value,
        })
        .then((response) => {
            year_list.value = Object.keys(response.data.holiday_list)
                .sort(customSort)
                .reduce((obj, key) => {
                    obj[key] = response.data.holiday_list[key];
                    return obj;
                }, {});

            loader.value = false;
        });
}

function openHolidayForm() {
    holiday_form_element.value.openModal();
}
</script>
