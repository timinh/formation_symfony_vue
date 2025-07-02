import {defineStore} from "pinia";
import {api, linkUrl} from "../api/Api.js";
import {Notify} from "quasar";

export const useProjectStore = defineStore('project', {
    state: () => ({
        projects: [],
        currentProject: null,
        isLoading: false,
    }),
    actions: {
        async getProjects() {
            this.isLoading = true;
            try {
                const response = api('projects?order[id]=DESC', 'GET').then((response) => {
                    this.projects = response.data.member;
                    Notify.create({
                        message: 'Projects fetched successfully',
                        type: 'positive',
                        position: 'top',
                    })
                });
            } catch (error) {
                Notify.create({
                    message: error,
                    type: 'negative',
                    position: 'top',
                })
            } finally {
                this.isLoading = false;
            }
        },
        async getProjectById(id) {
            this.isLoading = true;
            try {
                const response = await api(`projects/${id}`, 'GET');
                Notify.create({
                    message: 'Project fetched successfully',
                    type: 'positive',
                    position: 'top',
                });
                this.currentProject = response.data;
                if(response.headers.link) {
                    linkUrl(response, '/api/projects/', id);
                }
            } catch (error) {
                Notify.create({
                    message: error,
                    type: 'negative',
                    position: 'top',
                });
            } finally {
                this.isLoading = false;
            }
        },
        async createProject(project) {
            this.isLoading = true;
            try {
                await api('projects', 'POST', project)
                Notify.create({
                    message: 'Le projet a été créé avec succès',
                    type: 'positive',
                    position: 'top',
                });
            } catch (e) {
                Notify.create({
                    message: e,
                    type: 'negative',
                    position: 'top',
                });
            }
            this.isLoading = false;
        },
        async deleteProject(id) {
            this.isLoading = true;
            try {
                await api('projects/' + id, 'DELETE')
            } catch (e) {
                Notify.create(
                    {
                        message: e,
                        type: 'negative',
                        position: 'top',
                    }
                )
            }
            this.isLoading = false;
        },
        updateProject(project) {
            this.isLoading = true;
            api('projects/' + project.id, 'PATCH', project)
                .then(() => {
                    Notify.create({
                        message: 'Le projet a été mis à jour avec succès',
                        type: 'positive',
                        position: 'top',
                    });
                })
                .catch((e) => {
                    Notify.create({
                        message: e,
                        type: 'negative',
                        position: 'top',
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
     }
})
