const baseUrl = document.querySelector('meta[name="url"]').content;

let LeaveSettingsRoutes = {
    allleaves: `${baseUrl}/leave-settings/all-leaves`,
    update : `${baseUrl}/leave-settings/update`,
};

export { LeaveSettingsRoutes };
