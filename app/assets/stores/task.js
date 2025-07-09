import {defineStore} from "pinia";
import {api} from "../api/Api.js";
import {Notify} from "quasar";

export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        isLoading: false,
    }),
    actions: {
        async getTasks(projectId) {
            this.isLoading = true;
            try {
                const response = await api(`tasks?project.id=${projectId}`, 'GET');
                this.tasks = response.data.member;
                Notify.create({
                    message: 'Tasks fetched successfully',
                    type: 'positive',
                    position: 'top',
                });
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
    }
});