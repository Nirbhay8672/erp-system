function resetObjectKeys(input = {}, excludeKeys = []) {
    Object.keys(input).forEach((key) => {
        if (!excludeKeys.includes(key)) {
            if (typeof input[key] === "object") {
                input[key] = {};
            } else {
                input[key] = "";
            }
        }
    });
}

function getPackageTypeColor(package_type = null) {
    if(!package_type) {
        return;
    }

    let types_color = {
        'Small' : 'text-warning',
        'Medium' : 'text-success',
        'Big' : 'text-danger',
    };

    return types_color[package_type];
}

export { resetObjectKeys, getPackageTypeColor };
