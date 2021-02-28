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
     *
     * @param {String} url - url for backend
     * @param {Object} obj - object for sending to backend via json
     */
    static Service(url, obj = null) {
        return back
            .post(url, obj)
            .then(res => res.data)
            .catch(err => err);
    }
}

export default Back;
