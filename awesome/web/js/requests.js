function processGetString() {
    var result = [],
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            result[tmp[0]] = decodeURIComponent(tmp[1]);
        });
    return result;
}