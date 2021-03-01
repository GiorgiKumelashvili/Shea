import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh';
import store from '@/store/index';
import axios from 'axios';
import Const from './Const';

const back = axios.create({
    baseURL: 'http://localhost:8000/api'
});

back.interceptors.request.use(config => {
    const accessToken = localStorage.getItem(Const.names.token);
    config.headers.Authorization = `Bearer ${accessToken}`;

    return config;
});

class Back {
    /**
     * Connnects To Backend
     * Send access token and user id on every call
     *
     * @param {String} url - url for backend
     * @param {Object} obj - object for sending to backend via json
     */
    static async Service(url, obj = null) {
        if (!store.getters.UserId) {
            await store.dispatch('getUserCredential');
        }

        return back
            .post(url, { ...obj, user_id: store.getters.UserId })
            .then(res => res.data)
            .catch(err => err);
    }
}

export default Back;
