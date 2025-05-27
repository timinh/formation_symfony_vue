import axios from "axios";

export function api (url, method){
    return axios({
        url: url,
        method: method,
    });
}