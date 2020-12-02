import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        /* ======================================= */
        apiBaseUrl: process.env.API_URL ? process.env.API_URL : 'https://zolla.n-nikonorov.ru',
        axiosConfig: {crossDomain: true},
        token: 'QiWMJNi9MSIOsOZ6',
        /* ======================================= */
        loading: false,
        error: false,
    },
    mutations: {
        set(state, {type, items}) {
            state[type] = items
        }
    },
    actions: {
        async sendForm ({commit, state}, arFields) {
            commit('set', {type: 'loading', items: true})
            const url = state.apiBaseUrl + '/api/feedback.php'
            let arRequest = arFields
            arRequest.token = state.token
            axios.post(url, arFields, state.axiosConfig).then((response) => {
                console.log(response);
                if (response.data.result == 'ok') {
                    //eslint-disable-next-line
                    successShot('Заявка отправлена успешно! ' + response.data.data.fields.name + ', вам перезвонят по номеру: ' + response.data.data.fields.phone);
                }else{
                    //eslint-disable-next-line
                    warningShot(response.data.error);
                }
            }).catch((error) => {
                alert(error)
            })
            commit('set', {type: 'loading', items: false})
        },
    }
})
