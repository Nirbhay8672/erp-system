const baseUrl = document.querySelector('meta[name="url"]').content;

let RoleRoutes = {
    datatable: `${baseUrl}/roles/datatable`,
    createOrUpdate: (role_id) => {
        if (role_id > 0) {
            return `${baseUrl}/roles/create-or-update/${role_id}`;
        }
        return `${baseUrl}/roles/create-or-update`;
    },
    delete: (role_id) => {
        return `${baseUrl}/roles/delete/${role_id}`;
    },
};

export { RoleRoutes };
