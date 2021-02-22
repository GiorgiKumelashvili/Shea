import store from '@/store/index';
import axios from 'axios';

const back = axios.create({
    baseURL: 'http://localhost:8000/api'
});

class Back {
    /**
     * @param {String} name
     * @description connnects this method to backend
     */
    static Service(url, obj = null) {
        return back
            .post(url, obj)
            .then(res => res.data)
            .catch(err => err);
    }
}

export default Back;
