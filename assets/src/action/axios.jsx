import axios from 'axios'

/**
 * Получение днанных методом GET
 */
export function get(url, params) {
    return axios.get(url, params)
        .then(res => {
            return res;
        })
        .catch(err => err);
}

/**
 * Получение днанных методом POST
 */
export function post(url, params) {
    return axios.post(url, params)
        .then(res => {
            return res;
        })
        .catch(err => err);
}