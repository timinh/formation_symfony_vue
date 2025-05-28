import axios from "axios";

export function api (url, method, data = null) {
    let headers = {
      "Authorization": "Bearer " + user_token
    };
    if(method === 'post') {
        headers = {
            'Content-Type': 'application/ld+json',
            ...headers
        };
    }

    return axios({
        url: url,
        method: method,
        data: data,
        headers: headers
    });
}