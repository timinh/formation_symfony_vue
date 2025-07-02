import axios from "axios";
import {useProjectStore} from "../stores/project.js";

let token = '123'
try{
  token = user_token
} catch(e){
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

export function linkUrl(response, path, id) {
        const links = response.headers.link.split(',');
        const nextLink = links.find(link => link.includes('rel="mercure"'));
        if (nextLink) {
            const projectStore = useProjectStore();
            const nextUrl = nextLink.split(';')[0].trim().slice(1, -1);
            const domainName = document.location.hostname;
            const eventSource = new EventSource(nextUrl+"?topic=http://"+domainName+path+id);
            eventSource.onmessage = (event) => {
                projectStore.currentProject = JSON.parse(event.data);
            }
        }
}
