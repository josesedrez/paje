import axios from 'axios'

const baseUrl = '/goals/'

export default class Goal {
    static register (payload, callback) {
        console.log(callback);

        axios.post('/register', payload).then(callback)
    }

    static login (payload, callback) {
        console.log(callback);

        axios.post('/login', payload).then(callback)
    }

    static getCurrentUser (callback) {
        console.log(callback);

        axios.post('/current-user').then(callback)
    }

    static changeProfile (payload, callback) {
        console.log(callback);

        axios.post('/change-profile', payload).then(callback)
    }
}
