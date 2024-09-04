const baseUrl = document.querySelector('meta[name="url"]').content;

let AttendanceRoutes = {
    datatable: `${baseUrl}/attendance/datatable`,
    summary: `${baseUrl}/attendance/summary`,
    details: `${baseUrl}/attendance/details`,
    punchIn: `${baseUrl}/attendance/punch-in`,
    punchOut: `${baseUrl}/attendance/punch-out`,
};

export { AttendanceRoutes };
