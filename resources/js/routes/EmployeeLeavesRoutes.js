const baseUrl = document.querySelector('meta[name="url"]').content;

let EmployeeLeaveRoutes = {
    datatable: `${baseUrl}/employee-leaves/datatable`,
    updateStatus: `${baseUrl}/employee-leaves/update-status`,
};

export { EmployeeLeaveRoutes };
