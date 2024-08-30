const baseUrl = document.querySelector('meta[name="url"]').content;

let PermissionRoutes = {
    details: `${baseUrl}/permissions/details`,
    update: `${baseUrl}/permissions/save-changes`,
}

export {
    PermissionRoutes,
}
