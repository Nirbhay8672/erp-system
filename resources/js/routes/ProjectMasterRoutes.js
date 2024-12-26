const baseUrl = document.querySelector('meta[name="url"]').content;

let ProjectMasterRoutes = {
    datatable: `${baseUrl}/project-master/datatable`,
    createOrUpdate: (project_id) => {
        if (project_id > 0) {
            return `${baseUrl}/project-master/create-or-update/${project_id}`;
        }
        return `${baseUrl}/project-master/create-or-update`;
    },
    delete: (project_id) => {
        return `${baseUrl}/project-master/delete/${project_id}`;
    },
};

export { ProjectMasterRoutes };
