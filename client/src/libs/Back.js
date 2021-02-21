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
    static async Service(url) {
        return back
            .post(url)
            .then(res => res.data)
            .catch(err => err);
    }
}

export default Back;
