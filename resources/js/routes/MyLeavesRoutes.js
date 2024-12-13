const baseUrl = document.querySelector('meta[name="url"]').content;

let MyLeaveRoutes = {
    datatable: `${baseUrl}/my-leaves/datatable`,
    add: `${baseUrl}/my-leaves/add`,
    cancel: (leave_id) => {
        return `${baseUrl}/my-leaves/cancel/${leave_id}`;
    },
};

export { MyLeaveRoutes };
