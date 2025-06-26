import axios from "axios";

let token = '';
try {
    token = user_token;
} catch (error) {
    console.error('Error retrieving user token:', error);
}

export function api(url, method, data = null) {
    let header = {
        'Content-Type': 'application/ld+json',
        'Authorization': 'Bearer ' + token
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
