import {Notify} from "quasar";
import {api} from "../api/Api.js";
import {defineStore} from "pinia";

export const useStatusStore = defineStore('status', {
  state: () => ({
    statuses: [],
  }),
  actions: {
      async getStatus() {
          try {
              const reponse = await api('statuses', 'GET');
                this.statuses = reponse.data.member;
          }  catch (error) {
                Notify.create({
                    message: error,
                    type: 'negative',
                    position: 'top',
                });
          }
      }
  }
})
