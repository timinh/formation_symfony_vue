import axios from "axios";

export function api(url, method, data = null) {
    return axios({
        url: '/api/' + url,
        method: method,
        data: data
    })
}
