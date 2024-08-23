const baseUrl = document.querySelector('meta[name="url"]').content;

let EmployeeRoutes = {
    datatable: `${baseUrl}/employees/datatable`,
    updateProfile: (employee_id) => {
        return `${baseUrl}/employees/update-profile/${employee_id}`;
    },
    createOrUpdate: (employee_id) => {
        if (employee_id > 0) {
            return `${baseUrl}/employees/create-or-update/${employee_id}`;
        }
        return `${baseUrl}/employees/create-or-update`;
    },
    deleteUser: (employee_id) => {
        return `${baseUrl}/employees/delete/${employee_id}`;
    },
};

export { EmployeeRoutes };
