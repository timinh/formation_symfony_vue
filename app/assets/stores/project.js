import {defineStore} from "pinia";
import {api} from "../api/Api.js";
import {Notify} from "quasar";

export const useProjectStore = defineStore('project', {
    state: () => ({
        projects: [],
        isLoading: false,
    }),
    actions: {
        async getProjects() {
            this.isLoading = true;
            try {
                const response = api('projects', 'GET').then((response) => {
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
                // replace the project with id in the projects array
                const index = this.projects.findIndex(project => project.id === id);
                if (index !== -1) {
                    this.projects[index] = response.data.member;
                } else {
                    this.projects.push(response.data.member);
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
        }
    }
})
