import axios from "axios";

export function api (url, method, data = null) {
    let headers = {};
    if(method === 'post') {
        headers = {
            'Content-Type': 'application/ld+json',
        };
    }

    return axios({
        url: url,
        method: method,
        data: data,
        headers: headers
    });
}