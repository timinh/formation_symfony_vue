import {defineStore} from "pinia";
import {api} from "../api/Api.js";
import {Notify} from "quasar";
export const useProjectStore = defineStore('project', {
    state: () => ({
        projects: [],
        isLoading: false
    }),
    actions: {
        async getProjects(orderBy = 'order[id]', orderDirection = 'desc') {
            this.isLoading = true;
            await api('/api/projects?'+orderBy+'='+orderDirection, 'get').then(response => {
                this.projects = response.data.member;
            }).catch((error) => {
                console.error('Erreur lors de la récupération des projets:', error);
            }).finally(() => {
                this.isLoading = false;
            });
        },
        getProjectById(id) {
            return this.projects.find(project => project.id == id);
        },
        async createProject(project) {
            api('/api/projects', 'post', project).then(response => {
                this.getProjects();
            }).then(response => {
                Notify.create({
                    message: 'Projet créé avec succès',
                    type: 'positive',
                    position: 'top'
                });
            }).catch(error => {
                Notify.create({
                    message: error,
                    type: 'negative',
                    position: 'top'
                });
            });
        },
        async deleteProject(id) {
            api('/api/projects/'+id, 'delete').then(response => {
                Notify.create({
                    message: 'Projet supprimé avec succès',
                    type: 'positive',
                    position: 'top'
                });
            }).catch(error => {
                Notify.create({
                    message: error,
                    type: 'negative',
                    position: 'top'
                });
            });
        }
    }
})