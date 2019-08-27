import Vue from 'vue';
import Vuex from 'vuex';
import $ from 'jquery';
import mainStore from './stores/main';

Vue.use(Vuex);

export interface AddGroupResultData {
    id: number,
    name: string,
    color_id: number
}

export interface AddGroupPayload {
    projectId: number,
    successCallback: (data: AddGroupResultData) => void
}

export default new Vuex.Store({
    actions: {
        addGroup(context, payload: AddGroupPayload) {
            $.ajax({
                url: mainStore.groups.links.getAdd(payload.projectId),
                success: (data: string) => {
                    const groupData: AddGroupResultData = JSON.parse(data);
                    payload.successCallback(groupData);
                }
            });
        },
        deleteGroup(context, id: number) {
            $.ajax({ url: mainStore.groups.links.getDelete(id) });
        }
    }
});