import {defineStore} from "pinia";
import {api} from "../api/Api.js";

export const useProjectStore = defineStore('project', {
    state: () => ({
        projects: [],
        isLoading: false
    }),
    actions: {
        async getProjects() {
            this.isLoading = true;
            await api('/api/projects', 'get').then(response => {
                this.projects = response.data.member;
            }).catch((error) => {
                console.error('Erreur lors de la récupération des projets:', error);
            }).finally(() => {
                this.isLoading = false;
            });
        },
        getProjectById(id) {
            return this.projects.find(project => project.id == id);
        }
    }
})