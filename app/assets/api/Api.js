import axios from "axios";

export function api(url, method, data = null) {
    let header = {
        'Content-Type': 'application/ld+json',
    }

    if(method === 'PATCH') {
        header['Content-Type'] = 'application/merge-patch+json';
    }
    return axios({
        url: '/api/' + url,
        method: method,
        data: data,
        headers: header
    })
}
