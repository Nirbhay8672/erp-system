const baseUrl = document.querySelector('meta[name="url"]').content;

let DesignationRoutes = {
    datatable: `${baseUrl}/designations/datatable`,
    createOrUpdate: (designation_id) => {
        if (designation_id > 0) {
            return `${baseUrl}/designations/create-or-update/${designation_id}`;
        }
        return `${baseUrl}/designations/create-or-update`;
    },
    deleteDesignation: (designation_id) => {
        return `${baseUrl}/designations/delete/${designation_id}`;
    },
};

export { DesignationRoutes };
