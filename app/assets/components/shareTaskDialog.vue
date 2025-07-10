<script setup>
import {ref, watch} from "vue";
import {api} from "../api/Api.js";
import {useQuasar} from "quasar";

const props = defineProps({
    idTask: {
        type: Number,
        required: true
    },
    openDialog: {
        type: Boolean,
        required: true
    }
})

const filterFn  = (val, update, abort) => {
    update(async () => {
        const needle = val.toLocaleLowerCase()
        if(val.length < 3) {
            options.value = [];
            return;
        }
        await getUsers(val)
        options.value = users.value.filter(v => v.username.toLocaleLowerCase().indexOf(needle) > -1)
    })
}

const selectedUser = ref(null);
const users = ref([]);
const openShareDialog = ref(false);
const options = ref([]);
const $q = useQuasar();

const getUsers = async (q) => {
    await api('users?username=' + q, 'GET')
        .then(response => {
            users.value = response.data.member;
        })
        .catch(error => {
            console.error('Error fetching users:', error);
        });
}

const shareTask = async () => {
    await api('tasks/'+props.idTask, 'PATCH', {
        user: selectedUser.value['@id']
    }).then(() => {
        $q.notify({
            type: 'positive',
            position: 'top',
            message: 'Tâche partagée avec succès'
        })
        openShareDialog.value = false;
    })
}

watch(()=> props.openDialog, (newVal) => {
    openShareDialog.value = newVal;
});
</script>

<template>
<q-dialog v-model="openShareDialog">
    <q-card style="width: 500px">
        <q-card-section>
            <div class="text-h6">Partager la tâche avec un utilisateur</div>
        </q-card-section>
        <q-card-section>
            <q-select
                v-model="selectedUser"
                :options="options"
                use-input
                hide-selected
                fill-input
                option-label="username"
                @filter="filterFn"
            />
        </q-card-section>
        <q-card-actions>
            <q-btn flat label="Annuler" @click="$emit('close')" />
            <q-btn flat label="Partager" color="primary" @click="shareTask" />
        </q-card-actions>
    </q-card>
</q-dialog>
</template>

<style scoped>

</style>
